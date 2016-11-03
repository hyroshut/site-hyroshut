<?php
use Slim\Http\Request;
use Slim\Http\Response;

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

require __DIR__ . "/../src/functions.php";

$dot_env = new Dotenv\Dotenv(parent_dir(__DIR__, 1));
$dot_env->load();

// Register component on container
$app->getContainer()['view'] = function ($container) use($app, $settings) {
    $view = new \Slim\Views\Twig($settings["settings"]["renderer"]["template_path"], [
        'cache' => false#'tmp/cache/twig'
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$app->get("/redirect", function (Request $request, Response $response, $args) {
    $url = http_build_query($_GET);
    $url = substr($url, strlen('url='));
    header("Location: " . urldecode($url));
    exit;
});

require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
