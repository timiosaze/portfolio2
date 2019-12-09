<?php 

function classAutoLoader($class){

	$class = strtolower($class);
	$the_path = "includes/{$class}.php";

	if(is_file($the_path) && !class_exists($class)){
		include $the_path;
	}
	
}

function redirect($location){

	return header("Location:" . $location);

}