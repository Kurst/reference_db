<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?=html::anchor(url::base().'edit/organizations','Режим редактирования');?><br/><br/>

<table class='listtable' width='100%'>
	<tr>
                <th>Название</th>
                <th>Тип</th>
                <th>Родительское</th>
                
                <th></th>

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
            </tr>
            <script type="text/javascript">
            $(".box-<?=$i?>").colorbox({width:"300px", height:"300px"});


            </script>
        <?


	
}		


?>
</table>