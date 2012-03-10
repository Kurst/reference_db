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
		$this->template->title        = Kohana::config('config.application_name').".Удаление издательства";
		$this->template->sub_title    = "Удаление издательства";
                $this->db                     = new Publisher_Model();
                $this->session                = Session::instance();

		
	}



	public function index()
	{
            
	}

        public function id($id)
        {
            $state = $this->db->delete_publisher_by_id($id);
            if($state != 'failed')
            {
                url::redirect('/edit/publishers/');
            }else
            {
               show_404();
            }
           

        }
        




}
