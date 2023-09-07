<?php
include_once "App/iran.php";
spl_autoload_register(function ($class){
    $class_file = __DIR__ . "/" . $class . ".php";
    if(!(file_exists($class_file) and is_readable($class_file))){
        die("$class not found");
    }
    include_once $class_file;
});

//use \App\Services\CityService;
//use \App\Utilities\Response;

//new CityService();
//Response::respond([1,23],200);
