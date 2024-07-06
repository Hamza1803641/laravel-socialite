<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    //google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    //google callback

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();


        $this->RegisterOrLoginUser($user);
        return redirect()->route('home');

    }


    //google login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    //Facebook callback

    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();

        
        $this->RegisterOrLoginUser($user);
        return redirect()->route('home');
    }
    //Github login
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    //Github callback

    public function handleGithubCallback()
    {
        $user = Socialite::driver('github')->user();

        
        $this->RegisterOrLoginUser($user);
        return redirect()->route('home');
    }

    protected function RegisterOrLoginUser($data)
    {
        $user = User::where('email', '=', $data->email)->first();

        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->save();

            Auth::login($user);


        }

    }
}