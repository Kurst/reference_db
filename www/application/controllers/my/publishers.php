<?php defined('SYSPATH') OR die('No direct access allowed.');

class Publishers_Controller extends Template_Controller
{
	const ALLOW_PRODUCTION = TRUE;
	public $template = 'layouts/template';
	protected $db;
	public function __construct()
	{
		parent::__construct();
                 $acl = new Acl();
		if(!$acl->logged_auto())
		{

                        url::redirect('/login/auth');
		}
		$this->template->title        = Kohana::config('config.application_name').".Просмотр издательств";
		$this->template->sub_title    = "Просмотр издательств";
		$this->db                     = new Publisher_Model;
			
		
		
	}
	
	
	public function index()
	{
            $this->template->view             = new View('my/show_publisher_view');
            $this->template->view->publisher  = $this->db->get_publishers();
	}
	
	public function details($id)
        {
           $publisher           = $this->db->get_publisher_by_id($id);
           $view                = new View('my/publisher_view_details');
           $view->id            = $id;

           $view->description   = $publisher->description;
           $view->description == '0'?$view->description='Нет описания':$view->description;
           $view->telephone     = $publisher->telephone;
           $view->telephone   == '0'?$view->telephone='':$view->telephone;
           
           $view->city          = $publisher->CITY;
           $view->site          = $publisher->site;

           $view->render(TRUE);
           $this->auto_render = FALSE;
        }
}