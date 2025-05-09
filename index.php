<?php


require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/vendor/autoload.php');

use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Add middleware
(require __DIR__ . '/middleware/AuthMiddleware.php')($app);

// Register routes
(require __DIR__ . '/routes.php')($app);

// Run Slim
$app->run();
