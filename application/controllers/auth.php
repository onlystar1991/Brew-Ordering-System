<?php
/**
 * Created by PhpStorm.
 * User: bok
 * Date: 9/21/14
 * Time: 9:19 PM
 */
require PARSE_SDK_INC;
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

define('SIGNIN_WITHOUT_PARAMS', '');
define('SIGNIN_WITH_PARAMS',    '0');
define('SIGNUP_WITHOUT_PARAMS', '');
define('SIGNUP_WITH_PARAMS',    '1');

use Parse\ParseClient;
use Parse\ParseUser;
use Parse\ParseSessionStorage;
use Parse\ParseException;
use Parse\ParseFile;

class Auth extends CI_Controller{

    private static $app_id     =   'upTrZvYWTbzoZKTI9Up9uGWYHiamL3LCWNvfiTrx';
    private static $rest_key   =   'NUyL27OK8vIdZGtiqwskfVyPAiCT0Z6zCm7d3NXG';
    private static $master_key =   'UXkRORqhyp22XBg28k0EOxSZitOgVRv5gaDWFHJ8';

    public function __construct() {

        parent::__construct();
        //TODO:  Add extra constructor Code

        $this->load->library('session');
        session_start();
        ParseClient::initialize(self::$app_id, self::$rest_key, self::$master_key);
        ParseClient::setStorage( new ParseSessionStorage() );
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

    }

    public function index(){
        //TODO:  called when
        $type = $this->input->post('type');
       
        switch($type) {
            case SIGNIN_WITHOUT_PARAMS:
                $this->load->view('auth/signin');
                break;
            case SIGNIN_WITH_PARAMS:

                $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback__check_parse');

                if ($this->form_validation->run() == FALSE) {
                    //Field validation failed.  User redirected to login page
                    $this->load->view('auth/signin');
                } else {
                    //Go to private area
                    $user = ParseUser::getCurrentUser();
                    $permission = $user->get("permission");
                    $username = $user->get("username");
                    
                    if (user_can(UP_STORE_ALL) || user_can(UP_STORE_VIEW))
                        redirect('/store', 'get');
                    else if (user_can(UP_INVENTORY_ALL) || user_can(UP_INVENTORY_VIEW))
                        redirect('/inventory', 'get');
                    else
                        $this->load->view('auth/signin'); 
                }
                break;
            default:
                $this->load->view('auth/signin');
                break;
        }
    }

    public function  signin() {
        
    }

    public function  logout(){
        //TODO:  called when
        $this->session->sess_destroy();
        $this->load->view('auth/signin');
    }

    public function _check_parse($password){
        //TODO:  callback function when validate the form

        $username = $this->input->post('username');
        
        try{
            $user = ParseUser::logIn($username, $password);
            $this->session->set_userdata('isSigned', true);
            $this->session->set_userdata('userid', $user->getObjectId());
            $this->session->set_userdata('username', $user->getUsername());
            $this->session->set_userdata('role', user_permissions_by_role($user->get("permission")));
            $this->session->set_userdata('permission', $user->get("permission"));

            if($user->get('userphoto') == null)
                $this->session->set_userdata('userphoto', 'http://files.parsetfss.com/b56294c5-e2c0-4248-a5e2-a2f187ea5ff1/tfss-6dd72bed-731b-43fc-aa73-24e44fe368dc-profilePic.image');
            else
                $this->session->set_userdata('userphoto', $user->get('userphoto')->getURL());

            echo($user->getObjectId());

            return TRUE;

        } catch(ParseException $ex) {
            $this->form_validation->set_message('save_parse', $ex->getMessage());
            return FALSE;
        }
    }

    public function signup(){
        //TODO:  called when
        $type = $this->input->post('type');
        if(ParseUser::getCurrentUser() != NULL)
//            echo('Error');
            ParseUser::logOut();

        switch($type){
            case SIGNUP_WITHOUT_PARAMS:
                $this->load->view('auth/signup');
                break;
            case SIGNUP_WITH_PARAMS:
                $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]');
                $this->form_validation->set_rules('firstName', 'Firstname', 'trim|required|max_length[12]');
                $this->form_validation->set_rules('lastName', 'Lastname', 'trim|required|max_length[12]');
                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
                $this->form_validation->set_rules('usergroup', 'UserGroup', 'trim|required|valid_text');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]|callback__save_parse');
                $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');

                if($this->form_validation->run() == FALSE){
                    //Field validation failed.  User redirected to login page
                    $this->load->view('auth/signup');
                } else {
                    //Go to private area
                    $this->session->set_userdata('isSigned', true);
                    $this->session->set_userdata('userid',  ParseUser::getCurrentUser()->getObjectId());
                    $this->session->set_userdata('username', ParseUser::getCurrentUser()->getUsername());
                    redirect('/main/profile/'.ParseUser::getCurrentUser()->get('username'));                    
                }
                break;
            default:
        }
    }

    public function _save_parse($password) {
        //TODO:  callback function when validate the form

        $username = $this->input->post('username');
        $firstName = $this->input->post('firstName');
        $lastName = $this->input->post('lastName');
        $email = $this->input->post('email');

        try{

            ParseClient::setStorage( new ParseSessionStorage() );

            $user = new ParseUser();
            $user->set("username", $username);
            $user->set("firstName", $firstName);
            $user->set("lastName", $lastName);
            $user->set("password", $password);
            $user->set("email", $email);
            $user->signUp();
            return TRUE;

        } catch(ParseException $ex) {
            $this->form_validation->set_message('save_parse', $ex->getMessage());
            echo($ex->getMessage());
            return FALSE;
        }
    }
}