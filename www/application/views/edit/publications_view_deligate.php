<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<style>
        #head
        {
                background: #464646;
                color: #fff;
                padding-top: 10px;
                padding-bottom: 10px;
              
        }
        #subhead
        {
                background: #efefef;
                padding-left: 5px;
                padding-top: 10px;
                
        }
       
        #editors_list td
        {
                height: 30px;
                background: #dbdbdb;
        }
       

</style>


<div id="head"><center><b>Публикация</b></center><br/>
<center>"<?=$title?>"</center></div>
<div id="subhead">
&nbsp;Могут редактировать: <br/>
<table id="editors_list" border="0" width="100%">
        <tr>
                <td colspan="2">
                      <?= $creator[0]->family.' '.$creator[0]->name.' '.$creator[0]->patronymic;?>
                </td>
                
        </tr>
       
        <?
                foreach($all_coauthors as $coauth)
                {

                        echo '<tr><td colspan="2">';
                        echo $coauth->family.' '.$coauth->name.' '.$coauth->patronymic;
                        echo '</td></tr>';
                }
                foreach($delegate_authors as $dauth)
                {
                        echo '<tr><td>';
                        echo $dauth->family.' '.$dauth->name.' '.$dauth->patronymic;
                        echo '<td width="30px" align="center"><a href="javascript:void(0)" onClick="removeDelegation('.$id.','.$dauth->id.'); return false;"><img src="/static/images/delete.png" /></a></td></tr>';
                }
        ?>
</table><br/>
&nbsp;Делегировать права на редактирование: <br/>

<select id="coauthors">
        <?
                       
                        foreach($all_authors as $key => $auth)
                        {
                                if(in_array($auth,$all_coauthors))
                                {  
                                        unset($all_authors[$key]);      
                                }
                                if(in_array($auth,$creator))
                                {
                                        
                                        unset($all_authors[$key]);
                                       
                                }
                                if(in_array($auth,$delegate_authors))
                                {

                                        unset($all_authors[$key]);

                                }
                        }
                        
                        if(empty($all_authors))
                        {
                                echo "<option value='0'>Нет доступных соавторов</option>";
                        }else
                        {
                               foreach($all_authors as $auth)
                                {
                                        echo "<option value = '".$auth->id."'>".$auth->family.' '.$auth->name.' '.$auth->patronymic."</option>";
                                }
                        }
                        
           
               
        ?>
</select>
<input type="button" value="Делегировать" onClick="Delegate('<?=$id?>');"/>
</div>

