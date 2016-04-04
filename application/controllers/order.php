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


class Order extends CI_Controller {

    private static $app_id     =   'upTrZvYWTbzoZKTI9Up9uGWYHiamL3LCWNvfiTrx';
    private static $rest_key   =   'NUyL27OK8vIdZGtiqwskfVyPAiCT0Z6zCm7d3NXG';
    private static $master_key =   'UXkRORqhyp22XBg28k0EOxSZitOgVRv5gaDWFHJ8';

    public function __construct() {

        parent::__construct();
        ParseClient::initialize(self::$app_id, self::$rest_key, self::$master_key);
        $this->load->model('morder');
        $this->load->model('minventory');
        $this->load->model('mdistributor');
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->library("session");
    }

    public function index() {
        
        if (!$this->session->userdata('isSigned')) {
            redirect('auth/index');
        }

        $all_orders = $this->getOrderlist();
        $result_array = array();
        $this->data['orders'] = array();
        $config = array();
        $config["base_url"] = base_url() . "order";
        $config["total_rows"] = count($all_orders);
        $config["per_page"] = 4;
        $config["uri_segment"] = 2;

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $str_links = $this->pagination->create_links();
        $this->data['links'] = explode('&nbsp;',$str_links );

        for ($i = $page; $i < ($page + 4); $i++) {
            try {
                if ($all_orders[$i]) {
                    $result_array[] = $all_orders[$i];    
                } else {
                    break;
                }
            } catch (Exception $e) {
                break;
            }
        }
        
        $this->data['orders'] = $result_array;
        $this->data['instocks'] = $this->getInStocklist();
        $this->data['distributors'] = $this->getDistributorlist();

        $this->data['page'] = "order";

        $permission = $this->session->userdata("permission");
        

        if ($permission == "retailer") {
            $this->load->view('order/index', $data);
        } else if ($permission == "distributor") {
            $this->load->view('order/distributor_order', $data);
        } else {
            die("invalid permission");
        }
    }

    public function action_approve() {
     
        $id = $this->input->post("order_id");
        try {
            $query = new ParseQuery("MyOrders");
            $order = $query->get($id);
            $order->set("isApproved", true);
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
    

    public function action_deny() {
     
        $id = $this->input->post("order_id");
        $reason = $this->input->post("reason");
        
        try {
            $query = new ParseQuery("MyOrders");
            $order = $query->get($id);
            $order->set("isApproved", false);
            $order->set("deniedReason", $reason);
            $result = array();
            $order->save();
            $result['id'] = $id;
            $result['result'] = 'success';
            $result['reason'] = $reason;
        } catch (ParseException $ex) {
            $result['id'] = $id;
            $result['result'] = 'fail';
        }
        echo json_encode($result);
        exit;
    }

    private function getOrderlist() {
       
        $query = new ParseQuery("MyOrders");

        $query->notEqualTo("inStock", NULL);

        $result = $query->find();

        $resultArray = array();
        for($i = 0; $i < count($result); $i++) {
            $object = $result[$i];

            $order = new MOrder();

            $order->order_id = $object->getObjectId();

            $order->order_customer_name = $object->get("beerCreator");
            
            $order->order_payment_method = $object->get("cardType");

            $order->order_date = $object->getCreatedAt()->format('Y-m-d');

            $order->order_detail = $object->get("beerDescription");

            $order->order_isAproved = $object->get("isApproved");

            $order->order_deniedReason = $object->get("deniedReason");

            $order->order_beer_name = $object->get("beerTitle");
            
            $order->order_beer_price = $object->get("beerItemPrice");
            
            $order->order_beer_qty = $object->get("count");

            $order->order_inStock = $object->get("inStock");
            
            $resultArray[] = $order;
        }
        return $resultArray;
    }

    private function getInStocklist() {
       
        $query = new ParseQuery("Inventory");
        $result = $query->find();
        $resultArray = array();
        for($i = 0; $i < count($result); $i++) {
            
            $object = $result[$i];
            if ($object->get("inStock")) {
                $inventory = new MInventory();
                $inventory->inventory_id = $object->getObjectId();
                $inventory->inventory_name = $object->get("inventoryName");
                $inventory->inventory_sku = $object->get("inventorySku");
                $inventory->inventory_distributor = $object->get("inventoryDistributor");
                $inventory->inventory_quantity = $object->get("inventoryQuantity");
                $inventory->inventory_demand = $object->get("inventoryDemand");
                $inventory->inventory_price = $object->get("inventoryPrice");

                $inventory->inventory_in_stock = $object->get("inStock");
                $inventory->inventory_arrive_date = date_format($object->get("arriveDate"), "d/m/Y");
                $resultArray[] = $inventory;   
            }
        }
        return $resultArray;
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
            
            $resultArray[] = $distributor;
        }
        return $resultArray;
    }

    public function finalizeOrder() {

        $id = $this->input->post("order_id");
        try {
            $query = new ParseQuery("MyOrders");
            $order = $query->get($id);
            $qty = $order->get("count");
            

            $query1 = new ParseQuery("Inventory");
            $query1->equalTo("inventoryName", $order->get("beerTitle"));
            $result1 = $query1->first();
            $count = $result1->get("inventoryQuantity");
            $result1->set("inventoryQuantity", $count-$qty);
            $result1->save();

            $result['id'] = $id;
            $result['result'] = 'success';
        } catch(ParseException $ex) {
            $result['id'] = $id;
            $result['result'] = 'fail';
        }
        echo json_encode($result);
        exit;
    }
}