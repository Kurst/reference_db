<?php defined('SYSPATH') OR die('No direct access allowed.');

class Authors_Controller extends Template_Controller
{
	const ALLOW_PRODUCTION = TRUE;
	public $template = 'layouts/template';
	protected $db;
	public function __construct()
	{
		parent::__construct();

                $this->session                = Session::instance();
                $this->db                     = new Author_Model;
                $this->acl_db                 = new Acl_Model();
                $acl = new Acl();
		if(!$acl->logged_auto())
		{

                        url::redirect('/login/auth');
		}
		$this->template->title        = Kohana::config('config.application_name').".Редактирование авторов";
		$this->template->sub_title    = "Редактирование авторов";
		
	}



	public function index()
	{
                $this->template->view         = new View('edit/show_author_view');

                $username = $this->session->get('username');
		$this->template->view->author = $this->db->get_authors_created_by($username);
		$this->template->view->form   = array(
			'id' => '',
			'name' => '',
			'family' => '',
			'patronymic' => '',
			'date' => '',
			'town' => '',
			'email' => '',
			'phone' => '',
			'site' => '',
			'desc' => ''
		);
		$this->template->view->errors = $this->template->view->form;
	}

        public function id($id)
        {
            if($this->acl_db->get_access_permission($this->session->get('username'),$id,'author') == 1)
            {
                    $this->template->title                     = "Редактирование";
                    $this->template->sub_title                 = "Редактирование";
                    $author                                    = $this->db->get_author_by_id($id);
                    $this->template->view                      = new View('edit/edit_author_view');
                    $author->date_of_birth   == '0000-00-00'?$author->date_of_birth='':$author->date_of_birth;

                    $this->template->view->form   = array(
                                'id' => $id,
                                'name' => $author->name,
                                'family' => $author->family,
                                'patronymic' => $author->patronymic,
                                'date' => $author->date_of_birth,
                                'sex'  => $author->sex,
                                'city' => $author->city,
                                'city_id' => $author->city_id,
                                'email' => $author->email,
                                'phone' => $author->telephone=='0'?'':$author->telephone,
                                'site' => $author->site=='0'?'':$author->site,
                                'desc' => $author->description=='0'?'':$author->description,
                                'org'   => $author->ORG_NAME,
                                'org_id'   => $author->ORG_ID
                        );
                     $this->template->view->errors = array(
                                'name' => '',
                                'family' => '',
                                'patronymic' => '',
                                'date' => '',
                                'sex'  => '',
                                'city' => '',
                                'city_id' => '111111',
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
			$post->add_rules('name', 'required', 'standard_text');
			$post->add_rules('family', 'required', 'standard_text');
			$post->add_rules('patronymic', 'required', 'standard_text');
			//$post->add_rules('town', 'standard_text');
			
			//$post->add_rules('phone', 'phone');
                        $author['id']         = $this->input->post('id', null, true);
			if ($post->validate())
			{
				
				$author['name']       = $this->input->post('name', null, true);
				$author['family']     = $this->input->post('family', null, true);
				$author['patronymic'] = $this->input->post('patronymic', null, true);
				$author['date']       = $this->input->post('date', null, true);
				$author['sex']        = $this->input->post('sex', null, true);
				$author['town']       = $this->input->post('town', null, true);
				$author['email']      = $this->input->post('email', null, true);
				$author['phone']      = $this->input->post('phone', null, true);
				$author['site']       = $this->input->post('site', null, true);
				$author['desc']       = $this->input->post('desc', null, true);
				$author['org_id']     = $this->input->post('org_id', null, true);
                                $author['city_id']    = $this->input->post('city_id', null, true);

                                
				$state = $this->db->update_author_by_id($author);
                                if($state != 'failed')
                                {
                                        $this->template->view = new View('messages/success/edit_author_success');
                                }else
                                {
                                        $this->template->view = new View('messages/failure/edit_author_failure');
                                }
                                
				

			}
			else
			{
                                 url::redirect('/edit/authors/id/'.$author['id']);
			}
		}
	}

        public function organization()
        {
                $view                    = new View('edit/edit_author_view_org');
                $org_table_db            = new Org_Model;
		$opt                     = $org_table_db->get_orgs_by_parent_id(0);
		$list_of_options         = "<option value='1'>Нет организации</option>";
                if($opt)
                {
                    foreach($opt as $o)
                    {
                            $list_of_options .= "<option value='".$o->id."'>".$o->name."</option>";
                    }
                }



		$view->select_options = $list_of_options;
                $view->render(TRUE);
                $this->auto_render = FALSE;

        }

        public function check_sub_orgs()
	{
		if (request::is_ajax())
		{
			$this->auto_render      = FALSE;
			$id                     =  $this->input->post('id', null, true);
			$level                  =  $this->input->post('level', null, true);
			$level++;
			$org_table_db           = new Org_Model;
			$opt                    = $org_table_db->get_orgs_by_parent_id($id);

			if(!empty($opt))
			{

				$data = "<label for='org'>Подразделение</label><br/>
				<select name='org' id='org_lvl_".$level."' onChange='select(".$level.");'>
				<option value='".$id."'>Выберите</option>";
				foreach($opt as $o)
				{
					$data .= "<option value='".$o->id."'>".$o->name."</option>";
				}
				$data .="</select><br/><br/>
				<div id='loader_".$level."' style='display:none;'> <img   src='/static/images/ajax-loader.gif'/><br/><br/></div>
				<div id='sub_org_".$level."'></div>";

				echo $data;
			}

		}else
		{
			Kohana::show_404();

		}

	}

        public function changeOrg()
        {
                if (request::is_ajax())
		{
			$this->auto_render      = FALSE;
			$id                     = $this->input->post('id', null, true);
			$org_table_db           = new Org_Model;
			$org                    = $org_table_db->get_orgs_breadcrumbs($id);
                        $crumb                  = $org->CRUMB;
                        echo $crumb;


                }else
		{
			Kohana::show_404();

		}

        }



}
