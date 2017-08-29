<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     * 这些 URI 会被免除 CSRF 验证
     * @var array
     */
    protected $except = [
        //
        'index/clearCache',
        'admin/del',
        'admin/edit',
        'auth/editRole',
    ];
}
