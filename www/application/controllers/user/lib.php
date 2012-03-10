<?php defined('SYSPATH') OR die('No direct access allowed.');

class Lib_Controller extends Template_Controller
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
		$this->template->title        = Kohana::config('config.application_name').".Библиотека";
		$this->template->sub_title    = "Библиотека";
		$this->template->view         = new View('user/lib/lib_view');
                $this->lib_db                 = new Lib_Model;
                $this->session                = Session::instance();
		
                self::_make_lists();

	}


        public function _make_lists($id = '')
        {
                $username = $this->session->get('username');
                $lists = $this->lib_db->get_lib_lists($username);
                $list_of_options = '';
                foreach($lists as $l)
                {
                        if($l->id == $id)
                        {
                                $list_of_options .= "<option  value='".$l->id."' selected>".$l->name."</option>";
                        }else
                        {
                                $list_of_options .= "<option  value='".$l->id."'>".$l->name."</option>";
                        }

                         
                }
                $this->template->view->list_options = $list_of_options;

        }

        public function index()
	{
                

	}

        public function delete_list()
	{
                if (request::is_ajax())
		{
                        $this->auto_render = FALSE;
                        $id                = $this->input->post('id', null, true);
                        $username = $this->session->get('username');
                        $this->lib_db->delete_lib_list($username,$id);
                        self::_make_lists();
                        echo $this->template->view->list_options;
                }else
                {
                        Kohana::show_404();
                }

	}

        public function delete_pub_from_list()
        {
                if (request::is_ajax())
		{
                        $this->auto_render = FALSE;
                        $pub_id            = $this->input->post('pub_id', null, true);
                        $list_id           = $this->input->post('list_id', null, true);

                        $this->lib_db->delete_pub_from_list($pub_id,$list_id);
                       
                        echo 'true';
                }else
                {
                        Kohana::show_404();
                }

        }

        public function add_list()
	{
                        $this->template->view         = new View('user/lib/add_list_view');
                        $this->template->view->render(TRUE);
                        $this->auto_render = FALSE;

                       

	}

        public function add_list_ajax()
	{
                if (request::is_ajax())
		{
                        $this->auto_render = FALSE;
                        $name                = $this->input->post('name', null, true);
                        $username = $this->session->get('username');
                        $this->lib_db->insert_lib_list($username,$name);
                        self::_make_lists();
                        echo $this->template->view->list_options;
                }else
                {
                        Kohana::show_404();
                }


	}

        public function add_to_library($link_id)
	{
                        $this->template->view         = new View('user/lib/add_to_library_view');
                        self::_make_lists();
                        $this->template->view->link_id = $link_id;
                        $this->template->view->render(TRUE);
                        $this->auto_render = FALSE;



	}

        public function add_to_library_ajax()
        {
                if (request::is_ajax())
		{
                        $this->auto_render = FALSE;
                        $list_id                = $this->input->post('list_id', null, true);
                        $link_id                = $this->input->post('link_id', null, true);
                        
                        $this->lib_db->insert_link_to_lib($link_id,$list_id);
                        
                }

        }

        public function show()
        {
                if ($_POST)
		{

                        $list_id  = $this->input->post('list', null, true);
                        $this->template->view         = new View('user/lib/result_view');
                        $this->template->view->id     =$list_id;
                        self::_make_lists($list_id);


                        //////////////


                            $this->template->view->generator       = new View('generator/form');
                            $db_auth = new Author_Model();
                            $issue_db = new Issue_Model();
                            $pub_db   = new Publication_Model();
                            
                            $publications = array();
                            $username = $this->session->get('username');

                            $n =  $db_auth->get_one_author_name($username);
                            $name = $n['family']." ".$n['name']." ".$n['patronymic'];
                            $this->template->view->user_name = $name;

                            $p = $this->lib_db->get_publications_from_library($list_id);
                            foreach($p as $a)
                            {
                                    $authors = explode("|",$a->FIO);
                                    $authors_out = '';
                                    foreach ($authors as $auth)
                                    {
                                           $authors_out .= $auth.", ";

                                    }
                                    $authors_out = mb_substr($authors_out,0,-2);

                                    switch($a->type)
                                    {
                                            case 1: //методическое пособие
                                                    $a->date == '0000'?$a->date='':$a->date=", ".$a->date."г.";
                                                    $a->pages == '0'?$a->pages=' - ':$a->pages=$a->pages."c.";
                                                    $output = $a->TYPE_NAME.", ".$a->PUBLISHER_NAME.$a->date;

                                                    $publications[] = array(
                                                            'id' => $a->id,
                                                            'title' => $a->title,
                                                            'output' => $output,
                                                            'pages' => $a->pages,
                                                            'type' =>$a->TYPE_NAME,
                                                            'path_to_file' => $a->path_to_file,
                                                            'authors' => $authors_out
                                                    );
                                                    break;
                                            case 2: // статья в сборнике
                                                    $issues = $issue_db->get_issue($a->id_issue);
                                                    foreach($issues as $issue)
                                                    {
                                                        mb_internal_encoding("UTF-8");
                                                        $year = mb_substr($issue->date, 0,4);
                                                        $output = $a->TYPE_NAME.' "'.$issue->name.'", Изд."'
                                                                .$issue->publisher_name.'", '.$year.'. - C.'.$a->pages.'-'.$a->last_page.'.';
                                                        $pages_total = $a->last_page - $a->pages."c.";
                                                        $publications[] = array(
                                                                'id' => $a->id,
                                                                'title' => $a->title,
                                                                'output' => $output,
                                                                'pages' => $pages_total,
                                                                'type' =>$a->TYPE_NAME,
                                                                'path_to_file' => $a->path_to_file,
                                                                'authors' => $authors_out
                                                        );
                                                    }


                                                    break;
                                            case 3: // статья в журнале
                                                    $issues = $issue_db->get_issue($a->id_issue);
                                                    foreach($issues as $issue)
                                                    {
                                                        mb_internal_encoding("UTF-8");
                                                        $year = mb_substr($issue->date, 0,4);
                                                        $output = $a->TYPE_NAME.' "'.$issue->name.'", '.$year.'. - №'.$a->magazine_number.'. - C.'
                                                                 .$a->pages.'-'.$a->last_page.'.';
                                                        $pages_total = $a->last_page - $a->pages."c.";
                                                        $publications[] = array(
                                                                    'id' => $a->id,
                                                                    'title' => $a->title,
                                                                    'output' => $output,
                                                                    'pages' => $pages_total,
                                                                    'type' =>$a->TYPE_NAME,
                                                                    'path_to_file' => $a->path_to_file,
                                                                    'authors' => $authors_out
                                                            );

                                                    }
                                                    break;

                                    }

                            }

                            $this->template->view->publications = $publications;



                }
                else
                {
                        Kohana::show_404();
                }
        }

       

        

       





}
