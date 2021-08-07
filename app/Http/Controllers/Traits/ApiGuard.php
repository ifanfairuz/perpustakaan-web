<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Auth;

trait ApiGuard {

    /**
     * @return \Tymon\JWTAuth\JWTGuard
     */
    protected function guard()
    {
        return Auth::guard('api');
    }

    /**
     * @return \App\Models\Member|null
     */
    protected function user()
    {
        return $this->guard()->user();
    }

}