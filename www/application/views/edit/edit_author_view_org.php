<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<script type="text/javascript">
        function select(level)
        {
                var org = document.getElementById("org_lvl_"+level);
                var selected_id = org.options[org.selectedIndex].value;
                 var selected_text = org.options[org.selectedIndex].text;
                $('#loader_'+level).show();
                if(selected_id != 0 && selected_text != 'Выберите')
                {
                        $.post(url+"edit/authors/check_sub_orgs", {id: selected_id,level: level},function(data)
                        {
                                $('#loader_'+level).hide();
                                $("#sub_org_"+level).empty();
                                $("#sub_org_"+level).append(data);
                                $("#org_id_tmp").val(selected_id);

                              
                        }
                        );
                }else
                {
                        $('#loader_'+level).hide();
                        $("#sub_org_"+level).empty();
                }



        }

        function editOrg()
        {
                var id = $("#org_id_tmp").val();
                $.post(url+"edit/authors/changeOrg", {id: id},function(data)
                        {
                                $("#org_name").empty();
                                $("#org_name").append(data);
                                $("#org_id").val($("#org_id_tmp").val());
                        }
                        );
               
                $(".org_box").colorbox.close();
        }

</script>
<label for="org">Организация</label><br/>
<input type="hidden" name="org_id_tmp" id="org_id_tmp" value=""/>
<select name="org" id="org_lvl_1" onChange="select(1);" >
        <?=$select_options;?>
</select>

<div id="loader_1" style="display:none;"> <img   src="/static/images/ajax-loader.gif"/><br/><br/></div>
<div id="sub_org_1"></div>

<input type="button" value="Изменить" onClick="editOrg();"/>