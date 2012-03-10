<?php defined('SYSPATH') OR die('No direct access allowed.');

class Publications_Controller extends Template_Controller
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
		$this->template->title        = Kohana::config('config.application_name').".Удаление публикаций";
		$this->template->sub_title    = "Удаление публикаций";
		//$this->template->view         = new View('delete/publication_delete_view');
                $this->db                     = new Publication_Model();
                $this->session                = Session::instance();

		
	}



	public function index()
	{
            
	}

        public function id($id)
        {
            $state = $this->db->delete_publication_by_id($id);
            if($state != 'failed')
            {
                 //unlink('pub_storage/'.$id);
                 url::redirect('/edit/publications/');
            }else
            {
               show_404();
            }

        }
        




}
