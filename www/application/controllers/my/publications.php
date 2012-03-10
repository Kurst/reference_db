<?php defined('SYSPATH') OR die('No direct access allowed.');

class Publications_Controller extends Template_Controller
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
		$this->template->title        = Kohana::config('config.application_name').".Список публикаций";
		$this->template->sub_title    = "Список публикаций";
		$this->template->view         = new View('my/show_publications_view');
                $this->db                     = new Publication_Model();
                $this->session                = Session::instance();

		
	}



	public function index()
	{
            $this->template->view->generator       = new View('generator/form');
            $db_auth = new Author_Model();
            $issue_db = new Issue_Model();
            $publications = array();
            $username = $this->session->get('username');
          
            $n =  $db_auth->get_one_author_name($username);
            $name = $n['family']." ".$n['name']." ".$n['patronymic'];
            $this->template->view->user_name = $name;
           
            $p = $this->db->get_my_publications($username);
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
                                            'authors' => $authors_out,
                                            'status'  => $a->status
                                    );
                                    break;

                            case 2: //учебное пособие
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
                                            'authors' => $authors_out,
                                            'status'  => $a->status
                                    );
                                    break;
                            case 3: // статья в сборнике
                                    $issues = $issue_db->get_issue($a->id_issue);
                                    foreach($issues as $issue)
                                    {
                                        mb_internal_encoding("UTF-8");
                                        $year = mb_substr($issue->date, 0,4);
                                        $output = $a->TYPE_NAME.' "'.$issue->name.'", Изд."'
                                                .$issue->publisher_name.'", '.$year.'. - C.'.$a->pages.'-'.$a->last_page.'.';
                                        $pages_total = $a->last_page - $a->pages."c.";
                                        if($a->last_page == '0' || $a->pages == '0' ){$pages_total = '';}
                                        $publications[] = array(
                                                'id' => $a->id,
                                                'title' => $a->title,
                                                'output' => $output,
                                                'pages' => $pages_total,
                                                'type' =>$a->TYPE_NAME,
                                                'path_to_file' => $a->path_to_file,
                                                'authors' => $authors_out,
                                                'status'  => $a->status
                                        );
                                    }


                                    break;
                            case 4: // статья в журнале
                                    $issues = $issue_db->get_issue($a->id_issue);
                                    foreach($issues as $issue)
                                    {
                                        mb_internal_encoding("UTF-8");
                                        $year = mb_substr($issue->date, 0,4);
                                        $output = $a->TYPE_NAME.' "'.$issue->name.'", '.$year.'. - №'.$a->magazine_number.'. - C.'
                                                 .$a->pages.'-'.$a->last_page.'.';
                                        $pages_total = $a->last_page - $a->pages."c.";
                                        if($a->last_page == '0' || $a->pages == '0' ){$pages_total = '';}
                                        $publications[] = array(
                                                    'id' => $a->id,
                                                    'title' => $a->title,
                                                    'output' => $output,
                                                    'pages' => $pages_total,
                                                    'type' =>$a->TYPE_NAME,
                                                    'path_to_file' => $a->path_to_file,
                                                    'authors' => $authors_out,
                                                    'status'  => $a->status
                                            );

                                    }
                                    break;

                             case 5: // диссертация
                                    $a->date == '0000'?$a->date='':$a->date=", ".$a->date."г.";
                                    $a->pages == '0'?$a->pages=' - ':$a->pages=$a->pages."c.";
                                    $a->disser_protection = date("d.m.Y", strtotime($a->disser_protection));
                                    $a->disser_statement = date("d.m.Y", strtotime($a->disser_statement));            
                                    $output = $a->TYPE_NAME.", ".$a->disser_rank." : защищена ".$a->disser_protection." : утв. ".$a->disser_statement.
                                    " / ".$a->FIO.". - ".$a->PUBLISHER_NAME.$a->date;
                                    if($a->pages != ' - ')
                                    {
                                            $output .= " - ".$a->pages;
                                    }

                                    $publications[] = array(
                                            'id' => $a->id,
                                            'title' => $a->title,
                                            'output' => $output,
                                            'pages' => $a->pages,
                                            'type' =>$a->TYPE_NAME,
                                            'path_to_file' => $a->path_to_file,
                                            'authors' => $authors_out,
                                            'status'  => $a->status
                                    );
                                    break;
                              case 6: // автореферат
                                    $a->date == '0000'?$a->date='':$a->date=", ".$a->date."г.";
                                    $a->pages == '0'?$a->pages=' - ':$a->pages=$a->pages."c.";
                                    $a->disser_protection = date("d.m.Y", strtotime($a->disser_protection));
                                    $a->disser_statement = date("d.m.Y", strtotime($a->disser_statement));
                                    $output = $a->TYPE_NAME.", ".$a->disser_rank." : защищена ".$a->disser_protection." : утв. ".$a->disser_statement.
                                    " / ".$a->FIO.". - ".$a->PUBLISHER_NAME.$a->date;
                                    if($a->pages != ' - ')
                                    {
                                            $output .= " - ".$a->pages;
                                    }

                                    $publications[] = array(
                                            'id' => $a->id,
                                            'title' => $a->title,
                                            'output' => $output,
                                            'pages' => $a->pages,
                                            'type' =>$a->TYPE_NAME,
                                            'path_to_file' => $a->path_to_file,
                                            'authors' => $authors_out,
                                            'status'  => $a->status
                                    );
                                    break;
                               case 7: //отчет
                                    $a->date == '0000'?$a->date='':$a->date=", ".$a->date."г.";
                                    $a->pages == '0'?$a->pages=' - ':$a->pages=$a->pages."c.";
                                    $output = $a->TYPE_NAME.", ".$a->date;

                                    $publications[] = array(
                                            'id' => $a->id,
                                            'title' => $a->title,
                                            'output' => $output,
                                            'pages' => $a->pages,
                                            'type' =>$a->TYPE_NAME,
                                            'path_to_file' => $a->path_to_file,
                                            'authors' => $authors_out,
                                            'status'  => $a->status
                                    );
                                    break;

                    }

            }

            $this->template->view->publications = $publications;
            $this->template->view->new_pubs = $this->db->get_new_publications_amount($username);
                          
	}

        public function details($id)
        {
           $pub = $this->db->get_publication_by_id($id);
           $view = new View('my/publications_view_details');
           $view->id = $id;
          
           $view->description = $pub[0]->description;
           $view->description == '0'?$view->description='Нет описания':$view->description;
          if(!empty($pub[0]->path_to_file))
           {
               
               $view->links = explode("|",$pub[0]->path_to_file);
               
           }
           
           $view->render(TRUE);
           $this->auto_render = FALSE;

        }

        

       

        public function all()
        {
            $this->template->view->tab = '2';
           
        }

        public function approve_decline()
        {
                if (request::is_ajax())
		{
                        $this->auto_render = FALSE;
                        $action            = $this->input->post('action', null, true);
                        $id                = $this->input->post('id', null, true);
                        $username          = $this->session->get('username');
                        switch($action)
                        {
                                case 'approve':
                                        if($id == 'all')
                                        {
                                                $this->db->update_publication_status($username,$id,'3');
                                        }else
                                        {
                                                $this->db->update_publication_status($username,$id,'1');
                                        }
                                       
                                        break;
                                case 'decline':
                                        if($id == 'all')
                                        {
                                                 $this->db->update_publication_status($username,$id,'4');
                                        }else
                                        {
                                                 $this->db->update_publication_status($username,$id,'0');
                                        }
                                       
                                        break;

                        }

                       
                }else
                {
                        Kohana::show_404();
                }
        }





}
