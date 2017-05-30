<?php

function autoload($classe)
{
    $classe = str_replace('\\', '/', $classe);
    
    if (file_exists(__DIR__ . "/../app/{$classe}.php")) {
        require __DIR__ . "/../app/{$classe}.php";
    } else {
        echo "classe nao encontrada";
    }
}

spl_autoload_register('autoload');