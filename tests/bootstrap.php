<?php

/**
 * Define an autoloader for the classes
 */
spl_autoload_register(
    function($className){
        $path = __DIR__.'/..'.str_replace(array('Pv\\', '\\'), '/', $className).'.php';
        if (is_file(realpath($path))) {
            require_once realpath($path);
        }
    }
);


?>