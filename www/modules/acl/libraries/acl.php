<?php
defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Acess control list library
 * 
 * @copyright   Copyright (C) 2010 Ilya Semerhanov
 * @author      Ilya Semerhanov
 * @version     1.2
 * @package     Acl_Core
 */



class Acl
{
	protected $session;
	protected $users_db;
	
	
	public static function factory()
	{
		return new Acl();
	}

        /**
         * Returns message access denie
         *
         */
	public static function access_denied()
	{
		die("Access denied");
	}

        /**
         * Returns username from session
         *
         */
	public static function username()
	{
                $ses = Session::instance();
		return $ses->get('username');

	}

        public static function fullname()
        {
                $db  = new Profile_Model;
		$ses = Session::instance();
		$username = $ses->get('username');
                $name = $db->get_author_date($username)->family.' '.$db->get_author_date($username)->name;
                return $name;
        }




        public function __construct()
	{
                require_once Kohana::find_file('vendor/phpAES','AES.class');
		$this->session  = Session::instance();
		$this->users_db = new Acl_Model();
		
	}

        /**
         * Generate random hash code
         *
         * @param int $lenght hash code lenght
         * @return string hash code
         */
	public function generateHash($length = 6)
	{
		//$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
                $chars = "0123456789abcdefghijk0123456789lmnopqrstuvwxyz0123456789";
		$code  = "";
		$clen  = strlen($chars) - 1;
		while (strlen($code) < $length)
		{
			$code .= $chars[mt_rand(0, $clen)];
		}
		return $code;
	}

        /**
         * Add user to database
         *
         * @param string $username username
         * @param string $password password
         * @return bool true|false
         */
	public function add_user($username = '',$password = '',$hash = '')
	{
		if (!isset($username) || !isset($password))
		{
			return false;
		}
		else
		{
			$user = $this->users_db->get_user($username);
			if(!$user)
			{
				$password = md5(md5($password));
				$data = array(
                        	'username' => $username,
                        	'password' => $password,
                                'hash'     => $hash
                        	
                    		 );
                                $ins_id = $this->users_db->add_user($data);
                                
                                return $ins_id;
                
			}
		}
		
	}

        /**
         * Login function. Generates hash code from password and sets it to
         * the session
         *
         * @param string $username username
         * @param string $password password
         * @return bool
         */
	public function login($username = '', $password = '')
	{
		if (!isset($username) || !isset($password))
		{
			return false;
		}
		else
		{
                       
			$user = $this->users_db->get_user($username);
                        
			if ($user != false)
			{

				$password = md5(md5($password));
				if ($username == $user->username && $password == $user->password && $user->active == 1)
				{
                                        
                                        $encrypt_config = Kohana::config('encrypt.default');
                                        $u_cut = substr($username,1,3);
                                        
                                        $aes = new AES($encrypt_config['key'].$u_cut);
					//$hash = md5(md5($this->generateHash(12)));
					//$this->users_db->insert_hash($user->id,$hash);
                                        //User agent + username + IP + salt
					$uniq_data = $_SERVER['HTTP_USER_AGENT'].$user->username.$_SERVER['REMOTE_ADDR'].$encrypt_config['salt'];
                                        $uniq_hash = md5(md5($uniq_data) + $encrypt_config['salt']);
                                        $aes_crypt = $aes->encrypt($uniq_hash);
                                        $base_64 = base64_encode($aes_crypt);
					$this->session->destroy();
					$this->session->create();
                                        
					$timeout = time() + Kohana::config('acl.timeout');
					$data = array(
						'username'  => $username,
						'signature' => $base_64,
                                                'timeout'   => $timeout
					);
					
					$this->session->set($data);
					return true;
					
					
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
	}

        /**
         * Check if user is logged in
         *
         * @return bool true|false
         */
	public function logged_in()
	{
                

		$username = $this->session->get('username');
                if($this->users_db->check_debug_mode($username))
                {
                         url::redirect('/debug_mode/');
                }
		$signature = $this->session->get('signature');
                $timeout = $this->session->get('timeout');
               	$exp_time = intval($timeout);
		if (empty($username) || empty($signature) || empty($timeout))
		{
			return false;
		}
		else
		{
                        if(time() < $timeout)
                        {
                                $encrypt_config = Kohana::config('encrypt.default');
                                $u_cut = substr($username,1,3);
                                $aes = new AES($encrypt_config['key'].$u_cut);
                                $base_64_decode = base64_decode($signature);
                                $aes_decrypt = $aes->decrypt($base_64_decode);
                                
                                $client_data = $_SERVER['HTTP_USER_AGENT'].$username.$_SERVER['REMOTE_ADDR'].$encrypt_config['salt'];
                                $client_hash = md5(md5($client_data) + $encrypt_config['salt']);

                                if($aes_decrypt == $client_hash)
                                {
                                        $timeout = time() + Kohana::config('acl.timeout');
					$data = array(
                                                'timeout'   => $timeout
					);

					$this->session->set($data);
                                        return true;
                                }else
                                {
                                        return false;
                                }

                        }else
                        {
                                Session::instance()->destroy();
                                url::redirect('/reg_msg/timeout');
                        }
                        
 
		}
	}

        /**
         * Delete hash code from database and clear session
         *
         */
	public function logout()
	{
		if($this->logged_in())
		{
                        Session::instance()->destroy();
       	
		}else
		{
			url::redirect('/reg_msg/failure');
		}
	
              
   
	}

        /**
         * Check if user is in group
         *
         * @param string $group Group name
         * @return bool true|false
         */
        public function logged_as($group)
        {
                if($this->logged_in())
                {
                        $username = $this->session->get('username');
                        if (empty($username))
                        {
                                return false;
                        }else
                         {
                                $flag = $this->users_db->get_flag($username,$group);
                                
                                
                                if($flag[0] == 1)
                                {
                                        return true;
                                }else
                                {
                                        return false;
                                }
                                
                         }
                }else
                {
                       return false;
                }
               

        }

        /**
         * Auto authentication by roles.
         *
         */
        public function logged_auto()
        {

                $username = $this->session->get('username');
                $path = uri::segment(1)."/".uri::segment(2);
                if($this->logged_in())
                {
                         if (empty($username))
                         {
                                 return false;
                         }else
                         {
                                 $allow_flag = $this->users_db->get_allow_flag($username,$path);
                                 if($allow_flag == 1)
                                 {
                                         return true;
                                 }else
                                 {
                                         return false;
                                 }
                         }
                }else
                {
                       return false;
                }
        }


        public function role()
        {
            
            $username = $this->session->get('username');
            if($this->logged_in())
            {
                 if (empty($username))
                 {
                         return false;
                 }else
                 {
                         return $this->users_db->get_role($username)->name;
                         
                 }
                

            }else
            {
                return false;
            }
        }

        


	
	
	
}


?>