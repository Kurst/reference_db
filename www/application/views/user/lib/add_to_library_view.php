<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<script type="text/javascript">
        var flag = 0;
        function showAddForm()
        {
                if(flag == 0)
                {
                         $('#add_list').slideDown();
                         $('#open').hide();
                         $('#close').show();
                         flag = 1;
                }else
                {
                         $('#add_list').slideUp();
                         $('#close').hide();
                         $('#open').show();
                         flag = 0;
                }

        }

        function addList()
        {

            var val = document.getElementById("new_list_name").value;

            if(val != '')
            {
                
                $.post(url+"user/lib/add_list_ajax", {name: val},function(data)
                {
                        alert('Добавлено');
                        $('#l_list').empty();
                        $('#l_list').append(data);
                        $('#add_list').slideUp();
                        $('#close').hide();
                        $('#open').show();
                        //parent.location=url +'user/lib';
                }
                );
            }else
            {
                alert('Заполните поле');
            }



        }


</script>

<p>
      <form name="add_to_lib">
              <input name="link_id" type="hidden" value="<?=$link_id?>"/>
      <select id="l_list" name ="list" style="width:200px;">
                <?=$list_options?>
        </select>&nbsp;&nbsp;&nbsp;<a href="javascript:showAddForm();"><img id="open" src='/static/images/add-icon.png' title='Добавить список'/></a>
                <a href="javascript:showAddForm();"><img id="close" src='/static/images/edit_remove.png' title='Скрыть' style='display: none;'/></a><br/>
        <div id="add_list" style="display: none;">
                        <input id="new_list_name" type="text" size="10" style="margin:0px"/>&nbsp;&nbsp;
                        <input type="button" value="ок" id="show_list" onClick="addList();"/>     
        </div>
       <br/><input type="button" value="Добавить" onClick="addToLibrary();" id="show_list"/>
        </form>
       
</p>


