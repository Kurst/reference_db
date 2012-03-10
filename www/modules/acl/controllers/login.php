<?php
defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Login controller
 *
 * Controller for login page.
 *
 * @copyright   Copyright (C) 2010 Ilya Semerhanov
 * @author      Ilya Semerhanov
 * @version     1.0
 * @package     Acl_Core
 */

class Login_Controller extends Template_Controller
{
	const ALLOW_PRODUCTION = TRUE;
	
	public $template = 'login_view';
	public $acl;
	
	public function __construct()
	{
		parent::__construct();
		
		
		$this->acl = new Acl();
		
	}
	
	
	public function index()
	{
		if ($this->acl->logged_in())
		{
			url::redirect('/user/home');
		}
	
	}

        public function auth()
        {
                
        }

        public function enc()
        {
                include Kohana::find_file('vendor/phpAES','AES.class');
                $z = "abcdefgh01234568"; // 128-bit key

                $config = Kohana::config('encrypt.default');
                //die(print_r($config));

                $aes = new AES($z);
                $data = '42 is number';
                $enc = $aes->encrypt($data);
                $b64 = base64_encode($enc);
                $b_d = base64_decode($b64);
                die(print($aes->decrypt($b_d)));
              //  die(print(phpinfo()));
                /*$this->encrypt=new Encrypt;
                $encrypted_text = $this->encrypt->encode('The Answer is 42');

                die(print($encrypted_text));*/

        }
	
         /**
         * Redirects to ACL lib function <login>
         *
         */
	public function check()
	{
		$this->auto_render = FALSE;
		if ($_POST)
		{
			$username = $this->input->post('username', null, true);
			$password = $this->input->post('password', null, true);
			
			
			$this->acl->login($username, $password);
			
			url::redirect('/login');
			
		}
		else
		{
			url::redirect('/reg_msg/failure');
		}
	}
	
	
	
}


?>