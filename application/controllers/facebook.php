<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 7/7/2016
 * Time: 12:28 PM
 */
//require FACEBOOK_GRAPH_HELPER;
//require FACEBOOK_PAGE_HELPER;


require PARSE_SDK_INC;

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));


use Parse\ParseClient;
use Parse\ParseUser;
use Parse\ParseSessionStorage;
use Parse\ParseException;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseFile;

class Facebook extends  CI_Controller{
    private static $app_id     =   'upTrZvYWTbzoZKTI9Up9uGWYHiamL3LCWNvfiTrx';
    private static $rest_key   =   'NUyL27OK8vIdZGtiqwskfVyPAiCT0Z6zCm7d3NXG';
    private static $master_key =   'UXkRORqhyp22XBg28k0EOxSZitOgVRv5gaDWFHJ8';

    public function __construct() {
        echo "Inside Calling Facebook execute Constructor";
        parent::__construct();
        session_start();
        ParseClient::initialize(self::$app_id, self::$rest_key, self::$master_key);
        $this->load->model('mstore');
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->library("session");
        $this->load->library('form_validation');
        echo "Exited Facebook execute Constructor";

    }

    public  function execute()
    {

     //   echo FacebookGraphHelper::getAccessToken();
        echo "Inside  Facebook execute Method";
        $pages = FacebookGraphHelper::getPages();

        $pageMetaInfo = [];
        foreach ($pages as $key => $value) {
            foreach ($pages[$key]['data'] as $key1 => $value1) {
                //echo $value1['id'];
                $facebookPage = new FacebookPage($value1['id'], $value1['name']);
                $facebookPage->setMetaData();
//                if(array_key_exists($facebookPage->metaData[]))
                echo "Inside Facebook::Execute before calling config";
                $configs = include FACEBOOK_API_CONFIG;
                echo "Inside Facebook::Execute after calling config";
                $categories = $configs['categories'];
                $locations = $configs['locations'];
                $catFound = false;
                $locFound = false;
                if (array_key_exists('category_list',$facebookPage->metaData)) {

                    foreach($facebookPage->metaData['category_list'] as $key => $value)
                    {
                        $cat = $facebookPage->metaData['category_list'][$key]['name'];
                        if(in_array($cat, $categories))
                        {
                            $catFound =true;
                            break;
                        }
                    }

                    if (array_key_exists('location',$facebookPage->metaData)) {
                        if (array_key_exists('state', $facebookPage->metaData['location'])) {
                            $state = $facebookPage->metaData['location']['state'];
                            if ($state == 'MA') {
                                $locFound = true;
                            }

                        }
                        else
                            log_message('info', '!State MA Not Found!' . $facebookPage->id . '!' . $facebookPage->name  );
                    }
                    else
                        log_message('info', '!State MA Not Found!' . $facebookPage->id . '!' . $facebookPage->name );

                }
                else
                    log_message('info', '!Category Not Found!' . $facebookPage->id . '!' . $facebookPage->name );
                if($catFound && $locFound) {
                    $this->save($facebookPage);
                }

            }

        }

    }

    private function save($facebookPage)
    {
        $store = null;
        $query = new ParseQuery("Stores");

        $isPublished = true;
        $missingDetails = "";
        $query->equalTo("facebook_page_id", $facebookPage->id);
        $result = $query->first();
        if($result)
        {
            $store = $result;
        }
        else
        {
            $store = new ParseObject("Stores");
        }
        $store->set('json_response',json_encode($facebookPage->metaData));



        $store->set("facebook_page_id", $facebookPage->id);
        $store->set("storeOwner", "N/A");
        //$store->set("storeOwner", $this->session->userdata('userid'));

        $store->set("storeName", $facebookPage->metaData['global_brand_page_name']);
        //$store->set("storeName", $facebookPage->metaData['global_brand_page_name']);
        if (array_key_exists('description',$facebookPage->metaData))
            $store->set("storeDescription",$facebookPage->metaData["description"]);
        $configs = include FACEBOOK_API_CONFIG;
        $categories = $configs['categories'];
        foreach($facebookPage->metaData['category_list'] as $key => $value)
        {
            $cat = $facebookPage->metaData['category_list'][$key]['name'];

            if(in_array($cat, $categories))
            {
                $store->set("storeType", $cat);
                break;
            }
        }


        echo "After Break";
        if (array_key_exists('picture',$facebookPage->metaData) ) {
            if ($facebookPage->metaData['picture']['data']['url']) {
                $path_parts = pathinfo($url = strtok($facebookPage->metaData['picture']['data']['url'], '?'));
                $store_image1 = ParseFile::createFromData(file_get_contents($facebookPage->metaData['picture']['data']['url']), $path_parts['filename']);
                $store_image1->save();
                $store->set("storeIcon", $store_image1->getUrl());
                $store->set("storeImage1", $store_image1->getUrl());

            }
        }
        else {
            $isPublished = false;
            $missingDetails = $missingDetails . "Photo,";
        }

        if (array_key_exists('cover',$facebookPage->metaData))

            {
            $path_parts = pathinfo($url=strtok($facebookPage->metaData['cover']['source'],'?'));
            $store_image2 = ParseFile::createFromData(file_get_contents($facebookPage->metaData['cover']['source']), $path_parts['filename']);
            $store_image2->save();
            $store->set("storeImage2", $store_image2->getUrl());

        }


        $address = "";
        if (array_key_exists('location',$facebookPage->metaData)) {
            if (array_key_exists('street', $facebookPage->metaData['location']))
                $address = $address . $facebookPage->metaData['location']['street'];
            else
            {
                $isPublished = false;
                $missingDetails = $missingDetails . "Street,";
            }
            if (array_key_exists('city', $facebookPage->metaData['location']))
                $address = $address . ', ' . $facebookPage->metaData['location']['city'];
            else
            {
                $isPublished = false;
                $missingDetails = $missingDetails . "City,";
            }
            if (array_key_exists('state', $facebookPage->metaData['location']))
                $address = $address . ', ' . $facebookPage->metaData['location']['state'] . ' ';
            else
            {
                $isPublished = false;
                $missingDetails = $missingDetails . "State,";
            }
            if (array_key_exists('zip', $facebookPage->metaData['location']))
                $address = $address . $facebookPage->metaData['location']['zip'];
            else
            {
                $hasAddress = false;
                $missingDetails = $missingDetails . "Zip,";
            }

            $store->set("storeAddress", $address);
        }
        else
        {
            $isPublished =false;
            $missingDetails = $missingDetails . "Address,";

        }
        if($facebookPage->metaData['location']['latitude']) {
            $latitude = $facebookPage->metaData['location']['latitude'];
            $store->set('loc_latitude', strval($latitude));
        }
        if($facebookPage->metaData['location']['longitude']) {
            $longitude = $facebookPage->metaData['location']['longitude'];
            $store->set('loc_longitude', strval($longitude));
        }




        foreach($facebookPage->metaData as $key => $value)
        {


            if($key == 'hours')
            {

                foreach($value as $day => $hours)
                {
                    if (array_key_exists('mon_1_open',$value))
                        $store->set("fromMonday", $this->convertTime12HoursFormat($value['mon_1_open']));

                    if(array_key_exists('mon_1_close', $value))
                        $store->set("toMonday",  $this->convertTime12HoursFormat($value['mon_1_close']));
                    if(array_key_exists('tue_1_open',$value))
                        $store->set("fromTuesday",  $this->convertTime12HoursFormat($value['tue_1_open']));
                    if(array_key_exists('tue_1_close', $value))
                        $store->set("toTuesday",  $this->convertTime12HoursFormat($value['tue_1_close']));
                    if(array_key_exists('wed_1_open',$value))
                        $store->set("fromWednesday",  $this->convertTime12HoursFormat($value['wed_1_open']));
                    if(array_key_exists('wed_1_close',$value))
                        $store->set("toWednesday",  $this->convertTime12HoursFormat($value['wed_1_close']));
                    if(array_key_exists('thur_1_open',$value))
                        $store->set("fromThursday",  $this->convertTime12HoursFormat($value['thur_1_open']));
                    if(array_key_exists('thur_1_close',$value))
                        $store->set("toThursday",  $this->convertTime12HoursFormat($value['thur_1_close']));
                    if(array_key_exists('fri_1_open',$value))
                        $store->set("fromFriday",  $this->convertTime12HoursFormat($value['fri_1_open']));
                    if(array_key_exists('fri_1_close',$value))
                        $store->set("toFriday",  $this->convertTime12HoursFormat($value['fri_1_close']));
                    if(array_key_exists('sat_1_open',$value))
                        $store->set("fromSaturday",  $this->convertTime12HoursFormat($value['sat_1_open']));
                    if(array_key_exists('sat_1_close',$value))
                        $store->set("toSaturday",  $this->convertTime12HoursFormat($value['sat_1_close']));
                    if(array_key_exists('sun_1_open',$value))
                        $store->set("fromSunday",  $this->convertTime12HoursFormat($value['sun_1_open']));
                    if(array_key_exists('sun_1_close',$value))
                        $store->set("toSunday",  $this->convertTime12HoursFormat($value['sun_1_close']));

                }
            }
        }
        $store->set('is_published', $isPublished);
        $store->set('missing_details', $missingDetails);

        try {
            $store->save();
            log_message('info',  '!Saved!' .$facebookPage->id . '!' . $facebookPage->name );
            echo "After Store";
        } catch (ParseException $ex) {
            log_message('error',  '!'. $ex . '!' .$facebookPage->id );
            //die("Exception Occured :".$ex->getMessage());
        }
    }
    private function convertTime12HoursFormat($time)
    {
        return date("ga", strtotime($time));
    }

    public function store()
    {

    }
    public function index() {

        echo "GetStoreList";
        $all_stores = $this->getStorelist();
        $result_array = array();
        $this->data['stores'] = array();
        $config = array();
        $config["base_url"] = base_url() . "store";
        $config["total_rows"] = count($all_stores);
        $config["per_page"] = 4;
        $config["uri_segment"] = 2;

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $str_links = $this->pagination->create_links();
        $this->data['links'] = explode('&nbsp;',$str_links );

        for ($i = $page; $i < ($page + 4); $i++) {
            try {
                if ($all_stores[$i]) {
                    $result_array[] = $all_stores[$i];
                } else {
                    break;
                }
            } catch (Exception $e) {
                break;
            }
        }

        $this->data['stores'] = $result_array;
        $this->data['page'] = "store";

        if ($this->session->userdata('waiting')) {
            $query = new ParseQuery("Approve");

            $query->equalTo("user", ParseUser::getCurrentUser());
            $query->includeKey("store");

            $result = $query->first();

            // print_r($result);exit;
            if ($result) {
                $this->data['regStoreId'] = $result->get('store')->getObjectId();
                $this->data['regStoreName'] = $result->get('store')->get('storeName');
                // print_r($this->data);exit;
            }
        }

        $this->load->view('store/index', $data);
    }

    private function getStoreList() {
        echo "GetStoreList";
        $query = new ParseQuery("Stores");
       // if (!user_can(UP_ALL))
            $query->equalTo("storeOwner","N/A");
        $result = $query->find();
        $resultArray = array();
        for($i = 0; $i < count($result); $i++) {
            $object = $result[$i];
            $store = new MStore();
            $store->store_id = $object->getObjectId();
            $store->store_name = $object->get("storeName");
            $store->store_address = $object->get("storeAddress");
            $store->store_from_monday = $object->get("fromMonday");
            $store->store_to_monday = $object->get("toMonday");

            if ($object->get("storeIcon")) {
                $store->store_logo = $object->get("storeIcon");
            }
            $store->store_description = $object->get("storeDescription");
            $resultArray[] = $store;
        }
        //exit;
        return $resultArray;
    }

}

class CurlHelper
{

    public function execute($url)
    {
        try
        {
            //echo "start\t" . date("h:i:sa").  "\t";
            echo $url;
            ini_set('max_execution_time', 6000); //300 seconds = 5 minutes
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, trim($url));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            //echo curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            $response  = curl_exec($ch);
            if(curl_errno($ch))
            {
                echo 'Curl error: ' . curl_error($ch);
            }
            curl_close($ch);
            unset($ch);
            //echo "end\t" . date("h:i:sa").  "<br>";
            //echo "end\t" . date("h:i:sa").  "<br>";
        }
        catch(exception $ex)
        {
            echo $ex;
            Session::push('execute_error', $ex->getMessage());
        }

        return $response;

    }

}
class FacebookGraphHelper
{

    public static function getAccessToken()
    {

        $configs = include FACEBOOK_API_CONFIG;
        $app_id = $configs['app_id'];// "159228921157128";
        $app_secret =  $configs['app_secret']; //"ccbb21ca556d2fe2595614746357d27c";
        $access_token = null;
        $APPLICATION_API_URL_ENV_KEY= $configs['facebook_graph_url']; //"https://graph.facebook.com/v2.6";

        try
        {
            $request = $APPLICATION_API_URL_ENV_KEY .
                "oauth/access_token?client_id=" .
                $app_id .

                "&client_secret=" . $app_secret.
                "&grant_type=client_credentials";
            $response = CurlHelper::execute($request);
            $access_token = json_decode($response)->access_token;
        }

        catch(Exception $e) {
        }
        return $access_token;
    }
    public static function getResponse($url, $filter, $isPaging = true, &$nextPage)
    {

        try {
            $queryString = $filter;
            foreach($queryString as $key => $value) {
                //echo $key;
            }
            $access_token = FacebookGraphHelper::getAccessToken();
            $queryString += array('access_token' => $access_token);
            $queryString += array('limit' => 50);
            $url = $url. "?" .  http_build_query($queryString);
            $curlHelper = new CurlHelper;
            $jsonResponse = $curlHelper->execute($url);

            $facebookData = json_decode($jsonResponse,true);
            if(json_last_error() >0 )
            {
                echo json_last_error_msg();

            }
            if($facebookData != null && array_key_exists("error", $facebookData) )
            {

                echo $facebookData["error"]["message"];

            }
            else
            {
                if ($isPaging == true) {
                    if (FacebookGraphHelper::nextPageExists($facebookData) == true)
                        $nextPage = $facebookData["paging"]["next"];
                }
            }
        }
        catch(exception $ex)
        {
            echo $ex;
        }

        return $facebookData;
    }

    public static function getNextPageResponse($url, &$nextPage)
    {

        try {
            $curlHelper = new CurlHelper;
            $jsonResponse  = $curlHelper->execute($url);
            $facebookData = json_decode($jsonResponse,true);
            // echo json_last_error();
            if($facebookData != null &&  array_key_exists("error", $facebookData) )
            {
                echo $facebookData["error"]["message"];
            }
            else
            {
                if (FacebookGraphHelper::nextPageExists($facebookData) == true)
                    $nextPage = $facebookData["paging"]["next"];
            }

            return $facebookData;
        }
        catch(exception $ex)
        {
            echo $ex;
        }
    }

    private static function nextPageExists($data)
    {
        $value = false;
        if ($data != null && array_key_exists("paging", $data)) {
            if (array_key_exists("next", $data["paging"])) {
                $value = true;
            }
        }

        return $value;
    }

    public static function getPages()
    {
        $configs = include FACEBOOK_API_CONFIG;
        $categories = $configs['categories'];
        $types = $configs['types'];
        $locations = $configs['locations'];
        $url = $configs['facebook_graph_url'] . 'search';
        $pages = [];

        foreach ($locations as $location){

            foreach ($categories as $category) {
                //foreach($)
                $q = $category . ' in ' . $location . ', Massachusetts';
                //$q = str_replace(' ', '%', $q);
                foreach($types as $type) {
                    $request = ['q' => $q, 'type' => $type];
                    $nextPage = "";
                    $isNextPage = true;

                    $facebookResponse = FacebookGraphHelper::getResponse($url, $request, true, $nextPage);
                    //$page[] = $facebookResponse;
                    if ($facebookResponse != null) {
                        if (array_key_exists("data", $facebookResponse) && count($facebookResponse["data"]) > 0) {
                            echo count($facebookResponse["data"]) . 'No Data Present' . "<br/>";
                            $pages[] = $facebookResponse;
                            //var_dump($facebookResponse);
                            echo $url . "<br/>";
                            foreach ($facebookResponse['data'] as $key1 => $value1) {
                                log_message('info', '!Page!' . $value1['id'] . '!' . $value1['name']);
                            }


                            unset($facebookResponse);

                            while ($isNextPage) {
                                $url = $nextPage;
                                $nextPage = "";
                                $facebookResponse = FacebookGraphHelper::getNextPageResponse($url, $nextPage);
                                echo "Next Page:-" . $nextPage . "<br/>";
                                if (count($facebookResponse["data"]) > 0) {
                                    $pages[] = $facebookResponse;
                                    foreach ($facebookResponse['data'] as $key1 => $value1) {
                                        log_message('info', '!Page!' . $value1['id'] . '!' . $value1['name']);
                                    }

                                    echo "Next Page:-" . count($facebookResponse["data"]) . "<br/>";
                                } else {


                                    $nextPage = "";
                                    echo "Next Page:-" . count($facebookResponse["data"]) . "<br/>";
                                    unset($facebookResponse);
                                    $isNextPage = false;

                                }
                                $url = $configs['facebook_graph_url'] . 'search';

                                echo $url . "<br/>";


                            }
                        }
                    }
                }


            }

        }
        return $pages;

    }






}
class FacebookPage
{
    public $metaData;
    public $id;
    public $name;
    function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;

    }

    public function setMetaData()
    {
        $configs = include FACEBOOK_API_CONFIG;
        $url = $configs['facebook_graph_url'];
        $url = $url . $this->id . "";
        $nextPage = "";
        $filter = array('fields' => "hours,location,picture.height(961),cover.height(961),description,category_list,global_brand_page_name");
        $facebookResponse = FacebookGraphHelper::getResponse($url, $filter, false, $nextPage);
        $this->metaData = $facebookResponse;

    }
}