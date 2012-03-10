<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<p>

        <div  class ="vertical" style="width:265px;" >

        <?=form::open('user/lib/show',array('name'=>'lib'));?>
        Выберите список:
        <select id="l_list" name ="list" style="width:200px;">
                <?=$list_options?>
        </select>&nbsp;

        <?=html::anchor('user/lib/add_list',"<img src='/static/images/add-icon.png' title='Добавить список'/>",array('class'=>'box'))?>&nbsp;
        &nbsp;&nbsp;<a href="javascript:deleteLibList();" style="text-decoration:none;" id="edit_name"><img src='/static/images/delete-icon.png' title='Удалить список'/></a><br/>
         <input type="submit" value="Показать" id="show_list"/>
        <?=form::close();?>

        <span id="lib_list_opt"></span>

        </div>
<script type="text/javascript">
        $(".box").colorbox({width:"230px", height:"150px"});
</script>

<!-- #########TABLE######### -->
<br/>
<?=$generator?>
<form name="pubList">
<input type="hidden" name="report_header" value="1"/>
<table class='listtable' width='100%'>
	<tr>
                <th> № </th>
                <th>Наименование</th>
                <th>Выходные данные</th>
                <th>Кол-во страниц</th>
                <th>Авторы</th>
                <th width="20px"></th>

        </tr>
<?
$i = 0;

foreach($publications as $a)
{
        $i++;

        $link = html::anchor(url::base().'tmp/'.$a['path_to_file'].'','<img src="/static/images/download.png" alt="Скачать" title="Скачать"');

	?><tr>
	<td>    <input type="hidden" name="id_sel" value="<?=$a['id']?>"/>

                <center><?=$i?></center></td>
	<td><?=$a['title']?></td>
	<td><?=$a['output']?></td>
	<td><center><?=$a['pages']?></center></td>
        <td><?=$a['authors']?></td>
        <td><center><a href="/my/publications/details/<?=$a['id']?>" class="box-<?=$i?>"><img title="Подробности" src='/static/images/info.png'/></a>
                <?=html::anchor('','<img src="/static/images/delete-icon.png" alt="Удалить из списка" title="Удалить из списка" onClick="delete_from_liblist('.$a['id'].','.$id.'); return false;"')?></center></td>
        </tr>
        <script type="text/javascript">
        $(".box-<?=$i?>").colorbox({width:"40%", height:"40%"});


        </script>
<?
}


?>

</table>
 <input type="hidden" name="id_sel" value="0"/>
</form>
</p>


