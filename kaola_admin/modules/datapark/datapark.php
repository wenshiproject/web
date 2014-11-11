<?php 
define('SYSPATH', dirname(dirname(__FILE__)));
function my_autoloader($class) {
    include SYSPATH.'/datapark/classes/' . strtolower($class) . '.php';
}

spl_autoload_register('my_autoloader');
?>