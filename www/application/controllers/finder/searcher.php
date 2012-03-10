<?php
defined('SYSPATH') OR die('No direct access allowed.');


class Searcher_Controller extends Template_Controller
{
	const ALLOW_PRODUCTION = TRUE;

	public $template = 'layouts/template';


	public function __construct()
	{
		parent::__construct();

                $acl = new Acl();
		if(!$acl->logged_auto())
		{
                        url::redirect('/login/auth');
		}
                
                $this->template->title        = Kohana::config('config.application_name').".Поиск";
		$this->template->sub_title    = "Поиск";
		$this->template->view         = new View('finder/search');
                
                 
		$this->search            = new Search_Model;
                $this->author_db         = new Author_Model;
                $this->org_db            = new Org_Model;
                $this->publisher_db      = new Publisher_Model;
                $this->publication_db    = new Publication_Model;


	}

        public function _search_by_all($query)
        {
                $this->template->view->query = $query;
                $this->template->view->params = '
                        <input name="type" type="radio" value="0" checked>Все</input>
                        <input name="type" type="radio" value="1">Название</input>
                        <input name="type" type="radio" value="2">Автор</input>
                        <input name="type" type="radio" value="3">Организация</input>
                        <input name="type" type="radio" value="4">Издательство</input>
                        ';
                $this->template->view->result='';
                $result_name = $this->search->get_result_by_name($query);
                $result_author = $this->search->get_result_by_author($query);
                $result_org = $this->search->get_result_by_org($query);
                $result_publisher = $this->search->get_result_by_publisher($query);
                $i=1;
                $this->template->view->result .= "<table>";
                if(!empty($result_name)) //поиск по названию
                {

                     foreach($result_name as $r)
                        {
                             $this->template->view->result .= "<tr valign='top'><td style='padding-top:5px;'>".$i.".</td><td style='padding-left:10px;'>".html::anchor('show/publication/rfid/'.$r->id,$r->title,array('class'=>'box-'.$i)).
                             "&nbsp".html::anchor('user/lib/add_to_library/'.$r->id,"<img src='/static/images/edit_add.png' title='Добавить в библиотеку'/>",array('class'=>'lib-'.$i))."<br/><span style='font-size:0.8em;'>Авторы: ";
                             $auths = explode("|",$r->AUTHS);
                             foreach($auths as $a)
                             {
                                     $this->template->view->result .=  $a.' ';
                             }
                              $this->template->view->result .=  "</span></td></tr>";

                              $this->template->view->result .= '
                              <script type="text/javascript">
                                $(".box-'.$i.'").colorbox({width:"40%", height:"40%"});
                                $(".lib-'.$i.'").colorbox({width:"280px", height:"180px"});

                              </script>';

                             $i++;
                        }

                }

                if(!empty($result_author))
                {

                     foreach($result_author as $r)
                        {
                             $this->template->view->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'>".html::anchor('show/author/id/'.$r->id,$r->family.' '.$r->name.' '.$r->patronymic,array('class'=>'box-'.$i))
                             ." (Записей: ".$r->PUB_CNT.")</td></tr>";

                              $this->template->view->result .= '
                              <script type="text/javascript">
                                $(".box-'.$i.'").colorbox({width:"300px", height:"300px"});
                              </script>';

                             $i++;
                        }



                }

                if(!empty($result_org))
                {

                     foreach($result_org as $r)
                        {
                             $this->template->view->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'>".html::anchor('show/org/id/'.$r->id,$r->name,array('class'=>'box-'.$i)).
                             " (Авторов: ".$r->AUT_CNT.")</td></tr>";

                             $this->template->view->result .= '
                              <script type="text/javascript">
                                $(".box-'.$i.'").colorbox({width:"300px", height:"300px"});
                              </script>';

                             $i++;
                        }

                }

                if(!empty($result_publisher))
                {

                     foreach($result_publisher as $r)
                        {
                             $this->template->view->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'>" .html::anchor('show/publisher/id/'.$r->id,$r->name,array('class'=>'box-'.$i)).
                             " (Записей: ".$r->PUB_CNT.")</td></tr>";

                             $this->template->view->result .= '
                              <script type="text/javascript">
                                $(".box-'.$i.'").colorbox({width:"300px", height:"300px"});
                              </script>';

                             $i++;
                        }

                }

                if(empty($result_name) && empty($result_author) && empty($result_org) && empty($result_publisher))
                {
                         $this->template->view->result .= "Ничего не найдено";
                }


                $this->template->view->result .= "</table >";


        }


        public function _search_by_name($query)
        {
                $this->template->view->query = $query;
                $this->template->view->params = '
                        <input name="type" type="radio" value="0">Все</input>
                        <input name="type" type="radio" value="1" checked>Название</input>
                        <input name="type" type="radio" value="2">Автор</input>
                        <input name="type" type="radio" value="3">Организация</input>
                        <input name="type" type="radio" value="4">Издательство</input>
                        ';
                $result = $this->search->get_result_by_name($query);
                $this->template->view->result='';
                $i=1;
                if(!empty($result))
                {
                     $this->template->view->result .= "<table >";
                     foreach($result as $r)
                        {
                             $this->template->view->result .= "<tr valign='top'><td style='padding-top:5px;'>".$i.".</td><td style='padding-left:10px;'>".html::anchor('show/publication/rfid/'.$r->id,$r->title,array('class'=>'box-'.$i)).
                             "&nbsp".html::anchor('user/lib/add_to_library/'.$r->id,"<img src='/static/images/edit_add.png' title='Добавить в библиотеку'/>",array('class'=>'lib-'.$i))."<br/><span style='font-size:0.8em;'>Авторы: ";
                             $auths = explode("|",$r->AUTHS);
                             foreach($auths as $a)
                             {
                                     $this->template->view->result .=  $a.' ';
                             }
                              $this->template->view->result .=  "</span></td></tr>";

                              $this->template->view->result .= '
                              <script type="text/javascript">
                                $(".box-'.$i.'").colorbox({width:"40%", height:"40%"});
                                $(".lib-'.$i.'").colorbox({width:"280px", height:"180px"});
                                
                              </script>';
                              
                             $i++;
                        }
                      $this->template->view->result .= "</table >";
                }else
                {
                        $this->template->view->result = "Ничего не найдено";
                }

        }


        public function _search_by_author($query)
        {
                $this->template->view->query = $query;
                $this->template->view->params = '
                        <input name="type" type="radio" value="0" >Все</input>
                        <input name="type" type="radio" value="1" >Название</input>
                        <input name="type" type="radio" value="2" checked>Автор</input>
                        <input name="type" type="radio" value="3">Организация</input>
                        <input name="type" type="radio" value="4">Издательство</input>
                        ';
                $result = $this->search->get_result_by_author($query);
                $this->template->view->result='';
                $i=1;
                if(!empty($result))
                {
                     $this->template->view->result .= "<table>";
                     foreach($result as $r)
                        {
                             $this->template->view->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'>".html::anchor('show/author/id/'.$r->id,$r->family.' '.$r->name.' '.$r->patronymic,array('class'=>'box-'.$i))
                             ." (Записей: ".$r->PUB_CNT.")</td></tr>";

                              $this->template->view->result .= '
                              <script type="text/javascript">
                                $(".box-'.$i.'").colorbox({width:"300px", height:"300px"});
                              </script>';
 
                             $i++;
                        }

                         $this->template->view->result .= '</table>';
                     
                }else
                {
                        $this->template->view->result = "Ничего не найдено";
                }

        }

        public function _search_by_org($query)
        {
                $this->template->view->query = $query;
                $this->template->view->params = '
                        <input name="type" type="radio" value="0" >Все</input>
                        <input name="type" type="radio" value="1">Название</input>
                        <input name="type" type="radio" value="2">Автор</input>
                        <input name="type" type="radio" value="3" checked>Организация</input>
                        <input name="type" type="radio" value="4">Издательство</input>
                        ';
                $result = $this->search->get_result_by_org($query);
                $this->template->view->result='';
                $i=1;
                if(!empty($result))
                {
                     $this->template->view->result .= "<table>";
                     foreach($result as $r)
                        {
                             $this->template->view->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'>".html::anchor('show/org/id/'.$r->id,$r->name,array('class'=>'box-'.$i)).
                             " (Авторов: ".$r->AUT_CNT.")</td></tr>";
                          
                             $this->template->view->result .= '
                              <script type="text/javascript">
                                $(".box-'.$i.'").colorbox({width:"300px", height:"300px"});
                              </script>';

                             $i++;
                        }
                     $this->template->view->result .= "</table>";
                }else
                {
                        $this->template->view->result = "Ничего не найдено";
                }

        }

        public function _search_by_publisher($query)
        {
                $this->template->view->query = $query;
                $this->template->view->params = '
                        <input name="type" type="radio" value="0" >Все</input>
                        <input name="type" type="radio" value="1">Название</input>
                        <input name="type" type="radio" value="2">Автор</input>
                        <input name="type" type="radio" value="3">Организация</input>
                        <input name="type" type="radio" value="4" checked>Издательство</input>
                        ';
                $result = $this->search->get_result_by_publisher($query);
                $this->template->view->result='';
                $i=1;
                if(!empty($result))
                {
                     $this->template->view->result .= "<table>";
                     foreach($result as $r)
                        {
                             $this->template->view->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'>" .html::anchor('show/publisher/id/'.$r->id,$r->name,array('class'=>'box-'.$i)).
                             " (Записей: ".$r->PUB_CNT.")</td></tr>";
                             
                             $this->template->view->result .= '
                              <script type="text/javascript">
                                $(".box-'.$i.'").colorbox({width:"300px", height:"300px"});
                              </script>';

                             $i++;
                        }
                      $this->template->view->result .= "</table>";
                }else
                {
                        $this->template->view->result = "Ничего не найдено";
                }

        }

       

	public function index()
	{
                
                       $this->template->view->params = '
                                        <input name="type" type="radio" value="0" checked> Все</input>
                                        <input name="type" type="radio" value="1" > Название</input>
                                        <input name="type" type="radio" value="2" > Автор</input>
                                        <input name="type" type="radio" value="3"> Организация</input>
                                        <input name="type" type="radio" value="4"> Издательство</input>
                                        ';
                
                       $this->template->view->result = '';
                       $this->template->view->query = '';

	}


        public function q($q='')
        {
                if ($_POST)
		{

                        $query  = $this->input->post('query', null, true);
                        $type   = $this->input->post('type', null, true);

                        switch($type)
                        {

                                case '0': //все

                                        self::_search_by_all($query);
                                        break;
                                case '1': //название

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

        public function show($type,$id)
        {
                switch($type)
                {
                        case '1': // публикации автора

                                $result         = $this->publication_db->get_publications_of_author_by_id($id);

                                $this->template->view->query = '';
                                $this->template->view->params = '
                                        <input name="type" type="radio" value="0">Все</input>
                                        <input name="type" type="radio" value="1" checked>Название</input>
                                        <input name="type" type="radio" value="2" >Автор</input>
                                        <input name="type" type="radio" value="3">Организация</input>
                                        <input name="type" type="radio" value="4">Издательство</input>
                                        ';

                                $this->template->view->result='';
                                $i=1;
                                if(!empty($result))
                                {
                                     $this->template->view->result .= "<table >";
                                     foreach($result as $r)
                                        {
                                              $this->template->view->result .= "<tr valign='top'><td style='padding-top:5px;'>".$i.".</td><td style='padding-left:10px;'>".html::anchor('show/publication/rfid/'.$r->id,$r->title,array('class'=>'box-'.$i)).
                                             "&nbsp".html::anchor('user/lib/add_to_library/'.$r->id,"<img src='/static/images/edit_add.png' title='Добавить в библиотеку'/>",array('class'=>'lib-'.$i))."<br/><span style='font-size:0.8em;'>Авторы: ";
                                             $auths = explode("|",$r->FIO);
                                             foreach($auths as $a)
                                             {
                                                     $this->template->view->result .=  $a.' ';
                                             }
                                              $this->template->view->result .=  "</span></td></tr>";

                                              $this->template->view->result .= '
                                              <script type="text/javascript">
                                                $(".box-'.$i.'").colorbox({width:"40%", height:"40%"});
                                                $(".lib-'.$i.'").colorbox({width:"280px", height:"180px"});

                                              </script>';

                                             $i++;
                                        }
                                      $this->template->view->result .= "</table>";
                                }else
                                {
                                        $this->template->view->result = "Ничего не найдено";
                                }
                                break;

                         case '2': // авторы

                                $result         = $this->author_db->get_all_authors_by_org($id);

                                $this->template->view->query = '';
                                $this->template->view->params = '
                                        <input name="type" type="radio" value="0">Все</input>
                                        <input name="type" type="radio" value="1" >Название</input>
                                        <input name="type" type="radio" value="2" checked>Автор</input>
                                        <input name="type" type="radio" value="3" >Организация</input>
                                        <input name="type" type="radio" value="4">Издательство</input>
                                        ';

                                $this->template->view->result='';
                                $i=1;
                                if(!empty($result))
                                {
                                     $this->template->view->result .= "<table >";
                                     foreach($result as $r)
                                        {
                                             $this->template->view->view->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'>".html::anchor('show/author/id/'.$r->id,$r->family.' '.$r->name.' '.$r->patronymic,array('class'=>'box-'.$i))
                                             ." (Записей: ".$r->PUB_CNT.")</td></tr>";

                                              $this->template->view->view->result .= '
                                              <script type="text/javascript">
                                                $(".box-'.$i.'").colorbox({width:"300px", height:"300px"});
                                              </script>';

                                             $i++;
                                        }
                                      $this->template->view->result .= "</table >";
                                }else
                                {
                                        $this->template->view->result = "Ничего не найдено";
                                }
                                break;

                          case '3': // публикации издательства

                                $result         = $this->publication_db->get_publications_of_publisher_by_id($id);

                                $this->template->view->query = '';
                                $this->template->view->params = '
                                        <input name="type" type="radio" value="0">Все</input>
                                        <input name="type" type="radio" value="1" checked>Название</input>
                                        <input name="type" type="radio" value="2" >Автор</input>
                                        <input name="type" type="radio" value="3">Организация</input>
                                        <input name="type" type="radio" value="4">Издательство</input>
                                        ';

                                $this->template->view->result='';
                                $i=1;
                                if(!empty($result))
                                {
                                     $this->template->view->result .= "<table >";
                                     foreach($result as $r)
                                        {
                                             $this->template->view->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'>".html::anchor('show/publication/rfid/'.$r->id,$r->title,array('class'=>'box-'.$i)).
                                             "&nbsp<a href=''><img src='/static/images/edit_add.png' title='Добавить в библиотеку'/></a><br/><span style='font-size:0.8em;'>Авторы: ";
                                             $auths = explode("|",$r->FIO);
                                             foreach($auths as $a)
                                             {
                                                     $this->template->view->result .=  $a.' ';
                                             }
                                              $this->template->view->result .=  "</span></td></tr>";

                                              $this->template->view->result .= '
                                              <script type="text/javascript">
                                                $(".box-'.$i.'").colorbox({width:"40%", height:"40%"});
                                              </script>';

                                             $i++;
                                        }
                                      $this->template->view->result .= "</table>";
                                }else
                                {
                                        $this->template->view->result = "Ничего не найдено";
                                }
                                break;
                           case '4': // автор

                                $r         = $this->author_db->get_author_by_id($id);

                                $this->template->view->query = '';
                                $this->template->view->params = '
                                        <input name="type" type="radio" value="0">Все</input>
                                        <input name="type" type="radio" value="1" >Название</input>
                                        <input name="type" type="radio" value="2" checked>Автор</input>
                                        <input name="type" type="radio" value="3" >Организация</input>
                                        <input name="type" type="radio" value="4">Издательство</input>
                                        ';

                                $this->template->view->result='';
                                $i=1;
                                if(!empty($r))
                                {
                                     $this->template->view->result .= "<table >";
                                     
                                             $this->template->view->result .= "<tr valign='top'><td>".$i.".</td><td style='padding-left:10px;'>".html::anchor('show/author/id/'.$r->id,$r->family.' '.$r->name.' '.$r->patronymic,array('class'=>'box-'.$i))
                                             ." </td></tr>";

                                              $this->template->view->result .= '
                                              <script type="text/javascript">
                                                $(".box-'.$i.'").colorbox({width:"300px", height:"300px"});
                                              </script>';

                                             $i++;
                                        
                                      $this->template->view->result .= "</table >";
                                }else
                                {
                                        $this->template->view->result = "Ничего не найдено";
                                }
                                break;
                }

        }

        




}


?>