<?php defined('SYSPATH') OR die('No direct access allowed.');

class Publisher_Controller extends Template_Controller
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
                
                $this->session                = Session::instance();

		
	}



	public function index()
	{
                
	}

        public function id($id)
        {
                
                $pub_db                     = new Publisher_Model();
                $pub                        = $pub_db->get_publisher_by_id($id);

                if(!empty($pub))
                {
                        
                        $this->template->view         = new View('show/publisher_view');
                        $this->template->view->id     = $id;
                        $this->template->view->description         = $pub->description=='0'?'':$pub->description;

                        $this->template->view->description == '0'?$this->template->view->description='Нет описания':$this->template->view->description;
                        $this->template->view->telephone     = $pub->telephone;
                        $this->template->view->telephone   == '0'?$this->template->view->telephone='':$this->template->view->telephone;
                      
                        $this->template->view->site          = $pub->site;
                        $this->template->view->city          = $pub->CITY;
                        $this->template->view->render(TRUE);
                        $this->auto_render = FALSE;


                }else
                {
                        Kohana::show_404();
                }


        }

        
        




}
