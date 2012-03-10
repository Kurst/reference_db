<?php
defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Login controller
 *
 * Controller for login page.
 *
 * @copyright   Copyright (C) 2010 Ilya Semerhanov
 * @author      Ilya Semerhanov
 * @version     1.0
 * @package     Acl_Core
 */

class Filter_Controller extends Template_Controller
{
	const ALLOW_PRODUCTION = TRUE;
	
	public $template = 'filter/filter_view';
	
	
	public function __construct()
	{
		parent::__construct();
		
		
		//$this->acl = new Acl();
		
	}
	
	
	public function index()
	{
		
	
	}

       
	
	
}


?>