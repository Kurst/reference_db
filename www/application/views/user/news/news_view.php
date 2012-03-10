<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<h1><?=$news->title?></h1><br/>

<p>
<?

if(!empty($news->content))
        {
                echo $news->content;
        }
        ?>

</p>