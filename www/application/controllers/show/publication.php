<?php defined('SYSPATH') OR die('No direct access allowed.');

class Publication_Controller extends Template_Controller
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
		
		//
                $this->db                     = new Publication_Model();
                $this->session                = Session::instance();

		
	}



	public function index()
	{
                
	}

        public function rfid($id)
        {
                $issue_db                     = new Issue_Model();
                $pub                          = $this->db->get_publication_by_id($id);
                if(!empty($pub))
                {
                        $this->template->title        = 'Публикация';
                        $this->template->sub_title    = $pub[0]->title;
                        $this->template->view         = new View('show/publication_view');
                        $this->template->view->id     = $id;
                        $this->template->view->description         = $pub[0]->description=='0'?'':$pub[0]->description;
                        $this->template->view->authors      = '';
                        $auths = explode("|", $pub[0]->AUTHS);
                        $i=0;
                        foreach($pub as $p)
                        {
                                $this->template->view->authors .= html::anchor('finder/searcher/show/4/'.$p->AUTHOR_ID,$auths[$i]).', ';
                                $i++;
                        }
                        $this->template->view->authors = substr($this->template->view->authors,0,-2);

                        switch($pub[0]->type)
                            {
                                    case 1: //методическое пособие
                                            $pub[0]->date == '0000'?$pub[0]->date='':$pub[0]->date=", ".$pub[0]->date."г.";
                                            $pub[0]->pages == '0'?$pub[0]->pages=' - ':$pub[0]->pages=$pub[0]->pages."c.";
                                            $this->template->view->output = $pub[0]->TYPE_NAME.", ".$pub[0]->PUBLISHER_NAME.$pub[0]->date;


                                            break;
                                    case 2: //методическое пособие
                                            $pub[0]->date == '0000'?$pub[0]->date='':$pub[0]->date=", ".$pub[0]->date."г.";
                                            $pub[0]->pages == '0'?$pub[0]->pages=' - ':$pub[0]->pages=$pub[0]->pages."c.";
                                            $this->template->view->output = $pub[0]->TYPE_NAME.", ".$pub[0]->PUBLISHER_NAME.$pub[0]->date;


                                            break;
                                    case 3: // статья в сборнике
                                            $issues = $issue_db->get_issue($pub[0]->id_issue);
                                            foreach($issues as $issue)
                                            {
                                                mb_internal_encoding("UTF-8");
                                                $year = mb_substr($issue->date, 0,4);
                                                $this->template->view->output = $pub[0]->TYPE_NAME.' "'.$issue->name.'", Изд."'
                                                        .$issue->publisher_name.'", '.$year.'. - C.'.$pub[0]->pages.'-'.$pub[0]->last_page.'.';
                                                $pages_total = $pub[0]->last_page - $pub[0]->pages."c.";

                                            }


                                            break;
                                    case 4: // статья в журнале
                                            $issues = $issue_db->get_issue($pub[0]->id_issue);
                                            foreach($issues as $issue)
                                            {
                                                mb_internal_encoding("UTF-8");
                                                $year = mb_substr($issue->date, 0,4);
                                                $this->template->view->output = $pub[0]->TYPE_NAME.' "'.$issue->name.'", '.$year.'. - №'.$pub[0]->magazine_number.'. - C.'
                                                         .$pub[0]->pages.'-'.$pub[0]->last_page.'.';
                                                $pages_total = $pub[0]->last_page - $pub[0]->pages."c.";


                                            }
                                            break;
                                     case 5: // диссертация
                                            $pub[0]->date == '0000'?$a->date='':$pub[0]->date=", ".$pub[0]->date."г.";
                                            $pub[0]->pages == '0'?$pub[0]->pages=' - ':$pub[0]->pages=$pub[0]->pages."c.";
                                            $pub[0]->disser_protection = date("d.m.Y", strtotime($pub[0]->disser_protection));
                                            $pub[0]->disser_statement = date("d.m.Y", strtotime($pub[0]->disser_statement));
                                            $this->template->view->output = $pub[0]->TYPE_NAME.", ".$pub[0]->disser_rank." : защищена ".$pub[0]->disser_protection." : утв. ".$pub[0]->disser_statement.
                                            " / ".$pub[0]->FIO.". - ".$pub[0]->PUBLISHER_NAME.$pub[0]->date;
                                            if($pub[0]->pages != ' - ')
                                            {
                                                    $this->template->view->output .= " - ".$pub[0]->pages;
                                            }
                                            break;

                                     case 6: // автореферат
                                            $pub[0]->date == '0000'?$a->date='':$pub[0]->date=", ".$pub[0]->date."г.";
                                            $pub[0]->pages == '0'?$pub[0]->pages=' - ':$pub[0]->pages=$pub[0]->pages."c.";
                                            $pub[0]->disser_protection = date("d.m.Y", strtotime($pub[0]->disser_protection));
                                            $pub[0]->disser_statement = date("d.m.Y", strtotime($pub[0]->disser_statement));
                                            $this->template->view->output = $pub[0]->TYPE_NAME.", ".$pub[0]->disser_rank." : защищена ".$pub[0]->disser_protection." : утв. ".$pub[0]->disser_statement.
                                            " / ".$pub[0]->FIO.". - ".$pub[0]->PUBLISHER_NAME.$pub[0]->date;
                                            if($pub[0]->pages != ' - ')
                                            {
                                                    $this->template->view->output .= " - ".$pub[0]->pages;
                                            }
                                            break;

                                     case 7: // отчет
                                            $pub[0]->date == '0000'?$pub[0]->date='':$pub[0]->date=", ".$pub[0]->date."г.";
                                            $pub[0]->pages == '0'?$pub[0]->pages=' - ':$pub[0]->pages=$pub[0]->pages."c.";
                                            $this->template->view->output = $pub[0]->TYPE_NAME.", ".$pub[0]->date;
                                            break;


                            }

                             if(!empty($pub[0]->path_to_file))
                             {

                                 $this->template->view->links = explode("|",$pub[0]->path_to_file);

                             }
                        $this->template->view->render(TRUE);
                        $this->auto_render = FALSE;

                        }else
                        {
                                Kohana::show_404();
                        }


                }

        
        




}
