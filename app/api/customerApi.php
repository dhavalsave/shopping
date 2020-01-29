<?php

use App\controllers\Customer;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$app = new App($configuration);

$app->get('/customer', function (Request $request, Response $response, $args) {
    $obj = new Customer();
    $result = $obj->showAllCustomer();
    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/customer/{id}', function (Request $request, Response $response, $args) {
    $id = $request->getAttribute('id');
    $obj = new Customer();
    $result = $obj->showCustomer($id);
    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/customer', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    $obj = new Customer();
    $result = $obj->createCustomer($data);
    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->put('/customer/{id}', function (Request $request, Response $response, $args) {
    $id = $request->getAttribute('id');
    $data = $request->getParsedBody();
    $obj = new Customer();
    $result = $obj->updateCustomer($id, $data);
    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();