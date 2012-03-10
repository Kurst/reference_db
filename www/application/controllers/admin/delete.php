<?php defined('SYSPATH') OR die('No direct access allowed.');

class Delete_Controller extends Template_Controller
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
		$this->template->title        = Kohana::config('config.application_name').".Управление пользователями";
		$this->template->sub_title    = "Управление пользователями";
		$this->template->view         = new View('admin/users_view');
                $this->admin_db               = new Admin_Model();
		
               
		


	}



	public function index()
	{
           

	}

        public function user_id($id)
        {
            $state = $this->admin_db->delete_user_by_id($id);
            if($state != 'failed')
            {
                 url::redirect('/admin/users/');
            }else
            {
               show_404();
            }

        }

        public function group_id($id)
        {
            $state = $this->admin_db->delete_group_by_id($id);
            if($state != 'failed')
            {
                 url::redirect('/admin/groups/');
            }else
            {
               show_404();
            }

        }

        




}
