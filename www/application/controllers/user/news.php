<?php defined('SYSPATH') OR die('No direct access allowed.');

class News_Controller extends Template_Controller
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
		$this->template->title        = Kohana::config('config.application_name').".Новости";
		$this->template->sub_title    = "Новости";
		$this->template->view         = new View('user/news/news_view');
		$this->news_db                = new News_Model;
                $this->session                = Session::instance();
		


	}



	public function index()
	{
                
               url::redirect('/user/home');
                

	}

        public function id($id)
        {
                $this->template->view->news = $this->news_db->get_news_by_id($id);
        }




}
