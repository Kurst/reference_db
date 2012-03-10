<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<style type="text/css">
<?php include Kohana::find_file('views', 'register', FALSE, 'css') ?>
</style>
<head>

	<title>Регистрация</title>
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
<div id='label'>Регистрация </div>
<div id='login'>
<? if($view == 'first_step'){?>
	<?=form::open('register/ok');?>
		<table width='330px'  >
			<tr>

                                <td align='left'>Email* &nbsp;&nbsp; <span id ="error"><?=$errors["email"]?></span><br/> <input type='text' name='email' id='username' value='<?=$values["email"]?>'/></td>
				
			</tr>
			<tr>

				<td align='left'>Пароль* &nbsp;&nbsp; <span id ="error"><?=$errors["password"]?></span><br/>	<input type='password' name='password' id='password' value='<?=$values["password"]?>'/></td>
			</tr>
                        <tr>

				<td align='left'>Повторите пароль* &nbsp;&nbsp; <span id ="error"><?=$errors["confirm"]?></span><br/>	<input type='password' name='confirm' id='password' value='<?=$values["confirm"]?>'/></td>
			</tr>
			<tr>
                               
                                <td align='left'  ><br/><input type='submit' name='submit' id='submit'  value='Продолжить'/> </td>

			</tr>

		</table>
	 
	<?=form::close();
}
if($view == 'auto_connect'){
        $date = new DateTime($author->date_of_birth);
        ?>
        Указанный вами email <span style="color:#000;"><?=$author->email?></span> был найден в базе авторов.<br/>
        <table>
                <tr>
                        <td>Фамилия: &nbsp;</td><td><span style="color:#000;"><?=$author->family?></span></td>
                </tr>
                <tr>
                        <td> Имя: &nbsp;</td><td> <span style="color:#000;"><?=$author->name?></span></td>
                </tr>
                <tr>
                        <td> Отчество: &nbsp;</td><td> <span style="color:#000;"><?=$author->patronymic?></span></td>
                </tr>
                <tr>
                        <td> Дата рождения: &nbsp;</td><td> <span style="color:#000;"><?=$date->format('d.m.Y');?></span></td>
                </tr>
        </table>
        <br/>Это вы?
        <?=form::open('register/auto_connect');
        $array = array('u_id' => $u_id, 'author_id' => $author->id);
        print form::hidden($array);?>
        <input type='submit' name='button' id='submit'  value='Да'/>
        <?form::close();?>
         <?=form::open('register/auto_connect');
        $array = array('u_id' => $u_id, 'author_id' => $author->id);
        print form::hidden($array);?>
        <input type='submit' name='button' id='submit'  value='Нет'/>
        <?form::close();?>
      <br/>

<? }
if($view == 'man_connect'){?>
        Введите свои данные:<br/><br/>
        <?=form::open('register/man_connect');
        print form::hidden("u_id",$u_id);
        ?>
        <label for="family">Фамилия* <span id ="error"><?=$err['family']?></span></label><br/>
        <input type='text' id='fld' name='family' value="<?=$form['family']?>"/> <br/><br/>
        <label for="name">Имя* <span id ="error"><?=$err['name']?></span></label><br/>
        <input type='text' id='fld' name='name' value="<?=$form['name']?>"/><br/><br/>
        <label for="patronymic">Отчество* <span id ="error"><?=$err['patronymic']?></span></label><br/>
        <input type='text' id='fld' name='patronymic'value="<?=$form['patronymic']?>"/> <br/><br/>
        <label for="date">Дата рождения* <span id ="error"><?=$err['date']?></span></label><br/>
        <input type='text' id="datepicker" name='date' size='10'  value="<?=$form['date']?>"/><br/><br/>
        <label for="date">Пол</label><br/>
        <select name="sex">
                <option value="man">М</option>
                <option value="woman">Ж</option>
        </select><br/><br/>
        <input type='submit' name='submit' id='submit'  value='Зарегестрироваться'/>
        <?form::close();?>
<?}?>


</div>
</div>
</body>
</html>
