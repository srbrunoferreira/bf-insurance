<?php

use App\Http\Router;

Router::get('/api/user/{userid}/{name}', function() { echo '<h1>API | GET USER</h1>'; });
