<?php
defined('SYSPATH') OR die('No direct access allowed.');
class Org_Controller extends Template_Controller
{
	const ALLOW_PRODUCTION = TRUE;
	public $template = 'layouts/template';
	protected $db;
        protected $user_db;
        public function __construct()
	{
		parent::__construct();

                $acl = new Acl();
		if(!$acl->logged_auto())
		{

                        url::redirect('/login/auth');
		}

		$this->template->title        = Kohana::config('config.application_name').".Добавить организацию";
		$this->template->sub_title    = "Добавить новую организацию";
		$this->template->view         = new View('add/add_org_view');
		$this->db                     = new Org_Model;
                $this->user_db                = new Acl_Model();
                $this->session                = Session::instance();
		$this->template->view->form   = array(
			'name' => '',
			'email' => '',
			'phone' => '',
			'site' => '',
			'desc' => ''
		);
		$this->template->view->errors = $this->template->view->form;
		self::_make_org_options();

                
                
	}
	
	public function _make_org_options()
	{
		$orgs = $this->db->get_my_orgs();
		$list_of_options = "<option value='0'>Не является</option>";
		foreach($orgs as $o)
		{		
			$list_of_options .= "<option value='".$o->id."'>".$o->name."</option>";
		}
		
		
		$this->template->view->select_options = $list_of_options;
	}
	
	/*public function show()
	{
		
		$this->template->view         = new View('add/show_org_view');
		$this->template->title        = "Посмотреть организации";
		$this->template->sub_title    = "Просмотр (Временная функция)";
		$this->template->view->org = 		$this->db->get_orgs();
		
		
	}*/
	
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
			$post->add_rules('email', 'email');
			$post->add_rules('phone', 'phone');
			if ($post->validate())
			{
				$org['name']  = $this->input->post('name', null, true);
				$org['type']  = $this->input->post('type', null, true);
				$org['email'] = $this->input->post('email', null, true);
				$org['phone'] = $this->input->post('phone', null, true);
				$org['site']  = $this->input->post('site', null, true);
				$org['desc']  = $this->input->post('desc', null, true);
				$org['parent']  = $this->input->post('parent', null, true);

                                $user = $this->user_db->get_user($this->session->get('username'));
                                $org['user_id']    = $user->id;
                                if(!$this->db->org_exist($org))
                                {
                                    $state = $this->db->insert_org($org);
                                    if($state != 'failed')
                                    {
                                            $this->template->view         = new View('messages/success/add_org_success');
                                    }else
                                    {
                                            $this->template->view         = new View('messages/failure/add_org_failure');
                                    }
                                }else
                                {
                                    $this->template->view->org_exist = 'Такая организация уже есть в базе';
                                }
				
			}
			else
			{
				$this->template->view->form   = arr::overwrite($this->template->view->form, $post->as_array());
				$this->template->view->errors = arr::overwrite($this->template->view->errors, $post->errors('form_error_messages'));
			}
		}
	}
}
