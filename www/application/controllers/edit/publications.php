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
		$this->template->view         = new View('edit/publications_view');
                $this->db                     = new Publication_Model();
                $this->author_db              = new Author_Model();
                $this->acl_db                 = new Acl_Model();
                $this->org_db                 = new Org_Model();
                $this->session                = Session::instance();

		
	}

        public function _make_types($type = '')
	{
		$types_table_db = new Publication_type_Model;
                $types = $types_table_db->get_all_types();
		$list_of_options = "";

                foreach($types as $t)
                {
                        if($t->id == $type)
                        {
                             $list_of_options .= "<option selected value='".$t->id."'>".$t->name."</option>";
                        }else
                        {
                            $list_of_options .= "<option value='".$t->id."'>".$t->name."</option>";
                        }
                        
                }


		return $list_of_options;
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

        public function _make_org_options($id = 0)
	{


		$opt = $this->org_db->get_orgs_by_parent_id(0);
		$list_of_options = "<option value='0'></option>";
                if($opt)
                {
                    foreach($opt as $o)
                    {
                                if($id == $o->id)
                                {
                                    $list_of_options .= "<option value='".$o->id."' selected>".$o->name."</option>";
                                }else
                                {
                                    $list_of_options .= "<option value='".$o->id."'>".$o->name."</option>";
                                }
                            
                    }
                }



		return $list_of_options;
	}


        public function _make_issues($issue = '')
	{
		$issue_table_db = new Issue_Model;
		$issues = $issue_table_db->get_issues();
		$list_of_options = "<option value='0'></option>";
		foreach($issues as $i)
		{
			if($i->id == $issue)
                        {
                             $list_of_options .= "<option selected value='".$i->id."'>".$i->name."</option>";
                        }else
                        {
                             $list_of_options .= "<option value='".$i->id."'>".$i->name."</option>";
                        }
		}


		return $list_of_options;
	}

        public function _make_authors($creator_id,$pub_id)
	{
               // $j         = 0;
                $k         = 0;
               // $all       = 0;
                $res       = '';
                $authors   = $this->session->get('authors');
                $ids       = $this->session->get('authors_id');
                foreach($authors as $a)
                {
                    $k++;
                    
                    //$all++;
                    $res .= "<div style='height:20px;background:#ccc;margin-bottom:10px;margin-right:10px;position:relative;'>"
                         .$a."<a href='javascript:delete_author(".$ids[$k-1].",".$pub_id.",".$creator_id.");' style='text-decoration:none;'>
                         <img style='position:absolute; right:0;' src='/static/images/delete_small.png'/></a>
                         <input type='hidden' name='author_".$k."' value='".$ids[$k-1]."'/> </div>";
                    

                }
                
               /* foreach($authors as $a)
                {
                    $k++;
                    if($creator_id != $ids[$k-1])
                    {
                         $all++;
                         $res .= "<div style='height:20px;background:#ccc;margin-bottom:10px;margin-right:10px;position:relative;'>"
                         .$a."<a href='javascript:delete_author(".$ids[$k-1].",".$pub_id.",".$creator_id.");' style='text-decoration:none;'>
                         <img style='position:absolute; right:0;' src='/static/images/delete_small.png'/></a>
                         <input type='hidden' name='author_".$all."' value='".$ids[$k-1]."'/> </div>";
                    }
                    
                }*/
                $res .= "<input type='hidden' name='auth_num' value='".$k."'";
                return $res;
	}

        public function _make_file_links($id)
        {
            $res = '';
            $links   = $this->session->get('file_links');
            foreach($links as $lnk)
            {
                if(strlen($lnk) > 45)
                {
                    $l = substr($lnk,0,45).'...';
                }else
                {
                    $l = $lnk;
                }
                $ext = substr($lnk,strlen($lnk)-3,strlen($lnk));
                
                switch($ext)
                {
                    case 'doc':
                        $icon = "<img src='/static/images/word.png'/>";
                        break;
                    case 'pdf':
                        $icon = "<img src='/static/images/pdf.png'/>";
                        break;
                    case 'zip':
                        $icon = "<img src='/static/images/zip.png'/>";
                        break;
                    case 'rar':
                        $icon = "<img src='/static/images/zip.png'/>";
                        break;
                    case 'jpg':
                        $icon = "<img src='/static/images/image.png'/>";
                        break;
                    case 'peg':
                        $icon = "<img src='/static/images/image.png'/>";
                        break;
                    case 'png':
                        $icon = "<img src='/static/images/image.png'/>";
                        break;
                    default:
                        $icon = "<img src='/static/images/file.png'/>";
                        break;

                }
                
                $res .= "<div style='border:1px solid #ccc;height:20px;margin-bottom:10px;margin-right:10px;position:relative;'>"
                         .$icon." <a href='/pub_storage/".$id."/".$lnk."' title='".$lnk."'>".$l."</a>
                         <a href='javascript:delete_file(\"".$lnk."\",".$id.");' style='text-decoration:none;'>
                         <img style='position:absolute; right:0;' src='/static/images/delete_small.png'/></a>
                         </div>";

            }
            return $res;

        }



	public function index()
	{
            $db_auth = new Author_Model();
            $issue_db = new Issue_Model();
            $publications = array();
            $username = $this->session->get('username');

            $n =  $db_auth->get_one_author_name($username);
            $name = $n['family']." ".$n['name']." ".$n['patronymic'];
            $this->template->view->user_name = $name;
            $p = $this->db->get_publications_created_by($username);     
            $p = (object) array_merge((array) $p, (array) $this->db->get_publications_as_coauthor($username));
            $p = (object) array_merge((array) $p, (array) $this->db->get_publications_deligated_to($username));
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
                                            'authors' => $authors_out
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
                                                'authors' => $authors_out
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
                                                    'authors' => $authors_out
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
                                            'authors' => $authors_out
                                            
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
                                            'authors' => $authors_out

                                    );
                                    break;
                                case 7: //Отчет
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
                                            'authors' => $authors_out
                                    );
                                    break;

                    }

            }

            $this->template->view->publications = $publications;
            
               
               

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

        public function delegate($id)
        {
           $pub = $this->db->get_publication_by_id($id);
           $view = new View('edit/publications_view_deligate');
           $view->id = $id;
           $view->title = $pub[0]->title;
           $view->delegate_authors = $this->author_db->get_coauthors_by_pub_id($pub[0]->id,"0"); // second arg 0 for delegated
           $view->all_coauthors = $this->author_db->get_coauthors_by_pub_id($pub[0]->id,"1"); // second arg 1 for all coauthors
           $view->creator =  $this->author_db->get_coauthors_by_pub_id($pub[0]->creator_id,"3"); //3 for creator
           $view->all_authors = $this->author_db->get_coauthors_by_pub_id("0","4"); //3 for all
           
           $view->render(TRUE);
           $this->auto_render = FALSE;

        }

        public function do_delegate()
        {
           if (request::is_ajax())
		{
                        $this->auto_render = FALSE;
                        $id                = $this->input->post('id', null, true);
                        $auth_id            = $this->input->post('auth_id', null, true);
                        if($auth_id != '0')
                        {
                                 $this->db->delegate_rights_to_author($id,$auth_id);
                        }else
                        {
                                echo 'failed';
                        }



                }else
                {
                        Kohana::show_404();
                }

        }


        public function remove_delegate()
        {
           if (request::is_ajax())
		{
                        $this->auto_render = FALSE;
                        $id                = $this->input->post('id', null, true);
                        $auth_id           = $this->input->post('auth_id', null, true);
                        if($auth_id != '0')
                        {
                                 $this->db->remove_rights_from_author($id,$auth_id);
                                 echo "success";
                        }else
                        {
                                echo 'failed';
                        }



                }else
                {
                        Kohana::show_404();
                }

        }



        public function id($id,$f = '')
        {

            if($this->acl_db->get_access_permission($this->session->get('username'),$id,'publication') == 1)
            {
                    $this->template->title                     = "Редактирование";
                    $this->template->sub_title                 = "Редактирование";
                    $pub                                       = $this->db->get_publication_by_id($id);
                    if(!empty($pub))
                    {


                            $this->template->view                      = new View('edit/edit_publication_view');
                            $this->template->view->types               = $this->_make_types($pub[0]->type);
                            $this->template->view->title               = $pub[0]->title;
                            $this->template->view->description         = $pub[0]->description=='0'?'':$pub[0]->description;
                            $this->template->view->id                  = $pub[0]->id;
                            $authors                                   = array();
                            $authors_id                                = array();
                            if(empty($f))
                            {
                                foreach($pub as $p)
                                {
                                    array_push($authors, $p->FIO);
                                    array_push($authors_id, $p->AUTHOR_ID);
                                }

                                $this->session->delete('authors');
                                $this->session->delete('authors_id');
                                $ses_data = array(
                                        'authors' => $authors,
                                        'authors_id' => $authors_id
                                );
                                $this->session->set($ses_data);
                            }


                            $this->template->view->authors             = $this->_make_authors($pub[0]->creator_id,$id);

                            $this->session->delete('file_links');
                            $this->session->delete('todelete_links');
                            $this->template->view->file_links          = '';
                            if(!empty($pub[0]->path_to_file))
                            {
                                $todelete                              = array();
                                $links                                 = explode("|",$pub[0]->path_to_file);
                                $f_data                                = array(
                                                                            'file_links' => $links,
                                                                            'todelete_links' => $todelete
                                                                          );
                                $this->session->set($f_data);

                                $this->template->view->file_links      = $this->_make_file_links($id);

                            }



                            switch($pub[0]->type)
                            {
                                    case 1:
                                            $this->template->view->default_type                    = new View('edit/pub_types/edit_publication_metod');
                                            $this->template->view->default_type->date              = $pub[0]->date=='0000'?'':$pub[0]->date;
                                            $this->template->view->default_type->circulation       = $pub[0]->circulation=='0'?'':$pub[0]->circulation;
                                            $this->template->view->default_type->pages             = $pub[0]->pages=='0'?'':$pub[0]->pages;
                                            $this->template->view->default_type->publisher         = $this->_make_publisher($pub[0]->id_publisher);
                                            break;
                                    case 2:
                                            $this->template->view->default_type                    = new View('edit/pub_types/edit_publication_metod');
                                            $this->template->view->default_type->date              = $pub[0]->date=='0000'?'':$pub[0]->date;
                                            $this->template->view->default_type->circulation       = $pub[0]->circulation=='0'?'':$pub[0]->circulation;
                                            $this->template->view->default_type->pages             = $pub[0]->pages=='0'?'':$pub[0]->pages;
                                            $this->template->view->default_type->publisher         = $this->_make_publisher($pub[0]->id_publisher);
                                            break;
                                    case 3:
                                            $this->template->view->default_type                    = new View('edit/pub_types/edit_publication_statia');
                                            $this->template->view->default_type->first_page        = $pub[0]->pages=='0'?'':$pub[0]->pages;
                                            $this->template->view->default_type->last_page         = $pub[0]->last_page=='0'?'':$pub[0]->last_page;
                                            $this->template->view->default_type->issue             = $this->_make_issues($pub[0]->id_issue);
                                            break;
                                    case 4:
                                            $this->template->view->default_type                    = new View('edit/pub_types/edit_publication_magazine');
                                            $this->template->view->default_type->mag_num           = $pub[0]->magazine_number=='0'?'':$pub[0]->magazine_number;
                                            $this->template->view->default_type->first_page        = $pub[0]->pages;
                                            $this->template->view->default_type->last_page         = $pub[0]->last_page=='0'?'':$pub[0]->last_page;
                                            $this->template->view->default_type->issue             = $this->_make_issues($pub[0]->id_issue);
                                            break;
                                    case 5:

                                            $this->template->view->default_type                    = new View('edit/pub_types/edit_publication_disser');
                                            $this->template->view->default_type->date              = $pub[0]->date=='0000'?'':$pub[0]->date;
                                            $this->template->view->default_type->pages             = $pub[0]->pages=='0'?'':$pub[0]->pages;
                                            $this->template->view->default_type->publisher         = $this->_make_publisher($pub[0]->id_publisher);
                                            $this->template->view->default_type->rank              = $pub[0]->disser_rank;
                                            $this->template->view->default_type->protection        = $pub[0]->disser_protection;
                                            $this->template->view->default_type->statement         = $pub[0]->disser_statement;
                                            break;
                                    case 6:

                                            $this->template->view->default_type                    = new View('edit/pub_types/edit_publication_disser');
                                            $this->template->view->default_type->date              = $pub[0]->date=='0000'?'':$pub[0]->date;
                                            $this->template->view->default_type->pages             = $pub[0]->pages=='0'?'':$pub[0]->pages;
                                            $this->template->view->default_type->publisher         = $this->_make_publisher($pub[0]->id_publisher);
                                            $this->template->view->default_type->rank              = $pub[0]->disser_rank;
                                            $this->template->view->default_type->protection        = $pub[0]->disser_protection;
                                            $this->template->view->default_type->statement         = $pub[0]->disser_statement;
                                            break;
                                    case 7:
                                            $this->template->view->default_type                    = new View('edit/pub_types/edit_publication_report');
                                            $this->template->view->default_type->date              = $pub[0]->date=='0000'?'':$pub[0]->date;
                                            $this->template->view->default_type->city_id           = $pub[0]->city_id=='111111'?'':$pub[0]->city_id;
                                            $this->template->view->default_type->city              = $pub[0]->CITY;
                                            $this->template->view->default_type->pages             = $pub[0]->pages=='0'?'':$pub[0]->pages;
                                            $this->template->view->default_type->report_type       = $pub[0]->report_type;
                                            $this->template->view->default_type->short_name        = $pub[0]->short_name;
                                            $this->template->view->default_type->standart_number   = $pub[0]->standart_number;
                                            $this->template->view->default_type->select_options    = self::_make_org_options($pub[0]->org_id);
                                            
                                            break;

                            }


                    }else
                    {
                            Kohana::show_404();
                    }
            }else
            {
                    Kohana::show_404();
            }
            
        }

        public function change_type()
        {
                if (request::is_ajax())
		{
                        $this->auto_render = FALSE;
                        $id                = $this->input->post('id', null, true);
                        $sel_id            = $this->input->post('sel_id', null, true);
                        $pub               = $this->db->get_publication_by_id($id);
                        switch($sel_id)
                        {
                            case 1:
                                    $this->template->view->default_type                    = new View('edit/pub_types/edit_publication_metod');
                                    $this->template->view->default_type->date              = $pub[0]->date=='0000'?'':$pub[0]->date;
                                    $this->template->view->default_type->circulation       = $pub[0]->circulation=='0'?'':$pub[0]->circulation;
                                    $this->template->view->default_type->pages             = $pub[0]->pages=='0'?'':$pub[0]->pages;
                                    $this->template->view->default_type->publisher         = $this->_make_publisher($pub[0]->id_publisher);
                                    break;
                            case 2:
                                    $this->template->view->default_type                    = new View('edit/pub_types/edit_publication_metod');
                                    $this->template->view->default_type->date              = $pub[0]->date=='0000'?'':$pub[0]->date;
                                    $this->template->view->default_type->circulation       = $pub[0]->circulation=='0'?'':$pub[0]->circulation;
                                    $this->template->view->default_type->pages             = $pub[0]->pages=='0'?'':$pub[0]->pages;
                                    $this->template->view->default_type->publisher         = $this->_make_publisher($pub[0]->id_publisher);
                                    break;
                            case 3:
                                    $this->template->view->default_type                    = new View('edit/pub_types/edit_publication_statia');
                                    $this->template->view->default_type->first_page        = $pub[0]->pages=='0'?'':$pub[0]->pages;
                                    $this->template->view->default_type->last_page         = $pub[0]->last_page=='0'?'':$pub[0]->last_page;
                                    $this->template->view->default_type->issue             = $this->_make_issues($pub[0]->id_issue);
                                    break;
                            case 4:
                                    $this->template->view->default_type                    = new View('edit/pub_types/edit_publication_magazine');
                                    $this->template->view->default_type->mag_num           = $pub[0]->magazine_number=='0'?'':$pub[0]->magazine_number;
                                    $this->template->view->default_type->first_page        = $pub[0]->pages=='0'?'':$pub[0]->pages;
                                    $this->template->view->default_type->last_page         = $pub[0]->last_page=='0'?'':$pub[0]->last_page;
                                    $this->template->view->default_type->issue             = $this->_make_issues($pub[0]->id_issue);
                                    break;

                            case 5:
                                    $this->template->view->default_type                    = new View('edit/pub_types/edit_publication_disser');
                                    $this->template->view->default_type->date              = $pub[0]->date=='0000'?'':$pub[0]->date;
                                    $this->template->view->default_type->pages             = $pub[0]->pages=='0'?'':$pub[0]->pages;
                                    $this->template->view->default_type->publisher         = $this->_make_publisher($pub[0]->id_publisher);
                                    $this->template->view->default_type->rank              = $pub[0]->disser_rank;
                                    $this->template->view->default_type->protection        = $pub[0]->disser_protection;
                                    $this->template->view->default_type->statement         = $pub[0]->disser_statement;
                                    break;
                            case 6:
                                    $this->template->view->default_type                    = new View('edit/pub_types/edit_publication_disser');
                                    $this->template->view->default_type->date              = $pub[0]->date=='0000'?'':$pub[0]->date;
                                    $this->template->view->default_type->pages             = $pub[0]->pages=='0'?'':$pub[0]->pages;
                                    $this->template->view->default_type->publisher         = $this->_make_publisher($pub[0]->id_publisher);
                                    $this->template->view->default_type->rank              = $pub[0]->disser_rank;
                                    $this->template->view->default_type->protection        = $pub[0]->disser_protection;
                                    $this->template->view->default_type->statement         = $pub[0]->disser_statement;
                                    break;
                            case 7:
                                    $this->template->view->default_type                    = new View('edit/pub_types/edit_publication_report');
                                    $this->template->view->default_type->date              = $pub[0]->date=='0000'?'':$pub[0]->date;
                                    $this->template->view->default_type->city_id           = $pub[0]->city_id=='111111'?'':$pub[0]->city_id;
                                    $this->template->view->default_type->city              = $pub[0]->CITY;
                                    $this->template->view->default_type->pages             = $pub[0]->pages=='0'?'':$pub[0]->pages;
                                    $this->template->view->default_type->report_type       = $pub[0]->report_type;
                                    $this->template->view->default_type->short_name        = $pub[0]->short_name;
                                    $this->template->view->default_type->standart_number   = $pub[0]->standart_number;
                                    $this->template->view->default_type->select_options    = self::_make_org_options($pub[0]->org_id);

                                    break;
                        }
                        
                        echo $this->template->view->default_type;

                }else
                {
                        Kohana::show_404();
                }
        }

        public function delete_author()
        {
                if (request::is_ajax())
		{
                        $this->auto_render = FALSE;
                        $id                = $this->input->post('id', null, true);
                        $pub_id            = $this->input->post('pub_id', null, true);
                        $creator_id        = $this->input->post('creator_id', null, true);
                        /*$a                 = $this->db->delete_author_from_publication($id,$pub_id);
                        $authors                                   = array();
                        $authors_id                                = array();
                        foreach($a as $p)
                        {
                              array_push($authors, $p->FIO);
                              array_push($authors_id, $p->AUTHOR_ID);
                        }*/

                         $authors = $this->session->get('authors');
                         $ids     = $this->session->get('authors_id');
                         $authors_new = array();
                         $ids_new = array();
                         $i=0;
                         foreach($authors as $a)
                         {
                                 if($ids[$i] != $id)
                                 {
                                         array_push($authors_new,$a);
                                         array_push($ids_new,$ids[$i]);
                                 }
                                 $i++;

                         }
                         $this->session->delete('authors');
                         $this->session->delete('authors_id');
                         $ses_data = array(
                                        'authors' => $authors_new,
                                        'authors_id' => $ids_new
                         );
                         $this->session->set($ses_data);
                         echo $this->_make_authors($creator_id,$pub_id);
                }
        }

        public function delete_file_link()
        {
                if (request::is_ajax())
		{
                        $this->auto_render = FALSE;
                        $name                = $this->input->post('name', null, true);
                        $pub_id              = $this->input->post('pub_id', null, true);

                         $links = $this->session->get('file_links');
                         $to_delete = $this->session->get('todelete_links');
                       
                         $links_new = array();
                         
                         
                         foreach($links as $l)
                         {
                                 if($l != $name)
                                 {
                                      array_push($links_new,$l);
                                         
                                 }else
                                 {
                                      array_push($to_delete,$l);
                                 }
                                 

                         }
                         $this->session->delete('file_links');
                         $this->session->delete('todelete_links');
                         $ses_data = array(
                                        'file_links' => $links_new,
                                        'todelete_links' => $to_delete
                         );
                         $this->session->set($ses_data);
                         echo $this->_make_file_links($pub_id);
                }
        }

        public function add_file_field()
        {
            if (request::is_ajax())
		{
			$this->auto_render = FALSE;
			$files_counter =  $this->input->post('files_counter', null, true);
			$f = $files_counter +1;

                        $res = '<br/>
                          <input class="file_'.$files_counter.'" name="file_'.$files_counter.'" type="file" /><br/>
                          
                          <div id="new_file_'.$f.'"></div>';
                        $files_counter++;

			echo $res;

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
                $post->add_rules('title', 'required');
                
                $post->add_rules('circulation','digit');
                $publication['id']              = $this->input->post('id', null, true);
                $files                          = new Validation($_FILES);
                $trans                          = new Translit();
                $files_counter                  = $this->input->post('files_counter', null, true);
                $filename = '';
                $authors_id                     = $this->session->get('authors_id');
                
                    for($i = 0;$i<$files_counter;$i++)
                    {
                            $fls[] = $_FILES['file_'.$i];
                            $files->add_rules('file_'.$i,'upload::type[doc,docx,pdf,txt,jpg,jpeg,png,zip,rar]');
                            if(!empty($_FILES['file_'.$i]['name']))
                            {
                                $filename .= '|';
                            }
                            $n = $trans->translate($_FILES['file_'.$i]['name']);
                            $filename .= $n;

                    }

                if(empty($authors_id))
                {
                        $post->add_error('authors', 'default');

                }
                
                if ($post->validate() && ($files->validate() || !isset($_FILES['file_0'])))
                {
                    
                    $publication['title']           = $this->input->post('title', null, true);
                    $publication['type']            = $this->input->post('type', null, true);
                    $publication['issue']           = $this->input->post('issue', null, true);
                    $publication['issue']           = empty($publication['issue']) ? '0' : $publication['issue'];
                    $publication['publisher']       = $this->input->post('publisher', null, true);
                    $publication['date']            = $this->input->post('date', null, true);
                    $publication['date']            = empty($publication['date']) ? '0000' : $publication['date'];
                    $publication['circulation']     = $this->input->post('circulation', null, true);
                    $publication['circulation']     = empty($publication['circulation']) ? '0' : $publication['circulation'];
                    $publication['pages']           = $this->input->post('pages', null, true);
                    $publication['pages']           = empty($publication['pages']) ? '0' : $publication['pages'];
                    $publication['last_page']       = $this->input->post('last_page', null, true);
                    $publication['last_page']       = empty($publication['last_page']) ? '0' : $publication['last_page'];
                    $publication['desc']            = $this->input->post('desc', null, true);
                    $publication['desc']            = empty($publication['desc']) ? '0' : $publication['desc'];
                    $publication['magazine_number'] = $this->input->post('mag_number', null, true);
                    $publication['magazine_number'] = empty($publication['magazine_number']) ? '0' : $publication['magazine_number'];
                    $publication['protection']      = $this->input->post('protection', null, true);
                    $publication['protection']      = empty($publication['protection']) ? '0000' : $publication['protection'];
                    $publication['statement']       = $this->input->post('statement', null, true);
                    $publication['statement']       = empty($publication['statement']) ? '0000' : $publication['statement'];
                    $publication['rank']            = $this->input->post('rank', null, true);
                    $publication['city_id']         = $this->input->post('city_id', null, true);
                    $publication['city_id'] = empty($publication['city_id']) ? '111111' : $publication['city_id'];
                    $publication['report_type']     = $this->input->post('report_type', null, true);
                    $publication['short_name']      = $this->input->post('short_name', null, true);
                    $publication['standart_number'] = $this->input->post('standart_number', null, true);
                    $publication['org']             = $this->input->post('org', null, true);

                    $links_string                   = '';
                    $links                          = $this->session->get('file_links');
                    $to_delete                      = $this->session->get('todelete_links');
                    
                    $publication['authors_string']  = implode(',',$authors_id);
                    //die(print($publication['authors_string']));
                    if(!empty($links))
                    {
                            $links_string           = implode('|',$links);       
                    }else
                    {
                            $filename = substr($filename,1,strlen($filename));
                    }
                   
                    if(!empty($to_delete))
                    {
                           foreach($to_delete as $td)
                            {
                                unlink('pub_storage/'.$publication['id'].'/'.$td);
                            }
                    }
                    

                    for($i = 0;$i<$files_counter;$i++)
                    {
                        $name = $trans->translate($fls[$i]['name']);

                        upload::save($fls[$i],$name,'pub_storage/'.$publication['id'],'0644');
                    }
                    $publication['files']           = $links_string.$filename;
                  
                    $state                          = $this->db->update_publication_by_id($publication);
                    if($state != 'failed')
                    {
                            $this->template->view           = new View('messages/success/edit_publication_success');
                    }else
                    {
                            $this->template->view           = new View('messages/failure/edit_publication_failure');
                    }
                    

                }else
                {
                    url::redirect('/edit/publications/id/'.$publication['id']);

                }
               
            }
            
        }

        public function add_author($id)
        {
           $author_db                   = new Author_Model();
           $view                        = new View('edit/publications_view_add_author');
           $aut                         = $author_db->get_all_authors();
           $view->id                    = $id;
           $view->authors               = array();
           $view->authors_id            = array();
           $view->ids                   = $this->session->get('authors_id');
           $view->id_list               = implode(',',$view->ids);
          
           $view->name_list             = implode(',', $this->session->get('authors'));
           foreach($aut as $a)
           {
                $FIO = $a->family.' '.$a->name.' '.$a->patronymic;
                
                array_push($view->authors, $FIO);
                array_push($view->authors_id, $a->id);
           }

           $view->render(TRUE);
           $this->auto_render = FALSE;

        }

        public function add_author_session()
        {
                if (request::is_ajax())
		{
                         $this->auto_render     = FALSE;
                         $id_list               = $this->input->post('id_list', null, true);
                         $name_list             = $this->input->post('name_list', null, true);
                         $new_authors           = explode(",",$name_list);
                         $new_authors_id        = explode(",",$id_list);
                         $authors               = array();
                         $ids                   = array();
                         $i                     = 0;
                         foreach($new_authors as $a)
                         {
                                 if(!empty($a))
                                 {
                                         array_push($authors,$a);
                                         array_push($ids, $new_authors_id[$i]);
                                         $i++; 
                                 }
                                
                         }

                         $this->session->delete('authors');
                         $this->session->delete('authors_id');
                         $ses_data = array(
                                        'authors' => $authors,
                                        'authors_id' => $ids
                         );
                         $this->session->set($ses_data);

                         return true;

                         

                }
               
        }


        

     

}
