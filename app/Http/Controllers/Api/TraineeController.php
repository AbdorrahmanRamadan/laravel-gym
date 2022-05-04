<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\Trainee;
use App\Http\Requests\StoreTraineeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TraineeController extends Controller
{
    public function index(){
        return "success";
    }



    public function register(StoreTraineeRequest $request)
    {
        $submitted_data = request()->all();

        $User=User::create([
            'name'=>$submitted_data['name'],
            'email'=>$submitted_data['email'],
            'password'=>Hash::make($submitted_data['password']),
            //role if it will be added :trainee - city! - gym!
        ]);

        if ($request->hasFile('avatar_image'))
        {
            $image=$request->file('avatar_image');
            $image_name=$image->getClientOriginalName();
            $destination_path='public/trainees_images';
            $path=$request->file('avatar_image')->storeAs($destination_path,$image_name);
        }

        Trainee::create([
            'trainee_id'=> $User['id'],
            'birth_date'=>$submitted_data['birth_date'],
            'gender'=>$submitted_data['gender'],
            'remaining_sessions'=> 0,
            'avatar_image'=>$image_name,
        ]);

        $id=$User['id'];
        $Data=Trainee::where('trainee_id',$id)->first();
        $array=[$Data->user];
        return $array;
    }


}
