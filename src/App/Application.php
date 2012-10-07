<?php
namespace App;

class Application extends \Silex\Application
{
  public function __construct()
  {
    parent::__construct();
    $this['route_class'] = 'App\\Route';
  }
}
