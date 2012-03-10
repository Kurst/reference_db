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
                    <b>Email:</b>
                </td>
                <td >
                    <?=$email?>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Телефон:</b>
                </td>
                <td>
                    <?=$telephone?>
                </td>
            </tr>
             <tr>
                <td>
                    <b>Город:</b>
                </td>
                <td>
                    <?=$city?>
                </td>
            </tr>
             <tr>
                <td>
                    <b>Сайт:</b>
                </td>
                <td>
                    <?=$site?>
                </td>
            </tr>
        </table>
        
        <?
        
       
        ?>
        <br/>
       
</div>

