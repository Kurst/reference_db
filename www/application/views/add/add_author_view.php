<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<script type="text/javascript">
	
    $(document).ready(function(){
        
        

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

        if($(".family").val()!='' && $(".name").val()!='' && $(".email").val()!='')
        {
            $("#button").removeAttr("disabled");
        }else
        {
            $("#button").attr("disabled","disabled");
        }

        $(".family,.name,.patronymic,.date,.email").blur(function(){
            if($(".family").val()!='' && $(".name").val()!='' && $(".email").val()!='')
            {
                $("#button").removeAttr("disabled");
                
            }else
            {
                $("#button").attr("disabled","disabled");
            }
        });
     

        $("#sp_field").mouseover(function(){

            if($(".family").val()!='' && $(".name").val()!='' && $(".email").val()!='')
            {
                $("#button").removeAttr("disabled");

            }else
            {
                $("#button").attr("disabled","disabled");
            }
        });

        $("#button").mouseover(function(){
           
            if($('.city').val()=='')
            {
                $('#city_id').val('111111');
            }

          
        });

    });
    function selectItem(li)
    {
        $("#city_id").val(li.extra[0]);
    }


</script>
<p>
<table class ="verticaltable" width="425px">
    <tr><td >
         <span id ="error"> <? if(isset($author_exist)) echo $author_exist;?></span>

        <?=form::open('add/author/adding');?>
        <label for="family">Фамилия*</label> &nbsp;&nbsp;<span id ="error"><?=$errors["family"]?></span><br/>
        <input type='text' class="family" id="field" name='family' value="<?=$form['family']?>"/><br/><br/>
        <label for="name">Имя*</label> &nbsp;&nbsp;<span id ="error"><?=$errors["name"]?></span><br/>
        <input type='text' class="name" id="field" name='name' value="<?=$form['name']?>"/><br/><br/>
        <label for="patronymic">Отчество</label> &nbsp;&nbsp;<span id ="error"><?=$errors["patronymic"]?></span><br/>
        <input type='text' class="patronymic" id="field" name='patronymic'value="<?=$form['patronymic']?>"/> <br/><br/>
        <label for="date">Дата рождения</label> &nbsp;&nbsp;<span id ="error"><?=$errors["date"]?></span><br/>
        <input type='text' class="date" id="datepicker" name='date' size='10'  value="<?=$form['date']?>"/><br/><br/>
        <label for="date">Пол</label><br/>
        <select name="sex">
                <option value="man">М</option>
                <option value="woman">Ж</option>
        </select><br/><br/>
        <label for="email">Email*</label>  &nbsp;&nbsp;<span id ="error"><?=$errors["email"]?></span><br/>
        <input type='text' class="email" id="field" name='email' value="<?=$form['email']?>"/> <br/><br/>
        <label for="city">Город</label><br/>

        <input class="city" id="field" type="text" name="city" value="<?=$form['city']?>"/><input name="city_id" id="city_id" type="hidden" value="<?=$form['city_id']?>"/><br/><br/>


        <label for="phone">Телефон</label> &nbsp;&nbsp;<span id ="error"><?=$errors["phone"]?></span><br/>
        <input type='text' id="field" name='phone' value="<?=$form['phone']?>"/><br/><br/>
        <label for="site">Сайт</label> &nbsp;&nbsp;<span id ="error"><?=$errors["site"]?></span><br/>
        <input type='text' id="field" name='site' value="<?=$form['site']?>"/><br/><br/>
        <label for="auth">Об авторе</label><br/>
        <textarea name="desc" id="field"><?=$form['desc']?></textarea><br/><br/>
        <label for="org">Организация</label><br/>
        <select name="org" id="org_lvl_1" onChange="select_org(1);" class="wide_select" >
                <?=$select_options;?>
        </select><br/><br/>
        <div id="loader_1" style="display:none;"> <img   src="/static/images/ajax-loader.gif"/><br/><br/></div>
        <div id="sub_org_1"></div>
        <div id="sp_field">
        <input type="submit" name="submit" id="button" value="Добавить"/>
        </div>


        <?=form::close();?>
    </td></tr>
</table>
</p>