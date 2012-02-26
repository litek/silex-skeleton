<?php
use SilexPhpEngine\PhpEngineServiceProvider;

$app['autoloader']->registerNamespace(
    'SilexPhpEngine', APP_PATH.'/../vendor/silex-php-engine/src'
);

$app->register(new PhpEngineServiceProvider, array(
    'view.paths' => array(APP_PATH.'/views/%name%')
));
