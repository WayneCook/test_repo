<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\SocialFacebookAccount;
use Socialite;
use App\User;
use Auth;

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
    }

    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }




    public function handleProviderCallback(SocialFacebookAccount $service)
    {



        $userSocial = Socialite::driver('facebook')->stateless()->user();

        dd($userSocial);

        $userSignup = User::create([
          'name' => $userSocial->user['name'],
          'email' => $userSocial->user['email'],
          'password' => bcrypt('1234'),
          'avatar' => $userSocial->avatar,
          'facebook_profile' => $userSocial->user['link'],
          'gender' => $userSocial->user['gender'],
        ]);

        if($userSignup){
          if (Auth::loginUsingId($userSignup->id)) {
            return redirect()->route('home');
          }
        }
    }
}
