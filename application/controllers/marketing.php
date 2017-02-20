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

class Marketing extends CI_Controller{

    private static $app_id     =   'upTrZvYWTbzoZKTI9Up9uGWYHiamL3LCWNvfiTrx';
    private static $rest_key   =   'NUyL27OK8vIdZGtiqwskfVyPAiCT0Z6zCm7d3NXG';
    private static $master_key =   'UXkRORqhyp22XBg28k0EOxSZitOgVRv5gaDWFHJ8';

    public function __construct() {
        
        parent::__construct();
        ParseClient::initialize(self::$app_id, self::$rest_key, self::$master_key);
        ParseClient::setServerURL('https://notibrew-beta.herokuapp.com');
        $this->load->model('mmarketing');
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->library("session");
        $this->load->library('form_validation');

    }

    public function index() {
        if (!$this->session->userdata('isSigned')) {
            redirect('auth/index');
        }
        $all_markets = $this->getMarketinglist();
        $result_array = array();
        $this->data['marketings'] = array();
        $config = array();
        $config["base_url"] = base_url() . "marketing";
        $config["total_rows"] = count($all_markets);
        $config["per_page"] = 4;
        $config["uri_segment"] = 2;

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $str_links = $this->pagination->create_links();
        $this->data['links'] = explode('&nbsp;',$str_links );

        for ($i = $page; $i < ($page + 4); $i++) {
            try {
                if ($all_markets[$i]) {
                    $result_array[] = $all_markets[$i];
                } else {
                    break;
                }
            } catch (Exception $e) {
                break;
            }
        }

        $this->data['marketings'] = $result_array;
        $this->data['page'] = "marketing";

        $this->load->view('marketing/index', $data);
    }
    
    private function getMarketinglist() {
        $query = new ParseQuery("Campaign");

        if (!user_can(UP_ALL))
            $query->equalTo("campaignOwner", $this->session->userdata("userid"));
        $result = $query->find();
        $resultArray = array();

        for($i = 0; $i < count($result); $i++) {
            $object = $result[$i];
            $marketing = new MMarketing();

            $marketing->marketing_id = $object->getObjectId();
            $marketing->marketing_name = $object->get("campaignName");
            $marketing->marketing_convention = $object->get("campaignConvention");
            $marketing->marketing_reach = $object->get("campaignReach");
            $marketing->marketing_end_date = $object->get("campaignEndDate");

            $resultArray[] = $marketing;
        }
        return $resultArray;
    }

    
    public function delete($sId = "") {
        if (!$sId) {
            redirect("marketing/");
        } else {
            $query = new ParseQuery("Campaign");
            $store = $query->get($sId);
            $store->destroy();
            redirect("marketing/");
        }
    }

    public function edit($sId = "") {
        if (!$sId) {
            redirect("marketing/");
        }
            $query = new ParseQuery("Campaign");
            $object = $query->get($sId);
            $mmarketing = new MMarketing();

            $marketing->marketing_name = $object->get("campaignName");
            $marketing->marketing_convention = $object->get("campaignConvention");
            $marketing->marketing_reach = $object->get("campaignReach");
            $marketing->marketing_end_date = $object->get("campaignEndDate");

            $marketing->marketing_location = $object->get("campaignLocation");
            $marketing->marketing_end_time = $object->get("campaignEndTime");
            $marketing->marketing_start_date = $object->get("campaignStartDate");
            $marketing->marketing_start_time = $object->get("campaignStartTime");
            $marketing->marketing_head_line = $object->get("campaignHeadLine");
            $marketing->marketing_text = $object->get("campaignDescription");
            $marketing->marketing_image_url = $object->get("campaignImageUrl");
            $marketing->marketing_video_url = $object->get("campaignVideoUrl");
            
            $this->data['marketing'] = $marketing;
            $this->load->view("marketing/edit", $data);
        
    }
    public function save() {
        
        // var_dump($_FILES);
        $query = new ParseQuery("Campaign");
        // $store = $query->get($sId);
        $marketing = $query->get($this->input->post("marketingId"));
        $locationArray = $this->input->post("locations");
        $locations = "";
        foreach ($locationArray as $location) { 
            $locations = $locations.$location.";";
        }

        $marketing->set("campaignStartTime", $this->input->post("startTime"));
        $marketing->set("campaignName", $this->input->post("campaignName"));
        $marketing->set("campaignLocation", $locations);
        $marketing->set("campaignStartDate", $this->input->post("startDate"));
        $marketing->set("campaignEndDate", $this->input->post("endDate"));
        $marketing->set("campaignEndTime", $this->input->post("endTime"));
        $marketing->set("campaignHeadLine", $this->input->post("headline"));
        $marketing->set("campaignDescription", $this->input->post("text"));
        $marketing->set("campaignImageUrl", $this->input->post("imageURL"));
        $marketing->set("campaignVideoUrl", $this->input->post("videoURL"));
        $marketing->set("campaignOwner", $this->session->userdata("userid"));
        
        try {
            $marketing->save();
            redirect("marketing/");
        } catch (ParseException $ex) {
            die("Exception Occured :".$ex->getMessage());
        }
    }
    public function add() {
        $this->load->view('marketing/add');
    }

    public function create() {

        $marketing = new ParseObject("Campaign");
        
        $locations = "";

        foreach ($this->input->post("locations") as $location) {
            $locations = $locations.$location.";";
        }

        $marketing->set("campaignStartTime", $this->input->post("startTime"));
        $marketing->set("campaignName", $this->input->post("campaignName"));
        $marketing->set("campaignLocation", $locations);
        $marketing->set("campaignStartDate", $this->input->post("startDate"));
        $marketing->set("campaignEndDate", $this->input->post("endDate"));
        $marketing->set("campaignEndTime", $this->input->post("endTime"));
        $marketing->set("campaignHeadLine", $this->input->post("headline"));
        $marketing->set("campaignDescription", $this->input->post("text"));
        $marketing->set("campaignImageUrl", $this->input->post("imageURL"));
        $marketing->set("campaignVideoUrl", $this->input->post("videoURL"));
        $marketing->set("campaignOwner", $this->session->userdata("userid"));
        
        try {
            $marketing->save();
            redirect("marketing/");
        } catch (ParseException $ex) {
            die("Exception Occured :".$ex->getMessage());
        }
    }
}