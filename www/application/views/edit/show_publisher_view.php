<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?=html::anchor(url::base().'my/publishers','Посмотреть все');?><br/><br/>

<table class='listtable' width='100%'>
        <tr>
                <th>Название</th>
                <th>Город</th>
                <th colspan="3"></th>

        </tr>
<?
$i=0;
foreach($publisher as $a)
{
        $i++;
	echo "<tr>
	<td>".$a->name." </td>
	<td> ".$a->CITY." </td>";
        ?>
        <td width="20px"><center><a href="/my/publishers/details/<?=$a->id?>" class="box-<?=$i?>"><img title="Подробности" src='/static/images/info.png'/></a></center</td>
	<td width="20px">
        <center><?=html::anchor('/edit/publishers/id/'.$a->id.'','<img src="/static/images/edit.png" alt="Редактировать" title="Редактировать"')?></center>
        </td>
        <td width="20px"><center><?=html::anchor('','<img src="/static/images/delete.png" alt="Удалить" title="Удалить" onClick="delete_confirm(\'publisher\','.$a->id.'); return false;"')?></center></td>
            <script type="text/javascript">
            $(".box-<?=$i?>").colorbox({width:"300px", height:"300px"});


            </script>
	<?
}


?>
</table>