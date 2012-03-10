<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<script type="text/javascript">
	
        $(function() {

            
            $(".author_box").colorbox({width:"500px", height:"300px"});
            $(".new_author_box").colorbox({width:"450px", height:"250px"});
           
            if($(".title").val()!='' && id_list!='')
            {
                $("#button").removeAttr("disabled");
            }else
            {
                $("#button").attr("disabled","disabled");
            }

            $(".title").blur(function(){
                    if($(".title").val()!='' && id_list!='')
                    {
                        $("#button").removeAttr("disabled");
                    }else
                    {
                        $("#button").attr("disabled","disabled");
                    }
        });

            $("#sp_field").mouseover(function(){

                    if($(".title").val()!='' && id_list!='')
                    {
                        $("#button").removeAttr("disabled");
                    }else
                    {
                        $("#button").attr("disabled","disabled");
                    }
        });

	});

         function unselect_author(id)
        {
                $.post(url+"add/publication/delete_author_from_ses", {id: id},function(data)
                {                    
                       $('#author_field').empty();
                       $('#author_field').append(data.res);
                       id_list = data.id_list;
                       name_list = data.name_list;
                       $('#author_string').val(id_list+',');
                },"json"
                );
        }
        function clear_author(id)
        {
                $.post(url+"add/publication/delete_new_author_from_ses", {id: id},function(data)
                {
                       $('#author_field').empty();
                       $('#author_field').append(data);
                      
                }
                );

        }
</script>
<p>
    <table class ="verticaltable" width="425px">
    <tr><td>
<?=form::open_multipart('add/publication/adding');?>
<label for="type">Тип</label><br/>
<select name="type" id="sel_type" onChange="select_type();" class="wide_select">
	<?=$select_types?>
</select><br/><br/>
<label for="author">Авторы*:</label>&nbsp;&nbsp;<span id ="error"><?=$errors["author_1"]?></span>
<?//=$fields_options?>
<!--<iframe id="i_f" src="/add/publication/add_author" width="400" height="150" align="left">
    Ваш браузер не поддерживает плавающие фреймы!
 </iframe>-->
<br/><br/>

<div id="author_field"></div>
<a href="/add/publication/add_author/" class="author_box"><img src="/static/images/search_select.png" />&nbsp;Выбрать из списка</a>
&nbsp;&nbsp;<a href="/add/publication/add_new_author/" class="new_author_box"><img src="/static/images/add_auth.png" />&nbsp;Добавить нового</a>
<br/><br/>
<!--Новое добавление -->
<input type="hidden" name="author_string" id="author_string" value=""/>
<!--<a href="javascript:add_author_field();" style="text-decoration:none;">+ добавить автора</a><br/><br/>-->
<label for="title">Заголовок*</label>&nbsp;&nbsp;<span id ="error"><?=$errors["title"]?></span><br/>

<textarea class="title" name="title" id="title_field"><?=$form['title']?></textarea><br/><br/>

<div id="special_fields">
  <?=$default_type?>
</div>

<label for="file">Прикрепить файл</label>
<!--<input type="file"  name="file" size="50" /><br/><br/>-->
<?=$file_fields?>
<br/><a href="javascript:add_file_field();" style="text-decoration:none;"><img src="/static/images/add_auth.png" />&nbsp;Добавить файл</a><br/><br/>
<label for="desc">О публикации</label><br/>
<textarea name="desc" id="field"><?=$form['desc']?></textarea><br/><br/>
<div id="sp_field">
<input type="submit" name="submit" id="button" value="Добавить"/>
</div>


<?=form::close();?>
</td></tr>
</table>
</p>