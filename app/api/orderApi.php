<?php

use App\controllers\Order;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$app = new App($configuration);

$app->post('/order/{customer_id}', function (Request $request, Response $response, $args) {
    $customerId = $request->getAttribute('customer_id');
    $obj = new Order();

    $result = $obj->placeOrder($customerId);

    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});


$app->get('/order/{customer_id}', function (Request $request, Response $response, $args) {
    $id = $request->getAttribute('customer_id');
    $obj = new Order();
    $result = $obj->showOrder($id);

    $payload = json_encode($result);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();