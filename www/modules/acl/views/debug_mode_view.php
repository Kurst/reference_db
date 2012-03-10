<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<style type="text/css">
<?php include Kohana::find_file('views', 'register', FALSE, 'css') ?>
</style>
<head>

	<title><?=$title?></title>

</head>
<body>
<div id='container'>
<div id='label'><?=$sub_title?></div>
<div id='login'>


		<table width='330px'  style='padding-top: 25px;'>
			<tr>

                                <td align='center'>
                                        <?=$msg?><br/><br/>
                                        <?
                                        if(isset($link))
                                        {
                                               echo html::anchor($link,$link_text);
                                        }
                                        ?>
                                       
                                </td>

			</tr>
                       
                        <tr>

                                <td><center><img height="100px" src="/static/images/acl/stop.jpg"/></center></td>
                        </tr>


		</table>




</div>
</div>
</body>
</html>
