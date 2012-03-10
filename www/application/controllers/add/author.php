<?php defined('SYSPATH') OR die('No direct access allowed.');

class Author_Controller extends Template_Controller
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
			url::redirect('/login');
		}
		$this->template->title        = Kohana::config('config.application_name').".Добавить автора";
		$this->template->sub_title    = "Добавить нового автора";
		$this->template->view         = new View('add/add_author_view');
		$this->db                     = new Author_Model;
                $this->user_db                = new Acl_Model();
                $this->session                = Session::instance();
		$this->template->view->form   = array(
			'name' => '',
			'family' => '',
			'patronymic' => '',
			'date' => '',
			'city' => '',
                        'city_id' => '111111',
			'email' => '',
			'phone' => '',
			'site' => '',
			'desc' => ''
		);
		$this->template->view->errors = $this->template->view->form;
		self::_generate_options();

	}
	
	public function _generate_options()
	{
            
		$org_table_db = new Org_Model;
		$opt = $org_table_db->get_orgs_by_parent_id(0);
		$list_of_options = "<option value='0'>Нет организации</option>";
                if($opt)
                {
                    foreach($opt as $o)
                    {
                            $list_of_options .= "<option value='".$o->id."'>".$o->name."</option>";
                    }
                }
		
		
		
		$this->template->view->select_options = $list_of_options;
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
			$post->add_rules('name', 'required', 'standard_text');
			$post->add_rules('family', 'required', 'standard_text');
			$post->add_rules('patronymic', 'standard_text');
			$post->add_rules('city', 'standard_text');
			$post->add_rules('email', 'required', 'email');
			$post->add_rules('phone', 'phone');
                        $post->add_rules('date', 'standard_text');

                        if($post->date != '' && !preg_match("/^((19|20)[0-9][0-9])-(0?[1-9]|1[012])-(0?[1-9]|[12][0-9]|3[01])$/", $post->date))
                        {
                                $post->add_error('date', 'bad_format');
                                
                        }
                       
			if ($post->validate())
			{
				$author['name']       = $this->input->post('name', null, true);
				$author['family']     = $this->input->post('family', null, true);
				$author['patronymic'] = $this->input->post('patronymic', null, true);
				$author['date']       = $this->input->post('date', null, true);
				$author['sex']        = $this->input->post('sex', null, true);
				$author['city']       = $this->input->post('city', null, true);
				$author['email']      = $this->input->post('email', null, true);
				$author['phone']      = $this->input->post('phone', null, true);
				$author['site']       = $this->input->post('site', null, true);
				$author['desc']       = $this->input->post('desc', null, true);
				$author['org_id']     = $this->input->post('org', null, true);
                                $author['city_id']     = $this->input->post('city_id', null, true);
                               

                                $user = $this->user_db->get_user($this->session->get('username'));
                                $author['user_id']    = $user->id;
                              
                                    $state = $this->db->insert_author($author);
                                    if($state == 'failed')
                                    {
                                            $this->template->view         = new View('messages/failure/add_author_failure');
                                           
                                    }elseif($state == 'duplicate')
                                    {
                                            $this->template->view->author_exist = 'Такой автор или email уже есть в базе';
                                    }
                                    else
                                    {
                                             $this->template->view         = new View('messages/success/add_author_success');
                                    }

	
			}else
			{
				$this->template->view->form   = arr::overwrite($this->template->view->form, $post->as_array());
				$this->template->view->errors = arr::overwrite($this->template->view->errors, $post->errors('form_error_messages'));
			}
		}else
		{
			Kohana::show_404();
		}
	}
	
	public function check_sub_orgs()
	{
		if (request::is_ajax())
		{
			$this->auto_render = FALSE;
			$id =  $this->input->post('id', null, true);
			$level =  $this->input->post('level', null, true);
			$level++;
			$org_table_db = new Org_Model;
			$opt = $org_table_db->get_orgs_by_parent_id($id);
			
			if(!empty($opt))
			{
				
				$data = "<label for='org'>Подразделение</label><br/>
				<select name='org' id='org_lvl_".$level."' onChange='select_org(".$level.");' class='wide_select'>
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

        public function get_cities()
	{
            if (request::is_ajax())
            {
                $this->auto_render = FALSE;
                $city_db = new Cities_Model;
                $q =  $this->input->post('q', null, true);
                $cities = $city_db->get_cities_like($q);
                if($cities)
                {
                    $res = '';
                    foreach($cities as $city)
                    {

                        $res .= $city->name."|".$city->id."\n";
                    }

                    echo $res;
                }else
                {
                    echo "not found";
                }
              
            }else
            {
                    Kohana::show_404();

            }
	}
}
