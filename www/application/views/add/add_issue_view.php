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
        <?=form::open('add/issue/adding');?>
        <label for="name">Название*</label>&nbsp;&nbsp;<span id ="error"><?=$errors["name"]?></span><br/>
        <input class="name" type='text' id="field" name='name' value="<?=$form['name']?>"/> <?=$errors['name']?><br/><br/>
        <label for="type">Тип</label><br/>
        <select name="type" class="wide_select">
                <?=$select_types?>
        </select><br/><br/>
        <label for="id_publisher">Издательство</label>&nbsp;&nbsp;<span id ="error"><?=$errors["type"]?></span><br/>
        <select name="id_publisher" id="id_publisher" class="wide_select">
                <?=$select_options?>
        </select><br/><br/>
        <label for="date">Дата издания</label> &nbsp;&nbsp;<span id ="error"><?=$errors["date"]?></span><br/>
        <input type='text' id="pubdatepicker" name='date' size='10'  value="<?=$form['date']?>"/> <br/><br/>
        <label for="name">ISBN</label>&nbsp;&nbsp;<span id ="error"><?=$errors["isbn"]?></span><br/>
        <input type='text' id="field" name='isbn' value="<?=$form['isbn']?>"/> <br/><br/>
        <label for="name">ISSN</label>&nbsp;&nbsp;<span id ="error"><?=$errors["issn"]?></span><br/>
        <input type='text' id="field" name='issn' value="<?=$form['issn']?>"/><br/><br/>
        <label for="desc">Об издательстве</label><br/>
        <textarea name="desc" id="field"><?=$form['desc']?></textarea><br/><br/>
        <div id="sp_field">
        <input type="submit" name="submit" id="button" value="Добавить"/>
        </div>


        <?=form::close();?>
  </td></tr>
</table>
</p>