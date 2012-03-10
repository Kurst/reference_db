<?php defined('SYSPATH') OR die('No direct access allowed.');

class Mode_Controller extends Template_Controller
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
		$this->template->title        = Kohana::config('config.application_name').".Режим разработки";
		$this->template->sub_title    = "Режим разработки";
		$this->template->view         = new View('admin/mode_view');
		$this->users_db               = new Acl_Model();
               
		


	}



	public function index()
	{
          
                    if($this->users_db->debug_mode_status()=='ON')
                    {
                            $this->template->view->status = "<div style='color:#ff0000'>Включен  <a href='mode/stop'>[Выключить]</a></div> ";
                    }else
                    {
                            $this->template->view->status = "<div style='color:#008000'>Выключен <a href='mode/start'>[Включить]</a></div> ";
                    }
                     

	}

        public function start()
        {
               $this->users_db->debug_mode_start_stop('start');
               url::redirect('/admin/mode');
        }


        public function stop()
        {
                 $this->users_db->debug_mode_start_stop('stop');
                 url::redirect('/admin/mode');

        }


        
        




}
