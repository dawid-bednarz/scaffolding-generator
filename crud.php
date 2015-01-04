<?php

require 'vendor/autoload.php';

use daweb\crud as crud;

$scaffolding = new crud\Scaffolding;

try {
    /** controller commands * */
    $params = explode('/', $argv[1]);

    $scaffolding->init();

    $command = $params[0];

    unset($params[0]);

    call_user_func_array([$scaffolding->command, $command], $params);
    
} catch (Exception $ex) {

    echo "\n\033[01;31m{$ex->getMessage()}\033[0m \n";
    echo "maybe you need edit config file, you can locate it in " . __DIR__ . '/' . crud\ScaffoldingConfig::CONFIG_FILE . "\n\n";
}





