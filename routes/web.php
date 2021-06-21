<?php

use App\Http\Router;

Router::get('/', function() {echo '<h1>HOME PAGE</h1>'; });
Router::get('/dashboard/', function() {echo '<h1>DASHBOARD PAGE</h1>'; });
Router::get('/register-user/', function() {echo '<h1>REGISTER USER PAGE</h1>'; });
