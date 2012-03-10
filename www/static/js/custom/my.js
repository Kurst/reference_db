/**
name: Java Script functions for ires project
author: Ilya Semerhanov
**/
var url = document.getElementById('base_url').innerHTML;
//var url = "http://reference_db:3000/";

function select_org(level)
{
	var org = document.getElementById("org_lvl_"+level);
	var selected_id = org.options[org.selectedIndex].value;
        var selected_text = org.options[org.selectedIndex].text;
	$('#loader_'+level).show();
	if(selected_id != 0 && selected_text != 'Выберите' )
	{
		$.post(url+"add/author/check_sub_orgs", {id: selected_id,level: level},function(data)
		{
    		$('#loader_'+level).hide();
   			$("#sub_org_"+level).empty();
    		$("#sub_org_"+level).append(data);
 			//alert(data);
  	 	}
  		);
	}else
	{
		$('#loader_'+level).hide();
		$("#sub_org_"+level).empty();
	}
	
	
	
}

function select_type()
{
        var type = document.getElementById("sel_type");
        var selected_id = type.options[type.selectedIndex].value;
       // alert(selected_id);
        $.post(url+"add/publication/change_type", {id: selected_id},function(data)
        {
    		$('#special_fields').empty();
                $('#special_fields').append(data);
                //alert(data);
        }
        );
       
}

function select_edit_type(id)
{
        var type = document.getElementById("sel_type");
        var selected_id = type.options[type.selectedIndex].value;
       // alert(selected_id);
        $.post(url+"edit/publications/change_type", {sel_id: selected_id,id: id},function(data)
        {
    		$('#special_fields').empty();
                $('#special_fields').append(data);
                //alert(data);
        }
        );

}




function add_author_field()
{

	var num = $('#author_num').val();
	num = parseFloat(num);
	var next = num+1;
	$('#loader_'+num).show();
	$.post(url+"add/publication/add_author_field", {author_num: num},function(data)
		{
    		$('#loader_'+num).hide();
   			$("#new_author_"+num).empty();
   			$("#new_author_"+num).append(data);
   			$('#author_num').val(next);
   			/*$("#select_author_"+next).AddIncSearch({
        			maxListSize   : 20,
        			maxMultiMatch : 50,
       				warnNoMatch : 'нет',
        			selectBoxHeight : '20ex'
   					});*/
   			
    		
  	 	}
  		);
  	

}



function add_file_field()
{

	var num = $('#files_counter').val();
	num = parseFloat(num);
	var next = num+1;
	$('#f_loader_'+num).show();
	$.post(url+"add/publication/add_file_field", {files_counter: num},function(data)
		{
    		$('#f_loader_'+num).hide();
   			$("#new_file_"+num).empty();
   			$("#new_file_"+num).append(data);
   			$('#files_counter').val(next);
   			/*$("#select_author_"+next).AddIncSearch({
        			maxListSize   : 20,
        			maxMultiMatch : 50,
       				warnNoMatch : 'нет',
        			selectBoxHeight : '20ex'
   					});*/


  	 	}
  		);


}

function delete_author(id,pub_id,creator_id)
{
        
        $.post(url+"edit/publications/delete_author", {id: id,pub_id: pub_id,creator_id: creator_id},function(data)
        {
                
    		$('#authors').empty();
                $('#authors').append(data);
                //alert(data);
        }
        );
}

function delete_author_from_list(id)
{

        $.post(url+"add/publications/delete_author", {id: id},function(data)
        {

    		$('#authors').empty();
                $('#authors').append(data);
                //alert(data);
        }
        );
}

function delete_file(name,pub_id)
{

        $.post(url+"edit/publications/delete_file_link", {name: name, pub_id: pub_id},function(data)
        {

    		$('#file_links').empty();
                $('#file_links').append(data);
                //alert(data);
        }
        );
}

function add_file_field_in_edit()
{
        var num = $('#files_counter').val();
	num = parseFloat(num);
	var next = num+1;
	$('#f_loader').show();
	$.post(url+"edit/publications/add_file_field", {files_counter: num},function(data)
		{
    		$('#f_loader').hide();
   		$("#new_file_"+num).empty();
   		$("#new_file_"+num).append(data);
   		$('#files_counter').val(next);
   			
  	 	}
  		);
}

function delete_confirm(type,id)
{
        switch(type)
        {
                case 'org':

                        if (confirm("Удалить?"))
                        {
                                parent.location=url +'/delete/organizations/id/'+id;

                        }
                        break;
                case 'publisher':
                        if (confirm("Удалить?"))
                        {
                                parent.location=url +'/delete/publishers/id/'+id;

                        }

                        break;
                case 'issue':
                        if (confirm("Удалить?"))
                        {
                                parent.location=url +'/delete/issues/id/'+id;

                        }

                        break;
                case 'author':
                        if (confirm("Удалить?"))
                        {
                                parent.location=url +'/delete/authors/id/'+id;

                        }

                        break;
                case 'publication':
                        if (confirm("Удалить?"))
                        {
                                parent.location=url +'/delete/publications/id/'+id;

                        }

                        break;

                case 'user':
                        if (confirm("Удалить?"))
                        {
                                parent.location=url +'/admin/delete/user_id/'+id;

                        }

                        break;

                case 'group':
                        if (confirm("Удалить?"))
                        {
                                parent.location=url +'/admin/delete/group_id/'+id;

                        }

                        break;
        }

}


function deleteLibList()
{
        if (confirm("Удалить?"))
        {
                     var val = lib.list.options[lib.list.selectedIndex].value;
                    
                     $.post(url+"user/lib/delete_list", {id: val},function(data)
                    {
                            alert('Удалено');
                            $('#l_list').empty();
                            $('#l_list').append(data);
                            if(data == '')
                            {
                                    window.location.assign("/user/lib");
                            }
                           
                           
                    }
                    );
        }

}

function addLibList()
{

    var val = add_l.name.value;

    if(val != '')
    {
        $.colorbox.close();
        $.post(url+"user/lib/add_list_ajax", {name: val},function(data)
        {
                alert('Добавлено');
                parent.location=url +'user/lib';
        }
        );
    }else
    {
        alert('Заполните поле');
    }



}

function addToLibrary()
{

     var val = add_to_lib.l_list.options[add_to_lib.l_list.selectedIndex].value;
     var link = add_to_lib.link_id.value;
    
     $.post(url+"user/lib/add_to_library_ajax", {list_id: val,link_id: link},function(data)
    {
            alert('Добавлено');
            $.colorbox.close();
            //alert(data);
    }
    );


}


function approveNewPub(id)
{
       
        $.post(url+"my/publications/approve_decline", {action: 'approve',id: id},function(data)
        {
                
    		alert('Подтверждено');
                parent.location=url +'my/publications';
        }
        );
}

function declineNewPub(id)
{
        $.post(url+"my/publications/approve_decline", {action: 'decline',id: id},function(data)
        {

    		alert('Отменено');
                parent.location=url +'my/publications';
        }
        );
}


function changeReportType(type)
{
        $.post(url+"user/report/change_type", {type: type},function(data)
        {
                alert(data);

        }
        );
}


function delete_from_liblist(pub_id,list_id)
{
     $.post(url+"user/lib/delete_pub_from_list", {pub_id: pub_id,list_id: list_id},function(data)
        {

    		alert('Удалено');
            
                document.forms["lib"].submit();
        }
        );
}

function Delegate(id)
{
     var sel = $("#coauthors").val();
    
     $.post(url+"edit/publications/do_delegate", {auth_id: sel,id: id},function(data)
        {
            if(data != 'failed')
            {
                    alert('Выполнено');
                    $.colorbox.close();
            }else
            {
                    alert('Произошла ошибка');
            }

        }
        );
}


function removeDelegation(id,auth_id)
{
       $.post(url+"edit/publications/remove_delegate", {auth_id: auth_id,id: id},function(data)
        {
            if(data != 'failed')
            {
                    alert('Выполнено');
                    $.colorbox.close();
            }else
            {
                    alert('Произошла ошибка');
            }

        }
        );
}