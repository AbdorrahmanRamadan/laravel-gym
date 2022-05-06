<?php

namespace App\Http\Controllers\Api;
use App\Http\Requests\UpdateTraineeRequest;
use App\Models\Gym;
use App\Models\User;
use App\Models\Trainee;
use App\Http\Requests\StoreTraineeRequest;
use App\Http\Controllers\Controller;
use App\Notifications\Welcome;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\TrainingSession;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

class TraineeController extends Controller
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

    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        User::where('id', $user->id)->update([
            'last_login' => Carbon::now(),
        ]);


        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        else{
           return  [$user->createToken($request->device_name)->plainTextToken,$user];
        }

    }


    public function update($userId,UpdateTraineeRequest $req){
        $newData=$req->all();

        User::where('id', $userId)->update([
            'name'=>$newData['name'],
            'email'=>$newData['email'],
            'password'=>Hash::make($newData['password']),
        ]);
        if ($req->hasFile('avatar_image'))
        {
            $image=$req->file('avatar_image');
            $image_name=$image->getClientOriginalName();
            $destination_path='public/trainees_images';
            $path=$req->file('avatar_image')->storeAs($destination_path,$image_name);
            Trainee::where('trainee_id', $userId)->update([

                'avatar_image'=>$image_name,
            ]);
        }

        return response()
            ->json(['message' => 'Information updated successfully!']);
    }


    public function remaining(){
        $id=Auth::id();
        $trainee=Trainee::where('trainee_id',$id)->first();
        $remaining_sessions=$trainee->remaining_sessions;
        return "you hava : ".$remaining_sessions." remaining sessions";
    }

    public function history(){
        $id=Auth::id();
        $attendances=Attendance::where('trainee_id',$id)->get();
        foreach ($attendances as $attendance){
            $session=TrainingSession::where('id',$attendance->training_session_id)->first();
            $session_data=array();
            array_push($session_data,$session->name,$session->start_at,$session->end_at);
            $gym=Gym::where('id',$session->gym_id)->first();
            array_push($session_data,$gym->name);
        }
        $result=array(["session name :"=>$session_data[0],"you start you session at :"=>$session_data[1],"your session end at"=>$session_data[2],"Gym name"=>$session_data[3]]);
        return $result;
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



}
