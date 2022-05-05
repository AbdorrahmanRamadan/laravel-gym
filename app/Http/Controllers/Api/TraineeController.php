<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\Trainee;
use App\Http\Requests\StoreTraineeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\TrainingSession;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
class TraineeController extends Controller implements MustVerifyEmail
{
    public function index(){
        return "success";
    }



    public function register(StoreTraineeRequest $request,$id)
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
            'trainee_id'=> $id,
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

    public function login(){

    }

    public function attend($s_id){
        $id=Auth::id();

      $trainee=Trainee::where('trainee_id',$id)->first();
      $session=TrainingSession::find($s_id);

      $remaining_sessions=$trainee->remaining_sessions;

      if($remaining_sessions>0){
          Trainee::where('trainee_id', $id)->update([
              'remaining_sessions' => $remaining_sessions -1,
          ]);
          Attendance::create([
              'trainee_id'=>$id,
              'training_session_id'=>$s_id,
              'attendance_time'=>now(),
          ]);
          return "suc";
      }
return "fail";


    }


    public function hasVerifiedEmail()
    {
        // TODO: Implement hasVerifiedEmail() method.
    }

    public function markEmailAsVerified()
    {
        // TODO: Implement markEmailAsVerified() method.
    }

    public function sendEmailVerificationNotification()
    {
        // TODO: Implement sendEmailVerificationNotification() method.
    }

    public function getEmailForVerification()
    {
        // TODO: Implement getEmailForVerification() method.
    }
}
