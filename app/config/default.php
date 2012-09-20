<?php

// all passwords go in their respective <env>.php config files

return [
  'db.options' => [
    'driver' => 'pdo_mysql',
    'host' => '127.0.0.1',
    'dbname' => '',
    'user' => '',
    'password' => '',
    'driverOptions' => [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
  ]
];
