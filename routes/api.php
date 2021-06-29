<?php

use App\Http\Routing\Router;
use App\Http\Routing\Response;

Router::get('/api/user/{username}/{userId}', function($userId, $username) {
    Response::send(['error' => 'Request timeout'], 409, 'application/json');
});
