<?php
use Silex\Application;
use Silex\ControllerCollection;
$loader = require_once 'bootstrap.php';

$app = new Application;
$app['autoloader'] = is_object($loader) ? $loader : false;
$app['env'] = getenv('PHP_ENV') ?: 'development';
$app['debug'] = $app['env'] == 'development';

$app['config'] = require __DIR__.'/config/default.php';
if (file_exists(__DIR__.'/config/'.$app['env'].'.php')) {
    $app['config'] = array_merge_recursive(
        $app['config'],
        require __DIR__.'/config/'.$app['env'].'.php'
    );
}

foreach (glob(APP_PATH.'/{providers,controllers}/*.php', GLOB_BRACE) as $file) {
	require $file;
}

foreach (glob(APP_PATH.'/controllers/api/*.php') as $file) {
	$router = new ControllerCollection;
	require $file;
	$app->mount('/api/'.basename($file, '.php'), $router);
}

// workaround to make sure exceptions in filters are caught
$app->get('/{any}', function() use($app) {
	$app->abort(404);
})->assert('any', '.+');

return $app;
