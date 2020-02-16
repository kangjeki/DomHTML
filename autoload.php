<?php

spl_autoload_register(function($class) {
	$class 	= explode("\\", $class);
	require_once( __DIR__ . '/src/' . end( $class ) . ".php" );
});