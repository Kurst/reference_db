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
                $this->session                = Session::instance();
                $this->acl_db                 = new Acl_Model();
		if(!$acl->logged_auto())
		{

                        url::redirect('/login/auth');
		}
		$this->template->title        = Kohana::config('config.application_name').".Редактировать издание";
		$this->template->sub_title    = "Редактировать издание";
		
		$this->db                     = new Issue_Model;
		
		
	}
        
	public function _make_publisher($pub = '')
	{
                $publisher_table_db = new Publisher_Model;
		$publisher = $publisher_table_db->get_publishers();
		$list_of_options = "";
                $list_of_options .= "<option value=''></option>";
		foreach($publisher as $p)
		{
                        if($p->id == $pub)
                        {
                             $list_of_options .= "<option selected value='".$p->id."'>".$p->name."</option>";
                        }else
                        {
                             $list_of_options .= "<option value='".$p->id."'>".$p->name."</option>";
                        }


		}

		return $list_of_options;
	}

        public function _make_types($type = '')
	{
		$types_table_db = new Issue_type_Model;
		$types = $types_table_db->get_all_types();
		$list_of_options = "";
		foreach($types as $o)
		{
                    if($o->id == $type)
                    {
                        $list_of_options .= "<option value='".$o->id."' selected>".$o->name."</option>";
                    }else
                    {
                        $list_of_options .= "<option value='".$o->id."'>".$o->name."</option>";
                    }

		}

		return $list_of_options;
	}
	
	public function index()
	{
            $this->template->view         = new View('edit/show_issue_view');
            $username                     = $this->session->get('username');
            $this->template->view->issue = $this->db->get_issues_created_by($username);
            $this->template->view->form   = array(
                    'id' => '',
                    'name' => '',
                    'type' => '',
                    'isbn' => '',
                    'issn' => '',
                    'desc' => ''
            );
            $this->template->view->errors = $this->template->view->form;
	}
	
	
	
	public function id($id)
        {
            if($this->acl_db->get_access_permission($this->session->get('username'),$id,'issue') == 1)
            {
                    $this->template->title                     = "Редактирование";
                    $this->template->sub_title                 = "Редактирование";
                    $issue                                     = $this->db->get_issue($id);
                    $issue                                     = $issue[0];
                    $issue->isbn                               = $issue->isbn=='0'?'':$issue->isbn;
                    $issue->issn                               = $issue->issn=='0'?'':$issue->issn;

                    $this->template->view                      = new View('edit/edit_issue_view');
                    $this->template->view->form   = array(
                            'id' => $id,
                            'name' => $issue->name,
                            'type' => $issue->type,
                            'isbn' => $issue->isbn,
                            'issn' => $issue->issn,
                            'date' => $issue->date,
                            'desc' => $issue->description,
                            'issue_options' => $this->_make_publisher($issue->id_publisher),
                            'type_options' => $this->_make_types($issue->type)
                        );
                     $this->template->view->errors = array(
                                'id' => $id,
                                'name' => '',
                                'type' => '',
                                'isbn' => '',
                                'issn' => '',
                                'date' => '',
                                'desc' => '',
                                'issue_options' => '',
                                'type_options' => ''
                        );
            }else
            {
                    Kohana::show_404();
            }
            
        }


	
	
	
	
	
	
	public function editing()
	{
		
		if ($_POST)
		{
                       
			$post = new Validation($_POST);
			$post->pre_filter('trim', TRUE);
			$post->add_rules('name', 'required');
			if ($post->validate())
			{
                               
				$issue['id']		  = $this->input->post('id', null, true);
				$issue['type']		  = $this->input->post('type', null, true);
				$issue['name']            = $this->input->post('name', null, true);
				$issue['date']            = $this->input->post('date', null, true);
				$issue['id_publisher']	  = $this->input->post('id_publisher', null, true);
				$issue['isbn']		  = $this->input->post('isbn', null, true);
				$issue['issn']            = $this->input->post('issn', null, true);
				$issue['desc']            = $this->input->post('desc', null, true);
				
				
			
				$state = $this->db->update_issue_by_id($issue);
                                if($state != 'failed')
                                {
                                        $this->template->view     = new View('messages/success/edit_issue_success');
                                }else
                                {
                                        $this->template->view     = new View('messages/failure/edit_issue_failure');
                                }
				
				
				
			}
			else
			{
				url::redirect('/edit/publishers/id/'.$publisher['id']);
			}
		}
	}
}