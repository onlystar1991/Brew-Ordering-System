<?php defined('BASEPATH') OR exit('No direct script access allowed');
class fblogin extends CI_Controller
{
	function __construct() {
		parent::__construct();
		// Load user model
		// $this->load->model('user');
		parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
	}

	public function index(){
		// Include the facebook api php libraries
		include_once APPPATH."libraries/facebook-api-php-codexworld/facebook.php";

		// Facebook API Configuration
		$appId = '1258317107590660'; // 159228921157128
		$appSecret = '554423ab31abeee1afdb47d2f787b3d3'; // ccbb21ca556d2fe2595614746357d27c
		$redirectUrl = base_url() . 'fblogin/index';
		$fbPermissions = 'user_birthday, public_profile';
		
		//Call Facebook API
		$facebook = new Facebook(array(
			'appId'  => $appId,
			'secret' => $appSecret,
			'cookie' => true
		));
		$testData = array('test' => 'Test', 'data' => 'Data');

		$this->session->set_userdata('test', $testData);
		var_dump($testData); echo '<br><br><br>';
		$fbuser = $facebook->getUser();
		var_dump($fbuser);

		if ($fbuser) {
			$userProfile = $facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture');
			// Preparing data for database insertion
			$userData['oauth_provider'] = 'facebook';
			$userData['oauth_uid'] = $userProfile['id'];
			$userData['first_name'] = $userProfile['first_name'];
			$userData['last_name'] = $userProfile['last_name'];
			$userData['email'] = $userProfile['email'];
			$userData['gender'] = $userProfile['gender'];
			$userData['locale'] = $userProfile['locale'];
			$userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
			$userData['picture_url'] = $userProfile['picture']['data']['url'];
			// Insert or update user data
			// $userID = $this->user->checkUser($userData);
			if(!empty($userID)){
				$data['userData'] = $userData;
				$this->session->set_userdata('userData',$userData);
			} else {
				$data['userData'] = array();
			}
		} else {
			$fbuser = '';
			$data['authUrl'] = $facebook->getLoginUrl(array(
				'display' => 'popup',
				'redirect_uri'=>$redirectUrl,
				'scope'=>$fbPermissions
				));
		}

		var_dump($data);
		$this->load->view('user_authentication/index',$data);
	}
	
	public function logout() {
		$this->session->unset_userdata('userData');
		$this->session->sess_destroy();
		redirect('/fblogin');
	}
}