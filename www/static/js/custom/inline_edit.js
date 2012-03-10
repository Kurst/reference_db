/* 
 * Inline edit JS
 * 
 */
var p = '';
var n = '';

function inline_edit(field)
{

        module = 'profile';
        var previous = $('#'+field).html();
        p = previous;
        
        $('#edit_'+field).hide();
        
        $('#'+field).empty();
        switch(field)
        {
                case 'name':
                case 'family':
                case 'patronymic':
                case 'telephone':
                case 'site':
                         $('#'+field).append('<input type="text" id="year" class="'+field+'" name="'+field+'"\n\
                                               value="'+previous+'" />');
                        var link = "<a href=\"javascript:inline_save('"+field+"','"+previous+"');\" \n\
                                    style=\"text-decoration:none;\" id='ok_family'><img title='Save' src='/static/images/button_ok.png'/></a>";
                        $('#ok_'+field).append(link);
                         break;
                case 'city':
                        
                        $('#'+field).append('<input class="'+field+'" id="year" type="text" name="'+field+'" value = "'+previous+'"/>');
                        var link = "<a href=\"javascript:inline_save_city();\" \n\
                                    style=\"text-decoration:none;\" id='ok_family'><img title='Save' src='/static/images/button_ok.png'/></a>";
                        $('#ok_'+field).append(link);
                        break;
                case 'sex':
                        data = '<select name="'+field+'" class="'+field+'"  onchange="inline_save(\''+field+'\',\''+previous+'\');">\n\
                                <option value="man" id="man">man</option><option value="woman" id="woman">woman</option></select>';
                        $('#'+field).append(data);
                        $('#'+previous).attr('selected','selected');
                        var link = "<a href=\"javascript:inline_save('"+field+"','"+previous+"');\" \n\
                                    style=\"text-decoration:none;\" id='ok_family'><img title='Save' src='/static/images/button_ok.png'/></a>";
                        $('#ok_'+field).append(link);
                        break;
                case 'date':
                        $('#'+field).append('<input type="text" id="datepicker" class="'+field+'" name="'+field+'"\n\
                                               value="'+previous+'" />');
                        var link = "<a href=\"javascript:inline_save('"+field+"','"+previous+"');\" \n\
                                    style=\"text-decoration:none;\" id='ok_family'><img title='Save' src='/static/images/button_ok.png'/></a>";
                        $('#ok_'+field).append(link);
                         
                        break;

               case 'report_name':
                        $('#'+field).append('<input style="width:250px;" type="text" id="year" class="'+field+'" name="'+field+'"\n\
                                               value="'+previous+'" />');
                        var link = "<a href=\"javascript:inline_report_save('"+field+"','"+previous+"');\" \n\
                                    style=\"text-decoration:none;\" id='ok_family'><img title='Save' src='/static/images/button_ok.png'/></a>";
                        $('#ok_'+field).append(link);
                        break;
        }
       
        
}

function inline_save(field,previous)
{
        var newval = $('.'+field).val();
        
        $('#ok_'+field).empty();
        $('#edit_'+field).show();
        $('#'+field).empty();
        
        $.post(url+"user/profile/inline_edit", {field_type: field,prev: previous, newv: newval},function(data)
        {
                if(data == 'true')
                {

                        $('#'+field).append(newval);
                }else
                {
                        $('#'+field).append(previous);
                }
                
        }
        );
       
        
}

function inline_save_city()
{
         n = $(".city").val();
         id = $("#city_id").val();
         $('#ok_city').empty();
         $('#edit_city').show();
         $('#city').empty();
         $('#city').append(n);
         
         $.post(url+"user/profile/inline_edit", {field_type: 'city',prev: p, newv: id},function(data)
         {
                
         }
         );


         module = '';
       
}


function inline_report_save(field,previous)
{
        var newval = $('.'+field).val();

        $('#ok_'+field).empty();
        $('#edit_'+field).show();
        $('#'+field).empty();

        $.post(url+"user/report/inline_edit", {field_type: field,prev: previous, newv: newval},function(data)
        {

                
                if(data == 'true')
                {
                       
                        $('#'+field).append(newval);
                }else
                {
                        $('#'+field).append(previous);
                }

        }
        );


}


function inline_delete_basement(id)
{
         $.post(url+"user/report/inline_delete_basement", {id: id},function(data)
        {
                        $('#basement').empty();
                        $('#basement').append(data);

        }
        );
}


function inline_edit_basement(id)
{
        module = 'profile';
        var pos_previous = $('#report_pos_'+id).html();
        var fio_previous = $('#report_fio_'+id).html();
      //  p = previous;

        $('#edit_report_basement_'+id).hide();

        $('#report_pos_'+id).empty();
        $('#report_fio_'+id).empty();

        $('#report_pos_'+id).append('<textarea class="pos_'+id+'" style="height:80px;" id="pos_'+id+'" name="pos_'+id+'">'+pos_previous+' </textarea>');

        $('#report_fio_'+id).append('<input type="text" class="fio_'+id+'" id="fio_'+id+'" name="fio_'+id+'"\n\
                               value="'+fio_previous+'" />');
        var link = "<a href=\"javascript:inline_basement_save('"+id+"');\" \n\
                    style=\"text-decoration:none;\" id='"+id+"'><img title='Save' src='/static/images/button_ok.png'/></a>";
        $('#ok_report_basement_'+id).append(link);
       


}

function inline_basement_save(id)
{
        var newval_pos = $('.pos_'+id).val();
        var newval_fio = $('.fio_'+id).val();

        $('#ok_report_basement_'+id).empty();
        $('#edit_report_basement_'+id).show();
        $('#report_pos_'+id).empty();
        $('#report_fio_'+id).empty();

        $.post(url+"user/report/inline_basement_edit", {id: id, newv_pos: newval_pos,newv_fio: newval_fio},function(data)
        {

                    $('#report_pos_'+id).append(newval_pos);
                    $('#report_fio_'+id).append(newval_fio);

        }
        );


}

function addToBasement()
{
        var newval_pos = $('#pos_new').val();
        var newval_fio = $('#fio_new').val();
        if(newval_pos != '' && newval_fio != '')
        {
                 $.post(url+"user/report/inline_add_to_basement", {new_pos: newval_pos, new_fio:newval_fio},function(data)
                {


                }
                );
                window.location.href = url+"/user/report";
        }else
        {
                $(".add_to_basement_box").colorbox.close();
        }

         


}

