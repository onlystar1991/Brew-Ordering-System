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

class MMarketing extends CI_Model {

    //
    var $marketing_id;
    var $marketing_name;
    var $marketing_convention;
    var $marketing_reach;
    var $marketing_end_date;

    // will show at edit
    
    var $marketing_location;
    var $marketing_end_time;
    var $marketing_start_date;
    var $marketing_start_time;
    var $marketing_head_line;
    var $marketing_text;
    var $marketing_image_url;
    var $marketing_video_url;
    
    public function __construct()
    {
        parent::__construct();
    }
}