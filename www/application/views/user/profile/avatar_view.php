<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<p>
        
        <?=form::open_multipart('user/profile/change_avatar');?>
        <input type="file"  name="ava" size="50" /><br/><br/>
        <input type="hidden" name="id" value="<?=$id?>"/>
        <input type="submit" name="submit" value="Сохранить"/>

        <?=form::close();?>

</p>


