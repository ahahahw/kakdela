<?php

declare(strict_types = 1);

use App\App;
use App\Config;
use App\Controllers\HomeController;
use App\Controllers\GeneratorExampleController;
use App\Router;
use App\Container;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../views');

$container = new Container();
$router = new Router($container);

$router
    ->get('/', [HomeController::class, 'index'])
    ->get('/examples/generator', [GeneratorExampleController::class, 'index']);
$connectionParams = [
        'dbname' => $_ENV['DB_DATABASE'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],
        'host' => $_ENV['DB_HOST'],
        'driver' => $_ENV['DB_RIVER'] ?? 'pdo_mysql',
    ];
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);
$stmt=$conn->prepare('SELECT * FROM users');
$result = $stmt->executeQuery();

(new App(
    $container,
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
))->run();

