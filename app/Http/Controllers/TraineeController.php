<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Trainee;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreTraineeRequest;
use Illuminate\Support\Facades\Storage;

class TraineeController extends Controller
{
    public function index()
    {
        return view('Admin.Trainees.index');
    }

    public function getTrainees(){
        $trainees = Trainee::with('user')->select('trainees.*');
        return datatables()->eloquent($trainees)->addIndexColumn()->addColumn('action', function($trainee){
            return '<form class="d-inline" action="'.route('Admin.Trainees.destroy',  $trainee->trainee_id ).'" method="POST">
            '.csrf_field().'
            '.method_field("DELETE").'
            <button type="submit" class="btn btn-danger btn-sm me-2"
                onclick="return confirm(\'Are You Sure Want to Delete?\')"
            ">Delete</a>
            </form>';
        })->editColumn('trainee_id', function($trainee){
            return $trainee->user->name;
        })->editColumn('trainee_id', function($trainee){
            return $trainee->user->email;
        })->rawColumns(['action'])->toJson();
    }

    public function create()
    {
        return view('Admin.Trainees.create');
    }

    public function store(StoreTraineeRequest $request)
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
            'remaining_sessions'=> 0,           //defult
            'avatar_image'=>$image_name,
        ]);

        return to_route('Admin.Trainees.index');
    }

    public function destroy($trainee_id)
    {
        $trainee=Trainee::where('trainee_id',$trainee_id)->first();
        Storage::disk('public')->delete('trainees_images/'.$trainee->avatar_image);

        Trainee::where('trainee_id',$trainee_id)->delete();

        User::find($trainee_id)->delete();

        return to_route('Admin.Trainees.index');
    }

}
