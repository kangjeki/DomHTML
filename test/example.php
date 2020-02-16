<?php
require  __DIR__ . '/../autoload.php';
use DOMParserHTML\DOMParser;

$Doc 	= new DOMParser;
$input 	= $Doc->querySelector("input");
$exist 	= $Doc->value($input);

/* example select input value*/
echo "# Input Selector";
echo "<br>------------------------------------------------------------------------------ <br>";
echo $exist;
echo "<br>------------------------------------------------------------------------------ <br><br><br>";


/* example select table*/
$table 	= $Doc->querySelector("table");
$Table 	= new DOMParser($table);
$tr 	= $Table->querySelectorAll('tr');

echo "# Table Selector";
echo "<br>------------------------------------------------------------------------------ <br>";
var_dump($tr);

?>
<br><br>
<br><br>
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