<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<table width='100%'>
	<tr><td>ID</td><td>Название</td></tr>
<?

foreach($org as $a)
{
	echo "<tr>
	<td>".$a['id']." </td>
	<td>".$a['name']." </td>
	</tr> ";
}


?>
</table>