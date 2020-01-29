<?php

use App\controllers\Cart;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$app = new App($configuration);

$app->get('/cart/{customer_id}', function (Request $request, Response $response, $args) {
    $id = $request->getAttribute('customer_id');
    $obj = new Cart();
    $result = $obj->showCart($id);

    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/cart', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    $obj = new Cart();
    $result = $obj->addToCart($data);

    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->put('/cart/{id}', function (Request $request, Response $response, $args) {
    $id = $request->getAttribute('id');
    $data = $request->getParsedBody();
    $obj = new Cart();
    $result = $obj->updateCart($id, $data);

    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();