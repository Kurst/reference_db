<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?=html::anchor(url::base().'edit/authors','Режим редактирования');?><br/><br/>

<table class='listtable' width='100%'>
	<tr>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Дата рождения</th>
                <th></th>

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
            </tr>
            <script type="text/javascript">
            $(".box-<?=$i?>").colorbox({width:"300px", height:"300px"});


            </script>
        <?


}		


?>
</table>