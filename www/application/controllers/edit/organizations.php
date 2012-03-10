<?php defined('SYSPATH') OR die('No direct access allowed.');

class Organizations_Controller extends Template_Controller
{
	const ALLOW_PRODUCTION = TRUE;
	public $template = 'layouts/template';
	protected $db;
	public function __construct()
	{
		parent::__construct();
                $this->session                = Session::instance();
                $this->acl_db                 = new Acl_Model();
                $acl = new Acl();
		if(!$acl->logged_auto())
		{

                        url::redirect('/login/auth');
		}
                $this->db                     = new Org_Model;
                $this->template->title        = Kohana::config('config.application_name').".Редактирование организаций";
		$this->template->sub_title    = "Редактирование организаций";

		
		
	}
	public function _make_org_options($parent)
	{
		$orgs = $this->db->get_my_orgs();
		$list_of_options = "<option value='0'>Не является</option>";
		foreach($orgs as $o)
		{
                        if($parent == $o->id)
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
               
		$this->template->view         = new View('edit/show_organization_view');
                $username                     = $this->session->get('username');
		$this->template->view->organization = $this->db->get_orgs_created_by($username);
		$this->template->view->form   = array(
			'id' => '',
			'name' => '',
			'type' => '',
			'site' => '',
			'email' => '',
			'telephone' => '',
			'desc' => ''
		);
		$this->template->view->errors = $this->template->view->form;
	}

        public function id($id)
        {
            if($this->acl_db->get_access_permission($this->session->get('username'),$id,'organization') == 1)
            {
                    $this->template->title                     = "Редактирование";
                    $this->template->sub_title                 = "Редактирование";
                    $org                                       = $this->db->get_org_by_id($id);
                    $this->template->view                      = new View('edit/edit_org_view');
                    $this->template->view->select_options      = self::_make_org_options($org->id_parent);
                    $org->telephone                            = $org->telephone=='0'?'':$org->telephone;
                    $this->template->view->form   = array(
                                'id'    => $id,
                                'name' => $org->name,
                                'email' => $org->email,
                                'phone' => $org->telephone,
                                'site' => $org->site,
                                'desc' => $org->description,
                                'type'  => $org->type
                        );
                     $this->template->view->errors = array(
                                'name' => '',
                                'email' => '',
                                'phone' => '',
                                'site' => '',
                                'desc' => ''
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
			$post->add_rules('email', 'email');
			
                        $organization['id']         = $this->input->post('id', null, true);
			if ($post->validate())
			{
                               
				
				$organization['name']       = $this->input->post('name', null, true);
				$organization['type']       = $this->input->post('type', null, true);
				$organization['email']      = $this->input->post('email', null, true);
				$organization['phone']      = $this->input->post('phone', null, true);
				$organization['site']       = $this->input->post('site', null, true);
				$organization['desc']       = $this->input->post('desc', null, true);
				$organization['id_parent']  = $this->input->post('parent', null, true);

                                $state = $this->db->update_org_by_id($organization);
                                if($state != 'failed')
                                {
                                        $this->template->view = new View('messages/success/edit_organization_success');
                                }else
                                {
                                        $this->template->view = new View('messages/failure/edit_organization_failure');
                                }
                                
                        }else
                        {
				 url::redirect('/edit/organizations/id/'.$organization['id']);
			}
		}
	}
}