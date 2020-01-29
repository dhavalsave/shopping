<?php

use App\controllers\Variant;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$app = new App($configuration);

$app->get('/variant', function (Request $request, Response $response, $args) {
    $obj = new Variant();
    $result = $obj->showAll();
    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/variant/{id}', function (Request $request, Response $response, $args) {
    $id = $request->getAttribute('id');
    $obj = new Variant();
    $result = $obj->showVariant($id);
    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->put('/variant/{id}', function (Request $request, Response $response, $args) {
    $id = $request->getAttribute('id');
    $data = $request->getParsedBody();
    $obj = new Variant();
    $result = $obj->updateVariant($id, $data);
    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});


$app->put('/variant', function (Request $request, Response $response, $args) {

    $data = $request->getParsedBody();
    //dd($data);
    $obj = new Variant();
    $result = $obj->updateAll( $data);
    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/variant', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    $obj = new Variant();
    $result = $obj->insertVariant($data);
    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();