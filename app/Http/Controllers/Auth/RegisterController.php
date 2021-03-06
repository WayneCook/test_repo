<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;

class RegisterController extends Controller
{

    use RegistersUsers;

    protected $redirectTo = '/dashboard';


    public function __construct()
    {

        $this->middleware('guest');

    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'unit_number' => 'required|integer|digits_between:3,4',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }


    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'unit_number' => $data['unit_number'],
            'password' => Hash::make($data['password']),
        ]);

    }
}
