<?php defined('SYSPATH') OR die('No direct access allowed.');

class Report_Controller extends Template_Controller
{
	const ALLOW_PRODUCTION = TRUE;
	public $template = 'layouts/template';
	protected $db;
	public function __construct()
	{
		parent::__construct();
		$acl = new Acl();
                $this->session  = Session::instance();

		if(!$acl->logged_auto())
		{
			url::redirect('/login');
		}
		$this->template->title        = Kohana::config('config.application_name').".Настройки";
		$this->template->sub_title    = "Настройки";
		$this->template->view         = new View('user/report/report_view');
		$this->report_db              = new Report_Model;
                $this->session                = Session::instance();
		


	}



	public function index()
	{
                
                $username   = $this->session->get('username');
                $i          = $this->report_db->get_name($username);
                $basement   = $this->report_db->get_basement($username);
                $this->template->view->typeTable = '';
                $this->template->view->typeList  = '';

                if(isset($i->FIO))
                {
                    $this->template->view->FIO          = $i->FIO;
                    $this->template->view->basement     = $basement;

                }
                if($i->report_type == '1')
                {
                       $this->template->view->typeTable = '<input type="radio" checked name="table" value="1" onClick="changeReportType(\'1\');">';
                       $this->template->view->typeList  = '<input type="radio" name="table" value="1" onClick="changeReportType(\'2\');">';
                }else
                {
                       $this->template->view->typeTable = '<input type="radio" name="table" value="1" onClick="changeReportType(\'1\');">';
                       $this->template->view->typeList  = '<input type="radio" checked name="table" value="1" onClick="changeReportType(\'2\');">';
                }
                

	}

        public function add_to_basement()
        {
           $view = new View('user/report/add_to_basement_view');
          

           $view->render(TRUE);
           $this->auto_render = FALSE;
        }

        public function  inline_edit()
        {
                if (request::is_ajax())
		{
                        $this->auto_render = FALSE;
                       
			$this->auto_render = FALSE;
			$field =  $this->input->post('field_type', null, true);
                        $prev =  $this->input->post('prev', null, true);
                        $new =  $this->input->post('newv', null, true);
                        $username = $this->session->get('username');

                       
                        if($field == 'report_name')
                        {

                               

                                $state = $this->report_db->update_report_name($username,$new);
                                
                                if($state != 'failed')
                                {
                                        print 'true';
                                }else
                                {
                                        print 'false';
                                }
                                

                        }


		}else
		{
			Kohana::show_404();
		}
        }

        public function  inline_delete_basement()
        {
                if (request::is_ajax())
		{
                        $this->auto_render = FALSE;

			$this->auto_render = FALSE;
                        $id =  $this->input->post('id', null, true);
                        $username = $this->session->get('username');
                        $res = '';
                        $state = $this->report_db->delete_basement_by_id($id);
                        if($state != 'failed')
                        {
                                $basement   = $this->report_db->get_basement($username);
                                $res.='<table width="100%">';
                                foreach($basement as $b)
                                {
                                      $res .= "<tr><td width='200px'>".$b->position."</td><td align='center'>".$b->name."</td>
                                            <td style='border:none;'><a href='javascript:inline_edit(\"eee\");' style='text-decoration:none;' id='edit_report_name'><img title='Edit' src='/static/images/user_edit.png'/></a></td>
                                            <td style='border:none;'><a href='javascript:inline_delete_basement(\"".$b->id."\");' style='text-decoration:none;' id='delete_report_base'><img title='Delete' src='/static/images/delete.png'/></a></td></tr>";
                                }

                                $res.='</table>';
                                echo $res;
                        }else
                        {
                                show_404();
                        }
                        



		}else
		{
			Kohana::show_404();
		}
        }

        public function  inline_basement_edit()
        {
                if (request::is_ajax())
		{
                        $this->auto_render = FALSE;

			$this->auto_render = FALSE;
			$id =  $this->input->post('id', null, true);
                        $new_pos =  $this->input->post('newv_pos', null, true);
                        $new_fio =  $this->input->post('newv_fio', null, true);
                        $username = $this->session->get('username');


                        $state = $this->report_db->update_report_basement($id,$new_pos,$new_fio);

                        if($state != 'failed')
                        {
                                print 'true';
                        }else
                        {
                                print 'false';
                        }





		}else
		{
			Kohana::show_404();
		}
        }

        public function inline_add_to_basement()
        {
               if (request::is_ajax())
		{
                        $this->auto_render = FALSE;

			
                        $new_pos =  $this->input->post('new_pos', null, true);
                        $new_fio =  $this->input->post('new_fio', null, true);
                        $username = $this->session->get('username');

                        $state = $this->report_db->insert_to_basement($username,$new_pos,$new_fio);
                        if($state != 'failed')
                        {
                                $basement   = $this->report_db->get_basement($username);
                                $res.='<table width="100%">';
                                foreach($basement as $b)
                                {
                                      $res .= "<tr><td width='200px'>".$b->position."</td><td align='center'>".$b->name."</td>
                                            <td style='border:none;'><a href='javascript:inline_edit(\"eee\");' style='text-decoration:none;' id='edit_report_name'><img title='Edit' src='/static/images/user_edit.png'/></a></td>
                                            <td style='border:none;'><a href='javascript:inline_delete_basement(\"".$b->id."\");' style='text-decoration:none;' id='delete_report_base'><img title='Delete' src='/static/images/delete.png'/></a></td></tr>";
                                }

                                $res.='</table>';

                                echo $res;
                        }else
                        {
                                show_404();
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


                        $type =  $this->input->post('type', null, true);

                        $username = $this->session->get('username');

                        $state = $this->report_db->update_report_type($username,$type);
                        if($state != 'failed')
                        {
                                echo "Тип отчета изменен";
                        }else
                        {
                                echo "Тип отчета не изменен";
                        }








		}else
		{
			Kohana::show_404();
		}
        }




}
