<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<script type="text/javascript">

    $(document).ready(function(){


        $(".org_box").colorbox({width:"300px", height:"300px"});

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

        if($(".family").val()!='' && $(".name").val()!='' && $(".patronymic").val()!='' && $(".date").val()!='' && $(".email").val()!='')
        {
            $("#button").removeAttr("disabled");
        }else
        {
            $("#button").attr("disabled","disabled");
        }

        $(".family,.name,.patronymic,.date,.email").blur(function(){
            if($(".family").val()!='' && $(".name").val()!='' && $(".patronymic").val()!='' && $(".date").val()!='' && $(".email").val()!='')
            {
                $("#button").removeAttr("disabled");

            }else
            {
                $("#button").attr("disabled","disabled");
            }
        });


        $("#sp_field").mouseover(function(){

            if($(".family").val()!='' && $(".name").val()!='' && $(".patronymic").val()!='' && $(".date").val()!='' && $(".email").val()!='')
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


        <?=form::open('edit/authors/editing');?>
        <input type="hidden" name="id" value="<?=$form['id']?>"/>
        <label for="family">Фамилия*</label> &nbsp;&nbsp;<span id ="error"><?=$errors["family"]?></span><br/>
        <input type='text' class="family" id="field" name='family' value="<?=$form['family']?>"/><br/><br/>
        <label for="name">Имя*</label> &nbsp;&nbsp;<span id ="error"><?=$errors["name"]?></span><br/>
        <input type='text' class="name" id="field" name='name' value="<?=$form['name']?>"/><br/><br/>
        <label for="patronymic">Отчество*</label> &nbsp;&nbsp;<span id ="error"><?=$errors["patronymic"]?></span><br/>
        <input type='text' class="patronymic" id="field" name='patronymic'value="<?=$form['patronymic']?>"/> <br/><br/>
        <label for="date">Дата рождения*</label> &nbsp;&nbsp;<span id ="error"><?=$errors["date"]?></span><br/>
        <input type='text' class="date" id="datepicker" name='date' size='10'  value="<?=$form['date']?>"/><br/><br/>
        <label for="date">Пол</label><br/>
        <select name="sex">
                <?
                    switch($form['sex'])
                    {
                        case 'man':
                            ?>
                                <option value="man" selected>М</option>
                                <option value="woman">Ж</option>
                            <?
                            break;
                        case 'woman':
                             ?>
                                <option value="man">М</option>
                                <option value="woman" selected>Ж</option>
                             <?
                            break;
                    }
                ?>
                
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
        <label for="org">Организация:</label><br/><br/>
        <div id="org_name">
        <?=$form['org']?>
        </div>
        <input type="hidden" name="org_id" id="org_id" value="<?=$form['org_id']?>"/>
        <br/>
        <a href="/edit/authors/organization" class="org_box">Изменить</a><br/>
        
       
        <div id="sp_field" style="position:relative; width: 100%;">
        <div style="position: absolute; float:right; left:0;"><input type="submit" name="submit" id="button" value="Сохранить"/></div>
        <div style="position: absolute; right:1px;"><input type="button" name="cancel" id="button" value="Отмена" onClick="CancelButton();"/></div>
        </div>


        <?=form::close();?>
    </td></tr>
</table>
</p>