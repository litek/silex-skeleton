<?php
require_once __DIR__.'/../vendor/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';
require_once __DIR__.'/../vendor/symfony/src/Symfony/Component/ClassLoader/ApcUniversalClassLoader.php';
require_once __DIR__.'/../vendor/pimple/lib/Pimple.php';

defined('APP_PATH') or define('APP_PATH', __DIR__);

# but how will I know if I'm debugging...
if (getenv('PHP_ENV') == 'production')
    $loader = new Symfony\Component\ClassLoader\ApcUniversalClassLoader('loader');
else
    $loader = new Symfony\Component\ClassLoader\UniversalClassLoader;

$loader->registerNamespaces( array(
	'Silex'   => __DIR__.'/../vendor/silex/src',
	'Symfony' => __DIR__.'/../vendor/symfony/src',
    'App'     => __DIR__.'/../src'
));

$loader->registerPrefixFallback(__DIR__.'/../vendor');

$loader->register();

return $loader;
