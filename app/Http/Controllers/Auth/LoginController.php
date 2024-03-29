<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function username()
    {
        return 'username';
    }
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $this->validate($request, [
            'username'           => 'required|max:255',
            'password'           => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            // $request->user() returns an instance of the authenticated user..
            $user = $request->user();


            // // https://laravel.com/docs/5.8/passport#managing-personal-access-tokens
            // $tokenResult = $user->createToken('Personal Access Token');
            // $token = $tokenResult->token;
            // $getToken = $tokenResult->accessToken;

            // if ($request->remember_me) {
            //     // kasih expired seminggu
            //     $token->expires_at = Carbon::now()->addWeeks(1);
            // }


            // // save token expired kalo gak remember me expirednya default sekitar 5 jam
            // $token->save();
            // session(['token' => $getToken]);
            //return redirect('admin/members')->with('token', $token);
            return redirect()->intended('admin/members');
        } else {
            return redirect()->back()->withErrors([
                $this->username() => 'Invalid Username or Password',
            ]);
        }
    }
}
