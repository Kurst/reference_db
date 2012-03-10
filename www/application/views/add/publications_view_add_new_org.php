<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<script type="text/javascript">
      
               
		
         function addNewOrg()
         {
                var name = $('input[name=new_name]').val();
                var type = $('select[name=new_type]').val();
                var parent = $('select[name=new_parent]').val();
                
                if(name != '')
                {
                        $.post(url+"add/publication/add_new_org_session", {name: name, type: type,parent: parent},
                        function(data)
                        {

                               if(data == 'duplicate')
                               {
                                       alert('Такая организация уже существует');
                               }else
                               {
                                       $('#org_field').empty();
                                       $('#org_field').append(data);
                                       $.colorbox.close();
                               }
                               
                            
                        }
                        );
                }else
                {
                        alert('Не все поля заполнены правильно');
                }
        }
         
</script>
<label for="name">Название*</label>&nbsp;&nbsp;<br/>
<input type='text' id="field" class="name" name="new_name" value=""/> <br/><br/>
<label for="type">Тип</label><br/>
<select name="new_type" class="wide_select">
                <option value="state">Государственная</option>
                <option value="private">Частная</option>
                <option value="mixed">Смешанная</option>
</select><br/><br/>
<label for="parent">Является подразделением</label><br/>
<select name="new_parent" id="select_org" class="wide_select">
                <?=$select_options?>
</select><br/><br/>
 <input type="button" name="add" id="show_list" value="Добавить" onclick="addNewOrg();"/>