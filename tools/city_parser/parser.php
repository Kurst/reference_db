<?php
include('simple_html_dom.php');

//$html = file_get_html('http://ru.wikipedia.org/wiki/%D0%A1%D0%BF%D0%B8%D1%81%D0%BE%D0%BA_%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D0%BE%D0%B2_%D0%A0%D0%BE%D1%81%D1%81%D0%B8%D0%B8_%D1%81_%D0%BD%D0%B0%D1%81%D0%B5%D0%BB%D0%B5%D0%BD%D0%B8%D0%B5%D0%BC_%D0%B1%D0%BE%D0%BB%D0%B5%D0%B5_100_%D1%82%D1%8B%D1%81%D1%8F%D1%87_%D0%B6%D0%B8%D1%82%D0%B5%D0%BB%D0%B5%D0%B9');
//foreach($html->find('a',54) as $e)
//{
/*for($i = 53;$i<200;$i 
$e = $html->find('a',54);
$re = mb_convert_encoding($e->plaintext,'CP1251','UTF-8');
echo $re . '';*/
//}
	$File = "city.csv"; 
	$Handle = fopen($File, 'w');
    $html = file_get_html('http://autotravel.ru/towns.php?l=5');
	$ret = $html->find('.travell5 a');
	$i = 0;
	$data = "";
	foreach($ret as $r)
	{
		$i++;
		$data .= "'".$i."';'".trim($r->plaintext)."'\n";	
	}
	$data = mb_convert_encoding($data,'UTF-8','CP1251');
	fwrite($Handle, $data);
	print $data;
	fclose($Handle);

?>