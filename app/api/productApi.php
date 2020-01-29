<?php

use App\controllers\Product;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$app = new App($configuration);

$app->get('/product', function (Request $request, Response $response, $args) {
    $obj = new Product();
    $result = $obj->showAllProducts();
    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/product/{id}', function (Request $request, Response $response, $args) {
    $id = $request->getAttribute('id');
    $obj = new Product();
    $result = $obj->showProduct($id);
    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/product', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    $obj = new Product();
    $result = $obj->insertProduct($data);
    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->put('/product/{id}', function (Request $request, Response $response, $args) {
    $id = $request->getAttribute('id');
    $data = $request->getParsedBody();
    $obj = new Product();
    $result = $obj->updateProduct($id, $data);
    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});


$app->run();

