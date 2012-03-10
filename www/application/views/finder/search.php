<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<?=form::open('finder/searcher/q');?>
 <div class ="vertical" >
        <table border="0">
         <tr>
                 
                 <td width="300px" valign="middle">
                       
                        <input type='text' name='query' id='search' value='<?=$query?>'/><br/>
                        
                        <div id="params">
                                <?=$params?>
                        </div>


                 </td>
                 <td valign="top">
                         <input  style="margin-top: -3px;" type="image" id="lupa" src="/static/images/search/search_green.png" value="html" alt="Submit"/>

                 </td>

         </tr>

        </table>

<?=form::close();?>
<br/>


<?=$result?>
<br/>

 </div>