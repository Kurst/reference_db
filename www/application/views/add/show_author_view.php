<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<table width='100%'>
	
<?

foreach($author as $a)
{
	echo "<tr>
	<td>".$a['id']." </td>
	<td>".$a['name']." </td>
	<td> ".$a['patronymic']." </td>
	<td> ".$a['family']." </td>
	<td> ".$a['date_of_birth']." </td>
	<td> ".$a['sex']." </td>
	<td> ".$a['city']." </td>
	<td> ".$a['email']." </td>
	<td> ".$a['telephone']." </td>
	<td> ".$a['description']."</td></tr> ";
}


?>
</table>