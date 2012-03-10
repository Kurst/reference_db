<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?=html::anchor(url::base().'admin/users','Управление пользователями');?></br></br>



<table class='listtable' width='100%'>
	<tr>
                <th>Группа</th>
                <th>Описание</th>
                <th>Мастер группа</th>
                
                <th></th>

        </tr>
<?
$i = 0;
foreach($groups as $g)
{
        $i++;
	echo "<tr>

	<td align='center'>".$g->fullname." </td>
	<td align='center'> ".$g->description." </td>
	<td align='center'> ".$g->master_fullname." </td>
                
	";
         ?>
                    
                    <td width="40px">
                    <center><?=html::anchor('/admin/users/user_id/'.$g->id.'','<img src="/static/images/edit.png" alt="Редактировать" title="Редактировать"')?>
                    
                    <?=html::anchor('','<img src="/static/images/delete.png" alt="Удалить" title="Удалить" onClick="delete_confirm(\'group\','.$g->id.'); return false;"')?></center></td>
        

                <?
       


}


?>
</table><br/>
<?=html::anchor('admin/groups/add/','Добавить',array('class'=>'box-add'))?>
<script type="text/javascript">
        $(".box-add").colorbox({width:"470px", height:"515px"});

</script>