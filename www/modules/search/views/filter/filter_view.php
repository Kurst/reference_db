<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<style type="text/css">
<?php include Kohana::find_file('views/filter', 'filter', FALSE, 'css') ?>
</style>
<head>

	<title>Поиск</title>
        <script src="<?=url::base()?>static/js/jquery-1.4.2.min.js" type="text/javascript" ></script>
	<script src="<?=url::base()?>static/js/jquery-ui-1.8.custom.min.js" type="text/javascript" ></script>
        <script type="text/javascript">
        var flag = 0;
        function showParams()
        {
                if(flag == 0)
                {
                         $('#params').slideDown();
                         $('#down').hide();
                         $('#up').show();
                         flag = 1;
                }else
                {
                         $('#params').slideUp();
                          $('#up').hide();
                         $('#down').show();
                         flag = 0;
                }
               
        }
	</script>
</head>
<body>

<div id='container'>
<div id='label'><div id='label_l'>Поиск</div> <div id='label_entry'><?=html::anchor('login','Вход')?></div></div>
<div id='login'>
	<img id="logo" src="static/images/itmologo.png" />
        <div id="menu" ></div>
	<?=form::open('search');?>
        <table id="tbl" width='500px' border="0" cellpadding="0" cellspacing="0" >

                       
			<tr valign="middle">
                               
                                <td  align='right'><input type='text' name='query' id='search' /> </td>
                                <td align='left'> <input type="image" id="lupa" src="static/images/search/search_green.png" value="html" alt="Submit"/></td>
                               
				
			</tr>
                        
			
				
		</table>
        <div id="params_label"><a href="javascript:showParams();">Параметры&nbsp;<img id="down" src="static/images/search/down.png" /><img id="up" src="static/images/search/up.png" style="display: none;"/></a></div>
        <div id="params" style="display: none;">
                <table>
                        <tr>
                                <td valign="top">
                                        <input name="type" type="radio" value="0" checked>Все</input><br/>
                                        <input name="type" type="radio" value="1">Название</input><br/>
                                        <input name="type" type="radio" value="2">Автор</input><br/>
                                </td>
                                <td valign="top">
                                        <input name="type" type="radio" value="3">Организация</input><br/>
                                        <input name="type" type="radio" value="4">Издательство</input>

                                </td>
                        </tr>
                </table>
                
                

        </div>
	<?=form::close();?>
	

</div>	
</div>
<div id="footer">RefDB v. <?=Kohana::config('config.version')?></div>
</body>
</html>