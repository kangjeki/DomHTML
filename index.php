<?php
require  __DIR__ . '/DOMParserHTML/Autoload.php';
use DOMParserHTML\Parser\DOMParser;

$Doc 	= new DOMParser;
$input 	= $Doc->querySelector("input");
$exist 	= $Doc->value($input);

var_dump($exist);

?>

<div class="parser">
	<input type="text" name="test" class="oke" value="abc">
</div>