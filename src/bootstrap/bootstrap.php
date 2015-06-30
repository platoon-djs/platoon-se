<?php

date_default_timezone_set('Europe/Stockholm');

define('ROOT_PATH'  , __DIR__.'/../../');
define('VENDOR_PATH', __DIR__.'/../../vendor/');
define('APP_PATH'   , __DIR__.'/../../src/');
define('VIEW_PATH'  , __DIR__.'/../../src/views/');
define('PUBLIC_PATH', __DIR__.'/../../webroot/');

require VENDOR_PATH.'autoload.php';

/*$env = (funciton() {
	$envs = [];
	return function($key) {
		return $envs[$key];
	}
})();*/

$config = [
    'path.root'   => ROOT_PATH,
    'path.public' => PUBLIC_PATH,
    'path.app'    => APP_PATH
];

foreach (glob(APP_PATH.'config/*.php') as $configFile) {
    require $configFile;
}

foreach (glob(APP_PATH.'controllers/**') as $file) {
	require $file;
}

$env = parse_ini_file(ROOT_PATH.'.env');
function env($key) {
	return $env[$key];
}

$app = new \Slim\Slim($config['slim']);
$view = $app->view;

$view->parserOptions = $config;
$view->parserExtensions = array(
	new \Slim\Views\TwigExtension()
);

$loader = $view->getInstance()->getLoader();
$loader->addPath(VIEW_PATH.'pages', 'pages');
$loader->addPath(VIEW_PATH.'layouts', 'layouts');
$loader->addPath(VIEW_PATH.'components', 'components');


require APP_PATH.'routes.php';

return $app;
