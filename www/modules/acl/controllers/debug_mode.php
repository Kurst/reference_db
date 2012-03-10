<?php
defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Reg_msg controller
 *
 * Special controller for custom messages in registration module.
 * 
 * @copyright   Copyright (C) 2010 Ilya Semerhanov
 * @author      Ilya Semerhanov
 * @version     1.2
 * @package     Acl_Core
 */

class Debug_mode_Controller extends Template_Controller
{
	const ALLOW_PRODUCTION = TRUE;

	public $template = 'debug_mode_view';
	public $acl;

	public function __construct()
	{
		parent::__construct();
                $this->template->title        = "";
                $this->template->sub_title    = "";
                $this->template->msg          = "";
                $this->users_db = new Acl_Model();
                $this->session  = Session::instance();
                $username = $this->session->get('username');
                if(!$this->users_db->check_debug_mode($username))
                {
                         url::redirect('/');
                }

	}

        public function index()
        {
              $this->template->title        = "Включен режим разработки";
              $this->template->sub_title    = "Включен режим разработки";
              $this->template->msg          = "Доступ временно ограничен. Попробуйте зайти позже.";
              $this->template->link_text    = "Назад";
              $this->template->link         = "/";
        }


       

        

}
?>
