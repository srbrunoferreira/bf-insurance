<?php

require_once '../vendor/autoload.php';
require_once '../app/config.php';

use App\Http\Routing\Router;

require_once '../routes/api.php';
require_once '../routes/web.php';

Router::run();
