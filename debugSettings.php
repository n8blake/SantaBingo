<?php

	// DEBUGGING ON
	if(true) {
		ini_set('display_errors', '1');
		ini_set('display_startup_errors', '1');
		error_reporting(E_ALL);		
	}

	set_error_handler('exceptions_error_handler');

	function exceptions_error_handler($severity, $message, $filename, $lineno) {
	  if (error_reporting() == 0) {
	    return;
	  }
	  if (error_reporting() & $severity) {
	    throw new ErrorException($message, 0, $severity, $filename, $lineno);
	  }
	}

	function preDump($var){
		echo "<pre>";
		var_dump($var);
		echo "<pre>";
	}

	
?>