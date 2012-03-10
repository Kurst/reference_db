<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<script type="text/javascript">
        $(function() {
               
		$("#datepicker").datepicker( { dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true,yearRange: '1950:-20'} );
		
		$("#datepicker").datepicker($.datepicker.regional['ru']);
                 });


         function validateEmail(email)
         {
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                if( !emailReg.test(email) ) {
                        return false;
                } else {
                        return true;
                }
        }

         function addNewAuthor()
         {
                var name = $('#new_name').val();
                var family = $('#new_family').val();
                var patronymic = $('#new_patronymic').val();
                var date = $('#datepicker').val();
                var email = $('#email').val();
                var sex = $('#sex').val();
                if(name != '' && family != '' && email != '' && validateEmail(email))
                {
                        $.post(url+"add/publication/add_new_author_session", {name: name, family: family,patronymic: patronymic, date: date, email: email,sex: sex},
                        function(data)
                        {

                               if(data == 'duplicate')
                               {
                                       alert('Такой автор уже существует');
                               }else
                               {
                                       $('#author_field').empty();
                                       $('#author_field').append(data);
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
<table width="100%" align="center" style="font-size: 0.8em;">
        <tr>
                <td>
                        Имя*:<br/><input type="text" name="name" id="new_name" />
                </td>
                <td>
                        Фамилия*:<br/><input type="text" name="family" id="new_family" />
                </td>
        </tr>
        <tr>
                <td>
                        Отчество:<br/><input type="text" name="patronymic" id="new_patronymic"/>

                </td>
                <td>
                        Дата рождения:<br/><input type="text" class="date" id="datepicker" name='date' size='10'/>
                </td>
        </tr>
        <tr>
                <td>
                        Email*:<br/><input type="text" name="email" id="email"/>
                </td>
                <td>
                        Пол:<br/>
                        <select name="sex" id="sex">
                                <option value="man">М</option>
                                <option value="woman"> Ж </option>
                        </select>
                </td>
        </tr>
        <tr>
                <td colspan="2">
                        <input type="button" name="add" id="show_list" value="Добавить" onclick="addNewAuthor();"/>
                </td>

        </tr>

</table>
