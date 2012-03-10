<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?=html::anchor(url::base().'my/authors','Посмотреть все');?><br/><br/>

<table class='listtable' width='100%'>
	<tr>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Дата рождения</th>
                <th colspan="3" ></th>

        </tr>
<?
$i = 0;
foreach($author as $a)
{
        $a->date_of_birth   == '0000-00-00'?$a->date_of_birth='':$a->date_of_birth;
        $i++;
	echo "<tr>
	
	<td align='center'>".$a->family." </td>
	<td align='center'> ".$a->name." </td>
	<td align='center'> ".$a->patronymic." </td>
	<td align='center'> ".$a->date_of_birth." </td>";
                ?>
                    <td width="20px"><center><a href="/my/authors/details/<?=$a->id?>" class="box-<?=$i?>"><img title="Подробности" src='/static/images/info.png'/></a></center></td>
                    <td width="20px">
                    <center><?=html::anchor('/edit/authors/id/'.$a->id.'','<img src="/static/images/edit.png" alt="Редактировать" title="Редактировать"')?></center>
                    </td>
                    <td width="20px"><center><?=html::anchor('','<img src="/static/images/delete.png" alt="Удалить" title="Удалить" onClick="delete_confirm(\'author\','.$a->id.'); return false;"')?></center></td>
        <script type="text/javascript">
        $(".box-<?=$i?>").colorbox({width:"300px", height:"300px"});


        </script>

                <?

       
	
}		


?>
</table>