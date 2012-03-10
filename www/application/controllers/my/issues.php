<?php defined('SYSPATH') OR die('No direct access allowed.');

class Issues_Controller extends Template_Controller
{
	const ALLOW_PRODUCTION = TRUE;
	public $template = 'layouts/template';
	protected $db;
	protected $db2;
	public function __construct()
	{
		parent::__construct();
                 $acl = new Acl();
		if(!$acl->logged_auto())
		{

                        url::redirect('/login/auth');
		}
		$this->template->title        = Kohana::config('config.application_name').".Просмотр изданий";
		$this->template->sub_title    = "Просмотр изданий";
		$this->db                     = new Issue_Model;

	}
	
	
	public function index()
	{
                $this->template->view         = new View('my/show_issue_view');

		$this->template->view->issue = $this->db->get_issues();
	}
	


        public function details($id)
        {
           $issue               = $this->db->get_issue($id);
           $issue               = $issue[0];
           $view                = new View('my/issue_view_details');
           $view->id            = $id;

           $view->description   = $issue->description;
           $view->description   == '0'?$view->description='Нет описания':$view->description;
           $view->isbn          = $issue->isbn;
           $view->isbn          == '0'?$view->isbn='':$view->isbn;
           $view->issn          = $issue->issn;
           $view->issn          == '0'?$view->issn='':$view->issn;


           $view->render(TRUE);
           $this->auto_render = FALSE;
        }
	
	public function _make_issue_options()
	{
		$this->db2  = new Issue_type_Model;
		$issue = $this->db2->get_types();
		$list_of_options = "<option value='0'>Не является</option>";
		
		foreach($issue as $o)
		{
			
			$list_of_options .= "<option value='".$o['id']."'>".$o['name']."</option>";
			
			
		}
		
		
		$this->template->view->select_options = $list_of_options;
	}
	
	
	
	
	public function update()
	{
		
		if ($_POST)
		{
                       
			$post = new Validation($_POST);
			$post->pre_filter('trim', TRUE);
			$post->add_rules('name', 'required', 'standard_text');
			if ($post->validate())
			{
                               
				$issue['id']		  = $this->input->post('id', null, true);
				$issue['type']		  = $this->input->post('type', null, true);
				$issue['name']       = $this->input->post('name', null, true);
				$issue['date']      = $this->input->post('date', null, true);
				$issue['id_publisher']		  = $this->input->post('id_publisher', null, true);
				$issue['isbn']		  = $this->input->post('isbn', null, true);
				$issue['issn']       = $this->input->post('issn', null, true);
				$issue['desc']       = $this->input->post('desc', null, true);
				
				
			
				if($this->db->edit($issue))
				{
					
					$this->template->view         = new View('messages/success/edit_publisher_success');
				}else
				{
					$this->template->view         = new View('messages/failure/edit_publisher_failure');	
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