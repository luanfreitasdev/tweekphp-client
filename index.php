<?php

use TweakPHP\Client\Loader;

require __DIR__.'/vendor/autoload.php';

$arguments = $argv;

if (count($arguments) < 3) {
    echo 'Invalid arguments'.PHP_EOL;
    exit(1);
}

function dd(...$args)
{
    if (count($args) === 1) {
        return $args[0];
    }

    return $args;
}

$loader = Loader::load($arguments[1]);

if ($loader === null) {
    echo 'Invalid path'.PHP_EOL;
    exit(1);
}

$loader->init();

$supportedCommands = [
    'info',
    'execute',
];

if (! in_array($arguments[2], $supportedCommands)) {
    echo 'Invalid command'.PHP_EOL;
    exit(1);
}

switch ($arguments[2]) {
    case 'info':
        $info = json_encode([
            'name' => $loader->name(),
            'version' => $loader->version(),
            'php_version' => phpversion(),
        ]);
        echo $info.PHP_EOL;
        break;
    case 'execute':
        if (count($arguments) < 4) {
            echo 'Invalid arguments'.PHP_EOL;
            exit(1);
        }
        echo $loader->execute(base64_decode($arguments[3])).PHP_EOL;
        break;
}
