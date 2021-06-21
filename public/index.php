<?php

require_once '../vendor/autoload.php';
require_once '../app/config.php';

use \App\Http\Router;

Router::get('/', function() {});
Router::get('api/{userId}/{comeback}/', function() {});

Router::run();

echo '<pre>';
print_r(Router::$routes);
echo '</pre><hr>';
