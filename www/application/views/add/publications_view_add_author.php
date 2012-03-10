<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<script type="text/javascript">
        <?
                if(empty($id_list))
                {
                        ?>
                            var id_list = '';
                            var name_list ='';
                        <?
                }else
                {
                        ?>
                            var id_list = '' + '<?=$id_list?>' + ',';
                            var name_list ='' + '<?=$name_list?>' + ',';
                        <?
                }
        ?>
	$(function() {
		var theTable = $('table.authors_table')

                theTable.find("tbody > tr").find("td:eq(1)").mousedown(function(){
                 $(this).prev().find(":checkbox").click()
                 });

                 $("#filter").keyup(function() {
                     
                    $.uiTableFilter( theTable, this.value );
                 })

                 $('#filter-form').submit(function(){
                 theTable.find("tbody > tr:visible > td:eq(1)").mousedown();
                 return false;
                 }).focus(); //Give focus to input field


                        });

         function addAuthors()
         {
              
          
                id_list = id_list.substr(0,id_list.length - 1);
                name_list = name_list.substr(0,name_list.length - 1);
                $.post(url+"add/publication/add_author_session", {id_list: id_list, name_list: name_list},function(data)
                {
                     
                       $('#author_field').empty();
                       $('#author_field').append(data);
                       $.colorbox.close();
                      // window.parent.location = "/add/publication";
                }
                );

         }

        function addToList(obj,name)
        {
                var str = obj.value + ',';
                name = name +',';

                if(obj.checked)
                {
                       if(id_list.indexOf(str) == -1)
                       {
                               id_list += str;
                               name_list += name;
                       }
                }else
                {
                        if(id_list.indexOf(str) >=0)
                        {
                                id_list = id_list.substr(0,id_list.indexOf(str)) + id_list.substr((id_list.indexOf(str)+str.length),id_list.length);
                                name_list = name_list.substr(0,name_list.indexOf(name)) + name_list.substr((name_list.indexOf(name)+name.length),name_list.length);
    
                        }
                }
                
              parent.id_list = id_list;
              parent.$('#author_string').val(parent.id_list);
              if(id_list =='')
              {
                      parent.$("#button").attr("disabled","disabled");
              }else
              {
                      if(parent.$(".title").val()!='')
                      {
                          $("#button").removeAttr("disabled");
                      }
              }
        }

       
	</script>


<form id="filter-form">Фильтр: <input name="filter" id="filter" value="" maxlength="30" size="30" type="text"></form><br>
<input type="button" value="Добавить" onClick="addAuthors();"/>
<table class="authors_table" width="100%" >
        <thead><tr style="background-color: #464646; color:#fff;"><th colspan="2">Авторы</th><tr></thead>
    <tbody><tr style="display: table-row;"></tr>
            <?
             
                $i = 0;
                foreach($authors as $a)
                {
                        $i++;
                        echo "<tr  style='background-color: #ccc;'>
                                 <td width='30px'>";
                       
                        if(empty($ids))
                        {
                                $ids = array();
                        }
                        if(in_array($authors_id[$i-1],$ids))
                        {
                                echo "<input name='author_".$i."' value='".$authors_id[$i-1]."' type = 'checkbox' checked onClick='addToList(this,\"".$a."\");'/>";
                        }else
                        {
                                echo "<input name='author_".$i."' value='".$authors_id[$i-1]."' type = 'checkbox' onClick='addToList(this,\"".$a."\");'/>";
                        }


                              echo " </td>
                                 <td>
                                        ".$a."
                                 </td>
                              </tr>";
                }

            ?>


    </tbody>
</table>
<input type="button" value="Добавить" onClick="addAuthors();"/><br><br>


