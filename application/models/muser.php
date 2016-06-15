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

class MUser extends CI_Model {

    var $user_id;
    var $user_name;
    var $user_email;
    var $user_phone;
    var $business_name;
    var $business_type;
    var $user_status;

    public function __construct()
    {
        parent::__construct();
    }
}