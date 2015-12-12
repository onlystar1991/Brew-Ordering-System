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

class MDistributor extends CI_Model {

    //show in index view
    var $distributor_id;
    var $distributor_name;
    
    //save date in parse db

    public function __construct()
    {
        parent::__construct();
    }
}