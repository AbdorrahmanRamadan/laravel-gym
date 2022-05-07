<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGymManagerRequest;
use App\Http\Requests\UpdateGymManagerRequest;
use App\Models\City;
use App\Models\Gym;
use App\Models\CityManager;
use App\Models\GymManager;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Psr7\Response;

class GymManagerController extends Controller
{
    public function index(){
        return view("GymManager.index");
    }
    public function getGymManagers()

    {
        $gymManagers =  GymManager::with('user', 'gym')->select('gym_managers.*');
        return datatables()->eloquent($gymManagers)->addIndexColumn()->addColumn('action', function($gymManager){
            return '<a href="'.route('GymManager.edit', $gymManager).'" class="edit btn btn-primary me-2">Edit</a><a href="javascript:void(0)" class="btn btn-danger" onclick="deleteManager('.$gymManager->id.')">Delete</a>';
        })->editColumn('name', function($gymManager){
            return $gymManager->user->name;
        })->editColumn('email', function($gymManager){
            return $gymManager->user->email;
        })->editColumn('created_at', function($gymManager){
            return Carbon::parse($gymManager->created_at)->toDateString();
        })->editColumn('gym_id', function($gymManager){
            return $gymManager->gym->name;
        })->setRowId(function($gymManager){
            return 'managerId'.$gymManager->id;
        })->rawColumns(['action'])->toJson();
    }
    public function create(){
        $userRole = Auth::user()->roles->pluck('name')[0];
        $cities = '';
        $defaultCity = City::first();
        $defaultCityGyms = Gym::where('city_id', $defaultCity->id)->get();
        if($userRole == 'admin'){
            $cities = City::all();
        }else if($userRole == 'city_manager'){
            $cities = CityManager::find(Auth::id())->cities->id;
        }
        return view('GymManager.create', [
            'cities'=>$cities,
            'defaultCityGyms'=>$defaultCityGyms
        ]);

    }
    public function getGymsOfCity($cityId){
        $gyms = Gym::where('city_id', $cityId)->get();
        return response()->json($gyms);
    }

    public function store(StoreGymManagerRequest $request){
        $gymManagerInfo = request()->all();
        $profileImage = $request->file('profile-image');
        $name='default_profilepicture.jpg';
        if($profileImage != null){
            $name = $profileImage->getClientOriginalName();
            $path = Storage::putFileAs(
                'public/gymManagers', $profileImage, $name
            );
        }
        $gymManagerId = DB::table('users')->insertGetId([
            'name' => $gymManagerInfo['name'],
            'email' => $gymManagerInfo['email'],
            'password'=>Hash::make($gymManagerInfo['password'])
        ]);
        $gymManager = GymManager::create([
            'id'=>$gymManagerId,
            'national_id'=>$gymManagerInfo['national-id'],
            'gym_id'=>$gymManagerInfo['gym'],
            'avatar_image'=>$name
        ]);

        return redirect('gymsManagers')->with('success','Added Successfully');

    }


    public function edit($gymManagerId){
        $userRole = Auth::user()->roles->pluck('name')[0];
        $gymManagerInfo = GymManager::find($gymManagerId);
        $cities = '';
        $cityGyms = Gym::where('city_id', $gymManagerInfo->gym->city->id)->get();
        if($userRole == 'admin'){
            $cities = City::all();
        }else if($userRole == 'city_manager'){
            $cities = CityManager::find(Auth::id())->cities->id;
        }
        return view('GymManager.edit', [
            'cities'=>$cities,
            'gymManagerInfo'=>$gymManagerInfo,
            'cityGyms'=>$cityGyms
        ]);

    }

    public function update(UpdateGymManagerRequest $request, $gymManagerId){
        $gymManagerInfo = request()->all();
        $imageName = GymManager::find($gymManagerId)->avatar_image;
        $profileImage = $request->file('avatar_image');
        if($profileImage != null){
            Storage::delete('public/gymManagers/'.$imageName);
            $imageName = $profileImage->getClientOriginalName();
            $path = Storage::putFileAs(
                'public/gymManagers', $profileImage, $imageName
            );
        }
        User::where('id', $gymManagerId)->update([
            'name'=>$gymManagerInfo['name'],
            'email'=>$gymManagerInfo['email'],
        ]);
        GymManager::where('id',$gymManagerId )->update([
            'national_id'=>$gymManagerInfo['national-id'],
            'gym_id'=>$gymManagerInfo['gym'],
            'avatar_image'=>$imageName
        ]);
        return redirect(route('GymManager'))->with('status', 'Gym Manager Data is updated successfully');

    }


    public function destroy($gymManagerId){
        $gymManager = GymManager::find($gymManagerId);
        $gymManager->delete();
        $gymManager->user()->delete();
        Storage::delete('public/gymManagers/'.$gymManager->avatar_image);
        return response()->json(['success'=>"Gym Manager Deleted successfully."]);
    }

}
