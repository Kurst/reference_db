<?php defined('SYSPATH') OR die('No direct access allowed.');

class Author_Controller extends Template_Controller
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
                
                $author_db                     = new Author_Model();
                $auth                          = $author_db->get_author_by_id($id);

                if(!empty($auth))
                {
                        
                        $this->template->view         = new View('show/author_view');
                        $this->template->view->id     = $id;
                        $this->template->view->description         = $auth->description=='0'?'':$auth->description;
                        $this->template->view->date   = $auth->bdate;
                        $this->template->view->work   = $auth->ORG_NAME;
                        $this->template->view->city   = $auth->city;
                        $this->template->view->email  = $auth->email;
                        $this->template->view->telephone   = $auth->telephone;
                        $this->template->view->site   = $auth->site;
                        $this->template->view->render(TRUE);
                        $this->auto_render = FALSE;


                }else
                {
                        Kohana::show_404();
                }


        }

        
        




}
