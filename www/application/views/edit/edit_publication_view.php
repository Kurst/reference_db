<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<script type="text/javascript">
        
       
        $(function() {
             $(".author_box").colorbox({width:"500px", height:"300px"});

            if($(".title,.author_1").val()!='')
            {
                $("#button").removeAttr("disabled");
            }else
            {
                $("#button").attr("disabled","disabled");
            }

            $(".title,.author_1").blur(function(){
                    if($(".title").val()!='' && $(".author_1").val()!='')
                    {
                        $("#button").removeAttr("disabled");
                    }else
                    {
                        $("#button").attr("disabled","disabled");
                    }
        });

           $("#sp_field").mouseover(function(){

                    if($(".title").val()!='' && $(".author_1").val()!='')
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
<?=form::open_multipart('edit/publications/editing');?>
<input type="hidden" value ="<?=$id?>" name="id"/>
<label for="type">Тип</label><br/>
<select name="type" id="sel_type" onChange="select_edit_type(<?=$id?>);" class="wide_select">
	<?=$types?>
</select><br/><br/>
<label for="author">Авторы:</label>&nbsp;&nbsp;<span id ="error"></span><br/>
<div id="authors">
        <?=$authors?>
</div></div>

<a href="/edit/publications/add_author/<?=$id?>" class="author_box">добавить автора</a>
<br/><br/>
<label for="title">Заголовок*</label>&nbsp;&nbsp;<span id ="error"></span><br/>

<textarea class="title" name="title" id="title_field"><?=$title?></textarea><br/><br/>

<div id="special_fields">
  <?=$default_type?>
</div>

<label for="file">Файлы:</label><br/><br/>
<!--<input type="file"  name="file" size="50" /><br/><br/>-->
<div id="file_links">
<?=$file_links?>
</div>
<input type="hidden" name="files_counter" id="files_counter" value="0"/>

<div id="new_file_0">

</div>
<div id="f_loader" style="display:none;">
<img   src="/static/images/ajax-loader.gif"/><br/><br/></div>
<br/><a href="javascript:add_file_field_in_edit();" style="text-decoration:none;">добавить файл</a><br/><br/>
<label for="desc">О публикации</label><br/>
<textarea name="desc" id="field"><?=$description?></textarea><br/><br/>
<div id="sp_field" style="position:relative; width: 100%;">
        <div style="position: absolute; float:right; left:0;"><input type="submit" name="submit" id="button" value="Сохранить"/></div>
        <div style="position: absolute; right:1px;"><input type="button" name="cancel" id="button" value="Отмена" onClick="CancelButton();"/></div>
</div>


<?=form::close();?>
</td></tr>
</table>
</p>