<?php

$dir = dirname(__FILE__);
require_once $dir . '/../lib/PHPRtfLite.php';

// register PHPRtfLite class loader
PHPRtfLite::registerAutoloader();

$rtf = new PHPRtfLite();
$sect = $rtf->addSection();
$sect->writeText(iconv("CP1251", "UTF-8",'<i>Привет <b>Мир</b></i>.'), new PHPRtfLite_Font(12), new PHPRtfLite_ParFormat(PHPRtfLite_ParFormat::TEXT_ALIGN_CENTER));

// save rtf document
$rtf->sendRtf('Hello_World'); 