<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<p>
        <?=form::open_multipart('admin/groups/adding');?>
        Мастер группа:<br/>
        <select name="master_group">
                <option value="0">...</option>
                <?

                        foreach($groups as $gr)
                        {
                                echo "<option value='".$gr->id."'>".$gr->fullname."</option>";
                        }
                ?>
        </select><br/><br/>
        Название:<br/>
        <input type="text"  name="name" size="50" /><br/><br/>
        Полное название:<br/>
        <input type="text"  name="fullname" size="50" /><br/><br/>
        Описание:<br/>
        <textarea name="desc"></textarea><br/>
        
        <input type="submit" id="show_list" name="submit" value="Сохранить"/>

        <?=form::close();?>

</p>


