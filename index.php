<?php
require  __DIR__ . '/DOMParserHTML/Autoload.php';
use DOMParserHTML\Parser\DOMParser;

$Doc 	= new DOMParser;
$input 	= $Doc->querySelector("input");
$exist 	= $Doc->value($input);

//echo $input;

$table 	= $Doc->querySelector("table");

$Table 	= new DOMParser($table);
$tr 	= $Table->querySelectorAll('tr');
var_dump($tr);

?>

<div class="parser">
	<input type="text" name="test" class="oke" value="abc">
</div>
<br><br>
<table border="1" cellpadding="2" cellspacing="0" style="width: 200px;">
	<tr>
		<td>a</td>
		<td>b</td>
	</tr>
	<tr>
		<td>c</td>
		<td>d</td>
	</tr>
</table>