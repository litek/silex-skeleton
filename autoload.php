<?php
if (version_compare(phpversion(), '5.4.0', '<')) {
  throw new Exception('Requires PHP>=5.4.0');
}

if (defined('BASE_PATH')) {
  throw new Exception('Autoloader should only be included once');
}

define('BASE_PATH', __DIR__);
define('APP_PATH', __DIR__.'/app');

$env = getenv('APP_ENV') ?: 'development';
putenv("APP_ENV=$env");

// regular autoloader
$loader = require BASE_PATH.'/vendor/autoload.php';
$loader->add('App', BASE_PATH.'/src');

// APC autoloader cache
if ($env == 'production') {
  require BASE_PATH.'/vendor/symfony/class-loader/Symfony/Component/ClassLoader/ApcClassLoader.php';
  $apcLoader = new Symfony\Component\ClassLoader\ApcClassLoader('autoloader.', $loader);
  $apcLoader->register();
  $loader->unregister();
}

return $loader;
