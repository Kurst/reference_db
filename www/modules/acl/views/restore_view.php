<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<style type="text/css">
<?php include Kohana::find_file('views', 'register', FALSE, 'css') ?>
</style>
<head>

	<title>Восстановление пароля</title>
        <link rel="stylesheet" href="<?=url::base()?>static/css/redmond/jquery-ui-1.8.custom.css" type="text/css" />
    
	<script src="<?=url::base()?>static/js/jquery-1.4.2.min.js" type="text/javascript" ></script>
	<script src="<?=url::base()?>static/js/jquery-ui-1.8.custom.min.js" type="text/javascript" ></script>
	<script src="<?=url::base()?>static/js/jquery.ui.datepicker.js" type="text/javascript" ></script>
	<script src="<?=url::base()?>static/js/jquery.ui.datepicker-ru.js" type="text/javascript" ></script>
	

	<script type="text/javascript">
	$(function() {
		$("#datepicker").datepicker( { dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true,yearRange: '1920:2000'} );
		$("#datepicker").datepicker($.datepicker.regional['ru']);
	});
	</script>

</head>
<body>
<div id='container' style='<?=$style?>'>
<div id='label'>Восстановление пароля </div>
<div id='login'>
<? if($view == 'first_step'){?>
	<?=form::open('restore/check');?>
		<table width='330px'  >
			<tr>

                                <td align='left'>Укажите свой email &nbsp;&nbsp;<br/> <input type='text' name='email' id='username'/></td>
				
			</tr>
			<tr>
                               
                                <td align='left'  ><input type='submit' name='submit' id='submit'  value='Продолжить'/> </td>

			</tr>

		</table>
	 
	<?=form::close();
}
if($view == 'new_password'){
       
        ?>
        <?=form::open('restore/save');?>
                <input type="hidden" name="id" value="<?=$id?>"/>
                <table width='330px'  >
			<tr>

                                <td align='left'>Введите новый пароль &nbsp;&nbsp;<br/> <input type='password' name='new_pswd' id='username'/></td>

			</tr>
                        <tr>

                                <td align='left'>Подтвердите новый пароль &nbsp;&nbsp;<br/> <input type='password' name='confirm' id='username'/></td>

			</tr>
			<tr>

                                <td align='left'  ><input type='submit' name='submit' id='submit'  value='Сохранить'/> </td>

			</tr>

		</table>
<?=form::close();?>

<? }
?>


</div>
</div>
</body>
</html>
