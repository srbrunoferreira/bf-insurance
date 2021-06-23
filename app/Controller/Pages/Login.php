<?php

namespace App\Controller\Pages;

use App\Controller\AuthController;
use App\Controller\Pages\View;

final class Login extends View
{
    public static function getLoginPage()
    {
        $content = parent::render('login/login');
        echo parent::getPage('Login - BF Insurance', [
            'pageTitle' => 'Login - BF Insurance',
            'pageDescription' => 'Página de login destinada apenas a funcionários da BF Insurance.',
            'pageContent' => $content,
        ], false
        );
    }
}
