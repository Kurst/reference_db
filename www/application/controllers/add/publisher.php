<?php 
defined('SYSPATH') OR die('No direct access allowed.');

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
		
		$this->template->title        = Kohana::config('config.application_name').".Добавить издательство";
		$this->template->sub_title    = "Добавить новое издательство";
		$this->template->view         = new View('add/add_publisher_view');
		$this->db                     = new Publisher_Model;
                $this->user_db                = new Acl_Model();
                $this->session                = Session::instance();
		$this->template->view->form   = array(
			'name' => '',
                        'city' => '',
                        'city_id' => '',
			'site' => '',
			'phone' => '',
			'desc' => ''
		);
		$this->template->view->errors = $this->template->view->form;
	
	}
	

	public function index()
	{
	}
	
	public function adding()
	{
		if ($_POST)
		{
			$post = new Validation($_POST);
			$post->pre_filter('trim', TRUE);
			$post->add_rules('name', 'required');
			$post->add_rules('site', 'standard_text');
			$post->add_rules('phone', 'phone');
			if ($post->validate())
			{
				$publisher['name']       = $this->input->post('name', null, true);
				$publisher['site']      = $this->input->post('site', null, true);
				$publisher['phone']     = $this->input->post('phone', null, true);
				$publisher['desc']       = $this->input->post('desc', null, true);
                                $publisher['city_id']       = $this->input->post('city_id', null, true);
                                
                                $publisher['city_id']      = $publisher['city_id']==''?'111111':$publisher['city_id'];

                                $user = $this->user_db->get_user($this->session->get('username'));
                                $publisher['user_id']    = $user->id;

                                $state = $this->db->insert_publisher($publisher);
				if($state != 'failed')
				{
					$this->template->view         = new View('messages/success/add_publisher_success');
				}else
				{
					$this->template->view         = new View('messages/failure/add_publisher_failure');	
				}
				
			}
			else
			{
				$this->template->view->form   = arr::overwrite($this->template->view->form, $post->as_array());
				$this->template->view->errors = arr::overwrite($this->template->view->errors, $post->errors('form_error_messages'));
			}
		}else
		{
			Kohana::show_404();
		}
	}
}
