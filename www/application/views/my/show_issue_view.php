<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?=html::anchor(url::base().'edit/issues','Режим редактирования');?><br/><br/>
<table class='listtable' width='100%'>
        <tr>
                <th>Название</th>
                <th>Тип</th>
                <th>Издательство</th>
                <th>Дата</th>
                <th></th>

        </tr>
<?
$i=0;
foreach($issue as $a)
{
        $i++;
	echo "<tr>
	<td><center>".$a->name." </center></td>
	<td><center> ".$a->TYPE_NAME." </center></td>
	<td><center> ".$a->PUBLISHER_NAME." </center></td>
        <td><center> ".$a->date." </center></td>";
	?>
            <td width="20px"><center><a href="/my/issues/details/<?=$a->id?>" class="box-<?=$i?>"><img title="Подробности" src='/static/images/info.png'/></a></center></td>
           
            <script type="text/javascript">
            $(".box-<?=$i?>").colorbox({width:"300px", height:"200px"});


            </script>
        
        <?

	
}		


?>
</table>