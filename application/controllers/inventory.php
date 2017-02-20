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
use Parse\ParseInstallation;
use Parse\ParsePush;

class Inventory extends CI_Controller{

    private static $app_id     =   'upTrZvYWTbzoZKTI9Up9uGWYHiamL3LCWNvfiTrx';
    private static $rest_key   =   'NUyL27OK8vIdZGtiqwskfVyPAiCT0Z6zCm7d3NXG';
    private static $master_key =   'UXkRORqhyp22XBg28k0EOxSZitOgVRv5gaDWFHJ8';

    public function __construct() {

        parent::__construct();
        ParseClient::initialize(self::$app_id, self::$rest_key, self::$master_key);
        ParseClient::setServerURL('https://notibrew-beta.herokuapp.com', 'parse');
        $this->load->model('minventory');
        $this->load->model('mstore');
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->library("session");

    }

    public function index() {
        if (!$this->session->userdata('isSigned')) {
            redirect('auth/index');
        }
        
        $permission = $this->session->userdata('permission');
        $all_inventories = $this->getInventorylist();
        $result_array = array();
        $this->data['inventories'] = array();
        $config = array();
        $config["base_url"] = base_url() . "inventory";
        $config["total_rows"] = count($all_inventories);
        $config["per_page"] = 2;
        $config["uri_segment"] = 2;

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $str_links = $this->pagination->create_links();
        $this->data['links'] = explode('&nbsp;',$str_links );

        for ($i = $page; $i < ($page + 2); $i++) {
            try {
                if ($all_inventories[$i]) {
                    $result_array[] = $all_inventories[$i];    
                } else {
                    break;
                }
            } catch (Exception $e) {
                break;
            }
        }
        
        $this->data['inventories'] = $result_array;
        $this->data['page'] = "inventory";

        // $this->data['beers'] = $this->getBeerList();

        $this->data['stores'] = $this->getStoreList();
        $this->data['registered'] = isset($registerd)?true:false;
        
        if ($permission == "retailer") {
            $this->load->view('inventory/index', $data);
        } else {

            $this->load->view('inventory/distributor', $data);
        }
    }

    private function getStoreList() {
        $query1 = new ParseQuery("Stores");

        if (!user_can(UP_ALL))
            $query1->equalTo("storeOwner", $this->session->userdata('userid'));

        $result1 = $query1->find();
        $resultArray1 = array();
        for($i = 0; $i < count($result1); $i++) {
            $object = $result1[$i];
            
            $store = new MStore();
            $store->store_id = $object->getObjectId();
            $store->store_name = $object->get("storeName");

            $resultArray1[] = $store;

        }
        return $resultArray1;
    }
    
    public function getBeers() {
        
        $query = new ParseQuery("BreweryBeers");
        $query->limit(1000);
        $result = $query->find();
        $resultArray2 = array();
        for($i = 0; $i < count($result); $i++) {
            $object = $result[$i];

            $resultArray2[] = $object->get("name");
        }
        echo json_encode($resultArray2);
    }

    private function getInventorylist() {
       
        $query = new ParseQuery("Inventory");

        if (!user_can(UP_ALL))
            $query->equalTo("inventoryOwner", $this->session->userdata['userid']);
        
        $result = $query->find();
        $resultArray = array();
        for($i = 0; $i < count($result); $i++) {
            $object = $result[$i];

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
        return $resultArray;
    }

    
    public function delete($sId = "") {
        if (!$sId) {
            redirect("inventory/");
        } else {
            $query = new ParseQuery("Inventory");
            $inventory = $query->get($sId);
            $inventory->destroy();
            redirect("inventory/");
        }
    }

    public function edit($fId = "", $sId = "") {
        if (!$fId) {
            redirect("inventory/");
        } else {
            $query = new ParseQuery("Inventory");
            $resultArray = array();

            $inventory = $query->get($fId);

            $minventory = new MInventory();
            $minventory->inventory_id = $inventory->getObjectId();
            $minventory->inventory_name = $inventory->get("inventoryName");
            $minventory->inventory_sku = $inventory->get("inventorySku");
            $minventory->inventory_distributor = $inventory->get("inventoryDistributor");
            $minventory->inventory_quantity = $inventory->get("inventoryQuantity");
            $minventory->inventory_demand = $inventory->get("inventoryDemand");
            $minventory->inventory_price = $inventory->get("inventoryPrice");    

            $resultArray[] = $minventory;

            if ($sId) {
                $inventory1 = $query->get($sId);

                $minventory1 = new MInventory();
                $minventory1->inventory_id = $inventory1->getObjectId();
                $minventory1->inventory_name = $inventory1->get("inventoryName");
                $minventory1->inventory_sku = $inventory1->get("inventorySku");
                $minventory1->inventory_distributor = $inventory1->get("inventoryDistributor");
                $minventory1->inventory_quantity = $inventory1->get("inventoryQuantity");
                $minventory1->inventory_demand = $inventory1->get("inventoryDemand");
                $minventory1->inventory_price = $inventory1->get("inventoryPrice");    
                $resultArray[] = $minventory1;
            }            
            
            $this->data['inventory'] = $resultArray;
            $this->load->view("inventory/edit", $data);
        }
    }
    public function save() {
        
        $query = new ParseQuery("Inventory");
        $inventory = $query->get($this->input->post("inventory_id1"));

        $inventory->set("inventoryOwner", $this->session->userdata['userid']);
        $inventory->set("inventoryName", $this->input->post("name1"));
        $inventory->set("inventorySku", $this->input->post("sku1"));
        $inventory->set("inventoryDistributor", $this->input->post("distributor1"));
        $quantity = $this->input->post("quantity1");

        $inventory->set("inventoryQuantity", (int)$quantity);
        $inventory->set("inventoryPrice", $this->input->post("price1"));

        //second
        if (!$this->input->post("inventory_id2")) {
            try {
                $inventory->save();
                redirect("inventory/");
            } catch (ParseException $ex) {
                die("Exception Occured :".$ex->getMessage());
            }
        }

        $inventory1 = $query->get($this->input->post("inventory_id2"));

        $inventory1->set("inventoryName", $this->input->post("name2"));
        $inventory1->set("inventorySku", $this->input->post("sku2"));
        $inventory1->set("inventoryDistributor", $this->input->post("distributor2"));
        $quantity = $this->input->post("quantity2");

        $inventory1->set("inventoryQuantity", (int)$quantity);
        $inventory1->set("inventoryPrice", $this->input->post("price2"));

        try {
            $inventory->save();
            $inventory1->save();
            redirect("inventory/");
        } catch (ParseException $ex) {
            die("Exception Occured :".$ex->getMessage());
        }
    }

    public function saveBeer() {
        $sku = $this->input->post("sku");
        $price = $this->input->post("price");
        $name = $this->input->post("name");
        $distributor = $this->input->post("distributor");
        $quantity = $this->input->post("quantity");
        $demand = $this->input->post("demand");
        $storeId = $this->input->post("store_id");

        $inventory = new ParseObject("Inventory");
        
        $inventory->set("inventorySku", $sku);
        $inventory->set("inventoryPrice", "$".$price);
        $inventory->set("inventoryName", $name);
        $inventory->set("inventoryDistributor", $distributor);
        $inventory->set("inventoryQuantity", (int)$quantity);
        $inventory->set("inventoryDemand", (int)$demand);
        $inventory->set("createdBy", $this->session->userdata['permission']);
        $inventory->set("storeId", $storeId);

        try {
            $inventory->save();
            if ($this->session->userdata['permission'] == "bar") {
                $alert = $name . " is now on tap @ " . $this->session->userdata['username'];
            } else if ($this->session->userdata['permission'] == "brewery") {
                $alert = $name . " is available @ " . $this->session->userdata['username'];
            } else {
                $alert = $name . " is now available at " . $this->session->userdata['username'] . "'s Liquors";
            }

            $query = new ParseQuery("_Installation");
            $query->EqualTo("appName", 'NotiBrew');
            $devices = $query->find(true);
            // $query = ParseInstallation::query();
            
            for($i = 0; $i < count($devices); $i++) {
                $object = $devices[$i];
                $deviceToken = $object->get("deviceToken");
                if ($deviceToken) {
                    if (!$this->sendPushNotification($deviceToken, $alert)) {
                        die("fail");
                    }
                }
                
            }
            redirect("inventory");
        } catch (ParseException $e) {
            die(print_r($e));
        }
    }

    public function sendPushNotification($deviceToken, $message) {

        $passphrase = 'Notibrew';
        $ctx = stream_context_create();
    
        stream_context_set_option($ctx, 'ssl', 'local_cert', PEM_LOC);
        
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        
        // Open a connection to the APNS server
        //'ssl://gateway.push.apple.com:2195'
        // tls://gateway.sandbox.push.apple.com:2195

        // $fp = stream_socket_client( 'ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

        $fp = stream_socket_client( 'tls://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
       
        if (!$fp)
        {
            echo "Error Ocurred";
            return false;
        } else {
            $body['aps'] = array(
                    'alert' => array(
                    'title'=>'Alert title',
                    'body'=>$message
                ),
                'sound' => 'BeerSound.wav',
                'Person' =>array(
                    'userId'=>'test_id12345',
                    'name'=>'Test name push',
                    'image'=>'Test image'
                )
            );
             
             $body['message'] = 'notification_type';
             // Encode the payload as JSON
             $payload = json_encode($body);
             
             // Build the binary notification
             $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
             
             // Send it to the server
             $result = fwrite($fp, $msg, strlen($msg));
             
             fclose($fp);
             return true;
         }
    }
}