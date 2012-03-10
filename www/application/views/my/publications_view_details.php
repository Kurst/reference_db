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
<div id="head"><center><b>Подробные сведенья</b></center></div>
<div id="subhead">
        <?=$description?><br/>
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
                echo "<br/>".$icon." ".html::anchor(url::base().'pub_storage/'.$id.'/'.$l,$l,array("target"=>"_blank"))."<br/>";
             }
        }
       
        ?>
        <br/>
       
</div>

