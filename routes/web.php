<?php

use App\Http\Routing\Router;
use App\Controller\Pages\Login;

Router::get('/', function () {
Router::redirect('/dashboard/');
});

Router::get('/login/', function () {
    Login::getLoginPage();
});

Router::get('/dashboard/', function () {
    echo '<h1>Dashboard</h1>';
});

Router::get('/register-user/', function () {
});
