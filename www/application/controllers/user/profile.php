<?php defined('SYSPATH') OR die('No direct access allowed.');

class Profile_Controller extends Template_Controller
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
		$this->template->title        = Kohana::config('config.application_name').".Настройки";
		$this->template->sub_title    = "Настройки";
		$this->template->view         = new View('user/profile/profile_view');
		$this->db                     = new Profile_Model;
                $this->session                = Session::instance();
		


	}



	public function index()
	{
                $username = $this->session->get('username');
                $this->template->view->author = $this->db->get_author_date($username);
                $this->template->view->date = '';
                if($this->db->get_author_date($username)->date_of_birth != '0000-00-00')
                {
                        $this->template->view->date = $this->db->get_author_date($username)->date_of_birth;
                }
                $this->template->view->u_id = $this->db->get_user_id($username)->id;
                

	}

        public function  inline_edit()
        {
                if (request::is_ajax())
		{
			$this->auto_render = FALSE;
			$field =  $this->input->post('field_type', null, true);
                        $prev =  $this->input->post('prev', null, true);
                        $new =  $this->input->post('newv', null, true);
                        $username = $this->session->get('username');
                        if($field == 'city')
                        {
                                
                                if($new != 0)
                                {
                                        $res = $this->db->edit_profile_city($username,$new,$prev);
                                        if($res)
                                        {
                                                print 'true';
                                        }else
                                        {
                                                print 'false';
                                        }
                                }

                        }elseif($field == 'date')
                        {
                                $field = 'date_of_birth';
                                if(preg_match("/^((19|20)[0-9][0-9])-(0?[1-9]|1[012])-(0?[1-9]|[12][0-9]|3[01])$/", $new))
                                {
                                        if($new != $prev)
                                        {
                                                $res = $this->db->edit_profile($username,$field, $prev, $new);
                                                if($res)
                                                {
                                                        print 'true';
                                                }else
                                                {
                                                        print 'false';
                                                }
                                        }

                                }
                                
                        }else
                        {
                                if($new != $prev)
                                {
                                        $res = $this->db->edit_profile($username,$field, $prev, $new);
                                        if($res)
                                        {
                                                print 'true';
                                        }else
                                        {
                                                print 'false';
                                        }
                                }
                        }
			

		}else
		{
			Kohana::show_404();
		}
        }

        public function avatar($id='')
	{

                
                if($this->db->get_user_id($this->session->get('username'))->id == $id)
                {
                       
                        $view         = new View('user/profile/avatar_view');
                        $view->id     = $id;

                        $view->render(TRUE);
                        $this->auto_render = FALSE;
                }else
                {
                        Kohana::show_404();
                }
                



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
                                

                                url::redirect('/user/profile');


                        }else
                        {
                                url::redirect('/user/profile');
                        }
                }
        }


        /*public function organization()
        {
                $view                    = new View('user/profile/profile_view_org');
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

        }*/

       /* public function changeOrg()
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

        }*/






}
