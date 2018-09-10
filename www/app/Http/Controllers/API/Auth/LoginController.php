<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Auth\LoginRequest;
use App\User;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        
        if ($user) {
            $url = url('/login/'. $user->token);

            Mail::send('auth.emails.email-login', ['url' => $url], function ($m) use ($request) {
                $m->from('noreply@myapp.com', 'MyApp');
                $m->to($request->input('email'))->subject('MyApp Login');
            });

            return response()->json([
                'error' => false
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }

    public function loginToken($token)
    {
        if ($token = Auth::attempt(['token' => $token])) {
            return response()->json([
                'token' => $token
            ]);
        }

        return response()->json([
            'token' => null
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json([
            'success' => true
        ]);
    }
}
