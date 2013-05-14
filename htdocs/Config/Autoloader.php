<?php
namespace Vagrant\Config;

function load($namespace) {
    $namespace = str_replace('Vagrant\\', '', $namespace);
    $namespace = str_replace('\\', '/', $namespace);
    return include_once(DOC_ROOT . $namespace . '.php');
}

spl_autoload_register(__NAMESPACE__ . '\load');
