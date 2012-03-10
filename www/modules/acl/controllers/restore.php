<?php
defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Register controller
 *
 * @copyright   Copyright (C) 2010 Ilya Semerhanov
 * @author      Ilya Semerhanov
 * @version     1.2
 * @package     Acl_Core
 */

class Restore_Controller extends Template_Controller
{
	const ALLOW_PRODUCTION = TRUE;

        public $template = 'restore_view';
	public $acl;
        public $users_db;
        protected $session;

	public function __construct()
	{
                parent::__construct();
		$this->acl = new Acl();
                $this->users_db = new Acl_Model();
                $this->author_db = new Author_Model();
                $this->session  = Session::instance();
                if ($this->acl->logged_in())
		{
                        die('already registered');

                }
                 
                $this->template->values   = array(
			'email' => '',
			'password' => '',
			'confirm' => ''

		);
		
                $this->template->errors = array(
			'email' => '',
			'password' => '',
			'confirm' => ''

		);
                $this->template->view = 'first_step';

                $this->template->form   = array(
			'name' => '',
			'family' => '',
			'patronymic' => '',
			'date' => ''
		);
		$this->template->err = $this->template->form;
                $this->template->style = 'height:120px;';
	}


	public function index()
	{
               
                
        }


        public function check()
        {
                if ($_POST)
		{
                        $post = new Validation($_POST);
			$post->pre_filter('trim', TRUE);
                        $post->add_rules('email', 'required', 'email');

                        if ($post->validate())
			{

                                $email = $this->input->post('email', null, true);
                                $user = $this->users_db->get_user($email);
                                if($user)
                                {
                                        $hash = $this->acl->generateHash(32);
                                        $this->users_db->add_hash_to_user($user->id,$hash);
                                       
                                        $to      = $email;
                                        $from    = 'Система RefDB';
                                        $subject = 'Восстановление пароля';
                                        $message = '
                                                    <p>Здравствуйте, если вы забыли пароль и хотите его восстановить то перейдите по ссылке:
                                                   <br/>
                                                    <a href="'.url::base().'restore/proceed/'.$user->id.'/'.$hash.'">
                                                             '.url::base().'restore/proceed/'.$user->id.'/'.$hash.'</a>
                                                    </p>

                                                ';

                                        if(email::send($to, $from, $subject, $message, TRUE))
                                        {
                                                 url::redirect('/reg_msg/restore');
                                        }
                                }else
                                {
                                        url::redirect('/reg_msg/no_user');
                                }
                        }else
                        {
                                url::redirect('/reg_msg/failure');

                        }

                }else
                {
                        url::redirect('/reg_msg/failure');

                }
        }

        /**
         * Calls after user click link in email.
         *
         * @param int $id user id
         * @param int $hash temporary hash for confirming email
         */

        public function proceed($id = '',$hash = '')
        {
                if($id == '' || $hash == '')
                {
                        url::redirect('/reg_msg/failure');
                }else
                {
                        $user = $this->users_db->get_user_by_id($id);
                        if($hash == $user->hash)
                        {
                                $this->template->view = 'new_password';
                                $this->template->style = 'height:220px;';

                                $this->template->id = $user->id;
                                

                        }else
                        {
                                url::redirect('/reg_msg/failure');
                        }

                }


        }

        public function save()
        {
                if ($_POST)
		{
                        $post = new Validation($_POST);
			$post->pre_filter('trim', TRUE);
                        $post->add_rules('new_pswd', 'required');
                        $post->add_rules('confirm', 'required');

                        if ($post->validate())
			{

                                $new_pswd = $this->input->post('new_pswd', null, true);
                                $confirm = $this->input->post('confirm', null, true);
                                $id = $this->input->post('id', null, true);
                                $user = $this->users_db->get_user_by_id($id);
                                if($new_pswd == $confirm)
                                {
                                        $new_pswd = md5(md5($new_pswd));
                                        
                                        $this->users_db->update_user_pswd($user->id,$new_pswd);

                                        url::redirect('/reg_msg/restore_success');
                                }else
                                {
                                        url::redirect('/reg_msg/not_similar');
                                }
                        }else
                        {
                                url::redirect('/reg_msg/failure');

                        }

                }else
                {
                        url::redirect('/reg_msg/failure');

                }
        }


       

        


}


?>