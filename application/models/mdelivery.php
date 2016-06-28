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

class MDelivery extends CI_Model {

    //show in index view
    var $delivery_id;
    var $delivery_store;
    var $delivery_price;
    var $delivery_eta;
    
    //save date in parse db

    public function __construct()
    {
        parent::__construct();
    }
}