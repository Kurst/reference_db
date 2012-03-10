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
    <tr><td >
            <span id ="error"> <? if(isset($org_exist)) echo $org_exist;?></span>
        <?=form::open('add/org/adding');?>
        <label for="name">Название*</label>&nbsp;&nbsp;<span id ="error"><?=$errors["name"]?></span><br/>
        <input type='text' id="field" class="name" name="name" value="<?=$form['name']?>"/> <br/><br/>

        <label for="type">Тип</label><br/>
        <select name="type" class="wide_select">
                <option value="state">Государственная</option>
                <option value="private">Частная</option>
                <option value="mixed">Смешанная</option>
        </select><br/><br/>
        <label for="parent">Является подразделением</label><br/>
        <select name="parent" id="select_org" class="wide_select">
                <?=$select_options?>
        </select><br/><br/>
        <label for="email">Email</label>&nbsp;&nbsp;<span id ="error"><?=$errors["email"]?></span><br/>
        <input type='text' id="field" name='email' value="<?=$form['email']?>"/> <br/><br/>
        <label for="phone">Телефон</label>&nbsp;&nbsp;<span id ="error"><?=$errors["phone"]?></span><br/>
        <input type='text' id="field" name='phone' value="<?=$form['phone']?>"/> <br/><br/>
        <label for="site">Сайт</label>&nbsp;&nbsp;<span id ="error"><?=$errors["site"]?></span><br/>
        <input type='text' id="field" name='site' value="<?=$form['site']?>"/><br/><br/>
        <label for="desc">Описание</label>&nbsp;&nbsp;<span id ="error"><?=$errors["desc"]?></span><br/>
        <textarea name="desc" id="field"><?=$form['desc']?></textarea> <br/><br/>

        <div id="sp_field">
        <input type="submit" name="submit" id="button" value="Добавить"/>
        </div>


        <?=form::close();?>
    </td></tr>
</table>
</p>