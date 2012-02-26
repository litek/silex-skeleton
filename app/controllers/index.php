<?php

$app->get('/', function() use($app) {
	return $app['view']->render('index.phtml');
});