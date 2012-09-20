<?php
$app = new App\Application;
$app['env'] = getenv('APP_ENV');
$app['debug'] = $app['env'] != 'production';
$app['locale'] = 'en';
$app['config'] = array_replace_recursive(
  require APP_PATH.'/config/default.php',
  require APP_PATH.'/config/'.$app['env'].'.php'
);

// view
$app->register(new SilexPhpEngine\ViewServiceProvider, [
  'view.paths' => APP_PATH.'/views/%name%.phtml'
]);

// dbal and validator
$app->register(new Tabler\Provider\DbServiceProvider, [
  'db.options' => $app['config']['db.options'] + [
    'namespace' => 'App\\Table'
  ]
]);

// translator, add validation messages
$app->register(new Silex\Provider\TranslationServiceProvider);
$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
  $path = BASE_PATH.'/vendor/symfony/validator/Symfony/Component/Validator/Resources/translations';
  $translator->addResource('xliff', "$path/validators.$app[locale].xlf", $app['locale']);
  return $translator;
}));

// session
$app->register(new Silex\Provider\SessionServiceProvider, [
  'session.storage.options' => [
    'name' => 'sid'
  ]
]);

// controllers
$controllers = glob(APP_PATH.'/controllers/*.php');
foreach ($controllers as $file) {
  require $file;
}

return $app;
