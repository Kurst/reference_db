<?php
defined('SYSPATH') OR die('No direct access allowed.');
class Issue_Controller extends Template_Controller
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

		$this->template->title        = Kohana::config('config.application_name').".Добавить издание";
		$this->template->sub_title    = "Добавить новое издание";
		$this->template->view         = new View('add/add_issue_view');
		$this->db                     = new Issue_Model;
                $this->user_db                = new Acl_Model();
                $this->session                = Session::instance();
		$this->template->view->form   = array(
			'name' => '',
			'date' => '',
			'type' => '',
			'isbn' => '',
			'issn' => '',
			'desc' => ''
		);
		$this->template->view->errors = $this->template->view->form;
		self::_make_publisher_options();
		self::_make_types();

                
                
	}
	

	public function _make_types()
	{
		$types_table_db = new Issue_type_Model;
		$types = $types_table_db->get_all_types();
		$list_of_options = "";
		foreach($types as $o)
		{
			
			$list_of_options .= "<option value='".$o->id."'>".$o->name."</option>";
			
			
		}
		
		
		$this->template->view->select_types = $list_of_options;
	}
	
	
	public function _make_publisher_options()
	{
		
		$publisher_table_db = new Publisher_Model;
		$publisher = $publisher_table_db->get_publishers();
		$list_of_options = "<option value='0'>Не выбрано</option>";
                if($publisher)
                {
                    foreach($publisher as $o)
                    {

                            $list_of_options .= "<option value='".$o->id."'>".$o->name."</option>";


                    }

                }
		
		
		$this->template->view->select_options = $list_of_options;
		return $list_of_options;
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
			$post->add_rules('email', 'email');
			$post->add_rules('phone', 'phone');
                        $post->add_rules('isbn', 'chars[0-9,-,X]');

                        if($post->date!='' && !preg_match("/^((19|20)[0-9][0-9])-(0?[1-9]|1[012])-(0?[1-9]|[12][0-9]|3[01])$/", $post->date))
                        {
                                $post->add_error('date', 'bad_format');

                        }

                        if($post->isbn!='' && !preg_match("/^(97[89][- ]){0,1}[0-9]{1,5}[- ][0-9]{1,7}[- ][0-9]{1,6}[- ][0-9X]$/", $post->isbn))
                        {
                                $post->add_error('isbn', 'bad_format');

                        }
                        
                        if($post->id_publisher == '0')
                        {
                               //$post->add_error('type', 'not_selected');

                        }
                        
			if ($post->validate())
			{
				$issue['name']  = $this->input->post('name', null, true);
				$issue['type']  = $this->input->post('type', null, true);
				$issue['date'] = $this->input->post('date', null, true);
				$issue['isbn'] = $this->input->post('isbn', null, true);
				$issue['issn']  = $this->input->post('issn', null, true);
				$issue['id_publisher']  = $this->input->post('id_publisher', null, true);
				$issue['desc']  = $this->input->post('desc', null, true);
                              
                                $user = $this->user_db->get_user($this->session->get('username'));
                                $issue['user_id']    = $user->id;
                                
                                $state = $this->db->insert_issue($issue);
				if($state != 'failed')
				{
					$this->template->view         = new View('messages/success/add_issue_success');
				}else
				{
					$this->template->view         = new View('messages/failure/add_issue_failure');	
				}
			}
			else
			{       
                                $n = array();
                                $arr = $post->as_array();
                                foreach ($arr as $k => $v)
                                {
                                        $n[$k] = stripslashes($v);
                                }
                                
				$this->template->view->form   = arr::overwrite($this->template->view->form, $n);
				$this->template->view->errors = arr::overwrite($this->template->view->errors, $post->errors('form_error_messages'));
			}
		}
	}
}
