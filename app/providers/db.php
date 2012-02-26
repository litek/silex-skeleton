<?php
use SilexDoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Validator\Mapping\ClassMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\AnnotationLoader;

$app['autoloader']->registerNamespaces(array(
    'SilexDoctrineOrm', APP_PATH.'/../vendor/silex-doctrine-orm/src'
));

$app->register(new DoctrineOrmServiceProvider, array(
    'db.options' => $app['config']['db'],
    'em.entities' => array(
        array(
            'type' => 'annotation',
            'namespace' => 'App\\Entity'
        )
    ),
    'em.entity_namespaces' => array('' => 'App\\Entity'),
    'em.proxy_dir' => APP_PATH.'/../cache/Proxies',
    'em.proxy_namespace' => 'Proxies',
    'em.auto_generate_proxy_classes' => $app['debug'],
    'db.dbal.class_path'   => APP_PATH.'/../vendor/doctrine-dbal/lib',
    'db.common.class_path' => APP_PATH.'/../vendor/doctrine-common/lib',
    'db.orm.class_path'    => APP_PATH.'/../vendor/doctrine/lib'
));
