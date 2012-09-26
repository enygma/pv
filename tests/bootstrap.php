<?php

// make a little autoloader
spl_autoload_register(function($className){
    $path = __DIR__.'/../../'.str_replace('\\','/',$className).'.php';
    if (is_file(realpath($path))) {
        require_once realpath($path);
    }
});


?>