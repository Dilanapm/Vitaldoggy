<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     * Las URIs que pueden ser excluidas de la verificación CSRF.
     * de que trata: Este middleware se utiliza para proteger las aplicaciones web de ataques CSRF (Cross-Site Request Forgery).
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
