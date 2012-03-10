<?php defined('SYSPATH') OR die('No direct access allowed.');

class Lib_Core 
{
	public static function factory()
	{
		return new Lib();
	}
	
	
	public function test_lib()
	{
		die("libb");
	}
}


?>