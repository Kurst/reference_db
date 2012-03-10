<?php defined('SYSPATH') OR die('No direct access allowed.');

class Users_Controller extends Template_Controller
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
		$this->template->title        = Kohana::config('config.application_name').".Управление пользователями";
		$this->template->sub_title    = "Управление пользователями";
		$this->template->view         = new View('admin/users_view');
                $this->admin_db               = new Admin_Model();
		
               
		


	}



	public function index()
	{
            if (!$_POST)
            {
                    $this->template->view->users = $this->admin_db->get_all_users();
                     $this->template->view->query = '';
            }else
            {
                    $query  = $this->input->post('query', null, true);
                    $this->template->view->users = $this->admin_db->get_user_by_name($query);
                    $this->template->view->query = $query;
            }
                
                

	}


        public function user_id($id = '')
        {
                $this->template->title                     = "Редактирование";
                $this->template->sub_title                 = "Редактирование";
                                                    
                $this->template->view                      = new View('admin/edit_user_view');
                $this->template->view->author              = $this->admin_db->get_user_by_id($id);
                $groups                                    = $this->admin_db->get_all_user_groups();
                $this->template->view->group_list          = '';
                $this->template->view->id                  = $id;
                foreach($groups as $gr)
                {
                        if($gr->id == $this->template->view->author->group_id)
                        {
                                $this->template->view->group_list .= "<option value='".$gr->id."' selected>".$gr->fullname."</option>";
                        }else
                        {
                                $this->template->view->group_list .= "<option value='".$gr->id."'>".$gr->fullname."</option>";
                        }
                }
        }


        public function avatar($id='')
	{


                
                $view         = new View('admin/avatar_view');
                $view->id     = $id;

                $view->render(TRUE);
                $this->auto_render = FALSE;
                




	}

        public function change_avatar()
        {

                if ($_FILES)
		{
                        $files=new Validation($_FILES);
                        $files->add_rules('ava','upload::type[jpg,jpeg,png]');
                        $id = $this->input->post('id', null, true);
                        if ($files->validate())
                        {
                                $filename = upload::save('ava');
                                Image::factory($filename)
                                        ->resize(100, 100, Image::AUTO)
                                        ->save(DOCROOT.'static/images/acl/avatars/'.$id.'/ava.png');
                                unlink($filename);


                                url::redirect('admin/users/user_id/'.$id);


                        }else
                        {
                                url::redirect('admin/users/user_id/'.$id);
                        }
                }
        }

        public function save_user()
	{
            if ($_POST)
            {
                        $post = new Validation($_POST);
			$post->pre_filter('trim', TRUE);
			$post->add_rules('name', 'required', 'standard_text');
			$post->add_rules('family', 'required', 'standard_text');
			$post->add_rules('patronymic', 'required', 'standard_text');
                        $post->add_rules('date', 'required', 'standard_text');

                        $user['id']         = $this->input->post('id', null, true);
                        
			if ($post->validate())
			{

				$user['name']       = $this->input->post('name', null, true);
				$user['family']     = $this->input->post('family', null, true);
				$user['patronymic'] = $this->input->post('patronymic', null, true);
				$user['date']       = $this->input->post('date', null, true);
				$user['sex']        = $this->input->post('sex', null, true);
				$user['phone']      = $this->input->post('phone', null, true);
				$user['site']       = $this->input->post('site', null, true);
                                $user['city_id']    = $this->input->post('city_id', null, true);
                                $user['active']     = $this->input->post('active', null, true);
                                $user['group']      = $this->input->post('group', null, true);

                                if($user['city_id'] == '0'){$user['city_id'] = '111111';}
                                
				$state = $this->admin_db->update_user_by_id($user);
                                if($state != 'failed')
                                {
                                        url::redirect('admin/users/user_id/'.$user['id']);
                                }else
                                {
                                        url::redirect('admin/users');
                                }



			}
			else
			{
                                 url::redirect('admin/users/user_id/'.$user['id']);
			}
            }else
            {
                    Kohana::show_404();
            }



	}

        




}
