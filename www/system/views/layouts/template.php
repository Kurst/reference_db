<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?=html::specialchars($title)?></title>
        <div id="base_url" style="display: none;"><?=url::base()?></div>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />

	<meta name="robots" content="index, follow" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="<?=url::base()?>static/css/style.css" type="text/css" />
	<link rel="stylesheet" href="<?=url::base()?>static/css/redmond/jquery-ui-1.8.custom.css" type="text/css" />
        <link rel="stylesheet" href="<?=url::base()?>static/css/menu_style.css" type="text/css" />
        <link rel="stylesheet" href="<?=url::base()?>static/css/autocomplete.css" type="text/css" />
        <link rel="stylesheet" href="<?=url::base()?>static/css/colorbox.css" type="text/css" />
	<script src="<?=url::base()?>static/js/jquery-1.4.2.min.js" type="text/javascript" ></script>
	<script src="<?=url::base()?>static/js/jquery-ui-1.8.custom.min.js" type="text/javascript" ></script>
	<script src="<?=url::base()?>static/js/jquery.ui.datepicker.js" type="text/javascript" ></script>
	<script src="<?=url::base()?>static/js/jquery.ui.datepicker-ru.js" type="text/javascript" ></script>
	<script src="<?=url::base()?>static/js/custom/my.js" type="text/javascript" ></script>
        <script src="<?=url::base()?>static/js/custom/inline_edit.js" type="text/javascript" ></script>
        <script src="<?=url::base()?>static/js/jquery.autocomplete.js" type="text/javascript" ></script>
        <script src="<?=url::base()?>static/js/menu.js" type="text/javascript" ></script>
        <script src="<?=url::base()?>static/js/jquery.colorbox.js" type="text/javascript" ></script>
        <script src="<?=url::base()?>static/js/jquery.uitablefilter.js" type="text/javascript" ></script>
        <script src="<?=url::base()?>static/js/jquery.qtip-1.0.0-rc3.min.js" type="text/javascript" ></script>
        <script src="<?=url::base()?>static/js/highcharts/highcharts.js" type="text/javascript" ></script>
        <script src="<?=url::base()?>static/js/jquery.contextmenu.js" type="text/javascript" ></script>
     
	<script type="text/javascript">
      
       
	function CancelButton()
        {
                history.back(1);
        }
        
        function clickSearch()
        {
                v = $("#topsearch").val();
                if(v=='Поиск...')
                {
                        $("#topsearch").val('');
                }
        }

        function searchInputValue(type,el)
        {
                
                if(type=='focus')
                {
                        if(el.value=='Поиск...') el.value='';
                        $("#topsearch").css({color:'#000'});
                       
                }else
                {
                        if(el.value==''){
                                el.value='Поиск...';
                                $("#topsearch").css({color:'#ccc'});
                        }
                        
                }

               

        }

	$(function() {
              
		$("#datepicker").datepicker( { dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true,yearRange: '1950:-20'} );
		//$("#datepicker").datepicker( { } );
		$("#datepicker").datepicker($.datepicker.regional['ru']);
		$("#pubdatepicker").datepicker( { dateFormat: 'yy-mm-dd',changeMonth: true,changeYear: true,yearRange: '-40:+1'} );
		//$("#datepicker").datepicker( { } );
		$("#pubdatepicker").datepicker($.datepicker.regional['ru']);
                
		//$("#accordion_menu").accordion();
                initMenu();

                var theTable = $('table.food_planner')

                theTable.find("tbody > tr").find("td:eq(1)").mousedown(function(){
                 $(this).prev().find(":checkbox").click()
                 });

                 $("#filter").keyup(function() {
                     alert('d');
                    $.uiTableFilter( theTable, this.value );
                 })

                 $('#filter-form').submit(function(){
                 theTable.find("tbody > tr:visible > td:eq(1)").mousedown();
                 return false;
                 }).focus(); //Give focus to input field


                        });
	</script>
	<script type="text/javascript">
$(document).ready(
  function()
  {
  	$(".listtable tr").mouseover(function() {
  		$(this).addClass("over");
  	});
  
  	$(".listtable tr").mouseout(function() {
  		$(this).removeClass("over");
  	});
  	
  	$(".listtable tr:even").addClass("alt");

        
  }
);
</script>

    <!--[if lt IE 7]>
    <style media="screen" type="text/css">
    .col1 {
	    width:100%;
	}
    </style>
    <![endif]-->
</head>
<body >

        <form name = "test" action="ss" method="post">
                <input type="hidden" value="123" name="hid"/>

        </form>
<div id="header" style="position:relative; height: 40px;">
        <div style="position:absolute; float: right; left: 0;"> <?=html::anchor('user/home','<img id="logo" src="/static/images/itmologo.png" />')?></div>
        <div  style="position:absolute; right: 2px;">
         <?=form::open('finder/searcher/q');?>
         <table border="0" cellpadding="0" cellspacing="0">
         <tr>

                 <td valign="middle" align="right">
                        <input id="topsearch" style="color:#ccc; margin-top: -1px;margin-right: -5px;" type='text' name='query' value='Поиск...'
                               onBlur="searchInputValue('blur',this)" onfocus ="searchInputValue('focus',this)"/><br/>
                        <input type="hidden" value="0" name="type"/>
                 </td>
                 <td valign="top" align="left">
                         <input style="" type="image" src="/static/images/search/search_green_small.png" value="html" alt="Submit" onClick="clickSearch()" />
                 </td>
         </tr>
        </table>
        <?=form::close();?>
        </div>
    
   
  
	

</div>
<p id="layoutdims">Добро пожаловать, <?=Acl::fullname();?>&nbsp;<?=html::anchor(url::base().'logout','Выйти');?></p>
<div class="colmask leftmenu">
    <div class="colright">
        <div class="col1wrap">
            <div class="col1">
                <!-- Column 2 start -->
                <h3><? if(isset($view)) echo html::specialchars($sub_title)?></h3><hr/>
				<p>
                          
                <table width="100%" >
                        <tr>
                                <td >
                <?
		//if(isset($content)) echo $content;
                        if(isset($view)) echo $view;
                       
		?>
                                </td>
                                <td valign="top" >
                                       <!-- <div id="manual">
                                                Справочная информация
                                        </div>-->
                                </td>
                        </tr>
                </table>
			
			
				</p>
				<!-- Column 2 end -->
            </div>
        </div>
        <div class="col2">
            <!-- Column 1 start -->
            
            <div id="accordion_menu">

                        <?php
                               // MainMenu::Create();

                        ?>
	    </div>

            <ul id="menu">
                     <?php
                                MainMenu::Create();

                        ?>
            </ul>

         
			<!-- Column 1 end -->

        </div>
    </div>
</div>
<div id="footer">
    <p>Загружена за {execution_time} секунд, используя {memory_usage} памяти. RefDB v. <?=Kohana::config('config.version')?><br />
	
	</p>

</div>



</body>
</html>
