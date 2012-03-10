<?php
defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Search controller
 *
 * Controller for search page.
 *
 * @copyright   Copyright (C) 2010 Ilya Semerhanov
 * @author      Ilya Semerhanov
 * @version     1.0
 * @package     Search
 */

class Search_Controller extends Template_Controller
{
	const ALLOW_PRODUCTION = TRUE;

	public $template = 'search/search_view';


	public function __construct()
	{
		parent::__construct();

		$this->search = new Search_Model;
                $this->author_db         = new Author_Model;
                $this->org_db            = new Org_Model;
                $this->publisher_db      = new Publisher_Model;
                $this->publication_db    = new Publication_Model;


	}

        public function _search_by_all($query)
        {
                $this->template->query = $query;
                $this->template->params = '
                        <input name="type" type="radio" value="0" checked>Все</input>
                        <input name="type" type="radio" value="1">Название</input>
                        <input name="type" type="radio" value="2">Автор</input>
                        <input name="type" type="radio" value="3">Организация</input>
                        <input name="type" type="radio" value="4">Издательство</input>
                        ';
                $this->template->result='';

                $result_name = $this->search->get_result_by_name($query);
                $result_author = $this->search->get_result_by_author($query);
                $result_org = $this->search->get_result_by_org($query);
                $result_publisher = $this->search->get_result_by_publisher($query);
                $i=1;
                $this->template->result .= "<table >";
                if(!empty($result_name)) //поиск по названию
                {

                     foreach($result_name as $r)
                        {
                             $this->template->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'> <a href='javascript:showDetails(\"".$r->id."\",\"publication\");'>".
                             $r->title."</a><br/><span style='font-size:0.8em;'>Авторы: ";
                             $auths = explode("|",$r->AUTHS);
                             foreach($auths as $a)
                             {
                                     $this->template->result .=  $a.' ';
                             }
                              $this->template->result .=  "</span></td></tr>";
                             $i++;
                        }

                }

                if(!empty($result_author))
                {

                     foreach($result_author as $r)
                        {
                             $this->template->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'> <a href='javascript:showDetails(\"".$r->id."\",\"author\");'>".
                             $r->family.' '.$r->name.' '.$r->patronymic."</a> (Записей: ".$r->PUB_CNT.")</td></tr>";
                             $i++;
                        }


                }

                if(!empty($result_org))
                {

                     foreach($result_org as $r)
                        {
                             $this->template->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'> <a href='javascript:showDetails(\"".$r->id."\",\"org\");'>".
                             $r->name."</a> (Авторов: ".$r->AUT_CNT.")</td></tr>";

                             $i++;
                        }

                }

                if(!empty($result_publisher))
                {

                     foreach($result_publisher as $r)
                        {
                             $this->template->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'> <a href='javascript:showDetails(\"".$r->id."\",\"publisher\");'>".
                             $r->name."</a> (Записей: ".$r->PUB_CNT.")</td></tr>";

                             $i++;
                        }

                }

                if(empty($result_name) && empty($result_author) && empty($result_org) && empty($result_publisher))
                {
                         $this->template->result .= "Ничего не найдено";
                }


                $this->template->result .= "</table >";

        }

        public function _search_by_name($query)
        {
                $this->template->query = $query;
                $this->template->params = '
                        <input name="type" type="radio" value="0">Все</input>
                        <input name="type" type="radio" value="1" checked>Название</input>
                        <input name="type" type="radio" value="2" >Автор</input>
                        <input name="type" type="radio" value="3">Организация</input>
                        <input name="type" type="radio" value="4">Издательство</input>
                        ';
                $result = $this->search->get_result_by_name($query);
                $this->template->result='';
                $i=1;
                if(!empty($result))
                {
                     $this->template->result .= "<table >";
                     foreach($result as $r)
                        {
                             $this->template->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'> <a href='javascript:showDetails(\"".$r->id."\",\"publication\");'>".
                             $r->title."</a><br/><span style='font-size:0.8em;'>Авторы: ";
                             $auths = explode("|",$r->AUTHS);
                             foreach($auths as $a)
                             {
                                     $this->template->result .=  $a.' ';
                             }
                              $this->template->result .=  "</span></td></tr>";
                             $i++;
                        }
                      $this->template->result .= "</table >";
                }else
                {
                        $this->template->result = "Ничего не найдено";
                }

        }


        public function _search_by_author($query)
        {
                $this->template->query = $query;
                $this->template->params = '
                        <input name="type" type="radio" value="0">Все</input>
                        <input name="type" type="radio" value="1" >Название</input>
                        <input name="type" type="radio" value="2" checked>Автор</input>
                        <input name="type" type="radio" value="3">Организация</input>
                        <input name="type" type="radio" value="4">Издательство</input>
                        ';
                $result = $this->search->get_result_by_author($query);
                $this->template->result='';
                $i=1;
                if(!empty($result))
                {
                     $this->template->result .= "<table >";
                     foreach($result as $r)
                        {
                             $this->template->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'> <a href='javascript:showDetails(\"".$r->id."\",\"author\");'>".
                             $r->family.' '.$r->name.' '.$r->patronymic."</a> (Записей: ".$r->PUB_CNT.")</td></tr>";
                             $i++;
                        }
                      $this->template->result .= "</table >";
                }else
                {
                        $this->template->result = "Ничего не найдено";
                }

        }

        public function _search_by_org($query)
        {
                $this->template->query = $query;
                $this->template->params = '
                        <input name="type" type="radio" value="0">Все</input>
                        <input name="type" type="radio" value="1">Название</input>
                        <input name="type" type="radio" value="2">Автор</input>
                        <input name="type" type="radio" value="3" checked>Организация</input>
                        <input name="type" type="radio" value="4">Издательство</input>
                        ';
                $result = $this->search->get_result_by_org($query);
                $this->template->result='';
                $i=1;
                if(!empty($result))
                {
                     $this->template->result .= "<table>";
                     foreach($result as $r)
                        {
                             $this->template->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'> <a href='javascript:showDetails(\"".$r->id."\",\"org\");'>".
                             $r->name."</a> (Авторов: ".$r->AUT_CNT.")</td></tr>";
                          
                             $i++;
                        }
                     $this->template->result .= "</table>";
                }else
                {
                        $this->template->result = "Ничего не найдено";
                }

        }

        public function _search_by_publisher($query)
        {
                $this->template->query = $query;
                $this->template->params = '
                        <input name="type" type="radio" value="0">Все</input>
                        <input name="type" type="radio" value="1">Название</input>
                        <input name="type" type="radio" value="2">Автор</input>
                        <input name="type" type="radio" value="3">Организация</input>
                        <input name="type" type="radio" value="4" checked>Издательство</input>
                        ';
                $result = $this->search->get_result_by_publisher($query);
                $this->template->result='';
                $i=1;
                if(!empty($result))
                {
                     $this->template->result .= "<table>";
                     foreach($result as $r)
                        {
                             $this->template->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'> <a href='javascript:showDetails(\"".$r->id."\",\"publisher\");'>".
                             $r->name."</a> (Записей: ".$r->PUB_CNT.")</td></tr>";
                             
                             $i++;
                        }
                      $this->template->result .= "</table>";
                }else
                {
                        $this->template->result = "Ничего не найдено";
                }

        }

         public function _make_file_links($links,$id)
        {
            $res = '';
            $links = explode("|", $links);
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
                    case 'docx':
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

                
                $res .=  $icon." <a href='/pub_storage/".$id."/".$lnk."' title='".$lnk."'>".$l."</a><br/>";

            }
            return $res;

        }

	public function index()
	{
                if ($_POST)
		{

                        $query  = $this->input->post('query', null, true);
                        $type   = $this->input->post('type', null, true);

                        switch($type)
                        {

                                case '0': //Все

                                        self::_search_by_all($query);
                                        break;
                                case '1': //Название

                                        self::_search_by_name($query);
                                        break;
                                case '2': //Автор

                                        self::_search_by_author($query);
                                        break;
                                case '3': //Орг

                                        self::_search_by_org($query);
                                        break;
                                case '4': //Издательство

                                        self::_search_by_publisher($query);
                                        break;
                        }


                }
                else
                {
                        Kohana::show_404();
                }


	}


        public function show_details()
        {
                if (request::is_ajax())
		{
                        
                        $this->auto_render = FALSE;
                        $id                = $this->input->post('id', null, true);
                        $type              = $this->input->post('type', null, true);

                        switch($type)
                        {
                                
                                case 'author':
                                        $d                 = $this->author_db->get_author_by_id($id);
                                        $d->bdate   == '0000-00-00'?$d->bdate='':$d->bdate;
                                        echo "<h1>".$d->family." ".$d->name." ".$d->patronymic."</h1><br/>
                                              Дата рождения: ".$d->bdate."<br/>
                                              Место работы: ".$d->ORG_NAME."<br/>
                                              Город: ".$d->city."<br/><br/>
                                              ".$d->description."<br/><br/>
                                              <a href='/search/show/1/".$id."' >Посмотреть все публикации автора</a>";
                                        break;

                                case 'org':
                                        $d                 = $this->org_db->get_org_by_id($id);

                                        echo "<h1>".$d->name."</h1><br/>
                                              Сайт: ".$d->site."<br/>
                                              Email: ".$d->email."<br/>
                                              Телефон: ".$d->telephone."<br/>
                                              ".$d->description."<br/><br/>
                                              <a href='/search/show/2/".$id."' >Посмотреть авторов из организации</a>";
                                        break;
                                case 'publisher':
                                        $d                 = $this->publisher_db->get_publisher_by_id($id);

                                        echo "<h1>".$d->name."</h1><br/>
                                              Сайт: ".$d->site."<br/>
                                              Телефон: ".$d->telephone."<br/>
                                              Город: ".$d->CITY."<br/>
                                              ".$d->description."<br/><br/>
                                              <a href='/search/show/3/".$id."' >Посмотреть все публикации издательства</a>";
                                        break;
                                
                                case 'publication':
                                        $d                 = $this->publication_db->get_publication_by_id($id);
                                        $pub               = $d;
                                        $d                 = $d[0];
                                        $d->date           = $d->date=='0'?'':$d->date;
                                        $d->ISSUE_NAME     = $d->ISSUE_NAME=='0'?'':$d->ISSUE_NAME;
                                        $d->PUBLISHER_NAME = $d->PUBLISHER_NAME=='0'?'':$d->PUBLISHER_NAME;
                                        $d->TYPE_NAME      = $d->TYPE_NAME=='0'?'':$d->TYPE_NAME;
                                        $d->description    = $d->description=='0'?'':$d->description;
                                        $d->pages          = $d->pages=='0'?'':$d->pages;
                                        $d->circulation    = $d->circulation=='0'?'':$d->circulation;
                                        if(!empty($d->path_to_file))
                                        {
                                                $links     = $this->_make_file_links($d->path_to_file,$id);
                                        }else
                                        {
                                                $links     = '';
                                        }
                                        
                                        if($d->last_page != 0)
                                        {
                                                $d->pages = $d->last_page - $d->pages;
                                        }
                                        $authors           = explode("|",$d->AUTHS);
                                        //$authors           = implode(", ",$authors);

                                        echo "<h1>".$d->title."</h1><br/>";
                                        
                                        $str = "Авторы: ";
                                        foreach($pub as $k => $p)
                                        {
                                               $str .= "<a href='javascript:showDetails(\"".$p->AUTHOR_ID."\",\"author\");'>".$authors[$k]."</a>, ";
                                               //$str.= html::anchor('/search/show/4/'.$p->AUTHOR_ID,$authors[$k]).", ";
                                        }
                                       $str = substr($str,0,-2);
                                        echo $str."<br/>";
                                        echo "Год: ".$d->date."<br/>
                                              Тип: ".$d->TYPE_NAME."<br/>
                                              Издательство: ".$d->PUBLISHER_NAME."<br/>
                                              Издание: ".$d->ISSUE_NAME."<br/>
                                              Количество страниц: ".$d->pages."<br/>
                                              Тираж: ".$d->circulation."<br/><br/>
                                              ".$d->description."<br/><br/>
                                              Скачать:<br/><br/>
                                              ".$links;
                                        break;
                        }



                        //echo $this->template->view->default_type;

                }else
                {
                        Kohana::show_404();
                }
        }

        public function show($type,$id)
        {
                switch($type)
                {
                        case '1': // публикации автора
                                
                                $result         = $this->publication_db->get_publications_of_author_by_id($id);

                                $this->template->query = '';
                                $this->template->params = '
                                        <input name="type" type="radio" value="0">Все</input>
                                        <input name="type" type="radio" value="1" >Название</input>
                                        <input name="type" type="radio" value="2" checked>Автор</input>
                                        <input name="type" type="radio" value="3">Организация</input>
                                        <input name="type" type="radio" value="4">Издательство</input>
                                        ';
                                
                                $this->template->result='';
                                $i=1;
                                if(!empty($result))
                                {
                                     $this->template->result .= "<table >";
                                     foreach($result as $r)
                                        {
                                             
                                             $this->template->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'> <a href='javascript:showDetails(\"".$r->id."\",\"publication\");'>".
                                             $r->title."</a><br/><span style='font-size:0.8em;'>Авторы: ";
                                             $auths = explode("|",$r->FIO);
                                             foreach($auths as $a)
                                             {
                                                     $this->template->result .=  $a.' ';
                                             }
                                             $this->template->result .=  "</span></td></tr>";
                                             $i++;
                                        }
                                      $this->template->result .= "</table>";
                                }else
                                {
                                        $this->template->result = "Ничего не найдено";
                                }
                                break;

                         case '2': // авторы
                                
                                $result         = $this->author_db->get_all_authors_by_org($id);

                                $this->template->query = '';
                                $this->template->params = '
                                        <input name="type" type="radio" value="0">Все</input>
                                        <input name="type" type="radio" value="1" >Название</input>
                                        <input name="type" type="radio" value="2" checked>Автор</input>
                                        <input name="type" type="radio" value="3" >Организация</input>
                                        <input name="type" type="radio" value="4">Издательство</input>
                                        ';

                                $this->template->result='';
                                $i=1;
                                if(!empty($result))
                                {
                                     $this->template->result .= "<table >";
                                     foreach($result as $r)
                                        {
                                             $this->template->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'> <a href='javascript:showDetails(\"".$r->id."\",\"author\");'>".
                                             $r->family.' '.$r->name.' '.$r->patronymic."</a> (Записей: ".$r->PUB_CNT.")</td></tr>";
                                             $i++;
                                        }
                                      $this->template->result .= "</table >";
                                }else
                                {
                                        $this->template->result = "Ничего не найдено";
                                }
                                break;

                          case '3': // публикации издательства

                                $result         = $this->publication_db->get_publications_of_publisher_by_id($id);

                                $this->template->query = '';
                                $this->template->params = '
                                        <input name="type" type="radio" value="0">Все</input>
                                        <input name="type" type="radio" value="1" >Название</input>
                                        <input name="type" type="radio" value="2" checked>Автор</input>
                                        <input name="type" type="radio" value="3">Организация</input>
                                        <input name="type" type="radio" value="4">Издательство</input>
                                        ';

                                $this->template->result='';
                                $i=1;
                                 if(!empty($result))
                                {
                                     $this->template->result .= "<table >";
                                     foreach($result as $r)
                                        {

                                             $this->template->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'> <a href='javascript:showDetails(\"".$r->id."\",\"publication\");'>".
                                             $r->title."</a></td></tr>";
                                             $i++;
                                        }
                                      $this->template->result .= "</table>";
                                }else
                                {
                                        $this->template->result = "Ничего не найдено";
                                }
                                break;
                }

        }




}


?>