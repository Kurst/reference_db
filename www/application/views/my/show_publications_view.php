<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<h4><?=$user_name?></h4> <br/>
<?=html::anchor(url::base().'edit/publications','Режим редактирования');?><br/><br/>


<?=$generator?>
<div class="contextMenu" id="itemMenu">

      <ul>
        <li id="accept_all"  ><a href="javascript:approveNewPub('all');" style=" text-decoration: none; color:#000;font-size: 1em;"><img src="/static/images/button_ok.png" /> <span style="cursor:pointer;">Подтвердить все</span></a></li>

        <li id="decline_all"  ><a href="javascript:declineNewPub('all');" style=" text-decoration: none; color:#000;font-size: 1em;"><img src="/static/images/delete.png" /> <span style="cursor:pointer;">Отменить все</span></a></li>

        

      </ul>

</div>
<form name="pubList">
<input type="hidden" name="report_header" value="1"/>

<table class='listtable' width='100%'>
	<tr >
                <th> № </th>
                <th  > Наименование</th>
                <th>Выходные данные</th>
                <th>Кол-во страниц</th>
                <th>Авторы</th>
                <th width="20px">      
                <?
                        if($new_pubs > 0)
                        {
                              ?>
                              <a href="javascript:approveNewPub('');" ><img id="all-menu" title="Применить ко всем" src='/static/images/wheel_down.png'/></a>
                             
                              <?  
                        }
                ?>
                </th>

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
	<td > <?=$a['title']?></td>
	<td><?=$a['output']?></td>
	<td><center><?=$a['pages']?></center></td>
        <td><?=$a['authors']?></td>
        <td><center><a href="/my/publications/details/<?=$a['id']?>" class="box-<?=$i?>"><img title="Подробности" src='/static/images/info.png'/></a>
                <?
                        if($a['status'] == 2)
                        {
                                ?><a href="javascript:approveNewPub(<?=$a['id']?>);" ><img title="Подтвердить" src='/static/images/button_ok.png'/></a>
                                  <a href="javascript:declineNewPub(<?=$a['id']?>);"><img title="Отменить" src='/static/images/delete.png'/></a><?
                        }
                ?>
                </center></td>
        </tr>
        <script type="text/javascript">
        $(".box-<?=$i?>").colorbox({width:"40%", height:"40%"});

         $('#all-menu').contextMenu('itemMenu', {
                bindings: {
                        'accept_all': function(t) {
                                
                        },
                        'decline_all': function(t) {
                               
                        }
                }
                });

        </script>
<?
}


?>

</table>
 <input type="hidden" name="id_sel" value="0"/>
</form>
