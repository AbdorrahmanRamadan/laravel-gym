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
use Yajra\DataTables\Html\Editor\Fields\Select;

class GymManagerController extends Controller
{
    public function index()
    {
        $userRole = Auth::user()->roles->pluck('name')[0];

        if ($userRole=='admin' || $userRole=='city_manager'){
            return view("GymManager.index");

        }else{
            return view('403');
        }
    }
    public function getGymManagers()

    {
        $userRole = Auth::user()->roles->pluck('name')[0];

        if ($userRole=='admin' || $userRole=='city_manager'){
        $gymManagers = '';
        $currentUserId = Auth::id();
        if ($userRole == 'admin') {
            $gymManagers =  GymManager::with('user', 'gym')->select('gym_managers.*');
        } else if ($userRole == 'city_manager') {
            $cityId = CityManager::select('city_id')->where('city_manager_id', $currentUserId)->get()->pluck('city_id')[0];
            $gyms = Gym::where('city_id', $cityId)->get()->pluck('id');
            $gymManagers = GymManager::with('user', 'gym')->select('*')->whereIn('gym_id',$gyms);

        }

        return datatables()->eloquent($gymManagers)->addIndexColumn()->addColumn('action', function ($gymManager) {

            return '<a href="' . route("GymManager.show", $gymManager->id) . '" class="edit btn btn-success btn-sm me-2">Show</a><a href="' . route("GymManager.edit", $gymManager->id) . '" class="edit btn btn-primary btn-sm me-2">Edit</a><a href="javascript:void(0)" class="btn btn-danger me-2" onclick="deleteManager(' . $gymManager->id . ')">Remove</a>';
        })->addColumn('ban', function ($gymManager) {
            if ($gymManager->isban == 0) {
                return ' <a href="' . route("GymManager.ban", $gymManager->id) . '" class="btn btn-danger w-100"  id="ban" >ban</a>';
            } else {
                return ' <a href="' . route("GymManager.ban", $gymManager->id) . '" class="btn btn-primary w-100" id="ban" >unban</a>';
            }

            return '
            <a href="' . route('GymManager.show', $gymManager) . '" class="edit btn btn-primary me-2">View</a>
            <a href="' . route('GymManager.edit', $gymManager) . '" class="edit btn btn-success me-2">Edit</a><a href="javascript:void(0)" class="btn btn-danger" onclick="deleteManager(' . $gymManager->id . ')">Delete</a>';
        })->editColumn('name', function ($gymManager) {
            return $gymManager->user->name;
        })->editColumn('email', function ($gymManager) {
            return $gymManager->user->email;
        })->editColumn('created_at', function ($gymManager) {
            return Carbon::parse($gymManager->created_at)->toDateString();
        })->editColumn('gym_id', function ($gymManager) {
            return $gymManager->gym->name;
        })->setRowId(function ($gymManager) {
            return 'managerId' . $gymManager->id;
        })->rawColumns(['action', 'ban'])->toJson();}
        else{
            return view('403');
        }
    }
    public function show($gymId)
    {
        $userRole = Auth::user()->roles->pluck('name')[0];

        if ($userRole=='admin' || $userRole=='city_manager'){
        $gymManagerInfo = GymManager::with('gym', 'user')->find($gymId);
        return view('GymManager.show', [
            'gymManagerInfo' => $gymManagerInfo,
        ]);
    }else{
        return view('403');
    }
    }
    public function create()
    {
        $userRole = Auth::user()->roles->pluck('name')[0];

        if ($userRole=='admin' || $userRole=='city_manager'){
        $userRole = Auth::user()->roles->pluck('name')[0];
        $cities = $gyms='';
        $defaultCity = City::first();

        $defaultCityGyms = Gym::where('city_id', $defaultCity->id)->get();
        if ($userRole == 'admin') {
            $cities = City::all();
        } else if ($userRole == 'city_manager') {
            $currentId = Auth::id();
            $cityid = CityManager::select('*')->where('city_manager_id', $currentId)->get()->pluck('city_id')[0];
            $cities = City::where('id', $cityid)->select('*')->first();
            $gyms = Gym::where('city_id', $cityid)->get();
        }
        return view('GymManager.create', [
            'cities' => $cities,
            'defaultCityGyms' => $defaultCityGyms,
            'gyms' => $gyms,
        ]);
    }else{
        return view('403');
    }
    }
    public function getGymsOfCity($cityId)
    {
        $gyms = Gym::where('city_id', $cityId)->get();
        return response()->json($gyms);
    }
    public function ban($id)
    {
        $userRole = Auth::user()->roles->pluck('name')[0];

        if ($userRole=='admin' || $userRole=='city_manager'){
        $gymmanager = GymManager::where('id', $id)->first();

        if ($gymmanager->isban == 1) {
            GymManager::where('id', $id)->update([
                'isban' => 0,
            ]);
        } else {
            GymManager::where('id', $id)->update([
                'isban' => 1,
            ]);
        }
        return redirect('gymsManagers');}
        else {
            return view('403');
        }
    }
    public function store(StoreGymManagerRequest $request)
    {
        $userRole = Auth::user()->roles->pluck('name')[0];

        if ($userRole=='admin' || $userRole=='city_manager'){
        $gymManagerInfo = request()->all();
        $profileImage = $request->file('profile-image');
        $name = 'default_profilepicture.jpg';
        if ($profileImage != null) {
            $name = $profileImage->getClientOriginalName();
            $path = Storage::putFileAs(
                'public/gymManagers',
                $profileImage,
                $name
            );
        }
        $gymManagerId = DB::table('users')->insertGetId([
            'name' => $gymManagerInfo['name'],
            'email' => $gymManagerInfo['email'],
            'password' => Hash::make($gymManagerInfo['password'])
        ]);
        $gymManager = GymManager::create([
            'id' => $gymManagerId,
            'national_id' => $gymManagerInfo['national-id'],
            'gym_id' => $gymManagerInfo['gym'],
            'avatar_image' => $name
        ]);
        $user = User::where(['id' => $gymManagerId])->first();
        $user->assignRole('gym_manager');


        return redirect('gymsManagers')->with('success', 'Added Successfully');
    }else{
        return view('403');
    }
    }


    public function edit($gymManagerId)
    {
        $userRole = Auth::user()->roles->pluck('name')[0];

        if ($userRole=='admin' || $userRole=='city_manager'){        $gymManagerInfo = GymManager::find($gymManagerId);
        $cities = $gyms = '';
        $cityGyms = Gym::where('city_id', $gymManagerInfo->gym->city->id)->get();
        if ($userRole == 'admin') {
            $cities = City::all();
        } else if ($userRole == 'city_manager') {
            $currentId = Auth::id();
            $cityid = CityManager::select('*')->where('city_manager_id', $currentId)->get()->pluck('city_id')[0];
            $cities = City::where('id', $cityid)->select('*')->first();
            $gyms = Gym::where('city_id', $cityid)->get();
        }
        return view('GymManager.edit', [
            'cities' => $cities,
            'gymManagerInfo' => $gymManagerInfo,
            'cityGyms' => $cityGyms,
            'gyms' => $gyms,
        ]);
    }
    else {
        return view('403');
    }
    }

    public function update(UpdateGymManagerRequest $request, $gymManagerId)
    {
        $userRole = Auth::user()->roles->pluck('name')[0];

        if ($userRole=='admin' || $userRole=='city_manager'){
        $gymManagerInfo = request()->all();
        $imageName = GymManager::find($gymManagerId)->avatar_image;
        $profileImage = $request->file('avatar_image');
        if ($profileImage != null) {
            Storage::delete('public/gymManagers/' . $imageName);
            $imageName = $profileImage->getClientOriginalName();
            $path = Storage::putFileAs(
                'public/gymManagers',
                $profileImage,
                $imageName
            );
        }
        User::where('id', $gymManagerId)->update([
            'name' => $gymManagerInfo['name'],
            'email' => $gymManagerInfo['email'],
        ]);
        GymManager::where('id', $gymManagerId)->update([
            'national_id' => $gymManagerInfo['national-id'],
            'gym_id' => $gymManagerInfo['gym'],
            'avatar_image' => $imageName
        ]);
        return redirect(route('GymManager'))->with('status', 'Gym Manager Data is updated successfully');}
        else{
            return view('403');
        }
    }


    public function destroy($gymManagerId)
    {
        $userRole = Auth::user()->roles->pluck('name')[0];

        if ($userRole=='admin' || $userRole=='city_manager'){
        $gymManager = GymManager::find($gymManagerId);
        $gymManager->delete();
        $gymManager->user()->delete();
        Storage::delete('public/gymManagers/' . $gymManager->avatar_image);
        return response()->json(['success' => "Gym Manager Deleted successfully."]);}
        else {
            return view('403');
        }

    }
}
