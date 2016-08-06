<?php

date_default_timezone_set('Europe/Stockholm');

define('ROOT_PATH'  , __DIR__.'/../../');
define('VENDOR_PATH', __DIR__.'/../../vendor/');
define('APP_PATH'   , __DIR__.'/../../app/');
define('CONFIG_PATH', __DIR__.'/../../app/config/');
define('VIEW_PATH'  , __DIR__.'/../../app/views/');
define('PUBLIC_PATH', __DIR__.'/../../public/');

require VENDOR_PATH.'autoload.php';

try {
    (new Dotenv\Dotenv(ROOT_PATH))->load();
} catch (Exception $e) {
    echo $e;
}

$config = [
    'path.root'   => ROOT_PATH,
    'path.public' => PUBLIC_PATH,
    'path.app'    => APP_PATH
];

require CONFIG_PATH.'database.php';
require CONFIG_PATH.'slim.php';
require CONFIG_PATH.'twig.php';

$app = new \Slim\Slim($config['slim']);
$view = $app->view;

$view->parserOptions = $config['twig'];
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension()
);

$loader = $view->getInstance()->getLoader();
$loader->addPath(VIEW_PATH.'pages', 'pages');
$loader->addPath(VIEW_PATH.'layouts', 'layouts');
$loader->addPath(VIEW_PATH.'components', 'components');


require APP_PATH.'routes.php';

return $app;
