<?php

use App\Http\Router;
use App\Controller\Pages\Login;
use App\Controller\Pages\PagesController;

Router::get('/', function() {

});

Router::get('/login/', function() {
    Login::getLoginPage();
});

Router::get('/dashboard/', function() {

});

Router::get('/register-user/', function() {

});
