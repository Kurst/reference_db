<?php defined('SYSPATH') OR die('No direct access allowed.');

class Authors_Controller extends Template_Controller
{
	const ALLOW_PRODUCTION = TRUE;
	public $template = 'layouts/template';
	protected $db;
	public function __construct()
	{
		parent::__construct();

                $this->session                = Session::instance();
                $acl = new Acl();
		if(!$acl->logged_auto())
		{

                        url::redirect('/login/auth');
		}
		$this->db                     = new Author_Model;
                $this->template->title        = Kohana::config('config.application_name').".Просмотр авторов";
		$this->template->sub_title    = "Просмотр авторов";
	}



	public function index()
	{
                
		$this->template->view         = new View('my/show_author_view');


		$this->template->view->author = $this->db->get_all_authors();
		$this->template->view->form   = array(
			'id' => '',
			'name' => '',
			'family' => '',
			'patronymic' => '',
			'date' => '',
			'town' => '',
			'email' => '',
			'phone' => '',
			'site' => '',
			'desc' => ''
		);
		$this->template->view->errors = $this->template->view->form;
	}

        public function details($id)
        {
           $author              = $this->db->get_author_by_id($id);
           $view                = new View('my/author_view_details');
           $view->id            = $id;

           $view->description   = $author->description;
           $view->description == '0'?$view->description='Нет описания':$view->description;
           $view->telephone     = $author->telephone;
           $view->telephone   == '0'?$view->telephone='':$view->telephone;
           $view->email         = $author->email;
           $view->city          = $author->city;
           $view->site          = $author->site;
           $view->date_of_birth     = $author->date_of_birth;
           $view->date_of_birth   == '0000-00-00'?$view->date_of_birth='':$view->date_of_birth;
          
           $view->render(TRUE);
           $this->auto_render = FALSE;
        }

        


}
