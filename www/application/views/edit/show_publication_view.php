<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?=form::open('edit/publication/id');?>
Автор:<br/>
<select name="author"  class="wide_select">
        <?=$select_list?>
</select>
<input type="submit" name="show" value="Показать"/><br/><br/>
<?=form::close();?>
Версия в <?=html::anchor(url::base().'edit/publication/pdf/'.$id,'PDF');?> <br/><br/>
<table class='listtable' width='100%'>
	<tr>
                <td> № </td>
                <td>Наименование</td>
                <td>Выходные данные</td>
                <td>Кол-во страниц</td>
                <td>Авторы</td>
                <td>Действие</td>
        </tr>
<?
$i = 0;
foreach($publication as $a)
{
        $i++;
        $link = html::anchor(url::base().'tmp/'.$a['path_to_file'].'','<img src="/static/images/download.png" alt="Скачать" title="Скачать"');
       
	echo "<tr>
	<td>".$i." </td>
	<td> ".$a['title']." </td>
	<td> ".$a['output']." </td>
	<td> ".$a['pages']." </td>
        <td> ".$a['authors']." </td>
	<td align=center>".$link."</td>";
	

	
}		


?>
</table>