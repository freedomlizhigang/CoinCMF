<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        // 支付
        'alipay/gateway',
        'alipay/return',
        'weixin/return',
        'union/return',
        'union/success',
        // 微信
        'wx/*',
        'oauth/*',
    ];
}
