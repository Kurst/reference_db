<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<script type="text/javascript">
	$(function() {

            $(".basement_box").colorbox({width:"300px", height:"320px"});
            if($(".name").val()!='')
            {
                $("#button").removeAttr("disabled");
            }else
            {
                $("#button").attr("disabled","disabled");
            }

            $(".name").blur(function(){
            if($(".name").val()!='')
            {
                $("#button").removeAttr("disabled");
            }else
            {
                $("#button").attr("disabled","disabled");
            }
        });

         $("#sp_field").mouseover(function(){

            if($(".name").val()!='')
            {
                $("#button").removeAttr("disabled");
            }else
            {
                $("#button").attr("disabled","disabled");
            }
        });

	});
</script>
<p>
          <?=html::anchor(url::base().'user/profile','Профиль');?> | Отчет
<table class ="verticaltable" width="425px">
    <tr style="background: #dbdbdb;"><td>
       Формат списка публикаций
  </td></tr>
    <tr><td>
       <?=$typeTable?>Таблица &nbsp;&nbsp;&nbsp;
       <?=$typeList?>Список (ГОСТ 7.0.5-2008)

  </td></tr>
   <tr style="background: #dbdbdb;"><td>
           Имя в отчете <small><i>(в родительном падеже)</i></small>

  </td></tr>
   <tr><td>
         <table width="100%" >
             <tr>
                 <td style="border:none;"><div id="report_name"><?=$FIO?></div></td>
                 <td style="border:none;"><a href="javascript:inline_edit('report_name');" style="text-decoration:none;" id="edit_report_name"><img title="Edit" src='/static/images/user_edit.png'/></a>
            <span id="ok_report_name"></span></td>
             </tr>

         </table>
         <!--<a href="/set/report/change_name" class="name_box">Изменить</a>-->
        
     <input type="hidden" name="report_FIO" value="<?=$FIO?>"

  </td></tr>

   <tr style="background: #dbdbdb;"><td>
       Подвал в отчете
  </td></tr>
   <tr><td>
       <!-- <input type="text" name="job" value="1"/>&nbsp;
       &nbsp;&nbsp;<input type="text" name="FIO" value="1"/>-->
   <div id="basement">
       <table width="100%">


        <?
                foreach($basement as $b)
                {
                      echo "<tr><td width='200px'><div id='report_pos_".$b->id."'>".$b->position."</div></td><td align='center'><div id='report_fio_".$b->id."'>".$b->name."</div></td>
                            <td style='border:none;'><span id='ok_report_basement_".$b->id."'></span><a href='javascript:inline_edit_basement(\"".$b->id."\");' style='text-decoration:none;' id='edit_report_basement_".$b->id."'><img title='Edit' src='/static/images/user_edit.png'/></a></td>
                            <td style='border:none;'><a href='javascript:inline_delete_basement(\"".$b->id."\");' style='text-decoration:none;' id='delete_report_base'><img title='Delete' src='/static/images/delete.png'/></a></td></tr>";
                }
        ?>
        </table>
   </div>
   <br/><a href="/user/report/add_to_basement" class="basement_box">Добавить</a>

  </td></tr>
</table>