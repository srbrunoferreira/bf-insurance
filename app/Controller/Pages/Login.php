<?php

namespace App\Controller\Pages;

use App\Controller\AuthController;
use App\Controller\Pages\View;
use App\Http\Routing\Response;

final class Login extends View
{
    public static function getLoginPage()
    {
        $content = parent::render('login/login');
        $page = parent::getPage('Login - BF Insurance',
            ['pageDescription' => 'Página de login destinada apenas a funcionários da BF Insurance.', 'pageContent' => $content],
            false
        );

        Response::send($page);

    }
}
