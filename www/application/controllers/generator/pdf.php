<?php defined('SYSPATH') OR die('No direct access allowed.');

class Pdf_Controller extends Controller
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
                $this->session    = Session::instance();	
	}

        public function index()
        {
                
                $this->auto_render = FALSE;
                require_once 'system/vendor/tcpdf/tcpdf.php';
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
                        self::_create_pdf_table($pub_list,$header_flag,$name);
                        
                }else
                {
                        self::_create_pdf_list($pub_list);
                }
                

        }

        public function _create_pdf_table($pub_list,$header_flag,$name)
        {
                        $username = $this->session->get('username');
                        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
                        $pdf->setPrintHeader(false);
                        $pdf->setPrintFooter(false);
                        $pdf->SetMargins(10, 25, 10); // устанавливаем отступы (20 мм - слева, 25 мм - сверху, 25 мм - справа)
                        $pdf->SetAutoPageBreak(true);
                        $pdf->AddPage();

                        if($header_flag == 1)
                        {
                                $pdf->SetFont('arial', '', 18);
                                $pdf->SetXY(10, 10);
                                $pdf->Cell(190, 10, 'Список научных трудов', '0', '', 'C');
                                $pdf->Ln();
                                $pdf->SetFont('arial', '', 14);
                                $pdf->Cell(190, 6, $name, '0', '', 'C');
                        }

                        $pdf->SetFont('arial', '', 9);
                        $pdf->SetXY(10, 30);
                        $pdf->Cell(10, 6, '#', '1', '', 'C');
                        $pdf->Cell(50, 6, 'Наименование', '1', '', 'C');
                        $pdf->Cell(60, 6, 'Выходные данные', '1', '', 'C');
                        $pdf->Cell(20, 6, 'Страницы', '1', '', 'C');
                        $pdf->Cell(50, 6, 'Авторы', '1', '', 'C');
                        $pdf->Ln();
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
                                                $pages_total = $a->pages;
                                                break;

                                }

                                $lin = $pdf->getNumLines($a->title,50);
                                $lin_out =  $pdf->getNumLines($output,60);
                                if($lin_out > $lin)
                                {
                                        $lin = $lin_out;
                                }

                                $lin_auth =  $pdf->getNumLines($authors_out,50);
                                if($lin_auth > $lin)
                                {
                                        $lin = $lin_auth;
                                }
                                ///
                                $lin *= 5;
                                $pdf->MultiCell(10, $lin, $i, '1', 'C', '',0);
                                $pdf->MultiCell(50, $lin, $a->title, '1', '', '',0);
                                $pdf->MultiCell(60, $lin, $output, '1', '', '0',0);
                                $pdf->MultiCell(20, $lin, $pages_total, '1', 'C', '',0);
                                $pdf->MultiCell(50, $lin, $authors_out, '1', '', '',0);
                                $pdf->Ln();
                                if($pdf->checkPageBreak('','',true)) $pdf->Ln();

                        }

                        if($header_flag == 1)
                        {
                                $basement = $this->db_report->get_basement($username);
                                $pdf->SetFont('arial', '', 10);
                                foreach($basement as $b)
                                {
                                        $pdf->Ln();
                                        $pdf->MultiCell(5, 10, '', '0', 'C', '',0);
                                        $pdf->MultiCell(50, 20, $b->position, '0', 'L', '',0);
                                        $pdf->MultiCell(70, 10, '', '0', 'C', '',0);
                                        $pdf->MultiCell(60, 10, $b->name, '0', 'C', '',0);
                                        $pdf->Ln();
                                }
                        }



                        $name = 'Report_'.date("m-d-Y") .'.pdf';
                        $pdf->Output($name, 'D');
        }


        public function _create_pdf_list($pub_list)
        {
                $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->SetMargins(20, 25, 20); // устанавливаем отступы (20 мм - слева, 25 мм - сверху, 25 мм - справа)
                $pdf->SetAutoPageBreak(true);
                $pdf->AddPage();
                $pdf->SetFont('arial', '', 9);
                $pdf->SetXY(20, 25);

                $p = $this->db_pub->get_publications_from_list($pub_list);
                $i = 0;
                $output = '';
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


                        
                        //$pdf->MultiCell(10, 30, $i.' '.$output, '1', '', '0',0);
                       
                        
                        $pdf->Write(0, $i.'. '.$output);
                        $pdf->Ln();
                        $pdf->Ln();
                        
                }

                $name = 'Report_'.date("m-d-Y") .'.pdf';
                $pdf->Output($name, 'D');



        }

}
