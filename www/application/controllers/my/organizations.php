<?php defined('SYSPATH') OR die('No direct access allowed.');

class Organizations_Controller extends Template_Controller
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
		$this->template->title                  = Kohana::config('config.application_name').".Просмотр организаций";
		$this->template->sub_title              = "Просмотр организаций";
		$this->template->view                   = new View('my/show_organization_view');
		$this->db                               = new Org_Model;
		$this->template->view->organization     = $this->db->get_my_orgs();
		
	}
	
	
	public function index()
	{
	}

         public function details($id)
        {
           $org                 = $this->db->get_org_by_id($id);
           $view                = new View('my/org_view_details');
           $view->id            = $id;

           $view->description   = $org->description;
           $view->description == '0'?$view->description='Нет описания':$view->description;
           $view->telephone     = $org->telephone;
           $view->telephone   == '0'?$view->telephone='':$view->telephone;
           $view->email         = $org->email;
           $view->site          = $org->site;

           $view->render(TRUE);
           $this->auto_render = FALSE;
        }

	
	
}