<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * Las proxies de confianza para esta aplicación.
     *
     * @var array|string|null
     */
    protected $proxies = '*';

    /**
     * Los encabezados que deben usarse para detectar proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_FOR . ', ' .
                     Request::HEADER_X_FORWARDED_HOST . ', ' .
                     Request::HEADER_X_FORWARDED_PORT . ', ' .
                     Request::HEADER_X_FORWARDED_PROTO;
}