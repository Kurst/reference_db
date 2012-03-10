<?php defined('SYSPATH') OR die('No direct access allowed.');

class Bib_Controller extends Controller
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
                require_once 'system/vendor/bibtex_structures/BibTex.php';
               

                $pub_list = $this->input->post('id_list', null, true);
                

                if(empty($pub_list))
                {
                        $pub_list = 0;
                }
                
                $bibtex = new Structures_BibTex();

                $p = $this->db_pub->get_publications_from_list($pub_list);
                $i = 0;
                
                foreach($p as $a)
                {
                        $i++;

                        $this->db_auth = new Author_Model();
                        $authors = explode("|",$a->FIO);
                        
                        switch($a->type)
                        {
                                case 1: //методическое пособие  @book
                                        if($a->date == '0000'){$a->date='';}

                                        $bibarray                       = array();
                                        $bibarray['entryType']          = 'book';
                                        $bibarray['cite']               = $authors[0].$a->date;
                                        $bibarray['title']              = $a->title;
                                        $bibarray['year']               = $a->date;
                                        $bibarray['publisher']          = $a->PUBLISHER_NAME;
                                        if($a->pages != '0')
                                        {
                                                $bibarray['pages']      = $a->pages;
                                        }
                                        $j=0;
                                        foreach($authors as $auth)
                                        {
                                                $bibarray['author'][$j]['first'] = $auth;
                                                $j++;
                                        }
                                        $bibtex->addEntry($bibarray);
                                        
                                        

                                        break;
                                  case 2: //уч пособие  @book
                                        if($a->date == '0000'){$a->date='';}

                                        $bibarray                       = array();
                                        $bibarray['entryType']          = 'book';
                                        $bibarray['cite']               = $authors[0].$a->date;
                                        $bibarray['title']              = $a->title;
                                        $bibarray['year']               = $a->date;
                                        $bibarray['publisher']          = $a->PUBLISHER_NAME;
                                        if($a->pages != '0')
                                        {
                                                $bibarray['pages']      = $a->pages;
                                        }
                                        $j=0;
                                        foreach($authors as $auth)
                                        {
                                                $bibarray['author'][$j]['first'] = $auth;
                                                $j++;
                                        }
                                        $bibtex->addEntry($bibarray);
                                        
                                        

                                        break;

                                case 3: // статья в сборник @conference
                                        $issues = $this->issue_db->get_issue($a->id_issue);
                                        foreach($issues as $issue)
                                        {
                                            mb_internal_encoding("UTF-8");
                                            $year = mb_substr($issue->date, 0,4);
                                            if($year == '0000'){$year='';}
                                            $bibarray                       = array();
                                            $bibarray['entryType']          = 'conference';
                                            $bibarray['cite']               = $authors[0].$year;
                                            $bibarray['title']              = $a->title;
                                            $bibarray['year']               = $year;
                                            $bibarray['booktitle']          = $issue->name;
                                            $bibarray['publisher']          = $issue->publisher_name;
                                             if($a->pages != '0' && $a->last_page != '0')
                                             {
                                                        $bibarray['pages']      = $a->last_page - $a->pages;
                                             }


                                        }
                                       
                                        $j=0;
                                        foreach($authors as $auth)
                                        {
                                                $bibarray['author'][$j]['first'] = $auth;
                                                $j++;
                                        }
                                        $bibtex->addEntry($bibarray);
                                     
                                        break;
                                case 4: // статья в журнале   @article

                                        $issues = $this->issue_db->get_issue($a->id_issue);
                                        foreach($issues as $issue)
                                        {
                                            mb_internal_encoding("UTF-8");
                                            $year = mb_substr($issue->date, 0,4);
                                            if($year == '0000'){$year='';}

                                            $bibarray                       = array();
                                            $bibarray['entryType']          = 'article';
                                            $bibarray['cite']               = $authors[0].$year;
                                            $bibarray['title']              = $a->title;
                                            $bibarray['year']               = $year;
                                            $bibarray['journal']            = $issue->name;
                                            $bibarray['number']             = $a->magazine_number;
                                             if($a->pages != '0' && $a->last_page != '0')
                                             {
                                                        $bibarray['pages']      = $a->last_page - $a->pages;
                                             }

                                        }

                                        $j=0;
                                        foreach($authors as $auth)
                                        {
                                                $bibarray['author'][$j]['first'] = $auth;
                                                $j++;
                                        }
                                        $bibtex->addEntry($bibarray);
                                        break;

                                case 5: //диссертация  @phdthesis
                                        if($a->date == '0000'){$a->date='';}

                                        $bibarray                       = array();
                                        $bibarray['entryType']          = 'phdthesis';
                                        $bibarray['cite']               = $authors[0].$a->date;
                                        $bibarray['title']              = $a->title;
                                        $bibarray['school']             = '';
                                        $bibarray['year']               = $a->date;
                                        $bibarray['publisher']          = $a->PUBLISHER_NAME;
                                        if($a->pages != '0')
                                        {
                                                $bibarray['pages']      = $a->pages;
                                        }
                                        $j=0;
                                        foreach($authors as $auth)
                                        {
                                                $bibarray['author'][$j]['first'] = $auth;
                                                $j++;
                                        }
                                        $bibtex->addEntry($bibarray);



                                        break;
                                  case 6: //автореферат  @phdthesis
                                        if($a->date == '0000'){$a->date='';}

                                        $bibarray                       = array();
                                        $bibarray['entryType']          = 'phdthesis';
                                        $bibarray['cite']               = $authors[0].$a->date;
                                        $bibarray['title']              = $a->title;
                                        $bibarray['school']             = '';
                                        $bibarray['year']               = $a->date;
                                        $bibarray['publisher']          = $a->PUBLISHER_NAME;
                                        if($a->pages != '0')
                                        {
                                                $bibarray['pages']      = $a->pages;
                                        }
                                        $j=0;
                                        foreach($authors as $auth)
                                        {
                                                $bibarray['author'][$j]['first'] = $auth;
                                                $j++;
                                        }
                                        $bibtex->addEntry($bibarray);



                                        break;

                                  case 7: //отчет  @techreport
                                        if($a->date == '0000'){$a->date='';}
                                        

                                        $bibarray                       = array();
                                        $bibarray['entryType']          = 'techreport';
                                        $bibarray['cite']               = $authors[0].$a->date;
                                        $bibarray['title']              = $a->title;
                                        $bibarray['year']               = $a->date;
                                        $bibarray['institution']        = $a->ORG_NAME;
                                        if($a->pages != '0')
                                        {
                                                $bibarray['pages']      = $a->pages;
                                        }
                                        $j=0;
                                        foreach($authors as $auth)
                                        {
                                                $bibarray['author'][$j]['first'] = $auth;
                                                $j++;
                                        }
                                        $bibtex->addEntry($bibarray);



                                        break;

                        }

                }
              
                $file = $bibtex->bibTex();
                //print nl2br($file);
                $name = 'Report_'.date("m-d-Y") .'.bib';

                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=\"".$name."\"");
                print $file;


        }

        

}
