<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trainee;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;


class RegistrationController extends Controller
{
    public function registerNewUser(StoreUserRequest $request)
    {
        $newUser = User::create([
            'name' => request()->name,
            'email' => request()->email,
            'password' => Hash::make(request()->password),
        ]);
        $id=$newUser->id;

        if ($request->hasFile('avatar_image'))
        {
            $image=$request->file('avatar_image');
            $image_name=$image->getClientOriginalName();
            $destination_path='public/trainees_images';
            $path=$request->file('avatar_image')->storeAs($destination_path,$image_name);
        }

        $trainee=Trainee::create([
            'trainee_id'=> $id,
            'birth_date'=> request()->birth_date,
            'gender'=>request()->gender,
            'remaining_sessions'=> 0,
            'avatar_image'=>$image_name,
        ]);


        if ($newUser) {
            event(new Registered($newUser));
            $newUser["Please complete the validation"] = "An Email has been sent to your mail, Please verify your mail";
            return $newUser;
        } else {

            return response()
                ->json(['message' => 'An error ocurred while registering your information!']);
        }
    }
}
