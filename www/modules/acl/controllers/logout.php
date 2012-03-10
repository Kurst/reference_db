<?php
defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Logout controller
 *
 * Controller for logout.
 *
 * @copyright   Copyright (C) 2010 Ilya Semerhanov
 * @author      Ilya Semerhanov
 * @version     1.0
 * @package     Acl_Core
 */

class Logout_Controller
{
	const ALLOW_PRODUCTION = TRUE;
	
	
	public $acl;
	
	public function __construct()
	{
		$this->acl = new Acl();
	}
	
	
	public function index()
	{
		if ($this->acl->logged_in())
		{
			$this->acl->logout();
			url::redirect('/add');
		}else
                {
                        url::redirect('/reg_msg/failure');
                }
		
		
		
	}
	
	
}


?>