<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Las URIs que se deben excluir de la verificación CSRF.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Ejemplo: 'webhook/*'
    ];
}
