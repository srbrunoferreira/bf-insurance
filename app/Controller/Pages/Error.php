<?php

namespace App\Controller\Pages;

use App\Controller\Pages\View;

final class Error extends View
{
    public static function notFound(): string
    {
        $content = parent::render('not-found/not-found');

        return parent::getPage('Página não encontrada', [
            'pageDescription' => 'A página que você está procurando não foi encontrada.',
            'pageContent' => $content
        ]);
    }
}
