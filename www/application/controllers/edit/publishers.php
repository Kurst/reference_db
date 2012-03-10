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
                $this->session                = Session::instance();
                $this->acl_db                 = new Acl_Model();
                $this->db                     = new Publisher_Model;
		if(!$acl->logged_auto())
		{

                        url::redirect('/login/auth');
		}
		$this->template->title        = Kohana::config('config.application_name').".Редактировать издательсво";
		$this->template->sub_title    = "Редактировать издательство";
		
		
	}
	
	
	public function index()
	{
                $this->template->view         = new View('edit/show_publisher_view');

                $username                     = $this->session->get('username');
		$this->template->view->publisher = $this->db->get_publishers_created_by($username);
                
		$this->template->view->form   = array(
			'id' => '',
			'name' => '',
			'site' => '',
			'telephone' => '',
			'desc' => ''
		);
		$this->template->view->errors = $this->template->view->form;
	}
	
	public function id($id)
        {
            if($this->acl_db->get_access_permission($this->session->get('username'),$id,'publisher') == 1)
            {
                    $this->template->title                     = "Редактирование";
                    $this->template->sub_title                 = "Редактирование";
                    $publisher                                 = $this->db->get_publisher_by_id($id);
                    $publisher ->telephone                     = $publisher ->telephone=='0'?'':$publisher ->telephone;
                    $this->template->view                      = new View('edit/edit_publisher_view');


                    $this->template->view->form   = array(
                                'id'   => $id,
                                'name' => $publisher->name,
                                'city' => $publisher->CITY,
                                'city_id' => $publisher->city_id,
                                'site' => $publisher->site,
                                'phone' => $publisher->telephone,
                                'desc' => $publisher->description
                        );
                     $this->template->view->errors = array(
                                'id'   => $id,
                                'name' => '',
                                'city' => '',
                                'city_id' => '',
                                'site' => '',
                                'phone' => '',
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
			
			if ($post->validate())
			{
				$publisher['id']	 = $this->input->post('id', null, true);
				$publisher['name']       = $this->input->post('name', null, true);
				$publisher['telephone']  = $this->input->post('telephone', null, true);
				$publisher['site']       = $this->input->post('site', null, true);
				$publisher['desc']       = $this->input->post('desc', null, true);
                                $publisher['city_id']    = $this->input->post('city_id', null, true);
				
				
			
				$state = $this->db->update_publisher_by_id($publisher);
                                if($state != 'failed')
                                {
                                        $this->template->view         = new View('messages/success/edit_publisher_success');
                                }else
                                {
                                        $this->template->view         = new View('messages/failure/edit_publisher_failure');
                                }
				
				
				
			}
			else
			{
				url::redirect('/edit/publishers/id/'.$publisher['id']);
			}
		}
	}
}