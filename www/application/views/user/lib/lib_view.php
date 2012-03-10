<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<script type="text/javascript">
        function submitForm()
        {
                var sel = $("#l_list").val();
              
                if(sel != null)
                {
                         document.forms["lib"].submit();
                }
               
        }
</script>
<p>
        <div  class ="vertical" style="width:265px;" >

        <?=form::open('user/lib/show',array('name'=>'lib'));?>
        Выберите список:
        <select id="l_list" name ="list" style="width:200px;">
                <?=$list_options?>
        </select>&nbsp;
        
        <?=html::anchor('user/lib/add_list',"<img src='/static/images/add-icon.png' title='Добавить список'/>",array('class'=>'box'))?>&nbsp;
        &nbsp;&nbsp;<a href="javascript:deleteLibList();" style="text-decoration:none;" id="edit_name"><img src='/static/images/delete-icon.png' title='Удалить список'/></a><br/>
         <input type="button" value="Показать" id="show_list" onClick="submitForm();"/>
        <?=form::close();?>
       
        <span id="lib_list_opt"></span>
        
        </div>
<script type="text/javascript">
        $(".box").colorbox({width:"230px", height:"150px"});
</script>
</p>


