<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<style>
   
    .verticaltable tr
    {
        height:50px;

    }
    .verticaltable td
    {
        border:1px solid #c4c0c0;
        padding-left: 0px;
        padding-top: 0px;
        padding-bottom: 0px;
       
    }

</style>
<h4><?=$user_name?></h4>
<table class ="verticaltable" id="tbl" width="800px" border="0">
    <tr>
                <th> № </th>
                <th>Наименование</th>
                <th>Выходные данные</th>
                <th>Кол-во страниц</th>
                <th>Фамилии авторов</th>
                
                
    </tr>
    <?
    $i=0;
   //die(print_r($publications));
    foreach($publications as $a)
    {
        $i++;
        $link = html::anchor(url::base().'tmp/'.$a['path_to_file'].'','<img src="/static/images/download.png" alt="Скачать" title="Скачать"');

	echo "<tr >
	<td width='20px'><center>".$i." </center></td>
	<td width='200px'><center> ".$a['title']." </center></td>
	<td><center> ".$a['output']." </center></td>
	<td width='50px'><center> ".$a['pages']." </center></td>
        <td width='200px'><center> ".$a['authors']." </center></td></tr>";



    }
    ?>
   
   
</table>
