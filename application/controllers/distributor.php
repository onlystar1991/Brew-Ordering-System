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

class Beer {
    var $beer_title;
    var $beer_tax_price;
    var $beer_percent;
    var $beer_delivery_price;
}

class Distributor extends CI_Controller {

    private static $app_id     =   'upTrZvYWTbzoZKTI9Up9uGWYHiamL3LCWNvfiTrx';
    private static $rest_key   =   'NUyL27OK8vIdZGtiqwskfVyPAiCT0Z6zCm7d3NXG';
    private static $master_key =   'UXkRORqhyp22XBg28k0EOxSZitOgVRv5gaDWFHJ8';

    public function __construct() {

        parent::__construct();
        ParseClient::initialize(self::$app_id, self::$rest_key, self::$master_key);
        ParseClient::setServerURL('https://notibrew-beta.herokuapp.com');
        $this->load->model('mdistributor');
        $this->load->model('mdelivery');
        $this->load->model('morder');
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->library("session");
    }

    public function index() {

        if (!$this->session->userdata('isSigned')) {
            redirect('auth/index');
        }

        if ($this->session->userdata("permission") == "distributor") {
            $all_deliveries = $this->getAllDeliveries();

            $result_array = array();
            $this->data['distributors'] = array();
            $config = array();
            $config["base_url"] = base_url() . "distributor";
            $config["total_rows"] = count($all_deliveries);
            $config["per_page"] = 4;
            $config["uri_segment"] = 2;

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

            $str_links = $this->pagination->create_links();

            $this->data['links'] = explode('&nbsp;',$str_links );

            for ($i = $page; $i < ($page + 4); $i++) {
                try {
                    if ($all_deliveries[$i]) {
                        $result_array[] = $all_deliveries[$i];    
                    } else {
                        break;
                    }
                } catch (Exception $e) {
                    break;
                }
            }

            $this->data['distributors'] = $result_array;
            $this->data['page'] = "distributor";
            $this->load->view('distributor/delivery', $data);
        } else {
            $all_distributor = $this->getDistributorlist();
            $result_array = array();
            $this->data['distributors'] = array();
            $config = array();
            $config["base_url"] = base_url() . "distributor";
            $config["total_rows"] = count($all_distributor);
            $config["per_page"] = 10;
            $config["uri_segment"] = 2;

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

            $str_links = $this->pagination->create_links();

            $this->data['links'] = explode('&nbsp;',$str_links );

            for ($i = $page; $i < ($page + 4); $i++) {
                try {
                    if ($all_distributor[$i]) {
                        $result_array[] = $all_distributor[$i];    
                    } else {
                        break;
                    }
                } catch (Exception $e) {
                    break;
                }
            }
            
            $this->data['distributors'] = $result_array;
            $this->data['page'] = "distributor";

            $this->load->view('distributor/index', $data);

        }
    }
    
    private function getDistributorlist() {
       
        $query = new ParseQuery("Distributor");
        $result = $query->find();
        $resultArray = array();
        for($i = 0; $i < count($result); $i++) {
            $object = $result[$i];

            $distributor = new MDistributor();

            $distributor->distributor_id = $object->getObjectId();

            $distributor->distributor_name = $object->get("distributorName");

            $distributor->distributor_location = $object->get("distributorLocation");
            
            $distributor->distributor_phone = $object->get("distributorPhone");
            
            $distributor->distributor_contact = $object->get("distributorContactName");
            
            $resultArray[] = $distributor;
        }
        return $resultArray;
    }

    private function getAllDeliveries() {
        $query = new ParseQuery("MyOrders");
        
        $query->equalTo("isApproved", true);

        $query->includeKey("storeId");

        $result = $query->find();

        $resultArray = array();

        for($i = 0; $i < count($result); $i++) {
            

            //How to use Pointer in Parse SDK

            $object = $result[$i];

            $delivery = new MDelivery();
            $delivery->delivery_id = $object->getObjectId();

            try {
                $res = $object->get("storeId")->get('storeName');
                $delivery->delivery_store = $res;
            } catch (ParseException $ex) {
                var_dump($ex);
                die ;
            }

            $delivery->delivery_price = $object->get("beerTaxPrice") + $object->get("beerDeliveryPrice");

            $delivery->delivery_eta = date_format($object->get("deliveryDate"), "d/m/Y");
            
            $resultArray[] = $delivery;
        }

        return $resultArray;
    }

    public function save_eta() {

        $id = $this->input->post("delivery_id");
        $date = $this->input->post("value");
        try {
            $query = new ParseQuery("MyOrders");
            $order = $query->get($id);
            
            //This is formatting date for saving date type in parse db
            $saveDate = date("Y-m-d", strtotime($date));
            $saveDate = DateTime::createFromFormat("Y-m-d", $saveDate);
            $order->set("deliveryDate", $saveDate);
            
            $result = array();
            $order->save();
            $result['id'] = $id;
            $result['result'] = 'success';
        } catch (ParseException $ex) {
            $result['id'] = $id;
            $result['result'] = 'fail';
        }
        
        echo json_encode($result);
        exit;
    }

    public function view($id = "") {

        $query = new ParseQuery("Distributor");

        $distributor = $query->get($id);

        $this->data['distributor_name'] = $distributor->distributorName;
        
        try {
            $query = new ParseQuery("Beer");
            $query->equalTo("beerDistributor1", $id);
            $beers = $query->find();
            $resultArray = array();

            foreach($beers as $beer) {
                $mbeer = new Beer();
                $mbeer->beer_title = $beer->get("beerTitle");
                $mbeer->beer_tax_price = $beer->get("beerTaxPrice");
                $mbeer->beer_percent = $beer->get("beerPercent");
                $mbeer->beer_delivery_price = $beer->get("beerDeliveryPrice");
                $resultArray[] = $mbeer;
            }
            $this->data['beers'] = $resultArray;
        } catch (ParseException $ex) {
            $this->data['beers'] = array();
        }
        $this->load->view('distributor/view', $data);
    }
}