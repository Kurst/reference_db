<?php defined('SYSPATH') OR die('No direct access allowed.');

class Sxd_Controller extends Template_Controller
{
	const ALLOW_PRODUCTION = TRUE;
	public $template = 'layouts/template';
	protected $db;
	public function __construct()
	{
		parent::__construct();
		$acl = new Acl();
                $this->session  = Session::instance();

		if(!$acl->logged_auto())
		{
			url::redirect('/login');
		}
		$this->template->title        = Kohana::config('config.application_name').".Управление БД";
		$this->template->sub_title    = "Управление БД";
		$this->template->view         = new View('admin/sxd_view');
		
               
		


	}



	public function index()
	{
                
                

	}

        




}
