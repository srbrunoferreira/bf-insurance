<?php

use App\Http\Routing\Router;
use App\Http\Routing\Response;
use App\Controller\Pages\Login;
use App\Controller\Pages\PagesController;

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
