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
<?=form::open_multipart('admin/users/save_user');?>
     <input type="hidden" name="id" value ="<?=$id?>"/>
    <table width="600px" border="0" class="verticaltable">
         <tr>

            <td align="left" width="120px"  class="verticaltable_td_1">Пользователь:</td>
            <td><?=$author->email?></td>
             <td> </td>
            
            <td width="90px" rowspan="3" align="center" valign="middle" style="padding:0px; border-left: 1px solid #c4c0c0;"><?=html::anchor('admin/users/avatar/'.$id,'<img src="'.url::base().'static/images/acl/avatars/'.$id.'/ava.png" />',array('class'=>'box-ava'))?></td>
        </tr>
        <tr>
            
            <td align="left" width="120px" class="verticaltable_td_1">Фамилия: </td>
            <td><input name="family" type="text" value="<?=$author->family?>"/></td>
            <td> 
            </td>
            
        </tr>
        <tr>
            <td align="left" width="120px" class="verticaltable_td_1">Имя:</td>
            <td><input name="name" type="text" value="<?=$author->name?>"/></td>
            <td> 
           </td>
            
        </tr>
        <tr>
            <td align="left" width="120px" class="verticaltable_td_1">Отчество:</td>
            <td><input name="patronymic" type="text" value="<?=$author->patronymic?>"/></td>
             <td> 
            </td>
            <td width="90px"></td>
           
        </tr>
        <tr>
               
            <td align="left" width="120px"  class="verticaltable_td_1">Дата рождения:</td>
            <td><input name="date" id="datepicker" type="text" value="<?=$author->date_of_birth?>"/></td>
             <td>
             </td>
              <td width="90px" ></td>
        </tr>
        <tr>
               
            <td align="left" width="120px"  class="verticaltable_td_1">Пол:</td>
            <td><select name="sex">
                        <?
                                if($author->sex == 'man')
                                {
                                        echo "<option value='man' selected>М</option>";

                                }else
                                {
                                        echo "<option value='man'>М</option>";
                                }

                                if($author->sex == 'woman')
                                {
                                        echo "<option value='woman' selected>Ж</option>";

                                }else
                                {
                                        echo "<option value='woman'>Ж</option>";
                                }
                        ?>
                </select></td>
             <td>
             </td>
            <td width="90px" ></td>
        </tr>
       
        <tr> 
            <td align="left" width="120px"  class="verticaltable_td_1">Город:</td>
            <td><input name="city" class="city" type="text" value="<?=$author->city?>"/><input type="hidden" name="city_id" id="city_id" value="0"/></td>
             <td>
             </td>
           <td width="90px" ></td>
        </tr>
        <tr>
            <td align="left" width="120px" class="verticaltable_td_1">Телефон:</td>
            <td><input name="phone" type="text" value="<?=$author->telephone?>"/></td>
             <td>
              </td>
            <td width="90px" ></td>
        </tr>
        <tr>
            <td align="left" width="120px"  class="verticaltable_td_1">Сайт:</td>
            <td><input name="site" type="text" value="<?=$author->site?>"/></td>
             <td> 
              </td>
            <td width="90px" ></td>
        </tr>
        <tr>
            <td align="left" width="120px" class="verticaltable_td_1">Статус:</td>
            <td>
                    <select name="active">
                        <?
                                if($author->active == '1')
                                {
                                        echo "<option value='1' selected>Активирован</option>";

                                }else
                                {
                                        echo "<option value='1'>Активирован</option>";
                                }

                                if($author->active == '0')
                                {
                                        echo "<option value='0' selected>Неактивирован</option>";

                                }else
                                {
                                        echo "<option value='0'>Неактивирован</option>";
                                }
                        ?>
                </select>

            </td>
             <td>
              </td>
            <td width="90px" ></td>
        </tr>
        <tr>
            <td align="left" width="120px" class="verticaltable_td_1">Группа безопасности:</td>
            <td>
                    <select name="group">
                            <?=$group_list?>
                            
                    </select>
            </td>
             <td>
              </td>
            <td width="90px" ></td>
        </tr>

    </table>
<input id="show_list" type="submit" value="Сохранить"/>
    <?=form::close();?>
        <script type="text/javascript">
        $(".box-ava").colorbox({width:"290px", height:"290px"});


        </script>
    <br/>
   <!-- <h3>&nbsp;Организация</h3><hr/>
    <div id="org_name">
        <?//=$author->ORG?>
        </div>
        
        <br/>
        <a href="/set/profile/organization" class="org_box">Изменить</a><br/>-->

</p>


