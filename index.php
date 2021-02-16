<?php
    require_once __DIR__ . '/autoload.php';

    use app\core\Application;
    use app\controllers\GeneratorController;

    $app = new Application();

    $app->router->get('/', [GeneratorController::class, 'generator']);
    $app->router->post('/', [GeneratorController::class, 'generator']);

    $app->run();
