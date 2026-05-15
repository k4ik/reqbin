<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Request;
use App\Core\Pipeline;
use App\Core\Response;
use App\Middlewares\CorsMiddleware;
use App\Middlewares\RateLimitMiddleware;
use App\Middlewares\SecurityHeadersMiddleware;
use App\Services\BinService;
use App\Controllers\BinController;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;

$request = new Request();
$router = new RouteCollector();
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

$pipeline = new Pipeline();

$pipeline->pipe(new CorsMiddleware());
$pipeline->pipe(new SecurityHeadersMiddleware());
$pipeline->pipe(new RateLimitMiddleware());

try {
    $pipeline->process(
        [
            'method' => $request->method,
            'path' => $request->path,
            'ip' => $request->ip,
            'headers' => $request->headers,
            'body' => $request->body,
        ],
        function ($request) use ($dispatcher) {

            $response = $dispatcher->dispatch(
                $request['method'],
                $request['path']
            );

            Response::json($response);
        }
    );

} catch (Throwable $e) {
    Response::json([
        'error' => 'Internal server error'
    ], 500);
}