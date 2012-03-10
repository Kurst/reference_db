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

class Register_Controller extends Template_Controller
{
	const ALLOW_PRODUCTION = TRUE;

        public $template = 'register_view';
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
                $this->template->style = '';
	}


	public function index()
	{
               
                
        }

         /**
         * Checks that email and password are correct. Then calls Create function.
         *
         */

        public function ok()
	{
		if ($_POST)
		{
                        $post = new Validation($_POST);
			$post->pre_filter('trim', TRUE);
                        $post->add_rules('email', 'required', 'email');
			$post->add_rules('password', 'required', 'standard_text');
			$post->add_rules('confirm', 'required', 'standard_text');

                        if($post->password!=$post->confirm)
                        {
                                $post->add_error('confirm', 'pwd_check');

                        }
                        if($this->users_db->user_exist($post->email))
                        {
                                 $post->add_error('email', 'exist_check');

                        }
			if ($post->validate())
			{
                                $username = $this->input->post('email', null, true);
                                $password = $this->input->post('password', null, true);

                                
                                $hash = $this->acl->generateHash(32);
                                $ins_id = $this->acl->add_user($username,$password,$hash);

                                if($ins_id > 0)
                                {
                                        $to      = $username;
                                        $from    = 'Система RefDB';
                                        $subject = 'Регистрация';
                                        $message = '
                                                    <p>Здравствуйте, вы начали процедуру регистрации в системе Reference_db</p>
                                                    <p>Для продолжения регистрации перейдите по ссылке:<br/>
                                                    <a href="'.url::base().'register/proceed/'.$ins_id.'/'.$hash.'">
                                                             '.url::base().'register/proceed/'.$ins_id.'/'.$hash.'</a>
                                                    </p>

                                                ';

                                        if(email::send($to, $from, $subject, $message, TRUE))
                                        {
                                                 url::redirect('/reg_msg/activate');
                                        }



                                }
                                
                                



                        }else
                        {
                                $this->template->values   = arr::overwrite($this->template->values, $post->as_array());
                                $this->template->errors = arr::overwrite($this->template->errors, $post->errors('form_error_messages'));
                        }

                        
                       


                }else
                {
                        url::redirect('/reg_msg/failure');
                        
                }

        }

        
        /**
         * Calls after user click link in email. Check if email is presented in
         * author table. If true calls auto_connect function, else calls man_connection function
         *
         * @param int $id new user id
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
                                $this->session->destroy();
				$this->session->create();

				$data = array(
						'step' => '2'
				);

				$this->session->set($data);

                                $author = $this->users_db->get_author_by_email($user->username);
                                if($author)
                                {
                                        //auto connect
                                        url::redirect('/register/auto_connect/'.$id.'/'.$author->id);

                                }else
                                {
                                        //manual connect
                                        url::redirect('/register/man_connect/'.$id);
                                }

                                
                               
                        }else
                        {
                                url::redirect('/reg_msg/failure');
                        }

                }

                
        }

        /**
         * Used for automated connection user table and author table.
         * 2 types of acces:from POST and direct access. POST used for Yes\No buttons.
         * @param int $u_id user id
         * @param int $author_id author id
         */

        public function auto_connect($u_id = '',$author_id = '')
        {
                if($this->session->get('step') == '2')
                {
                        if (!$_POST)
                        {
                                if($u_id == '' || $author_id == '')
                                {
                                        url::redirect('/reg_msg/failure');
                                }else
                                {
                                        $this->template->view = 'auto_connect';
                                        $author = $this->users_db->get_author_by_id($author_id);
                                        $this->template->author = $author;
                                        $this->template->u_id = $u_id;


                                }
                        }else
                        {
                                $but = $this->input->post('button', null, true);
                                if($but == 'Да')
                                {
                                        $id = $this->input->post('u_id', null, true);
                                        $a_id = $this->input->post('author_id', null, true);
                                        $this->users_db->insert_author_id($id,$a_id);
                                        $this->users_db->activate_user($id);
                                        $this->users_db->delete_hash($id);

                                        $auth = $this->author_db->get_author_by_id($a_id);
                                        $author['family'] = $auth->family;
                                        $author['name'] = $auth->name;
                                        $author['patronymic'] = $auth->patronymic;
                                        $this->users_db->add_report_head($id,$author);
                                        $this->session->destroy();
                                        mkdir(DOCROOT.'static/images/acl/avatars/'.$id.'/');
                                        
                                        $file = DOCROOT.'static/images/acl/avatars/noava/ava.png';
                                        $newfile = DOCROOT.'static/images/acl/avatars/'.$id.'/ava.png';
                                        if(copy($file, $newfile))
                                        {
                                                url::redirect('/reg_msg/success');
                                        }
                                        
                                }else
                                {
                                        url::redirect('/reg_msg/admin');
                                }

                        }

                }else
                {
                        url::redirect('/reg_msg/failure');
                }
                
                


        }

         /**
         * Used for manual connection user table and author table.
         * 2 types of acces:from POST and direct access.
         * @param int $u_id user id
         * @param int $author_id author id
         */

        public function man_connect($u_id = '')
        {
                if($this->session->get('step') == '2')
                {
                        $this->template->view = 'man_connect';
                        $this->template->style = 'height:410px;';
                        $this->template->u_id = $u_id;



                        if($_POST)
                        {
                                $post = new Validation($_POST);
                                $post->pre_filter('trim', TRUE);
                                $post->add_rules('family', 'required', 'standard_text');
                                $post->add_rules('name', 'required', 'standard_text');
                                $post->add_rules('patronymic', 'required', 'standard_text');
                                $post->add_rules('date', 'required', 'standard_text');

                                if(!preg_match("/^((19|20)[0-9][0-9])-(0?[1-9]|1[012])-(0?[1-9]|[12][0-9]|3[01])$/", $post->date))
                                {
                                        $post->add_error('date', 'bad_format');
                                }
                                if ($post->validate())
                                {
                                        $u_id = $this->input->post('u_id', null, true);
                                        $user = $this->users_db->get_user_by_id($u_id);

                                        $author['family'] = $this->input->post('family', null, true);
                                        $author['name'] = $this->input->post('name', null, true);
                                        $author['patronymic'] = $this->input->post('patronymic', null, true);
                                        $author['date'] = $this->input->post('date', null, true);
                                        $author['sex'] = $this->input->post('sex', null, true);
                                        $author['email'] = $user->username;
                                        $a_id = $this->users_db->add_author($author);
                                        $this->users_db->add_report_head($u_id,$author);
                                        if($a_id > 0)
                                        {
                                                $this->users_db->insert_author_id($u_id,$a_id);
                                                $this->users_db->activate_user($u_id);
                                                $this->users_db->delete_hash($u_id);
                                                $this->session->destroy();
                                                mkdir(DOCROOT.'static/images/acl/avatars/'.$u_id.'/');

                                                $file = DOCROOT.'static/images/acl/avatars/noava/ava.png';
                                                $newfile = DOCROOT.'static/images/acl/avatars/'.$u_id.'/ava.png';
                                                if(copy($file, $newfile))
                                                {
                                                        url::redirect('/reg_msg/success');
                                                }
                                        }else
                                        {
                                               url::redirect('/reg_msg/failure');
                                        }


                                }else
                                {
                                        $this->template->form   = arr::overwrite($this->template->form, $post->as_array());
                                        $this->template->err = arr::overwrite($this->template->err, $post->errors('form_error_messages'));

                                }

                        }
                }else
                {
                         url::redirect('/reg_msg/failure');
                }
                



        }

        


}


?>