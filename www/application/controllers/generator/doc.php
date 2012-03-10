<?php defined('SYSPATH') OR die('No direct access allowed.');

class Doc_Controller extends Controller
{
	const ALLOW_PRODUCTION = TRUE;
	
	public function __construct()
	{
		parent::__construct();

                $acl = new Acl();
		if(!$acl->logged_auto())
		{
                        url::redirect('/login/auth');
		}
                $this->db_auth = new Author_Model();
                $this->db_report = new Report_Model();
                $this->db_pub = new Publication_Model();
                $this->issue_db = new Issue_Model();

                $this->session                = Session::instance();
              
	}

        public function index()
        {
                
                $this->auto_render = FALSE;
               

                $username = $this->session->get('username');

                $pub_list = $this->input->post('id_list', null, true);
                $header_flag = $this->input->post('report_header', null, true);

                if(empty($pub_list))
                {
                        $pub_list = 0;
                }

                $settings = $this->db_report->get_name($username);
                $name = $settings->FIO;
                $report_type = $settings->report_type;

                if($report_type == '1')
                {
                        self::_create_doc_table($username,$pub_list,$header_flag,$name);

                }else
                {
                        self::_create_doc_list($username,$pub_list);
                }

               
               

                
        }

        public function _create_doc_table($username,$pub_list,$header_flag,$name)
        {
                $fname = 'Report_'.date("m-d-Y") .'.doc';
                header("Content-type: application/vnd.ms-word");
                header("Content-Disposition: attachment;Filename=".$fname);
                echo "<html>";
                echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
                echo "<body>";
              
                echo "<center><h2>Cписок научных публикаций</h2></center>
                        <center><h2>".$name."</h2></center>
                     <table style='border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;' cellspacing='0' cellpadding='0' width='100%'>
                        <tr>
                                <td style='border-right: 1px solid #000;border-bottom: 1px solid #000;'><center>№</center></td>
                                <td style='border-right: 1px solid #000;border-bottom: 1px solid #000;'><center>Наименование</center></td>
                                <td style='border-right: 1px solid #000;border-bottom: 1px solid #000;'><center>Выходные данные</center></td>
                                <td style='border-right: 1px solid #000;border-bottom: 1px solid #000;'><center>Страницы</center></td>
                                <td style='border-bottom: 1px solid #000;'><center>Авторы</center></td>
                                
                        </tr>";

                $i=0;
                $p = $this->db_pub->get_publications_from_list($pub_list);
                

                foreach($p as $a)
                {
                        $i++;
                         ///
                        $this->db_auth = new Author_Model();
                        $authors = explode("|",$a->FIO);
                        $authors_out = implode(', ',$authors);

                        switch($a->type)
                        {
                                case 1: //методическое пособие
                                        $a->date == '0000'?$a->date='':$a->date=", ".$a->date."г.";
                                        $a->pages == '0'?$a->pages=' - ':$a->pages=$a->pages."c.";
                                        $output = $a->TYPE_NAME.", ".$a->PUBLISHER_NAME.$a->date;
                                        $pages_total = $a->pages;
                                        break;
                                case 2: //учебное пособие
                                        $a->date == '0000'?$a->date='':$a->date=", ".$a->date."г.";
                                        $a->pages == '0'?$a->pages=' - ':$a->pages=$a->pages."c.";
                                        $output = $a->TYPE_NAME.", ".$a->PUBLISHER_NAME.$a->date;
                                        $pages_total = $a->pages;
                                        break;
                                case 3: // статья в сборник

                                        $issues = $this->issue_db->get_issue($a->id_issue);
                                        foreach($issues as $issue)
                                        {
                                            mb_internal_encoding("UTF-8");
                                            $year = mb_substr($issue->date, 0,4);
                                            $output = $a->TYPE_NAME.' "'.$issue->name.'", Изд."'
                                                    .$issue->publisher_name.'", '.$year.'. - C.'.$a->pages.'-'.$a->last_page.'.';
                                            $pages_total = $a->last_page - $a->pages."c.";
                                            if($a->last_page == '0' || $a->pages == '0' ){$pages_total = '';}

                                        }

                                        break;
                                case 4: // статья в журнале

                                        $issues = $this->issue_db->get_issue($a->id_issue);
                                        foreach($issues as $issue)
                                        {
                                            mb_internal_encoding("UTF-8");
                                            $year = mb_substr($issue->date, 0,4);
                                            $output = $a->TYPE_NAME.' "'.$issue->name.'", '.$year.'. - №'.$a->magazine_number.'. - C.'
                                                     .$a->pages.'-'.$a->last_page.'.';
                                            $pages_total = $a->last_page - $a->pages."c.";
                                            if($a->last_page == '0' || $a->pages == '0' ){$pages_total = '';}
                                        }
                                        break;

                                case 5: //диссертация
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
                                        $pages_total = $a->pages;
                                        break;
                                 case 6: //автореферат
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
                                        $pages_total = $a->pages;
                                        break;
                                  case 7: //отчет
                                        $a->date == '0000'?$a->date='':$a->date=", ".$a->date."г.";
                                        $a->pages == '0'?$a->pages=' - ':$a->pages=$a->pages."c.";
                                        $output = $a->TYPE_NAME.", ".$a->date;

                                        break;

                        }


                        echo "<tr>
                                <td style='border-right: 1px solid #000;border-bottom: 1px solid #000;'>".$i."</td>
                                <td style='border-right: 1px solid #000;border-bottom: 1px solid #000;'>".$a->title."</td>
                                <td style='border-right: 1px solid #000;border-bottom: 1px solid #000;'>".$output."</td>
                                <td style='border-right: 1px solid #000;border-bottom: 1px solid #000;'>".$pages_total."</td>
                                <td style='border-bottom: 1px solid #000;'>".$authors_out."</td>
                              </tr>";


                }
                echo "</table>";
                if($header_flag == 1)
                {
                        echo "<br/><br/><table width='100%'>";
                        $basement = $this->db_report->get_basement($username);

                        foreach($basement as $b)
                        {
                                echo "<tr>
                                      <td width='50%' align='left'>".$b->position."</td>
                                      <td width='50%' align='right'>".$b->name."</td>
                                      </tr>";
                        }
                        echo "</table>";
                }

                echo "</body>";
                echo "</html>";
        }

        
        public function _create_doc_list($username,$pub_list)
        {
                $fname = 'Report_'.date("m-d-Y") .'.doc';
                header("Content-type: application/vnd.ms-word");
                header("Content-Disposition: attachment;Filename=".$fname);
                echo "<html>";
                echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
                echo "<body>";

                $i=0;
                $p = $this->db_pub->get_publications_from_list($pub_list);

                foreach($p as $a)
                {
                        $i++;
                                 ///
                        $this->db_auth = new Author_Model();
                        $authors = explode("|",$a->FIO);

                        $authors_out = implode(', ',$authors);

                        switch($a->type)
                        {
                                case 1: //методическое пособие
                                        $a->pages == '0'?$a->pages='':$a->pages=" - ".$a->pages."c.";
                                        $a->date == '0000'?$a->date='':$a->date=", ".$a->date."г.";
                                        $output = $authors_out.' '.$a->title.' / '.$authors_out.
                                                  ' // '.$a->TYPE_NAME.", ".$a->PUBLISHER_NAME.' '.$a->date.$a->pages;
                                        break;
                                case 2: //учебное пособие
                                        $a->pages == '0'?$a->pages='':$a->pages=" - ".$a->pages."c.";
                                        $a->date == '0000'?$a->date='':$a->date=", ".$a->date."г.";
                                        $output = $authors_out.' '.$a->title.' / '.$authors_out.
                                                  ' // '.$a->TYPE_NAME.", ".$a->PUBLISHER_NAME.' '.$a->date.$a->pages;
                                        break;
                                case 3: // статья в сборник


                                        $issues = $this->issue_db->get_issue($a->id_issue);
                                        foreach($issues as $issue)
                                        {
                                            mb_internal_encoding("UTF-8");
                                            $year = mb_substr($issue->date, 0,4);

                                            $output = $authors_out.' '.$a->title.' / '.$authors_out.
                                                  ' // '.$a->TYPE_NAME.' "'.$issue->name.'", Изд."'
                                                    .$issue->publisher_name.'", '.$year.'. - C.'.$a->pages.'-'.$a->last_page.'.';
                                        }

                                        break;
                                case 4: // статья в журнале
                                        $issues = $this->issue_db->get_issue($a->id_issue);
                                        foreach($issues as $issue)
                                        {
                                            mb_internal_encoding("UTF-8");
                                            $year = mb_substr($issue->date, 0,4);

                                            $output = $authors_out.' '.$a->title.' / '.$authors_out.
                                                  ' // '.$a->TYPE_NAME.' "'.$issue->name.'", '.$year.'. - #'.$a->magazine_number.'. - C.'
                                                     .$a->pages.'-'.$a->last_page.'.';


                                        }


                                        break;

                                case 5: //диссертация
                                        $a->date == '0000'?$a->date='':$a->date=", ".$a->date."г.";
                                        $a->pages == '0'?$a->pages=' - ':$a->pages=$a->pages."c.";
                                        $a->disser_protection = date("d.m.Y", strtotime($a->disser_protection));
                                        $a->disser_statement = date("d.m.Y", strtotime($a->disser_statement));
                                        $output = $authors_out.' '.$a->title.' : '.$a->TYPE_NAME.", ".$a->disser_rank." : защищена ".$a->disser_protection." : утв. ".$a->disser_statement.
                                                " / ".$a->FIO.". - ".$a->PUBLISHER_NAME.$a->date;
                                        if($a->pages != ' - ')
                                        {
                                             $output .= " - ".$a->pages;
                                        }

                                        break;
                                case 6: //автореферат
                                        $a->date == '0000'?$a->date='':$a->date=", ".$a->date."г.";
                                        $a->pages == '0'?$a->pages=' - ':$a->pages=$a->pages."c.";
                                        $a->disser_protection = date("d.m.Y", strtotime($a->disser_protection));
                                        $a->disser_statement = date("d.m.Y", strtotime($a->disser_statement));
                                        $output = $authors_out.' '.$a->title.' : '.$a->TYPE_NAME.", ".$a->disser_rank." : защищена ".$a->disser_protection." : утв. ".$a->disser_statement.
                                                " / ".$a->FIO.". - ".$a->PUBLISHER_NAME.$a->date;
                                        if($a->pages != ' - ')
                                        {
                                             $output .= " - ".$a->pages;
                                        }

                                        break;
                                case 7: //отчет
                                        $a->pages == '0'?$a->pages='':$a->pages=" - ".$a->pages."c.";
                                        $a->date == '0000'?$a->date='':$a->date=", ".$a->date."г.";
                                        $output = $authors_out.' '.$a->title.' / '.$authors_out.
                                                  ' // '.$a->TYPE_NAME.", ".$a->date.$a->pages;
                                        break;
                        }

                        echo $i.". ".$output."<br/><br/>";

                }

                echo "</body>";
                echo "</html>";
        }

       
}
