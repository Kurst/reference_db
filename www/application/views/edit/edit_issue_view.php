<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<script type="text/javascript">
	$(function() {
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
<table class ="verticaltable" width="425px">
    <tr><td>
        <?=form::open('edit/issues/editing');?>
        <input type="hidden" name="id" value="<?=$form['id']?>"/>
        <label for="name">Название*</label>&nbsp;&nbsp;<span id ="error"><?=$errors["name"]?></span><br/>
        <input class="name" type='text' id="field" name='name' value="<?=$form['name']?>"/> <?=$errors['name']?><br/><br/>
        <label for="type">Тип</label><br/>
        <select name="type" class="wide_select">
                 <?=$form['type_options']?>
        </select><br/><br/>
        <label for="id_publisher">Издательство</label><br/>
        <select name="id_publisher" id="id_publisher" class="wide_select">
                <?=$form['issue_options']?>
        </select><br/><br/>
        <label for="date">Дата издания</label> &nbsp;&nbsp;<span id ="error"><?=$errors["date"]?></span><br/>
        <input type='text' id="pubdatepicker" name='date' size='10'  value="<?=$form['date']?>"/> <br/><br/>
        <label for="name">ISBN</label>&nbsp;&nbsp;<span id ="error"><?=$errors["isbn"]?></span><br/>
        <input type='text' id="field" name='isbn' value="<?=$form['isbn']?>"/> <br/><br/>
        <label for="name">ISSN</label>&nbsp;&nbsp;<span id ="error"><?=$errors["issn"]?></span><br/>
        <input type='text' id="field" name='issn' value="<?=$form['issn']?>"/><br/><br/>
        <label for="desc">Об издательстве</label><br/>
        <textarea name="desc" id="field"><?=$form['desc']?></textarea><br/><br/>
        <div id="sp_field" style="position:relative; width: 100%;">
        <div style="position: absolute; float:right; left:0;"><input type="submit" name="submit" id="button" value="Сохранить"/></div>
        <div style="position: absolute; right:1px;"><input type="button" name="cancel" id="button" value="Отмена" onClick="CancelButton();"/></div>
        </div>


        <?=form::close();?>
  </td></tr>
</table>
</p>