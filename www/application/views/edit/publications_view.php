<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<h4><?=$user_name?></h4> <br/>
<?=html::anchor(url::base().'my/publications','Режим просмотра');?><br/><br/>
<div class="contextMenu" id="itemMenu">

      <ul>
        <li id="info"  ><img src="/static/images/info.png" /> <span style="cursor:pointer;">Информация</span></li>

        <li id="edit"  ><img src="/static/images/edit.png" /> <span style="cursor:pointer;">Редактировать</span></li>

        <li id="deligate"><img src="/static/images/switch.png" /> <span style="cursor:pointer;">Делегировать</span></li>

        <li id="delete"><img src="/static/images/delete.png" /> <span style="cursor:pointer;">Удалить</span></li>

      </ul>

</div>
<table class='listtable' width='100%'>
	<tr>
                <th> № </th>
                <th>Наименование</th>
                <th>Выходные данные</th>
                <th>Кол-во страниц</th>
                <th>Авторы</th>
                <th></th>

        </tr>
<?
$i = 0;
foreach($publications as $a)
{
        $i++;
        //$link = html::anchor(url::base().'tmp/'.$a['path_to_file'].'','<img src="/static/images/download.png" alt="Скачать" title="Скачать"');

	?><tr>
	<td><center><?=$i?></center></td>
	<td><?=$a['title']?></td>
	<td><?=$a['output']?></td>
	<td><center><?=$a['pages']?></center></td>
        <td><?=$a['authors']?></td>
        <td><center><img id="menu-<?=$i?>" src="/static/images/wheels.png" alt="Действия" title="Действия" style="cursor:pointer;"/></center></td>
        </tr>
        <script type="text/javascript">
        
                $('#menu-<?=$i?>').contextMenu('itemMenu', {
                bindings: {
                        'info': function(t) {
                                $.colorbox({href:url+"/edit/publications/details/<?=$a['id']?>",width:"40%", height:"40%"});
                        },
                        'edit': function(t) {
                                parent.location=url +'edit/publications/id/'+<?=$a['id']?>;
                        },
                        'deligate': function(t) {
                                 $.colorbox({href:url+"/edit/publications/delegate/<?=$a['id']?>",width:"40%", height:"40%"});
                        },
                        'delete': function(t) {
                                delete_confirm('publication','<?=$a['id']?>');
                        }
                }
                });

        </script>
<?
}
?>

</table>
