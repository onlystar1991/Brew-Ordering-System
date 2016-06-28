<?php
/**
 * Created by PhpStorm.
 * User: bok
 * Date: 9/21/14
 * Time: 9:19 PM
 */
require PARSE_SDK_INC;

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));


use Parse\ParseClient;
use Parse\ParseUser;
use Parse\ParseSessionStorage;
use Parse\ParseException;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseFile;

class Store extends CI_Controller{

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

    public function index() {
        if (!$this->session->userdata('isSigned')) {
            redirect('auth/index');
        }

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
        $query = new ParseQuery("Stores");
        if (!user_can(UP_ALL)) 
            $query->equalTo("storeOwner", $this->session->userdata('userid'));
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
        return $resultArray;
    }

    
    public function delete($sId = "") {
        if (!$sId) {
            redirect("store/");
        } else {
            $query = new ParseQuery("Stores");
            $store = $query->get($sId);
            $store->destroy();
            redirect("store/");
        }
    }

    public function add() {
        $this->data['page'] = "store";
        $this->load->view("store/add");
    }

    public function edit($sId = "") {
        if (!$sId) {
            redirect("store/");
        } else {
            $query = new ParseQuery("Stores");
            $store = $query->get($sId);
            $mstore = new MStore();

            $mstore->store_id = $store->getObjectId();
            $mstore->store_name = $store->get("storeName");
            $mstore->store_address = $store->get("storeAddress");
            $mstore->store_description = $store->get("storeDescription");
            $mstore->store_from_monday = $store->get("fromMonday");
            $mstore->store_to_monday = $store->get("toMonday");

            $mstore->store_from_tuesday = $store->get("fromTuesday");
            $mstore->store_to_tuesday = $store->get("toTuesday");
            $mstore->store_from_wednesday = $store->get("fromWednesday");
            $mstore->store_to_wednesday = $store->get("toWednesday");
            $mstore->store_from_thursday = $store->get("fromThursday");
            $mstore->store_to_thursday = $store->get("toThursday");
            $mstore->store_from_friday = $store->get("fromFriday");
            $mstore->store_to_friday = $store->get("toFriday");
            $mstore->store_from_saturday  = $store->get("fromSaturday");;
            $mstore->store_to_saturday  = $store->get("toSaturday");;
            $mstore->store_from_sunday = $store->get("fromSunday");
            $mstore->store_to_sunday = $store->get("toSunday");

            // print_r($store->get("storeIcon"));exit;
            if ($store->get("storeIcon")) {
                $mstore->store_logo = $store->get("storeIcon");
            }
            if ($store->get("storeImage1")) {
                $mstore->store_image1 =  $store->get("storeImage1");    
            }
            if ($store->get("storeImage2")) {
                $mstore->store_image2 =  $store->get("storeImage2");    
            }
            
            $this->data['store'] = $mstore;
            $this->data['page'] = "store";
            $this->load->view("store/edit", $data);
        }
    }

    public function detail($sId = "") {
        if (!$sId) {
            redirect("store/");
        } else {
            $query = new ParseQuery("Stores");
            $store = $query->get($sId);
            $mstore = new MStore();

            $mstore->store_id = $store->getObjectId();
            $mstore->store_name = $store->get("storeName");
            $mstore->store_address = $store->get("storeAddress");
            $mstore->store_description = $store->get("storeDescription");
            $mstore->store_from_monday = $store->get("fromMonday");
            $mstore->store_to_monday = $store->get("toMonday");

            $mstore->store_from_tuesday = $store->get("fromTuesday");
            $mstore->store_to_tuesday = $store->get("toTuesday");
            $mstore->store_from_wednesday = $store->get("fromWednesday");
            $mstore->store_to_wednesday = $store->get("toWednesday");
            $mstore->store_from_thursday = $store->get("fromThursday");
            $mstore->store_to_thursday = $store->get("toThursday");
            $mstore->store_from_friday = $store->get("fromFriday");
            $mstore->store_to_friday = $store->get("toFriday");
            $mstore->store_from_saturday  = $store->get("fromSaturday");;
            $mstore->store_to_saturday  = $store->get("toSaturday");;
            $mstore->store_from_sunday = $store->get("fromSunday");
            $mstore->store_to_sunday = $store->get("toSunday");

            // print_r($store->get("storeIcon"));exit;
            if ($store->get("storeIcon")) {
                $mstore->store_logo = $store->get("storeIcon");
            }
            if ($store->get("storeImage1")) {
                $mstore->store_image1 =  $store->get("storeImage1");    
            }
            if ($store->get("storeImage2")) {
                $mstore->store_image2 =  $store->get("storeImage2");    
            }
            
            $this->data['store'] = $mstore;
            $this->data['page'] = "store";
            $this->load->view("store/detail", $data);
        }
    }

    public function save() {
        
        $store_id = $this->input->post("store_id");

        if ($store_id == null) {
            // var_dump($_FILES);
            $store = new ParseObject("Stores");
            
            $store->set("storeName", $this->input->post("storeName"));
            $store->set("storeAddress", $this->input->post("storeAddress"));
            $store->set("storeDescription", $this->input->post("storeDescripton"));
            $store->set("fromMonday", $this->input->post("moFrom"));
            $store->set("toMonday", $this->input->post("moTo"));
            $store->set("fromTuesday", $this->input->post("tuFrom"));
            $store->set("toTuesday", $this->input->post("tuTo"));
            $store->set("fromWednesday", $this->input->post("weFrom"));
            $store->set("toWednesday", $this->input->post("weTo"));
            $store->set("fromThursday", $this->input->post("thFrom"));
            $store->set("toThursday", $this->input->post("thTo"));
            $store->set("fromFriday", $this->input->post("frFrom"));
            $store->set("toFriday", $this->input->post("frTo"));
            $store->set("fromSaturday", $this->input->post("saFrom"));
            $store->set("toSaturday", $this->input->post("saTo"));
            $store->set("fromSunday", $this->input->post("suFrom"));
            $store->set("toSunday", $this->input->post("suTo"));
            $store->set("storeOwner", $this->session->userdata('userid'));
            $store->set("storeType", "Store");

            if ($_FILES['store_icon']['name']) {
                $store_icon = ParseFile::createFromData(file_get_contents($_FILES['store_icon']['tmp_name']), $_FILES['store_icon']['name']);
                $store_icon->save();
                $store->set("storeIcon", $store_icon->getUrl());
            }

            if ($_FILES['store_image1']['name']) {
                $store_image1 = ParseFile::createFromData(file_get_contents($_FILES['store_image1']['tmp_name']), $_FILES['store_image1']['name']);
                $store_image1->save();
                $store->set("storeImage1", $store_image1->getUrl());
            }

            if ($_FILES['store_image2']['name']) {
                $store_image2 = ParseFile::createFromData(file_get_contents($_FILES['store_image2']['tmp_name']), $_FILES['store_image2']['name']);
                $store_image2->save();
                $store->set("storeImage2", $store_image2->getUrl());
            }

            try {
                $store->save();
                redirect("store/");
            } catch (ParseException $ex) {
                die("Exception Occured :".$ex->getMessage());
            }

        } else {
            // var_dump($_FILES);
            $query = new ParseQuery("Stores");
            // $store = $query->get($sId);
            $store = $query->get($this->input->post("store_id"));

            $store->set("storeName", $this->input->post("storeName"));
            $store->set("storeAddress", $this->input->post("storeAddress"));
            $store->set("storeDescription", $this->input->post("storeDescripton"));
            $store->set("fromMonday", $this->input->post("moFrom"));
            $store->set("toMonday", $this->input->post("moTo"));
            $store->set("fromTuesday", $this->input->post("tuFrom"));
            $store->set("toTuesday", $this->input->post("tuTo"));
            $store->set("fromWednesday", $this->input->post("weFrom"));
            $store->set("toWednesday", $this->input->post("weTo"));
            $store->set("fromThursday", $this->input->post("thFrom"));
            $store->set("toThursday", $this->input->post("thTo"));
            $store->set("fromFriday", $this->input->post("frFrom"));
            $store->set("toFriday", $this->input->post("frTo"));
            $store->set("fromSaturday", $this->input->post("saFrom"));
            $store->set("toSaturday", $this->input->post("saTo"));
            $store->set("fromSunday", $this->input->post("suFrom"));
            $store->set("toSunday", $this->input->post("suTo"));

            if ($this->input->post("store_icon_delete") == 1) {
                $store->set("storeIcon", null);
            }
            if ($this->input->post("store_image1_delete") == 1) {
                $store->set("storeImage1", null);
            }
            if ($this->input->post("store_image2_delete") == 1) {
                $store->set("storeImage2", null);
            }

            if ($_FILES['store_icon']['name']) {
                $store_icon = ParseFile::createFromData(file_get_contents($_FILES['store_icon']['tmp_name']), $_FILES['store_icon']['name']);
                $store_icon->save();
                $store->set("storeIcon", $store_icon);
            }

            if ($_FILES['store_image1']['name']) {
                $store_image1 = ParseFile::createFromData(file_get_contents($_FILES['store_image1']['tmp_name']), $_FILES['store_image1']['name']);
                $store_image1->save();
                $store->set("storeImage1", $store_image1);
            }
            if ($_FILES['store_image2']['name']) {
                $store_image2 = ParseFile::createFromData(file_get_contents($_FILES['store_image2']['tmp_name']), $_FILES['store_image2']['name']);
                $store_image2->save();
                $store->set("storeImage2", $store_image2);
            }

            try {
                $store->save();
                redirect("store/");
            } catch (ParseException $ex) {
                die("Exception Occured :".$ex->getMessage());
            }
        }
    }
}