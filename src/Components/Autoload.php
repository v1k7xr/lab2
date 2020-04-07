<?php 

function my_autoloader($class_name) {
    $array_paths = [
        '/src/Components/',
        '/src/Controller',
        '/src/Model/',
        '/src/View/Posts/',
        '/src/View/templates/',
        '/src/View/User/',
        '/lib/DataBaseWorker',
        '/lib/',
    ];

    foreach ($array_paths as $path) {
        $path = '..' . $path . $class_name . '.php';
        if (is_file($path)) {
            include_once $path;
        }
    }

}

spl_autoload_register('my_autoloader');

?>