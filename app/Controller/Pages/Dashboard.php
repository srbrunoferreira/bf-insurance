<?php

namespace App\Controller\Pages;

use App\Controller\AuthController;
use App\Controller\Pages\View;

final class Dashboard extends View
{
    public static function getLoginPage()
    {
        $content = parent::render('login/login');
        echo parent::getPage('Dashboard - BF Insurance', [
            'pageDescription' => 'Dashboard - BF Insurance',
            'pageContent' => $content,
        ], false
        );
    }
}
