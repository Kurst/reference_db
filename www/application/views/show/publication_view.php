<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div id="head"> <h2><center>Подробные сведенья</center></h2><hr/></div>

<p>
   Авторы: <?=$authors?><br/><br/>
   <?=$output?>
   <h2>Описание:</h2>
    <?=$description?>
   <h2>Скачать:</h2>
        <?
        if(isset($links))
        {
             foreach($links as $l)
             {
                $ext = substr($l,strlen($l)-3,strlen($l));

                switch($ext)
                {
                    case 'doc':
                        $icon = "<img src='/static/images/word.png'/>";
                        break;
                    case 'pdf':
                        $icon = "<img src='/static/images/pdf.png'/>";
                        break;
                    case 'zip':
                        $icon = "<img src='/static/images/zip.png'/>";
                        break;
                    case 'rar':
                        $icon = "<img src='/static/images/zip.png'/>";
                        break;
                    case 'jpg':
                        $icon = "<img src='/static/images/image.png'/>";
                        break;
                    case 'peg':
                        $icon = "<img src='/static/images/image.png'/>";
                        break;
                    case 'png':
                        $icon = "<img src='/static/images/image.png'/>";
                        break;
                    default:
                        $icon = "<img src='/static/images/file.png'/>";
                        break;

                }
                echo "<br/>".$icon." ".html::anchor(url::base().'pub_storage/'.$id.'/'.$l,$l)."<br/>";
             }
        }

        ?>

</p>