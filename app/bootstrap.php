<?php
require_once __DIR__.'/../vendor/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';
require_once __DIR__.'/../vendor/symfony/src/Symfony/Component/ClassLoader/ApcUniversalClassLoader.php';
require_once __DIR__.'/../vendor/pimple/lib/Pimple.php';

defined('APP_PATH') or define('APP_PATH', __DIR__);

$loader = new Symfony\Component\ClassLoader\ApcUniversalClassLoader('loader');

$loader->registerNamespaces( array(
	'Silex'   => __DIR__.'/../vendor/silex/src',
	'Symfony' => __DIR__.'/../vendor/symfony/src',
    'App'     => __DIR__.'/../src'
));

$loader->registerPrefixFallback(__DIR__.'/../vendor');

$loader->register();

return $loader;
