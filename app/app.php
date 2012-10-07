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
  'view.paths'  => APP_PATH.'/views/%name%.phtml',
  'assets.root' => '/assets'
]);

$app['view.helpers'] = $app->share(function() use($app) {
  $assets = Parcel\AssetsHelper::create($app);
  return [$assets];
});

// dbal
$app->register(new Tabler\Provider\DbServiceProvider, [
  'db.options' => $app['config']['db.options'] + [
    'namespace' => 'App\\Table'
  ]
]);

// validator
$app->register(new Silex\Provider\ValidatorServiceProvider);
$app['validator.mapping.class_metadata_factory'] = $app->share(function ($app) {
  foreach (spl_autoload_functions() as $fn) {
    Doctrine\Common\Annotations\AnnotationRegistry::registerLoader($fn);
  }

  $reader = new Doctrine\Common\Annotations\AnnotationReader;
  $loader = new Symfony\Component\Validator\Mapping\Loader\AnnotationLoader($reader);
  $cache  = extension_loaded('apc') ? new Symfony\Component\Validator\Mapping\ClassMetadata\ApcCache : null;
  return new Symfony\Component\Validator\Mapping\ClassMetadataFactory($loader, $cache);
});

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
