<?php

namespace App\Http\Middleware;

use App\Controller\Pages\Error;
use App\Http\Routing\Response;
use App\Http\Routing\Request;

final class Auth
{
    public function run(): void
    {
        if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true)
            Response::send('Acesso negado. Você não está logado', 401); exit;
    }
}
