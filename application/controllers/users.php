<?php
/**
 * Created by PhpStorm.
 * User: bok
 * Date: 9/21/14
 * Time: 9:19 PM
 */
require PARSE_SDK_INC;

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

define('USER_STATUS_REGISTER', 0);
define('USER_STATUS_APPROVE',  1);
define('USER_STATUS_DENY',     2);


use Parse\ParseClient;
use Parse\ParseUser;
use Parse\ParseSessionStorage;
use Parse\ParseException;
use Parse\ParseObject;
use Parse\ParseQuery;

class Users extends CI_Controller{

    private static $app_id     =   'upTrZvYWTbzoZKTI9Up9uGWYHiamL3LCWNvfiTrx';
    private static $rest_key   =   'NUyL27OK8vIdZGtiqwskfVyPAiCT0Z6zCm7d3NXG';
    private static $master_key =   'UXkRORqhyp22XBg28k0EOxSZitOgVRv5gaDWFHJ8';

    public function __construct(){

        parent::__construct();
        //TODO:  Add extra constructor Code
        ParseClient::initialize(self::$app_id, self::$rest_key, self::$master_key);
        ParseClient::setServerURL('https://notibrew-beta.herokuapp.com');
        $this->load->library("session");
        $this->load->library("pagination");
        $this->load->helper('url');
        $this->load->model('muser');

    }

    public function index(){
        if (!$this->session->userdata('isSigned')) {
            redirect('auth/index');
        }

        $all_users = $this->getUserlist();
        $result_array = array();
        $this->data['users'] = array();
        $config = array();
        $config["base_url"] = base_url() . "users";
        $config["total_rows"] = count($all_users);
        $config["per_page"] = 4;
        $config["uri_segment"] = 2;

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $str_links = $this->pagination->create_links();
        $this->data['links'] = explode('&nbsp;',$str_links );

        for ($i = $page; $i < ($page + 4); $i++) {
            try {
                if ($all_users[$i]) {
                    $cUser = $all_users[$i];

                    $query = new ParseQuery("Stores");
                    $query->equalTo("storeOwner", $cUser->user_id);
                    
                    $result = $query->first();
                    //print_r($result);exit;
                    if (!$result) continue;
                    
                    $cUser->business_name = $result->get("storeName");
                    $result_array[] = $all_users[$i];
                } else {
                    break;
                }
            } catch (Exception $e) {
                break;
            }
        }

        //print_r($result_array);exit;
        $this->data['users'] = $result_array;
        $this->data['page'] = "users";
        $this->load->view('users/index', $data);
    }

    private function getUserList() {
        $query = new ParseQuery("Approve");
        //if (!user_can(UP_ALL)) 
        // $query->notEqualTo("user", $this->session->userdata('userid'));
        $query->equalTo("status", USER_STATUS_REGISTER);
        $query->includeKey("user");
        $result = $query->find();

        // print_r($result);exit;
        $resultArray = array();
        for($i = 0; $i < count($result); $i++) {
            $userPointer = $result[$i];
            // print_r($userPointer->get("user"));exit;
            $object = $userPointer->get("user");

            $store = new MUser();
            $store->user_id = $object->getObjectId();
            $store->user_name = $object->get("fullname");
            $store->user_email = $object->get("email");
            $store->user_phone = $object->get("phone");
            $store->user_status = $object->get("approved");
            $store->business_type = $object->get("permission");

            $resultArray[] = $store;
        }
        return $resultArray;
    }

    public function approve($user_id) {
        $query = new ParseQuery("Approve");
        //if (!user_can(UP_ALL)) 
        // $query->equalTo("objectId", $user_id);
        $query->equalTo("user", ['__type' => "Pointer", 'className'=> "_User", 'objectId' => $user_id]);
        $query->includeKey("user");
        $user = $query->first();
        // print_r($user);exit;
        $user->set("status", USER_STATUS_APPROVE);
        try {
            $user->save(true);
            redirect("users/");
        } catch (ParseException $ex) {
            die("Exception Occured :".$ex->getMessage());
        }
    }

    public function deny($user_id) {
        $query = new ParseQuery("_User");
        //if (!user_can(UP_ALL)) 
        // $query->equalTo("objectId", $user_id);
        $query->equalTo("user", ['__type' => "Pointer", 'className'=> "_User", 'objectId' => $user_id]);
        $query->includeKey("user");
        $user = $query->first();
        $user->set("status", USER_STATUS_DENY);
        try {
            $user->save(true);
            redirect("users/");
        } catch (ParseException $ex) {
            die("Exception Occured :".$ex->getMessage());
        }
    }
}