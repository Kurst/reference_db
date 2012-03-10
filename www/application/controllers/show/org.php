<?php defined('SYSPATH') OR die('No direct access allowed.');

class Org_Controller extends Template_Controller
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
		
		//
                $this->db                     = new Publication_Model();
                $this->session                = Session::instance();

		
	}



	public function index()
	{
                
	}

        public function id($id)
        {
                
                $org_db                     = new Org_Model();
                $org                        = $org_db->get_org_by_id($id);

                if(!empty($org))
                {
                        
                        $this->template->view         = new View('show/org_view');
                        $this->template->view->id     = $id;
                        $this->template->view->description         = $org->description=='0'?'':$org->description;

                        $this->template->view->description == '0'?$this->template->view->description='Нет описания':$this->template->view->description;
                        $this->template->view->telephone     = $org->telephone;
                        $this->template->view->telephone   == '0'?$this->template->view->telephone='':$this->template->view->telephone;
                        $this->template->view->email         = $org->email;
                        $this->template->view->site          = $org->site;
                        $this->template->view->render(TRUE);
                        $this->auto_render = FALSE;


                }else
                {
                        Kohana::show_404();
                }


        }

        
        




}
