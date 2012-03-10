<?php 
defined('SYSPATH') OR die('No direct access allowed.');

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
		
		$this->template->title        = Kohana::config('config.application_name').".Добавить публикацию";
		$this->template->sub_title    = "Добавить новую публикацию";
		$this->template->view         = new View('add/add_publication_view');
                $this->template->view->default_type    = new View('add/add_publication_metod');
		$this->db                     = new Publication_Model;
                $this->user_db                = new Acl_Model();
                $this->auth_db                = new Author_Model();
                $this->org_db                 = new Org_Model();
                $this->session                = Session::instance();
                
                //$this->template->view->authors  = $this->_make_authors();
                
		$this->template->view->form   = array(
			'title' => '',
			'type' => '',
			'issue' => '',
			'isbn' => '',
			'date' => '',
			'circulation' => '',
			'pages' => '',
			'desc' => '',
                        'author_1' => '',
                        'rank'    => '',
                        'protection' => '',
                        'statement' => '',
                        'short_name' => '',
                        'report_type' => '',
                        'standart_number' => '',
                        'city'          => '',
                        'city_id' => '111111'

		);
		$this->template->view->errors = $this->template->view->form;
                $this->template->view->default_type->form = $this->template->view->form;
                $this->template->view->default_type->errors = $this->template->view->errors;
		
                self::_make_author_fields();
                self::_make_file_fields();
		self::_make_types();
                self::_make_issues();
                self::_make_publisher();
               
               
	}

        
        
	/*public function _make_aut_options($trigger = 0,$arr = 0)
	{
		
		$auths_table_db = new Author_Model;
		$auths = $auths_table_db->get_authors();

                switch($trigger)
                {
                case 0:
                        $list_of_options = '<input type="hidden" name="author_num" id="author_num" value="1"/>
                                <select name="author_1" id="select_author_1" class="wide_select">
                                <option value="0"></option>';
                        foreach($auths as $o)
                        {
                              $list_of_options .= "<option value='".$o['id']."'>".$o['family']." ".$o['name']." ".$o['patronymic']."</option>";
                        }
                        $list_of_options .= '</select></br><div id="loader_1" style="display:none;">
                                             <img   src="/static/images/ajax-loader.gif"/><br/><br/></div>
                                             <div id="new_author_1"></div>';
                        
                        $this->template->view->select_options = $list_of_options;
                        
                        return $list_of_options;   
                        break;
               case 1:
               
                       $list_of_options = "<option value='0'></option>";
                        foreach($auths as $o)
                        {

                                $list_of_options .= "<option value='".$o['id']."'>".$o['family']." ".$o['name']." ".$o['patronymic']."</option>";


                        }


                        $this->template->view->select_options = $list_of_options;
                        return $list_of_options;
                        break;
               case 2:
                       $n=1;
                       $list_of_options="";
                       foreach ($arr as $key)
                       {
                               $id = $auths[$key-1]['id'];
                               $list_of_options .= '
                                <select name="author_'.$n.'" id="select_author_'.$n.'" class="wide_select">
                                <option value="'.$id.'">'.$auths[$key-1]['family'].' '.$auths[$key-1]['name'].' '.$auths[$key-1]['patronymic'].'</option>';
                               foreach($auths as $o)
                               {
                                       if($o['id'] != $id)
                                       {
                                        $list_of_options .= "<option value='".$o['id']."'>".$o['family']." ".$o['name']." ".$o['patronymic']."</option>";
                                       }
                               }
                               $list_of_options .= '</select></br><div id="loader_'.$n.'" style="display:none;">
                                                    <img   src="/static/images/ajax-loader.gif"/><br/><br/></div>
                                                    <div id="new_author_'.$n.'"></div>';
                               $n++;
                               
                       }
                       $n--;
                       $list_of_options .= '<input type="hidden" name="author_num" id="author_num" value="'.$n.'"/>';
                       $this->template->view->select_options = $list_of_options;
                        
                
                        break;

               }
	}*/
	
	public function _make_types($triger = '1',$type = '')
	{
		$types_table_db = new Publication_type_Model;
		$types = $types_table_db->get_all_types();
		$list_of_options = "";
                switch($triger)
                {
                        case 1:
                                foreach($types as $o)
                                {
                                        $list_of_options .= "<option value='".$o->id."'>".$o->name."</option>";
                                }
                                break;
                        case 2:
                                foreach($types as $o)
                                {
                                        if($o->id == $type)
                                        {
                                             $list_of_options .= "<option selected value='".$o->id."'>".$o->name."</option>";
                                        }
                                        $list_of_options .= "<option value='".$o->id."'>".$o->name."</option>";
                                }
                                break;
                }	
		$this->template->view->select_types = $list_of_options;
	}

        public function _make_issues()
	{
		$issue_table_db = new Issue_Model;
		$issues = $issue_table_db->get_issues();
		$list_of_options = "<option value='0'></option>";
		foreach($issues as $i)
		{
			$list_of_options .= "<option value='".$i->id."'>".$i->name."</option>";
		}


		$this->template->view->default_type->select_issues = $list_of_options;
	}

        public function _make_publisher()
	{
		$publisher_table_db = new Publisher_Model;
		$publisher = $publisher_table_db->get_publishers();
		$list_of_options = "<option value='0'></option>";
		foreach($publisher as $o)
		{

			$list_of_options .= "<option value='".$o->id."'>".$o->name."</option>";


		}


		$this->template->view->default_type->select_publisher = $list_of_options;

	}

        public function _make_org_options()
	{


		$opt = $this->org_db->get_orgs_by_parent_id(0);
		$list_of_options = "<option value='0'></option>";
                if($opt)
                {
                    foreach($opt as $o)
                    {
                            $list_of_options .= "<option value='".$o->id."'>".$o->name."</option>";
                    }
                }



		return $list_of_options;
	}

        

	public function index()
	{
                $this->session->delete('authors');
                $this->session->delete('authors_id');
                $this->session->delete('new_authors');
                $this->session->delete('new_orgs');
                $ses_data = array(
                                        'authors' => '',
                                        'authors_id' => '',
                                        'new_authors' => ''
                         );

                $this->session->set($ses_data);
              
	}

        public function _check_selectbox(Validation $array, $field)
        {
            if($array[$field] == 0)
              {
                   
                     $array->add_error($field, 'select please');
                    



              }
        }
	public function adding()
	{
		if ($_POST)
		{
                        $flag = true;
			$post = new Validation($_POST);
			$post->pre_filter('trim', TRUE);
			$post->add_rules('title', 'required');
			//$post->add_rules('rank', 'required', 'standard_text');
                        //$post->add_rules('author_1', 'required', 'standard_text');
			$post->add_rules('circulation','digit');
                        $files=new Validation($_FILES);
                        $trans = new Translit();
                        
                        $files_counter = $this->input->post('files_counter', null, true);
                        $filename = '';

                        for($i = 1;$i<$files_counter+1;$i++)
                        {
                                $fls[] = $_FILES['file_'.$i];
                                $files->add_rules('file_'.$i,'upload::type[doc,docx,pdf,txt,jpg,jpeg,png,zip,rar]');
                                if($i > 1)
                                {
                                    $filename .= '|';
                                }
                                $n = $trans->translate($_FILES['file_'.$i]['name']);
                                $filename .= $n;




                        }
                        
                                              
                        if(isset($post->date) && $post->date!='' && !preg_match("/^((19|20)[0-9][0-9])$/", $post->date))
                        {
                                $post->add_error('date', 'bad_format');

                        }

                        /*if(isset($post->author_1_id) && $post->author_1_id == '0')
                        {
                                $post->add_error('author_1', 'default');

                        }*/
                       
			if ($post->validate() && $files->validate())
			{          
                              
                                $publication['path_to_file'] = $filename;
				$publication['title']       = $this->input->post('title', null, true);
				$publication['type']     = $this->input->post('type', null, true);
                                $publication['issue']     = $this->input->post('issue', null, true);
                                $publication['issue'] = empty($publication['issue']) ? '0' : $publication['issue']; 
				$publication['publisher']     = $this->input->post('publisher', null, true);
				$publication['date']       = $this->input->post('date', null, true);   
                                $publication['date'] = empty($publication['date']) ? '0000' : $publication['date'];
				$publication['circulation']       = $this->input->post('circulation', null, true);
                                $publication['circulation'] = empty($publication['circulation']) ? '0' : $publication['circulation'];
				$publication['pages']       = $this->input->post('pages', null, true);
                                $publication['pages'] = empty($publication['pages']) ? '0' : $publication['pages'];
                                $publication['last_page']       = $this->input->post('last_page', null, true);
                                $publication['last_page'] = empty($publication['last_page']) ? '0' : $publication['last_page'];
				$publication['desc']       = $this->input->post('desc', null, true);
                                $publication['desc'] = empty($publication['desc']) ? '0' : $publication['desc'];
                                $publication['magazine_number']       = $this->input->post('mag_number', null, true);
                                $publication['magazine_number'] = empty($publication['magazine_number']) ? '0' : $publication['magazine_number'];
				$publication['protection']       = $this->input->post('protection', null, true);   
                                $publication['protection'] = empty($publication['protection']) ? '0000' : $publication['protection'];
                                $publication['statement']       = $this->input->post('statement', null, true);
                                $publication['statement'] = empty($publication['statement']) ? '0000' : $publication['statement'];
                                $publication['rank']       = $this->input->post('rank', null, true);
                                $publication['city_id']       = $this->input->post('city_id', null, true);
                                $publication['city_id'] = empty($publication['city_id']) ? '111111' : $publication['city_id'];
                                $publication['report_type']       = $this->input->post('report_type', null, true);
                                $publication['short_name']       = $this->input->post('short_name', null, true);
                                $publication['standart_number']       = $this->input->post('standart_number', null, true);
                                $publication['org']       = $this->input->post('org', null, true);
                                $publication['org_flag'] = '0';
                                if(substr($publication['org'],0,4) == 'name')
                                {
                                        $publication['org_flag'] = '1';
                                        $publication['org']  = substr($publication['org'],5,strlen($publication['org']));
                                }
				
				$publication['authors']       = $this->input->post('author_string', null, true); // авторы из списка
                                ///добавление новых организаций
                                $new_orgs = $this->session->get('new_orgs');
                                if(!empty($new_orgs))
                                {
                                        foreach($new_orgs as $o)
                                        {

                                               $last_org = $this->org_db->insert_quick_org($this->session->get('username'),$o);


                                        }
                                }

                                ///добавление новых авторов

                                $new_authors = $this->session->get('new_authors');
                                if(!empty($new_authors))
                                {
                                        foreach($new_authors as $n)
                                        {
                                                if(preg_match('/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/', $n['email']))
                                                {
                                                       $last_author = $this->auth_db->insert_quick_author($this->session->get('username'),$n);
                                                       if($last_author != 'failed' )
                                                       {                   
                                                              $publication['authors'] .=  $last_author->id.',';
                                                       }
                                                }
                                        }
                                }


                                ///
                                         

                                $user = $this->user_db->get_user($this->session->get('username'));
                                $publication['user_id']    = $user->id;
                                if($flag)
                                {
                                    $state = $this->db->insert_publication($publication);
                                    
                                    if($state != 'failed')
                                    {
                                            $pub_id = $state['LAST_ID'];
                                            for($i = 0;$i<$files_counter;$i++)
                                            {
                                                $name = $trans->translate($fls[$i]['name']);
                                               
                                                upload::save($fls[$i],$name,'pub_storage/'.$pub_id,'0744');
                                                chmod('pub_storage/'.$pub_id,0744);
                                                chmod('pub_storage/'.$pub_id.'/'.$name,0744);
                                            }
                                            
                                            
                                            $this->template->view         = new View('messages/success/add_publication_success');
                                    }else
                                    {
                                            $this->template->view         = new View('messages/failure/add_publication_failure');
                                    }
                                }
				
				
			}
			else
			{
                                $num = $this->input->post('author_num', null, true);
				for($i = 1;$i<$num+1;$i++)
				{
					$author[] = $this->input->post('author_'.$i, null, true);
                                        $author_id[] = $this->input->post('author_'.$i.'_id', null, true);
				}
                                $date = $this->input->post('date', null, true);
                                $type = $this->input->post('type', null, true);
                                switch($type)
                                {
                                        case 1: //методическое пособие
                                                $this->template->view->default_type    = new View('add/add_publication_metod');
                                                break;
                                        case 2: //учебное пособие
                                                $this->template->view->default_type    = new View('add/add_publication_metod');
                                                break;
                                        case 3: //статья из сборника
                                                $this->template->view->default_type    = new View('add/add_publication_statia');
                                                break;
                                        case 4: //статья из журнала
                                                $this->template->view->default_type    = new View('add/add_publication_magazine');
                                                break;
                                        case 5: //диссертация
                                                $this->template->view->default_type    = new View('add/dissertation/add_publication_disser');
                                                break;
                                        case 6: //автореферат диссертации
                                                $this->template->view->default_type    = new View('add/dissertation/add_publication_disser');
                                                break;
                                        case 7: //Отчет по НИР
                                                $this->template->view->default_type    = new View('add/add_publication_report');
                                                break;
                                }
                              
				$this->template->view->form   = arr::overwrite($this->template->view->form, $post->as_array());
                                $this->template->view->default_type->form = $this->template->view->form;
				$this->template->view->errors = arr::overwrite($this->template->view->errors, $post->errors('form_error_messages'));
                                $this->template->view->default_type->errors = $this->template->view->errors;
                                $this->_make_issues();
                               
                                $this->_make_publisher();
                                
                                //$this->_make_author_fields(1,$author,$author_id);
                              
                                $this->_make_types(2,$type);
                               
			}
		}else
		{
			Kohana::show_404();
		}
	}
	
	public function add_author()
        {
           
           $author_db                   = new Author_Model();
           $view                        = new View('add/publications_view_add_author');
           $aut                         = $author_db->get_all_authors();
          
           $view->authors               = array();
           $view->authors_id            = array();
           $view->ids                   = $this->session->get('authors_id');
           $names                       = $this->session->get('authors');
          
           if(!empty($view->ids))
           {      
                   $view->id_list               = implode(',',$view->ids);
                   $view->name_list             = implode(',',$names);
           }else
           {
                   $view->id_list               = '';
                   $view->name_list             = '';
           }


           foreach($aut as $a)
           {
                $FIO = $a->family.' '.$a->name.' '.$a->patronymic;

                array_push($view->authors, $FIO);
                array_push($view->authors_id, $a->id);
           }

           $view->render(TRUE);
           $this->auto_render = FALSE;

        }

        public function add_new_author()
        {
                   $author_db                   = new Author_Model();
                   $view                        = new View('add/publications_view_add_new_author');
                   
                   $view->render(TRUE);
                   $this->auto_render = FALSE;
        }

        public function add_new_org()
        {

                   $view                        = new View('add/publications_view_add_new_org');
                   $view->select_options        = self::_make_org_options();
                   $view->render(TRUE);
                   $this->auto_render = FALSE;
        }

       
	public function add_author_field()
	{
		if (request::is_ajax())
		{
			$this->auto_render = FALSE;
			$auth_num =  $this->input->post('author_num', null, true);
			$auth_num++;
                        $script = '<script type="text/javascript">
                                   $(function() {

                                                $(".author_'.$auth_num.'").autocomplete(url+"add/publication/get_authors_like", {
                                                delay:10,
                                                autoFill:true,
                                                minChars:1,
                                                matchSubset:1,
                                                autoFill:true,
                                                matchContains:1,
                                                cacheLength:10,
                                                selectFirst:true,
                                                maxItemsToShow:10,
                                                onItemSelect:selectItem_'.$auth_num.'



                                                });

                                                function selectItem_'.$auth_num.'(li)
                                                {
                                                    $("#author_'.$auth_num.'_id").val(li.extra[0]);
                                                }




                                            });
                                    </script>';
                        $res = '
                                  <input class="author_'.$auth_num.'" name="author_'.$auth_num.'" type="text" id="field" /><br/>
                                  <input name="author_'.$auth_num.'_id" id="author_'.$auth_num.'_id" type="hidden" value="0"/><br/>
                                  <div id="loader_'.$auth_num.'" style="display:none;"> <img   src="/static/images/ajax-loader.gif"/><br/><br/></div>
                                  <div id="new_author_'.$auth_num.'"></div>';
			echo $script.$res;
				
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
                        $id =  $this->input->post('id', null, true);
                        switch($id)
                        {
                                
                                case 1: //методическое пособие
                                        $this->template->view->default_type    = new View('add/add_publication_metod');
                                        break;
                                case 2: //учебное пособие
                                        $this->template->view->default_type    = new View('add/add_publication_metod');
                                        break;
                                case 3: //статья из сборника
                                        $this->template->view->default_type    = new View('add/add_publication_statia');
                                        break;
                                case 4: //статья из журнала
                                        $this->template->view->default_type    = new View('add/add_publication_magazine');
                                        break;
                                case 5: //диссертация
                                        $this->template->view->default_type    = new View('add/dissertation/add_publication_disser');
                                        break;
                                case 6: //автореферат
                                        $this->template->view->default_type    = new View('add/dissertation/add_publication_disser');
                                        break;
                                case 7: //Отчет по НИР
                                        $this->template->view->default_type    = new View('add/add_publication_report');
                                        break;
                             
                        }
                        $this->template->view->default_type->form = $this->template->view->form;
                        $this->template->view->default_type->errors = $this->template->view->errors;
                        self::_make_issues();
                        self::_make_publisher();
                        $this->template->view->default_type->select_options = self::_make_org_options();
                        echo $this->template->view->default_type;

                }else
                {
                        Kohana::show_404();
                }
        }

        public function get_authors_like()
        {
          
                if (request::is_ajax())
		{

                        $this->auto_render = FALSE;
                        $auths_db = new Author_Model;
                        $q =  $this->input->post('q', null, true);
                        $authors = $auths_db->get_authors_like($q);
                        if($authors)
                        {
                            $res = '';
                            foreach($authors as $a)
                            {

                                $res .= $a->family." ".$a->name." ".$a->patronymic."|".$a->id."\n";
                            }

                            echo $res;
                        }else
                        {
                            echo "not found";
                        }
                        

                }else
                {
                        Kohana::show_404();
                }
        }
        

        public function _make_author_fields($trigger = 0,$arr = 0,$id_arr = 0)
	{

                switch($trigger)
                {
                case 0:
                        $script = '<script type="text/javascript">
                                   $(function() {

                                                $(".author_1").autocomplete(url+"add/publication/get_authors_like", {
                                                delay:10,
                                                autoFill:true,
                                                minChars:1,
                                                matchSubset:1,
                                                autoFill:true,
                                                matchContains:1,
                                                cacheLength:10,
                                                selectFirst:true,
                                                maxItemsToShow:10,
                                                onItemSelect:selectItem_1



                                                });

                                                function selectItem_1(li)
                                                {
                                                    $("#author_1_id").val(li.extra[0]);
                                                }




                                            });
                                    </script>';

                        $field = '<input type="hidden" name="author_num" id="author_num" value="1"/><br/>
                                  <input class="author_1" name="author_1" type="text" id="field" /><br/>
                                  <input name="author_1_id" id="author_1_id" type="hidden" value="0"/><br/>
                                  <div id="loader_1" style="display:none;">
                                  <img   src="/static/images/ajax-loader.gif"/><br/><br/></div>
                                  <div id="new_author_1"></div>';

                        $this->template->view->fields_options = $script.$field;

                        return $script.$field;
                        break;

               case 1:
                   
                       $n=1;
                       $field="";
                       $script="";
                       foreach ($arr as $key)
                       {
                           
                               $script .= '<script type="text/javascript">
                                   $(function() {

                                                $(".author_'.$n.'").autocomplete(url+"add/publication/get_authors_like", {
                                                delay:10,
                                                autoFill:true,
                                                minChars:1,
                                                matchSubset:1,
                                                autoFill:true,
                                                matchContains:1,
                                                cacheLength:10,
                                                selectFirst:true,
                                                maxItemsToShow:10,
                                                onItemSelect:selectItem_'.$n.'



                                                });

                                                function selectItem_'.$n.'(li)
                                                {
                                                    $("#author_'.$n.'_id").val(li.extra[0]);
                                                }




                                            });
                                    </script>';
                              $field .= '
                                  <input class="author_'.$n.'" name="author_'.$n.'" type="text" id="field" value="'.$arr[$n-1].'" /><br/>
                                  <input id="author_'.$n.'_id" type="hidden" value="'.$id_arr[$n-1].'"/><br/>
                                  <div id="loader_'.$n.'" style="display:none;">
                                  <img   src="/static/images/ajax-loader.gif"/><br/><br/></div>
                                  <div id="new_author_'.$n.'"></div>';
                               
                               $n++;

                       }
                       $n--;
                       $field .= '<input type="hidden" name="author_num" id="author_num" value="'.$n.'"/>';
                       $this->template->view->fields_options = $script.$field;


                        break;

               }
	}

        public function _make_file_fields($arr = 0,$id_arr = 0)
	{

            $field = '<input type="hidden" name="files_counter" id="files_counter" value="1"/><br/>
                      <input class="file_1" name="file_1" type="file" /><br/>

                      <div id="f_loader_1" style="display:none;">
                      <img   src="/static/images/ajax-loader.gif"/><br/><br/></div>
                      <div id="new_file_1"></div>';

            $this->template->view->file_fields = $field;

            return $field;



	}

        public function add_file_field()
	{
		if (request::is_ajax())
		{
			$this->auto_render = FALSE;
			$files_counter =  $this->input->post('files_counter', null, true);
			$files_counter++;
			
                        $res = '<br/>
                          <input class="file_'.$files_counter.'" name="file_'.$files_counter.'" type="file" /><br/>
                          <div id="f_loader_'.$files_counter.'" style="display:none;">
                          <img   src="/static/images/ajax-loader.gif"/><br/><br/></div>
                          <div id="new_file_'.$files_counter.'"></div>';
                        
			echo $res;

		}else
		{
			Kohana::show_404();
		}
	}

        public function _make_authors($authors = '',$ids = '')
        {
                 $k         = 0;
                 $res       = '';
                 if(!empty($authors) && !empty($ids))
                 {
                         foreach($authors as $at)
                         {
                            $k++;


                            $res .= "<div style='height:20px;background:#ccc;margin-bottom:10px;margin-right:10px;position:relative;'>"
                                 .$at."<a href='javascript:unselect_author(".$ids[$k-1].");' style='text-decoration:none;'>
                                 <img style='position:absolute; right:0;' src='/static/images/delete_small.png'/></a>
                                 <input type='hidden' name='author_".$k."' value='".$ids[$k-1]."'/> </div>";


                         }
                 }
                 

                 $new_authors_array   = $this->session->get('new_authors');
                 if(!empty($new_authors_array))
                 {
                         $i = 0;
                          foreach($new_authors_array as $new)
                          {
                                
                                 $name = $new['family'].' '.$new['name'].' '.$new['patronymic'];

                                 $res .= "<div style='height:20px;background:#ccc;margin-bottom:10px;margin-right:10px;position:relative;'>"
                                 .$name."<a href='javascript:clear_author(".$i.");' style='text-decoration:none;'>
                                 <img style='position:absolute; right:0;' src='/static/images/delete_small.png'/></a>
                                 </div>";

                                 $i++;
                          }
                 }

                 $res .= "<input type='hidden' name='auth_num' value='".$k."'";

                 return $res;

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

                         $res = $this->_make_authors($authors,$ids);
                         
                         echo $res;



                }
        }


        public function delete_author_from_ses()
        {
                if (request::is_ajax())
		{
                         $this->auto_render = FALSE;
                         $id                = $this->input->post('id', null, true);

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
                         
                         $res = $this->_make_authors($this->session->get('authors'),$this->session->get('authors_id'));

                         if(!empty($ids_new))
                           {
                                   $id_list               = implode(',',$ids_new);
                                   $name_list             = implode(',',$authors_new);
                           }else
                           {
                                   $id_list               = '';
                                   $name_list             = '';
                           }

                          echo json_encode(array('res'=>$res,'id_list'=>$id_list,'name_list' => $name_list));
                        

                }
        }

        public function add_new_author_session()
        {
                if (request::is_ajax())
		{
                         $this->auto_render     = FALSE;
                         $name               = $this->input->post('name', null, true);
                         $family             = $this->input->post('family', null, true);
                         $patronymic         = $this->input->post('patronymic', null, true);
                         $date               = $this->input->post('date', null, true);
                         $email              = $this->input->post('email', null, true);
                         $sex                = $this->input->post('sex', null, true);
                         $f_date             = date("d.m.Y",strtotime($date));


                         $new_author               = array(
                                                        'name' => $name,
                                                        'family' => $family,
                                                        'patronymic' => $patronymic,
                                                        'date'       => $date,
                                                        'f_date'     => $f_date,
                                                        'email'      => $email,
                                                        'sex'        => $sex
                                                        );
                         if($this->auth_db->check_duplicate_author($new_author)->cnt == 0)
                         {
                                $new_authors_array   = $this->session->get('new_authors');
                                 if(!empty($new_authors_array))
                                 {
                                         array_push($new_authors_array,$new_author);
                                 }else
                                 {
                                         $new_authors_array = array();
                                         array_push($new_authors_array,$new_author);
                                 }

                                 $this->session->delete('new_authors');

                                 $ses_data = array(
                                                'new_authors' => $new_authors_array
                                 );

                                 $this->session->set($ses_data);

                                 $authors = $this->session->get('authors');
                                 $ids = $this->session->get('authors_id');
                                 $res = $this->_make_authors($authors,$ids);

                                 echo $res;
                         }else
                         {
                                 echo 'duplicate';
                         }
                 
                        



                }
        }

        public function add_new_org_session()
        {
                if (request::is_ajax())
		{
                         $this->auto_render  = FALSE;
                         $name               = $this->input->post('name', null, true);
                         $type               = $this->input->post('type', null, true);
                         $parent             = $this->input->post('parent', null, true);
                         
                         $new_org               = array(
                                                        'name' => $name,
                                                        'type' => $type,
                                                        'parent' => $parent
                                                        );
                         if($this->org_db->check_duplicate_org($new_org)->cnt == 0)
                         {
                                 $new_org_array   = $this->session->get('new_orgs');
                                 if(!empty($new_org_array))
                                 {
                                         array_push($new_org_array,$new_org);
                                 }else
                                 {
                                         $new_org_array = array();
                                         array_push($new_org_array,$new_org);
                                 }

                                 $this->session->delete('new_orgs');

                                 $ses_data = array(
                                                'new_orgs' => $new_org_array
                                 );

                                 $this->session->set($ses_data);

                                 $res = self::_make_org_options();
                                 foreach($new_org_array as $org)
                                 {
                                        $res .= "
                                                <option selected value='name:".$org['name']."'>".$org['name']."</option>
                                        ";
                                 }


                                 echo $res;
                         }else
                         {
                                 echo 'duplicate';
                         }





                }
        }

        public function delete_new_author_from_ses()
        {
                if (request::is_ajax())
		{
                         $this->auto_render = FALSE;
                         $id                = $this->input->post('id', null, true);
                         $prev_arr          = array();
                         $after_arr         = array();
                         $new_authors = $this->session->get('new_authors');
                         $i=0;
                         $c = count($new_authors);
                         foreach($new_authors as $n)
                         {
                                 if($i < $id)
                                 {
                                       $prev_arr[$i] = $new_authors[$i];
                                 }
                                 $r = $c-$i-1;
                                 if($r > $id )
                                 {
                                       $after_arr[$r] = $new_authors[$r];
                                 }
                                 $i++;

                         }
                         $new_authors = array_merge($prev_arr,$after_arr);

                         $this->session->delete('new_authors');

                         $ses_data = array(
                                        'new_authors' => $new_authors
                         );
                         $this->session->set($ses_data);

                         $res = $this->_make_authors($this->session->get('authors'),$this->session->get('authors_id'));



                         echo $res;


                }
        }
}
