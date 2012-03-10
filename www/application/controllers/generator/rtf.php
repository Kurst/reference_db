<?php defined('SYSPATH') OR die('No direct access allowed.');

class Rtf_Controller extends Controller
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
                require_once 'system/vendor/phprftlite/lib/PHPRtfLite.php';
                PHPRtfLite::registerAutoloader();

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
                        self::_create_rtf_table($pub_list,$header_flag,$name);

                }else
                {
                        self::_create_rtf_list($pub_list);
                }

                
        }

        public function _create_rtf_table($pub_list,$header_flag,$name)
        {
                $username = $this->session->get('username');
                $rtf = new PHPRtfLite();
                $rtf->setMargins(1, 2, 2, 4);
                $sect = $rtf->addSection();
                $head = new PHPRtfLite_Font(18,'Times New Roman');
                $subhead = new PHPRtfLite_Font(14,'Times New Roman');
                $text_font = new PHPRtfLite_Font(12,'Times New Roman');
                $base_font = new PHPRtfLite_Font(12,'Times New Roman');
                $border = new PHPRtfLite_Border(
                    $rtf,                                       // PHPRtfLite instance
                    new PHPRtfLite_Border_Format(1, '#000'), // left border: 2pt, green color
                    new PHPRtfLite_Border_Format(1, '#000'), // top border: 1pt, yellow color
                    new PHPRtfLite_Border_Format(1, '#000'), // right border: 2pt, red color
                    new PHPRtfLite_Border_Format(1, '#000')  // bottom border: 1pt, blue color
                );

                if($header_flag == 1)
                {
                        $name = str_replace(' ','&nbsp;',$name);
                        $sect->writeText('Список &nbsp;научных &nbsp;публикаций<br/>', $head,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
                        $sect->writeText($name.'<br/>', $subhead,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));

                }

                $table = $sect->addTable();

                $table->addRows(1);
                $table->addColumnsList(array(1,5,6,2,5));
                $table->writeToCell(1,1,'#',null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
                $table->writeToCell(1,2,'Наименование',null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
                $table->writeToCell(1,3,'Выходные&nbsp;данные',null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
                $table->writeToCell(1,4,'Страницы',null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
                $table->writeToCell(1,5,'Авторы',null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));


                //body

                $i=0;

                $p = $this->db_pub->get_publications_from_list($pub_list);

                foreach($p as $a)
                {
                        $i++;


                        $authors = explode("|",$a->FIO);
                        $authors_out = implode(', ',$authors);

                        switch($a->type)
                        {
                                case 1: //методическое пособие

                                        mb_internal_encoding("UTF-8");
                                        $a->date == '0000'?$a->date='':$a->date=$a->date."г.";

                                        $a->pages == '0'?$a->pages=' - ':$a->pages=$a->pages."c.";
                                        $type = $a->TYPE_NAME.', ';
                                        $publisher = $a->PUBLISHER_NAME.', ';
                                        $date = $a->date;
                                        $pages_total = $a->pages;

                                        $cell_row = $i+1;
                                        $title = str_replace(' ','&nbsp;',$a->title);
                                        $type = str_replace(' ','&nbsp;',$type);
                                        $publisher = str_replace(' ','&nbsp;',$publisher);
                                        $pages_total = str_replace(' ','&nbsp;',$pages_total);
                                        $authors_out = str_replace(' ','&nbsp;',$authors_out);


                                        $table->addRows(1);
                                        $table->addColumnsList(array(1,5,6,2,5));

                                        $table->writeToCell($cell_row,1,$i,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
                                        $table->writeToCell($cell_row,2,$title,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                        $table->writeToCell($cell_row,3,$type,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                        $table->writeToCell($cell_row,3,$publisher,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                        $table->writeToCell($cell_row,3,$date,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                        $table->writeToCell($cell_row,4,$pages_total,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
                                        $table->writeToCell($cell_row,5,$authors_out,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));

                                        break;

                                case 2: //уч пособие

                                        mb_internal_encoding("UTF-8");
                                        $a->date == '0000'?$a->date='':$a->date=$a->date."г.";

                                        $a->pages == '0'?$a->pages=' - ':$a->pages=$a->pages."c.";
                                        $type = $a->TYPE_NAME.', ';
                                        $publisher = $a->PUBLISHER_NAME.', ';
                                        $date = $a->date;
                                        $pages_total = $a->pages;

                                        $cell_row = $i+1;
                                        $title = str_replace(' ','&nbsp;',$a->title);
                                        $type = str_replace(' ','&nbsp;',$type);
                                        $publisher = str_replace(' ','&nbsp;',$publisher);
                                        $pages_total = str_replace(' ','&nbsp;',$pages_total);
                                        $authors_out = str_replace(' ','&nbsp;',$authors_out);


                                        $table->addRows(1);
                                        $table->addColumnsList(array(1,5,6,2,5));

                                        $table->writeToCell($cell_row,1,$i,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
                                        $table->writeToCell($cell_row,2,$title,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                        $table->writeToCell($cell_row,3,$type,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                        $table->writeToCell($cell_row,3,$publisher,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                        $table->writeToCell($cell_row,3,$date,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                        $table->writeToCell($cell_row,4,$pages_total,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
                                        $table->writeToCell($cell_row,5,$authors_out,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));

                                        break;
                                case 3: // статья в сборник


                                        $issues = $this->issue_db->get_issue($a->id_issue);
                                        foreach($issues as $issue)
                                        {
                                            mb_internal_encoding("UTF-8");
                                            $year = mb_substr($issue->date, 0,4);
                                            $output = $a->TYPE_NAME.' "'.$issue->name.'", Изд."'
                                                    .$issue->publisher_name.'", '.$year.'. - C.'.$a->pages.'-'.$a->last_page.'.';

                                            $type = $a->TYPE_NAME.' '.$issue->name.', ';
                                            $publisher = 'Изд. '.$issue->publisher_name.', ';
                                            $date = $year.'. - C.'.$a->pages.'-'.$a->last_page.'.';
                                            $pages_total = $a->last_page - $a->pages."c.";
                                            if($a->last_page == '0' || $a->pages == '0' ){$pages_total = '';}


                                            $cell_row = $i+1;
                                            $title = str_replace(' ','&nbsp;',$a->title);
                                            $type = str_replace(' ','&nbsp;',$type);
                                            $publisher = str_replace(' ','&nbsp;',$publisher);
                                            $pages_total = str_replace(' ','&nbsp;',$pages_total);
                                            $authors_out = str_replace(' ','&nbsp;',$authors_out);

                                            $table->addRows(1);
                                            $table->addColumnsList(array(1,5,6,2,5));

                                            $table->writeToCell($cell_row,1,$i,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
                                            $table->writeToCell($cell_row,2,$title,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                            $table->writeToCell($cell_row,3,$type,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                            $table->writeToCell($cell_row,3,$publisher,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                            $table->writeToCell($cell_row,3,$date,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                            $table->writeToCell($cell_row,4,$pages_total,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
                                            $table->writeToCell($cell_row,5,$authors_out,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
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

                                            $type = $a->TYPE_NAME.' '.$issue->name.', ';

                                            $date = $year.'. - #'.$a->magazine_number.'. - C.'
                                                     .$a->pages.'-'.$a->last_page.'.';
                                            $pages_total = $a->last_page - $a->pages."c.";
                                            if($a->last_page == '0' || $a->pages == '0' ){$pages_total = '';}


                                            $cell_row = $i+1;
                                            $title = str_replace(' ','&nbsp;',$a->title);
                                            $type = str_replace(' ','&nbsp;',$type);

                                            $pages_total = str_replace(' ','&nbsp;',$pages_total);
                                            $authors_out = str_replace(' ','&nbsp;',$authors_out);

                                            $table->addRows(1);
                                            $table->addColumnsList(array(1,5,6,2,5));

                                            $table->writeToCell($cell_row,1,$i,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
                                            $table->writeToCell($cell_row,2,$title,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                            $table->writeToCell($cell_row,3,$type,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));

                                            $table->writeToCell($cell_row,3,$date,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                            $table->writeToCell($cell_row,4,$pages_total,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
                                            $table->writeToCell($cell_row,5,$authors_out,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));

                                        }
                                        break;

                                 case 5: //диссертация

                                        mb_internal_encoding("UTF-8");
                                        $a->date == '0000'?$a->date='':$a->date=$a->date."г.";
                                        $a->pages == '0'?$a->pages=' - ':$a->pages=$a->pages."c.";
                                        $type = $a->TYPE_NAME.", ".$a->disser_rank." : защищена ".$a->disser_protection." : утв. ".$a->disser_statement.
                                                " / ".$a->FIO.". - ";
                                        $publisher = $a->PUBLISHER_NAME.', ';
                                        $date = $a->date." - ".$a->pages;
                                        $pages_total = $a->pages;
                                        $a->disser_protection = date("d.m.Y", strtotime($a->disser_protection));
                                        $a->disser_statement = date("d.m.Y", strtotime($a->disser_statement));

                                        $cell_row = $i+1;
                                        $title = str_replace(' ','&nbsp;',$a->title);
                                        $type = str_replace(' ','&nbsp;',$type);
                                        $publisher = str_replace(' ','&nbsp;',$publisher);
                                        $pages_total = str_replace(' ','&nbsp;',$pages_total);
                                        $authors_out = str_replace(' ','&nbsp;',$authors_out);


                                        $table->addRows(1);
                                        $table->addColumnsList(array(1,5,6,2,5));

                                        $table->writeToCell($cell_row,1,$i,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
                                        $table->writeToCell($cell_row,2,$title,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                        $table->writeToCell($cell_row,3,$type,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                        $table->writeToCell($cell_row,3,$publisher,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                        $table->writeToCell($cell_row,3,$date,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));
                                        $table->writeToCell($cell_row,4,$pages_total,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
                                        $table->writeToCell($cell_row,5,$authors_out,null,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_JUSTIFY));

                                        break;
                        }

                }

                if($header_flag == 1)
                {
                        $basement = $this->db_report->get_basement($username);
                        $j=1;
                        foreach($basement as $b)
                        {
                                $j++;
                                $position = str_replace(' ','&nbsp;',$b->position);
                                $nn = str_replace(' ','&nbsp;',$b->name);
                                $table->addRows(2);
                                $table->addColumnsList(array(36,1,1,1,37));
                                $table->mergeCellRange($cell_row+$j, 1,$cell_row+$j, 2);
                                $table->mergeCellRange($cell_row+$j, 4,$cell_row+$j, 5);
                                $table->writeToCell($cell_row+$j,1,$position,$base_font,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));
                                $table->writeToCell($cell_row+$j,4,$nn,$base_font,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));


                        }
                }

                // save rtf document
                $table->setFontForCellRange($text_font, 1, 1,$i+1, 5);
                $table->setBorderForCellRange($border, 1, 1,$i+1, 5);
                $report = 'Report_'.date("m-d-Y");
                $rtf->sendRtf($report);
                        
        }


        public function _create_rtf_list($pub_list)
        {
                
                $username = $this->session->get('username');
                $rtf = new PHPRtfLite();
                $rtf->setMargins(2, 2, 2, 4);
                $sect = $rtf->addSection();
                $text_font = new PHPRtfLite_Font(12,'Times New Roman');
                

                $i=0;

                $p = $this->db_pub->get_publications_from_list($pub_list);

                foreach($p as $a)
                {
                        $i++;
                        $authors = explode("|",$a->FIO);
                        $authors_out = implode(', ',$authors);

                        switch($a->type)
                        {
                                case 1: //методическое пособие

                                         
                                        mb_internal_encoding("UTF-8");
                                        $a->pages == '0'?$a->pages='':$a->pages=" - ".$a->pages."c.";
                                        $a->date == '0000'?$a->date='':$a->date=", ".$a->date."г.";
                                     
                                        $output = $i.'. '.$authors_out.' '.$a->title.' / '.$authors_out.
                                                  ' // '.$a->TYPE_NAME.", ".$a->PUBLISHER_NAME.' '.$a->date.$a->pages;
                                        $output = str_replace(' ','&nbsp;',$output);
                                        $sect->writeText($output, $text_font,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_LEFT));
                                        break;
                                case 2: //уч пособие


                                        mb_internal_encoding("UTF-8");
                                        $a->pages == '0'?$a->pages='':$a->pages=" - ".$a->pages."c.";
                                        $a->date == '0000'?$a->date='':$a->date=", ".$a->date."г.";

                                        $output = $i.'. '.$authors_out.' '.$a->title.' / '.$authors_out.
                                                  ' // '.$a->TYPE_NAME.", ".$a->PUBLISHER_NAME.' '.$a->date.$a->pages;
                                        $output = str_replace(' ','&nbsp;',$output);
                                        $sect->writeText($output, $text_font,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_LEFT));
                                        break;
                                case 3: // статья в сборник

                                        $issues = $this->issue_db->get_issue($a->id_issue);
                                        foreach($issues as $issue)
                                        {
                                            mb_internal_encoding("UTF-8");
                                            $year = mb_substr($issue->date, 0,4);
                                            $year = ' ,'.$year;               

                                            $output = $i.'. '.$authors_out.' '.$a->title.' / '.$authors_out.
                                                  ' // '.$a->TYPE_NAME.' "'.$issue->name.'", Изд."'
                                                    .$issue->publisher_name.'" '.$year.'. - C.'.$a->pages.'-'.$a->last_page.'.';
                                           
                                        }
                                        $output = str_replace(' ','&nbsp;',$output);
                                       
                                        $sect->writeText($output, $text_font,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_LEFT));

                                        
                                     


                                        break;
                                case 4: // статья в журнале
                                       

                                        $issues = $this->issue_db->get_issue($a->id_issue);
                                        foreach($issues as $issue)
                                        {
                                            mb_internal_encoding("UTF-8");
                                            $year = mb_substr($issue->date, 0,4);
                                            $year = ' ,'.$year;
                                            $output = $i.'. '.$authors_out.' '.$a->title.' / '.$authors_out.
                                                  ' // '.$a->TYPE_NAME.' "'.$issue->name.'"'.$year.'. - #'.$a->magazine_number.'. - C.'
                                                     .$a->pages.'-'.$a->last_page.'.';
                                            

                                        }
                                        $output = str_replace(' ','&nbsp;',$output);

                                        $sect->writeText($output, $text_font,new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_LEFT));


                                        break;
                               
                        }

                        $sect->addEmptyParagraph();

                }

                // save rtf document
                
               
                $report = 'Report_'.date("m-d-Y");
                $rtf->sendRtf($report);

        }

}
