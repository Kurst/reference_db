<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<script type="text/javascript">

        $(document).ready(function(){


                $(".org_box").colorbox({width:"300px", height:"300px"});
                });
   $(".city").live('mouseover',function()
   {
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
                //inline_save_city(li.extra[0]);
                 
        }
        });

        $(".date").live('mouseover',function()
        {
                $("#datepicker").datepicker( { dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true,yearRange: '1950:2000'} );

        });

 
 

</script>
<p>
        
Профиль |  <?=html::anchor(url::base().'user/report','Отчет');?>
    <table width="600px" border="0" class="verticaltable">
        <tr>

            <td align="left" width="120px"  class="verticaltable_td_1">Пользователь:</td>
            <td><?=$author->email?></td>
             <td> </td>

            <td width="90px" rowspan="3" align="center" valign="middle" style="padding:0px; border-left: 1px solid #c4c0c0;"><?=html::anchor('user/profile/avatar/'.$u_id,'<img src="'.url::base().'static/images/acl/avatars/'.$u_id.'/ava.png" />',array('class'=>'box-ava'))?></td>
        </tr>
        <tr>
                
            <td align="left" width="120px" class="verticaltable_td_1">Фамилия: </td>
            <td><span id="family"><?=$author->family?></span></td>
            <td> <a href="javascript:inline_edit('family');" style="text-decoration:none;" id="edit_family"><img title="Edit" src='/static/images/user_edit.png'/></a>
            <span id="ok_family"></span></td>
            
        </tr>
        <tr>
            <td align="left" width="120px" class="verticaltable_td_1">Имя:</td>
            <td><span id="name"><?=$author->name?></span></td>
            <td> <a href="javascript:inline_edit('name');" style="text-decoration:none;" id="edit_name"><img title="Edit" src='/static/images/user_edit.png'/></a>
            <span id="ok_name"></span></td>
            
        </tr>
        <tr>
            <td align="left" width="120px" class="verticaltable_td_1">Отчество:</td>
            <td><span id="patronymic"><?=$author->patronymic?></span></td>
             <td> <a href="javascript:inline_edit('patronymic');" style="text-decoration:none;" id="edit_patronymic"><img title="Edit" src='/static/images/user_edit.png'/></a>
             <span id="ok_patronymic"></span></td>
             <td width="90px"></td>
        </tr>
        <tr>
               
            <td align="left" width="120px"  class="verticaltable_td_1">Дата рождения:</td><td><span id="date"><?=$date?></span></td>
             <td><a href="javascript:inline_edit('date');" style="text-decoration:none;" id="edit_date"><img title="Edit" src='/static/images/user_edit.png'/></a>
             <span id="ok_date"></span></td>
              <td width="90px" ></td>
        </tr>
        <tr>
               
            <td align="left" width="120px"  class="verticaltable_td_1">Пол:</td><td><span id="sex"><?=$author->sex?></span></td>
             <td><a href="javascript:inline_edit('sex');" style="text-decoration:none;" id="edit_sex"><img title="Edit" src='/static/images/user_edit.png'/></a>
             <span id="ok_sex"></span></td>
            <td width="90px" ></td>
        </tr>
        
        <tr> 
            <td align="left" width="120px"  class="verticaltable_td_1">Город:</td>
            <td><span id="city"><?=$author->city?></span><input type="hidden" name="city_id" id="city_id" value="0"/></td>
             <td><a href="javascript:inline_edit('city');" style="text-decoration:none;" id="edit_city"><img title="Edit" src='/static/images/user_edit.png'/></a>
             <span id="ok_city"></span></td>
           <td width="90px" ></td>
        </tr>
        <tr>
            <td align="left" width="120px" class="verticaltable_td_1">Телефон:</td>
            <td><span id="telephone"><?=$author->telephone?></span></td>
             <td><a href="javascript:inline_edit('telephone');" style="text-decoration:none;" id="edit_telephone"><img title="Edit" src='/static/images/user_edit.png'/></a>
              <span id="ok_telephone"></span></td>
            <td width="90px" ></td>
        </tr>
        <tr>
            <td align="left" width="120px"  class="verticaltable_td_1">Сайт:</td>
            <td><span id="site"><?=$author->site?></span></td>
             <td> <a href="javascript:inline_edit('site');" style="text-decoration:none;" id="edit_site"><img title="Edit" src='/static/images/user_edit.png'/></a>
              <span id="ok_site"></span></td>
            <td width="90px" ></td>
        </tr>
    </table>
        <script type="text/javascript">
        $(".box-ava").colorbox({width:"290px", height:"190px"});


        </script>
    <br/>
   <!-- <h3>&nbsp;Организация</h3><hr/>
    <div id="org_name">
        <?//=$author->ORG?>
        </div>
        
        <br/>
        <a href="/set/profile/organization" class="org_box">Изменить</a><br/>-->

</p>


