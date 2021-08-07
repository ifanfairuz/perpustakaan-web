<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MyResponse;
use App\Models\Member;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    
    use AuthenticatesUsers, MyResponse;

    /**
     * @return \Tymon\JWTAuth\JWTGuard
     */
    protected function guard()
    {
        return Auth::guard('api');
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request)
        );
    }
    
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
    }

    protected function authenticated(Request $request, Member $user)
    {
        $token = $this->guard()->tokenById($user->id);
        return $this->api_response([
            'token' => $token,
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    protected function loggedOut(Request $request)
    {
        return $this->api_response([]);
    }

    public function me(Request $request)
    {
        return $this->api_response($this->guard()->user());
    }
}