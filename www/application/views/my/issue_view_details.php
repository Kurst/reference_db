<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<style>
       
        #cont {
		
		color: #FFF;
                padding: 15px 15px;
		text-align:justify;
                white-space: pre-wrap;
                white-space: -moz-pre-wrap !important;
                white-space: -pre-wrap;
                white-space: -o-pre-wrap;
                word-wrap: break-word;
                

	}
       

</style>
<div id="head"> <h2><center>Подробные сведенья</center></h2><hr/></div>
<div>
        <p><?=$description?></p><br/>

        <table>

            <tr>
                <td>
                    <b>ISBN:</b>
                </td>
                <td >
                    <?=$isbn?>
                </td>
            </tr>
            <tr>
                <td>
                    <b>ISSN:</b>
                </td>
                <td>
                    <?=$issn?>
                </td>
            </tr>
             
        </table>
        
        <?
        
       
        ?>
        <br/>
       
</div>

