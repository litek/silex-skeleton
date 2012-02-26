<?php
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;

$app->before(function($req) use($app) {
    if (preg_match("#/api/users/\d?#", $req->getRequestUri())) {
        $data = array(
            "CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT);",
            "INSERT INTO users VALUES(1, 'John Maynard Keynes');",
            "INSERT INTO users VALUES(2, 'Vilfredo Pareto');"
        );

        foreach ($data as $query) {
            $app['db']->query($query);
        }
    }
});

$router->get('/', function() use($app) {
    $users = $app['em']->getRepository(':User')->findAll();

    $json = json_encode(array_map(function($user) {
        return $user->serialize();
    }, $users));

    return new Response($json, 200, array('Content-Type' => 'application/json'));
});

$router->get('/{id}', function($id) use($app) {
    if (!$user = $app['em']->find(':User', $id))
        $app->abort(404);

    $json = $user->toJSON();

    return new Response($json, 200, array('Content-Type' => 'application/json'));
});