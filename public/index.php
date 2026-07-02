<?php
declare(strict_types=1);

// Require Composer Autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Request;
use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\UserController;

$request = new Request();
$router = new Router();

// Auth Routes
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

// Dashboard & User Management Routes
$router->get('/users', [UserController::class, 'index']);
$router->get('/users/view', [UserController::class, 'view']);
$router->get('/users/create', [UserController::class, 'create']);
$router->post('/users/create', [UserController::class, 'store']);
$router->get('/users/edit', [UserController::class, 'edit']);
$router->post('/users/edit', [UserController::class, 'update']);
$router->get('/users/delete', [UserController::class, 'delete']);

// Fallback routing
$router->resolve($request);
