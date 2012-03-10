

var url = document.getElementById('base_url').innerHTML;

function showDetails(id,type)
{
        $('#details').empty();
        $('#loader').show();
        $.post(url+"search/show_details", {id: id,type: type},function(data)
        {
                $('#loader').hide();
    		$('#details').empty();
                $('#details').append(data);
                //alert(data);
        }
        );
}
