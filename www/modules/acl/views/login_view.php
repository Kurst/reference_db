<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<style type="text/css">
<?php include Kohana::find_file('views', 'login', FALSE, 'css') ?>
</style>
<head>

	<title>Вход</title>

</head>
<body>
<div id='container'>
<div id='label'>Авторизация </div>
<div id='login'>
	
	<?=form::open('login/check');?>
		<table width='300px' >
			<tr>
				
				<td align='left'>Email<br/> <input type='text' name='username' id='username' /></td>
				<td rowspan=2 align='right'> <img id="logo" src="/static/images/acl/loginmanager.png"/> </td>
			</tr>
			<tr>
				
				<td align='left'>Пароль<br/>	<input type='password' name='password' id='password'/></td>
			</tr>
			<tr>				
				<td align='left'><input type='submit' name='submit' id='submit'  value='Войти'/> </td>
                               
			</tr>
				
		</table>
        <span id="reg"><?=html::anchor('restore','Забыли пароль?') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=html::anchor('register','Регистрация') ?></span>
	<?=form::close();?>
	

</div>	
</div>
</body>
</html>