<?php defined('SYSPATH') OR die('No direct access allowed.');

class Page_Controller extends Template_Controller 
	{
		const ALLOW_PRODUCTION = TRUE;
		
		public $template = 'layouts/template';
		
		public function __construct()
		{
			parent::__construct();
			$this->template->title = "Система управления интеллектуальными ресурсами";
			$this->template->content = new View('main_content');
		}
		
		
		public function index()
		{
			
			
		} 

	}


?>