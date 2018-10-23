<?php

spl_autoload_register(function($class_name){

    $filename = $class_name.DIRECTORY_SEPARATOR.$class_name.".php";

    $filename2 = "..".DIRECTORY_SEPARATOR.$class_name.DIRECTORY_SEPARATOR.$class_name.".php";

	if (file_exists(($filename))) {

	    require_once($filename);

	} else {

        require_once($filename2);

	}

});

include_once('cabecalho.php');

function ecoPre($var){
    echo"<pre>";
    print_r($var);
    echo"</pre>";
}

 ?>