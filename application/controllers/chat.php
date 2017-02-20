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


class Chat extends CI_Controller{


    private static $app_id     =   'upTrZvYWTbzoZKTI9Up9uGWYHiamL3LCWNvfiTrx';
    private static $rest_key   =   'NUyL27OK8vIdZGtiqwskfVyPAiCT0Z6zCm7d3NXG';
    private static $master_key =   'UXkRORqhyp22XBg28k0EOxSZitOgVRv5gaDWFHJ8';


    public function __construct(){

        parent::__construct();
        //TODO:  Add extra constructor Code
        ParseClient::initialize(self::$app_id, self::$rest_key, self::$master_key);
        ParseClient::setServerURL('https://notibrew-beta.herokuapp.com');
        $this->load->library("session");
        $this->load->helper('url');

    }

    public function index(){
        //TODO:  called when method name is requested.
        if (!$this->session->userdata('isSigned')) {
            redirect('auth/index');
        }

        $this->data['page'] = "chat";

        $this->load->view('chat/index', $data);
    }

}