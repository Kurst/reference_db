<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<style>
    #pub_tab1_active{
        width:120px;
        height:25px;
        background-color: #fff;
        font-size:0.9em;
        padding-left:15px;
        padding-top:5px;
        padding-right:15px;
        border:1px solid #9E9E9E;
        border-bottom:0px;
        overflow: auto;
        position: absolute;
        margin-top: 5px;
    }
    #pub_tab1{
        width:120px;
        height:24px;
        background-color: #eeeeff;
        font-size:0.9em;
        padding-left:15px;
        padding-top:5px;
        padding-right:15px;
        border:1px solid #9E9E9E;
        border-right:0px;
        border-right:0px;
        position: absolute;
        margin-top: 5px;
    }

    #pub_tab2_active{
        width:100px;
        height:25px;
        background-color: #fff;
        font-size:0.9em;
        padding-left:15px;
        padding-top:5px;
        padding-right:15px;
        border:1px solid #9E9E9E;
        border-bottom:0px;
        position: absolute;
        margin-top: 5px;
        margin-left: 131px;
    }

     #pub_tab2{
        width:100px;
        height:24px;
        background-color: #eeeeff;
        font-size:0.9em;
        padding-left:15px;
        padding-top:5px;
        padding-right:15px;
        border:1px solid #9E9E9E;
        border-left: 0px;
        
        overflow: auto;
        position: absolute;
        margin-top: 5px;
        margin-left: 152px;
    }
    #tbl{
         margin-top: 35px;
    }
    a{
        text-decoration: none;
        color:#000;
    }
    

</style>

<?

if(!isset($tab)){?>

<a href="<?=url::base()?>my/publications"><div id="pub_tab1_active">
    Список публикаций
</div></a>
<a href="<?=url::base()?>my/publications/all"><div id="pub_tab2">
    &nbsp;&nbsp;Редактировать
</div></a>
<?
    }else
    {?>
    <a href="<?=url::base()?>my/publications"><div id="pub_tab1">
    Список публикаций
</div></a>
<a href="<?=url::base()?>my/publications/all"><div id="pub_tab2_active">
    &nbsp;&nbsp;Редактировать
</div></a>
    <?}?>
<table class ="verticaltable" id="tbl" width="800px" border="0">
    <?
    die(print_r($publications));
    foreach($publications as $p)
    {?>
      <tr>
        <td width="250px">
           Авторы
        </td>
        <td width="300px"><?=$p['title']?></td>
         <td width="250px">Издательство</td>

     </tr>
    <?}
    ?>
   
   
</table>
