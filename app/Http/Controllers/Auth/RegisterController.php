<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTraineeRequest;
use App\Models\Trainee;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
            'avatar_image'=>['required'],
            'birth_date'=>['required'],
            'gender'=>['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    protected function create(array $data)
    {

// image has a problem
//        if ($data->hasFile('avatar_image'))
//        {
//            $image=$data->file('avatar_image');
//            $image_name=$image->getClientOriginalName();
//            $destination_path='public/trainees_images';
//            $path=$data->file('avatar_image')->storeAs($destination_path,$image_name);
//        }


       $user=User::create([
           'name' => $data['name'],
           'email' => $data['email'],
           'password' => Hash::make($data['password']),
       ]);
        Trainee::create([
            'trainee_id'=> $user->id,
            'birth_date'=>$data['birth_date'],
            'gender'=>$data['gender'],
            'remaining_sessions'=> 0,
            'avatar_image'=>$data['avatar_image'],
        ]);

        return $user;

    }
}
//$User=User::create([
//    'name'=>$data['name'],
//    'email'=>$data['email'],
//    'password'=>Hash::make($data['password']),
//    //role if it will be added :trainee - city! - gym!
//]);
//
//
//
//if ($data1->hasFile('avatar_image'))
//{
//    $image=$data1->file('avatar_image');
//    $image_name=$image->getClientOriginalName();
//    $destination_path='public/trainees_images';
//    $path=$data1->file('avatar_image')->storeAs($destination_path,$image_name);
//}
//
//Trainee::create([
//    'trainee_id'=> $User->id,
//    'birth_date'=>$data['birth_date'],
//    'gender'=>$data['gender'],
//    'remaining_sessions'=> 0,
//    'avatar_image'=>$image_name,
//]);
//
//
//
//
//return "please verify your email now";
