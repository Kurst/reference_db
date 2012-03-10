<?php defined('SYSPATH') OR die('No direct access allowed.');

class Chart_Controller extends Template_Controller
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
		$this->template->title        = "Главная";
		$this->template->sub_title    = "Главная";
		$this->template->view         = new View('user/home_view');
		$this->db                     = new Profile_Model;
                $this->news_db                = new News_Model;
                $this->session                = Session::instance();
		


	}



	public function index()
	{
               
                

	}


        public function get_chart_data()
        {
                if (request::is_ajax())
		{
                        $this->auto_render = FALSE;
                        $x = time() * 1000;
                        // The y value is a random number
                        $y = rand(0, 100);

                        // Create a PHP array and echo it as JSON
                        $ret = array($x, $y);
                        echo json_encode($ret);
                }
        }

       





}
