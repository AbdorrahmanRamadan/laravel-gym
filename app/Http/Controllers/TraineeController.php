<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Trainee;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreTraineeRequest;
use App\Models\BoughtPackage;
use App\Models\CityManager;
use App\Models\GymManager;
use App\Models\Gym;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class TraineeController extends Controller
{
    public function index()
    {
        return view('Trainees.index');
    }

    public function getTrainees()
    {
        $userRole = Auth::user()->roles->pluck('name')[0];
        $currentUserId = Auth::id();
        $trainees = '';
        if ($userRole == 'admin') {
            $trainees = Trainee::with('user')->select('trainees.*');
        } else if ($userRole == 'city_manager') {
            $cityId = CityManager::select('city_id')->where('city_manager_id', $currentUserId)->get()->pluck('city_id')[0];
            $gymsId = Gym::select('*')->where('city_id', $cityId)->get()->pluck('id');
            $users = DB::table('bought_packages')->select('*')->whereIn('gym_id', $gymsId)->get()->pluck('trainee_id');
            $trainees =  Trainee::with('user')->select('*')->whereIn('trainee_id', $users);
        } else if ($userRole == 'gym_manager') {
            $gymId = GymManager::select('gym_id')->where('id', $currentUserId)->get()->pluck('gym_id')[0];
            $users = DB::table('bought_packages')->select('*')->where('gym_id', $gymId)->get()->pluck('trainee_id');
            $trainees =  Trainee::with('user')->select('*')->whereIn('trainee_id', $users);
        }
        return datatables()->eloquent($trainees)->addIndexColumn()->addColumn('action', function ($trainee) {
            return '
            <a href="' . route('Trainees.show',  $trainee->trainee_id) . '"  class="edit btn btn-primary btn-sm me-2">View</a>

            <a href="javascript:void(0)" class="btn btn-danger" onclick="deleteTrainee(' . $trainee->trainee_id . ')">Delete</a>';
        })->editColumn('trainee_id', function ($trainee) {
            return $trainee->user->name;
        })->editColumn('trainee_id', function ($trainee) {
            return $trainee->user->email;
        })->rawColumns(['action'])->toJson();
    }

    public function create()
    {
        return view('Trainees.create');
    }

    public function store(StoreTraineeRequest $request)
    {
        $submitted_data = request()->all();

        $User = User::create([
            'name' => $submitted_data['name'],
            'email' => $submitted_data['email'],
            'password' => Hash::make($submitted_data['password']),
            //role if it will be added :trainee - city! - gym!
        ]);

        if ($request->hasFile('avatar_image')) {
            $image = $request->file('avatar_image');
            $image_name = $image->getClientOriginalName();
            $destination_path = 'public/trainees_images';
            $path = $request->file('avatar_image')->storeAs($destination_path, $image_name);
        }

        Trainee::create([
            'trainee_id' => $User['id'],
            'birth_date' => $submitted_data['birth_date'],
            'gender' => $submitted_data['gender'],
            'remaining_sessions' => 0,           //defult
            'avatar_image' => $image_name,
        ]);

        return to_route('Trainees.index');
    }

    public function show($trainee_id)
    {
        $trainee = Trainee::where('trainee_id', $trainee_id)->first();
        //User::find($trainee_id);
        return view('Trainees.show', compact('trainee'));
    }

    public function destroy($trainee_id)
    {
        $trainee = Trainee::where('trainee_id', $trainee_id)->first();
        Storage::disk('public')->delete('trainees_images/' . $trainee->avatar_image);

        Trainee::where('trainee_id', $trainee_id)->delete();

        User::find($trainee_id)->delete();
        return response()->json(['success' => "Trainee Deleted successfully."]);

        //return to_route('Trainees.index');
    }
}
