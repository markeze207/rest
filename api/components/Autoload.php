<?php

function my_autoloader($class): void
{
    $filename = ROOT . '/api/' . str_replace('\\', '/', $class) . '.php';
    if(file_exists($filename))
    {
        include_once $filename;
    }
}
spl_autoload_register('my_autoloader');