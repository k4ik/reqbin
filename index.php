<?php
declare(strict_types=1);
header('Content-Type: application/json');
require __DIR__ . "/vendor/autoload.php";

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use App\Controllers\BinController;
use App\Services\BinService;

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$router = new RouteCollector;

$service = new BinService();
$controller = new BinController($service);

$router->post("/bin/new", function() use ($controller) {
    return $controller->createBin();
});

$router->any("/bin/{id}", function($id) use ($controller) {
    return $controller->handleRequest($id);
});

$router->get("/bin/{id}/requests", function($id) use ($controller) {
    return $controller->getRequests($id);
});

$dispatcher = new Dispatcher($router->getData());

try {
    $response = $dispatcher->dispatch($_SERVER["REQUEST_METHOD"], $path);
    echo json_encode($response);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}