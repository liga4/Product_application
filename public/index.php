<?php
declare(strict_types=1);
use App\Controllers\ProductController;
use App\RedirectResponse;
use App\ViewResponse;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
session_start();
require_once '../vendor/autoload.php';

$loader = new FilesystemLoader('../Views');

$twig = new Environment($loader);
if (isset($_SESSION['flush'])) {
    $flashMessages = [];
    foreach ($_SESSION['flush'] as $messageType => $messages) {
        foreach ($messages as $message) {
            $flashMessages[] = [
                'type' => $messageType,
                'message' => $message,
            ];
        }
    }
    $twig->addGlobal('flash_messages', $flashMessages);
    unset($_SESSION['flush']);
}

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $router) {
    $router->addRoute('GET', '/', [ProductController::class, 'index']);
    $router->addRoute('GET', '/add-product', [ProductController::class, 'create']);
    $router->addRoute('POST', '/', [ProductController::class, 'store']);
    $router->addRoute('POST', '/delete-products', [ProductController::class, 'delete']);
    $router->addRoute('GET', '/delete-all-products', [ProductController::class, 'deleteAll']);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;

        $response = (new $controller)->{$method}(...array_values($vars));
        switch (true)
        {
            case $response instanceof ViewResponse:
                echo $twig->render($response->getViewName() . '.twig', $response->getData());
                break;
            case $response instanceof RedirectResponse:
                header('Location: ' . $response->getLocation());
                break;
            default:
                break;
        }
        break;
}