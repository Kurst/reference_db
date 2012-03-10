<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?=html::anchor(url::base().'my/organizations','Посмотреть все');?><br/><br/>

<table class='listtable' width='100%'>
	<tr>
                <th>Название</th>
                <th>Тип</th>
                <th>Родительское</th>
               
                <th colspan="3"></th>

        </tr>
<?
$i = 0;


foreach($organization as $a)
{
        $type = '';
        switch($a->type)
        {
            case 'state':
                $type = 'Государственная';
                break;
            case 'private':
                $type = 'Частная';
                break;
            case 'mixed':
                $type = 'Смешанная';
                break;
        }
        $i++;
	echo "<tr>
	<td><center>".$a->name." </center></td>
	<td><center> ".$type." </center></td>
	<td width='20%'><center> ".$a->parent." </center></td>
	";

	?>
            <td width="20px"><center><a href="/my/organizations/details/<?=$a->id?>" class="box-<?=$i?>"><img title="Подробности" src='/static/images/info.png'/></a></center></td>
           
            <td width="20px">
            <center><?=html::anchor('/edit/organizations/id/'.$a->id.'','<img src="/static/images/edit.png" alt="Редактировать" title="Редактировать"')?></center>
            </td>
            <td width="20px"><center><?=html::anchor('','<img src="/static/images/delete.png" alt="Удалить" title="удалить" onClick="delete_confirm(\'org\','.$a->id.'); return false;"')?></center></td>
            <script type="text/javascript">
            $(".box-<?=$i?>").colorbox({width:"300px", height:"300px"});


            </script>
        <?



}


?>
</table>