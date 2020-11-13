<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Middleware;

use Closure;

use App\Utilities\Helpers;

class ToSnakeCase {
    public function handle($request, Closure $next) {
        return $next($request->replace(Helpers::snakeKeys($request->all())));
    }
}