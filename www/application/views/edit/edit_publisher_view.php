<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
	
<script type="text/javascript">
	$(function() {

            $(".city").autocomplete(url+"add/author/get_cities", {
                delay:10,
                autoFill:true,
                minChars:1,
                matchSubset:1,
                autoFill:true,
                matchContains:1,
                cacheLength:10,
                selectFirst:true,
                maxItemsToShow:10,
                onItemSelect:selectItem

            });

            function selectItem(li)
            {
                $("#city_id").val(li.extra[0]);
            }


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
        <?=form::open('edit/publishers/editing');?>
        <input type="hidden" name="id" value="<?=$form['id']?>"/>
        <label for="name">Название*</label>&nbsp;&nbsp;<span id ="error"><?=$errors["name"]?></span><br/>
        <input class="name" type='text' id="field" name='name' value="<?=$form['name']?>"/><br/><br/>
        <label for="city">Город</label><br/>

        <input class="city" id="field" type="text" name="city" value="<?=$form['city']?>"/><input name="city_id" id="city_id" type="hidden" value="<?=$form['city_id']?>"/><br/><br/>
        <label for="phone">Телефон</label>&nbsp;&nbsp;<span id ="error"><?=$errors["phone"]?></span><br/>
        <input type='text' id="field" name='phone' value="<?=$form['phone']?>"/> <br/><br/>
        <label for="site">Веб-сайт</label><br/>
        <input type='text' id="field" name='site' value="<?=$form['site']?>"/> <br/><br/>
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