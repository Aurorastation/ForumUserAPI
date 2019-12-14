<?php

/**
 * Copyright (c) 2019 "Werner Maisl"
 *
 * This file is part of ForumUserAPI
 * Aurorastation-Wi is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace App\Http\Middleware;

use Firebase\JWT\JWT;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class Authorize
{
    protected $public_key;

    /**
     * Create a new middleware instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->public_key = File::get("../config/public.pem");
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //Check if the Request contains a JWT Auth Header
        if (!$request->hasHeader("Authorization")) {
            return response('Missing Auth Header', 400);
        }

        $auth_header = explode(" ",$request->header("Authorization"));

        if ($auth_header[0] !== "Bearer"){
            return response('Unsupported Auth Header', 400);
        }

        $jwt_token = $auth_header[1];

        try{
            $decoded = JWT::decode($jwt_token, $this->public_key, array('RS256'));
        } catch( \UnexpectedValueException $e){
            return response("Invalid JWT Token",400);
        }

        return $next($request);
    }
}
