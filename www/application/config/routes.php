<?php defined('SYSPATH') OR die('No direct access allowed.');

//$config['(.*)'] = "welcome";
$config['_default'] = 'filter';


$exclude            = array(
					'.',
					'..',
					'page.php',
					'.svn'
					);
					
					
$handle             = opendir(APPPATH . 'controllers/');
while ($file = readdir($handle))
{
	if (!in_array($file, $exclude))
	{
		if (!is_dir(APPPATH . 'controllers/' . $file))
		{
			$file                = substr($file, 0, strlen($file) - 4);
			$installed_modules[] = $file;
		}
		else
		{
			$new_handle = opendir(APPPATH . 'controllers/' . $file);
			while ($sub_file = readdir($new_handle))
			{
				if (!in_array($sub_file, $exclude))
				{
					if (!is_dir(APPPATH . 'controllers/' . $sub_file))
					{
						$sub_file         = substr($sub_file, 0, strlen($sub_file) - 4);
						$sub_mod[$file][] = $sub_file;
					}
				}
			}
			closedir($new_handle);
			$installed_modules[] = $sub_mod;
		}
	}
}
closedir($handle);

foreach ($installed_modules as $module)
{
	if (is_array($module))
	{
		foreach ($module as $sub_mod => $arr)
		{
			$config[$sub_mod] = $sub_mod . '/' . $arr[0];
			foreach ($arr as $cont)
			{
				$config[$sub_mod . '/' . $cont]           = $sub_mod . '/' . $cont;
				$config[$sub_mod . '/' . $cont . '/(.*)'] = $sub_mod . '/' . $cont . '/$1';
			}
		}
	}
	else
	{
		$config[$module]           = $module;
		$config[$module . '/(.*)'] = $module . '/$1';
	}
}

//// extra modules dir

$handle             = opendir(MODPATH);
while ($file = readdir($handle))
{
	if (!in_array($file, $exclude))
	{
		if(is_dir(MODPATH . $file))
		{
			if(is_dir(MODPATH . $file. '/controllers/'))
			{
				$new_handle = opendir(MODPATH . $file. '/controllers/');
				while ($sub_file = readdir($new_handle))
				{
					if (!in_array($sub_file, $exclude))
					{
						$sub_file         = substr($sub_file, 0, strlen($sub_file) - 4);
						$extra_modules[] = $sub_file;
						
					}
				}
				closedir($new_handle);
			}
			
			
		}
	}
	
}

closedir($handle);
if(isset($extra_modules))
{
	foreach ($extra_modules as $module)
	{
	
		$config[$module]           = $module;
		$config[$module . '/(.*)'] = $module . '/$1';
	}
}


////
$config['(.*)'] = "login/$1";



