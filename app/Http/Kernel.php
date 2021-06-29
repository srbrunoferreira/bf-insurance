<?php

namespace App\Http;

abstract class Kernel
{
    /**
     * The middlewares are executed at the their order
     * in this array;
     *
     * @var array
     */
    protected array $middlewarePriority = [
        \App\Http\Middleware\ApiAuth::class
    ];
}
