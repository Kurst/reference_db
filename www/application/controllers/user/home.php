<?php defined('SYSPATH') OR die('No direct access allowed.');

class Home_Controller extends Template_Controller
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
		$this->template->title        = Kohana::config('config.application_name').".Главная";
		$this->template->sub_title    = "Главная";
		$this->template->view         = new View('user/home_view');
		$this->db                     = new Profile_Model;
                $this->news_db                = new News_Model;
                $this->pub_type_db            = new Publication_type_Model;
                $this->pub_db                 = new Publication_Model;
                $this->session                = Session::instance();
		


	}



	public function index()
	{
                $username = $this->session->get('username');
                $this->template->view->news = $this->news_db->get_news($username);
                $this->template->view->activity = '';
                $this->template->view->author = $this->db->get_author_date($username);
                $this->template->view->name = $this->db->get_author_date($username)->family.' '.$this->db->get_author_date($username)->name.
                ' '.$this->db->get_author_date($username)->patronymic;
                $this->template->view->age = '';
                if(substr($this->db->get_author_date($username)->date_of_birth,0,4) != '0000')
                {
					$birthday = date('Y/m/d',strtotime($this->db->get_author_date($username)->date_of_birth));
					list($y,$m,$d) = explode('/',$birthday);
					$age = (date("Y")-$y-((intval($m.$d)-intval(date("m").date("d"))>0)?1:0));              
					$this->template->view->age = $age;
                }
               
                $this->template->view->u_id = $this->db->get_user_id($username)->id;
                

	}

         public function get_chart_data()
        {
                if (request::is_ajax())
		{
                        $this->auto_render = FALSE;
                        $username = $this->session->get('username');
                        $name = $this->db->get_author_date($username)->family.' '.$this->db->get_author_date($username)->name;
                        $types = $this->pub_type_db->get_all_types();
                        $res =  "<chart>
                                        <categories>";
                        $a = array();
                        $i=0;
                        foreach($types as $t)
                        {
                                $res.= "<item>".$t->name."</item>";
                                $a[0][$i] = $this->pub_db->get_pub_amount_of_author_by_type($t->id,$username);
                                $a[1][$i] = $this->pub_db->get_pub_amount_by_author_by_type($t->id,$username);
                                $i++;
                        }
                        
                               
                       $res .= "</categories>
                                        <series>
                                        <name>Автор</name>
                                        <data>";

                       foreach($a[0] as $pnt)
                       {
                               $res.="<point>".$pnt."</point>";
                       }
                        $res.= "</data>
                                </series>
                                <series>
                                <name>Добавил в систему</name>
                                <data>";

                       foreach($a[1] as $pnt)
                       {
                               $res.="<point>".$pnt."</point>";
                       }
                        $res.= "
                                </data>
                                </series>

                                </chart>";
                        echo $res;
                }
        }

       





}
