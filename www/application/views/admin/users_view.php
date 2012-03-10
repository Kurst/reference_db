<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?=html::anchor(url::base().'admin/groups','Управление группами');?></br></br>

<?=form::open('admin/users/');?>
 <div class ="vertical" >
        <table border="0">
         <tr>

                 <td width="300px" valign="middle">

                        <input type='text' name='query' id='search' value='<?=$query?>'/><br/>

                      
                 </td>
                 <td valign="top">
                         <input  style="margin-top: -3px;" type="image" id="lupa" src="/static/images/search/search_green.png" value="html" alt="Submit"/>

                 </td>

         </tr>

        </table>

<?=form::close();?>
<br/>



<br/>

 </div>
<br/>

<table class='listtable' width='100%'>
	<tr>
                <th>Имя пользователя</th>
                <th>Группа</th>
                <th>Статус</th>
                
                <th></th>

        </tr>
<?
$i = 0;
foreach($users as $u)
{
        $i++;
	echo "<tr>

	<td align='center'>".$u->username." </td>
	<td align='center'> ".$u->group_name." </td>
	<td align='center'> ".$u->active." </td>
                
	";
         ?>
                    
                    <td width="40px">
                    <center><?=html::anchor('/admin/users/user_id/'.$u->id.'','<img src="/static/images/edit.png" alt="Редактировать" title="Редактировать"')?>
                    
                    <?=html::anchor('','<img src="/static/images/delete.png" alt="Удалить" title="Удалить" onClick="delete_confirm(\'user\','.$u->id.'); return false;"')?></center></td>
        <script type="text/javascript">
        $(".box-<?=$i?>").colorbox({width:"300px", height:"300px"});


        </script>

                <?
       


}


?>
</table>
