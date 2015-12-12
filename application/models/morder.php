<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 1/7/15
 * Time: 9:35 PM
 */

use Parse\ParseException;
use Parse\ParseObject;
use Parse\ParseQuery;

class MOrder extends CI_Model {

    //show in index view
    var $order_id;
    var $order_customer_name;
    var $order_date;
    var $order_payment_method;
    var $order_detail;
    var $order_isAproved;
    var $order_deniedReason;
    var $order_inStock;
    

    //Dialog
    
    var $order_beer_name;
    var $order_beer_price;
    var $order_beer_qty;
    //save date in parse db

    public function __construct()
    {
        parent::__construct();
    }
}