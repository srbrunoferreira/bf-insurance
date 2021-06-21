<?php

require_once '../vendor/autoload.php';
require_once '../app/config.php';

use \App\Http\Router;

Router::init();

require_once '../routes/web.php';
require_once '../routes/api.php';

Router::run();
