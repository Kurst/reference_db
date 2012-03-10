<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<script type="text/javascript">
        var flag = 0;
        function showExport()
        {
                if(flag == 0)
                {
                         $('#export').slideDown();
                         $('#down').hide();
                         $('#up').show();
                         flag = 1;
                }else
                {
                         $('#export').slideUp();
                          $('#up').hide();
                         $('#down').show();
                         flag = 0;
                }

        }

        function setFormAction(target)
        {
                 document.exp_form.action = '/generator/'+target;
        }

        function submit()
        {
                var el = document.pubList;
            
                list = '';
                
                for(var i=0; i<el.id_sel.length;i++)
                {
                        
                        list += el.id_sel[i].value+',';
                }
                list = list.substr(0,list.length-3);
                document.exp_form.id_list.value = list;
                document.exp_form.report_header.value = el.report_header.value;
                document.exp_form.submit();
        }
</script>

<div id="export_label"><a href="javascript:showExport();">Экспорт&nbsp;<img id="down" src="/static/images/down.png" /><img id="up" src="/static/images/up.png" style="display: none;"/></a></div>  
<div id="export" style="display: none;">
      
       
        <form method="POST" action="/generator/pdf" name="exp_form" >
        <input name="type" type="radio" value="1" onClick="setFormAction('pdf');" checked> PDF<br/>
        <input name="type" type="radio" value="1" onClick="setFormAction('doc');"> Word<br/>
        <input name="type" type="radio" value="1" onClick="setFormAction('bib');"> BibTeX<br/><hr/>
        Вы можете выбрать стиль отчета в <?=html::anchor(url::base().'user/report','настройках')?><br/><br/>
        
        <input type="hidden" name="id_list" value=""/>
        <input type="hidden" name="report_header" value=""/>
        </form>

        <input type="button" onClick="submit();" name="exp" value="Скачать" id="show_list" style="margin-left:5px;"/>
       

</div>
<br/>