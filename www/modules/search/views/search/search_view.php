<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<style type="text/css">
<?php include Kohana::find_file('views/search', 'search', FALSE, 'css') ?>

</style>
<head>
        <div id="base_url" style="display: none;"><?=url::base()?></div>
	<title>Поиск</title>
        <script src="<?=url::base()?>static/js/jquery-1.4.2.min.js" type="text/javascript" ></script>
	<script src="<?=url::base()?>static/js/jquery-ui-1.8.custom.min.js" type="text/javascript" ></script>
        <script type="text/javascript">
        <?php include Kohana::find_file('views/search', 'script', FALSE, 'js') ?>
        </script>
        
</head>
<body>
        
        <div id="entrance"> <?=html::anchor('login','Вход')?></div>
<div class="page">

<div class="header">
        
        <?=form::open('search');?>
        <table width="100%" border="0">
         <tr valign="bottom">
                 <td width="100px" >
                       <?=html::anchor('','<img id="logo" src="/static/images/itmologo.png" />')?>
                 </td>
                 <td width="300px" >

                        <input type='text' name='query' id='search' value='<?=$query?>'/><br/>
                        <div id="params">
                                <?=$params?>
                        </div>

                 </td>
                 <td valign="middle">
                         <input style="margin-top: 26px;" type="image" id="lupa" src="/static/images/search/search_green.png" value="html" alt="Submit"/>

                 </td>

         </tr>

        </table>
        <?=form::close();?>
      
</div>

<div class="sidebar"><h1>Результаты</h1>
<div class="patch_minheight"></div>

<br />
<div id="result">


<!--<li> &nbsp;<span style="background-color:#fab0b0; border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;</span> - html</li>-->

<?=$result

?>


</div>
</div>

<div class="mainbar">
<div class="patch_minheight"></div>

<center>
        <div  style="display: none; padding-top:100px;" id="loader">

                <img  src="/static/images/search/loader.gif"/><br/>
                Загрузка...
        </div>
</center>

<div id="details"></div>


</div>

<div class="footer_guarantor"></div>

</div>

<div class="footer">
<p>Загружена за {execution_time} секунд, используя {memory_usage} памяти. 
   RefDB v. <?=Kohana::config('config.version')?></p>


</div>

</div>

</body> 
</html>