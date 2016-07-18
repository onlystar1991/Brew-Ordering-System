<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 7/7/2016
 * Time: 12:28 PM
 */
require "application\helpers\FacebookGraphHelper.php";
require "application\helpers\FacebookPage.php";
use application\helpers\FacebookGraphHelper;
use application\helpers\FacebookPage;

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

        parent::__construct();
        session_start();
        ParseClient::initialize(self::$app_id, self::$rest_key, self::$master_key);
        $this->load->model('mstore');
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->library("session");
        $this->load->library('form_validation');

    }

    public  function execute()
    {

     //   echo FacebookGraphHelper::getAccessToken();

        $pages = FacebookGraphHelper::getPages();
        $pageMetaInfo = [];
        foreach ($pages as $key => $value) {
            foreach ($pages[$key]['data'] as $key1 => $value1) {
                //echo $value1['id'];
                $facebookPage = new FacebookPage($value1['id']);
                $facebookPage->setMetaData();
//                if(array_key_exists($facebookPage->metaData[]))
                if($facebookPage->metaData['category_list']) {
                    $this->save($facebookPage);
                  //  exit;
                }

            }

        }

    }

    private function save($facebookPage)
    {

        $store = null;
        $query = new ParseQuery("Stores");
        //if (!user_can(UP_ALL))
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



        $store->set("facebook_page_id", $facebookPage->id);
        $store->set("storeOwner", "N/A");
        //$store->set("storeOwner", $this->session->userdata('userid'));

        $store->set("storeName", $facebookPage->metaData['global_brand_page_name']);
        //$store->set("storeName", $facebookPage->metaData['global_brand_page_name']);
        $store->set("storeDescription",$facebookPage->metaData["description"]);
        $configs = include('application\config\facebook_api.php');
        $categories = $configs['categories'];
        var_dump($facebookPage->metaData['category_list']);
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

        if ($facebookPage->metaData['picture']['data']['url']) {
            $path_parts = pathinfo($url=strtok($facebookPage->metaData['picture']['data']['url'],'?'));
            $store_image1 = ParseFile::createFromData(file_get_contents($facebookPage->metaData['picture']['data']['url']), $path_parts['filename']);
            $store_image1->save();
            $store->set("storeIcon", $store_image1->getUrl());
            $store->set("storeImage1", $store_image1->getUrl());

        }

        if ($facebookPage->metaData['cover']['source']) {
            $path_parts = pathinfo($url=strtok($facebookPage->metaData['cover']['source'],'?'));
            $store_image2 = ParseFile::createFromData(file_get_contents($facebookPage->metaData['cover']['source']), $path_parts['filename']);
            $store_image2->save();
            $store->set("storeImage2", $store_image2->getUrl());

        }

        $address = "";
        $address = $address . $facebookPage->metaData['location']['street'];
        $address = $address . ', ' . $facebookPage->metaData['location']['city'];
        $address = $address . ', ' . $facebookPage->metaData['location']['state'] .' ' . $facebookPage->metaData['location']['zip'] ;
        $store->set("storeAddress", $address);
        $latitude =  $facebookPage->metaData['location']['latitude'];
        $store->set('loc_latitude', strval($latitude));
        $longitude =  $facebookPage->metaData['location']['longitude'];
        $store->set('loc_longitude', strval($longitude));



        foreach($facebookPage->metaData as $key => $value)
        {

            /*if($key == 'location')

            {
                foreach($value as $type => $location)
                {
                    if($type == 'street')
                        $address =  $location;

                    if($type == 'latitude')
                    {
                        $store->set('loc_latitude', strval($location));
                    }
                    if($type == 'longitude')
                    {
                        $store->set('loc_longitude', strval($location));
                    }
                }
                $store->set("storeAddress", $address);

            }*/

            if($key == 'hours')
            {

                foreach($value as $day => $hours)
                {
                    $store->set("fromMonday", $this->convertTime12HoursFormat($value['mon_1_open']));
                    $store->set("toMonday",  $this->convertTime12HoursFormat($value['mon_1_close']));
                    $store->set("fromTuesday",  $this->convertTime12HoursFormat($value['tue_1_open']));
                    $store->set("toTuesday",  $this->convertTime12HoursFormat($value['tue_1_close']));
                    $store->set("fromWednesday",  $this->convertTime12HoursFormat($value['wed_1_open']));
                    $store->set("toWednesday",  $this->convertTime12HoursFormat($value['wed_1_close']));
                    $store->set("fromThursday",  $this->convertTime12HoursFormat($value['thur_1_open']));
                    $store->set("toThursday",  $this->convertTime12HoursFormat($value['thur_1_close']));
                    $store->set("fromFriday",  $this->convertTime12HoursFormat($value['fri_1_open']));
                    $store->set("toFriday",  $this->convertTime12HoursFormat($value['fri_1_close']));
                    $store->set("fromSaturday",  $this->convertTime12HoursFormat($value['sat_1_open']));
                    $store->set("toSaturday",  $this->convertTime12HoursFormat($value['sat_1_close']));
                    $store->set("fromSunday",  $this->convertTime12HoursFormat($value['sun_1_open']));
                    $store->set("toSunday",  $this->convertTime12HoursFormat($value['sun_1_close']));

                }
            }
        }

        try {
            $store->save();
            echo "After Store";
            var_dump($store);
            exit;
        } catch (ParseException $ex) {
            die("Exception Occured :".$ex->getMessage());
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

