<?php

use App\Http\Router;

Router::get('/api/user/{username}/{userId}', function($userId, $username) {
    echo '<h1>API | GET USER</h1>';
    echo 'USERID: ' . $userId . ' | ' . 'USERNAME: ' . $username;
});
