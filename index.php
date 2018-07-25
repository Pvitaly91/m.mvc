<? 

use Classes\Routing;
session_start();

function __autoload($class){
   // d(str_replace("\\", "/", $class));
   // d( $class);
    require_once(__DIR__."/".$class.".php");
}

function d($array){
    echo "<pre>";
        print_r($array);
    echo "</pre>";
}

 Routing::getInstance()->route()->render();
