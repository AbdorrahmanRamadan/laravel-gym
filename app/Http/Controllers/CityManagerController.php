<?php

namespace App\Http\Controllers;

use App\Models\CityManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\City;
use App\Models\User;
use App\Http\Requests\StoreCityManagerRequest;
use App\Http\Requests\UpdateCityManagerRequest;
use Database\Factories\CityFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Illuminate\Support\Facades\Auth;

class CityManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('CityManager.index');
    }
    public function getCitiesManagers()

    {
        $cityManagers = CityManager::with('user','cities')->select('city_managers.*');;
        return datatables()->eloquent($cityManagers)->addIndexColumn()->addColumn('action', function($cityManager){
            return '
            <a href="'. route("citiesManagers.show", $cityManager->city_manager_id) .'"  class="edit btn btn-primary btn-sm me-2">View</a>
            <a href="'. route("citiesManagers.edit", $cityManager->city_manager_id) .'"  class="edit btn btn-success btn-sm me-2">Edit</a>
            <a href="javascript:void(0)" class="btn btn-danger" onclick="deleteCityManager('.$cityManager->city_manager_id.')">Delete</a>';


        })->editColumn('city_id', function($cityManager){
            return $cityManager->cities->name;
        })->editColumn('name', function($cityManager){
            return $cityManager->user->name;
        })->editColumn('email', function($cityManager){
            return $cityManager->cities->email;
        })->rawColumns(['action'])->toJson();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

       $citiesID=DB::table('city_managers')->select('city_id')->get()->pluck('city_id');
        $filtered=DB::table('cities')->select('id','name')->whereNotIn('id',$citiesID)->get();
        //dd($filtered);
        $cityManagers=User::all();
        return view('CityManager.create',compact(['cityManagers','filtered']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function store(StoreCityManagerRequest $request)
    {
        $imageName=$path='';
        if($request->file('avatar_image')){
            $file = $request->file('avatar_image');
            $imageName = $file->getClientOriginalName();
            $path = Storage::putFileAs('public/images', $request->file('avatar_image'), $imageName);
            }

            $cityManagerInfo = request()->all();

            $id = DB::table('users')->insertGetId([
                'name' => request('name'),
                'email' => request('email'),
                'password'=>Hash::make(request('password'))
            ]);
            CityManager::create([
                'national_id'=>$cityManagerInfo['national_id'],
                'city_manager_id'=>$id,
                'city_id'=>$cityManagerInfo['city_name'],
                'avatar_image'=>$imageName
            ]);

            return redirect(route('citiesManagers.index'))->with('success','Added Successfully');




    }


    public function show($city_manager_id)
    {

        $cityManager =CityManager::where('city_manager_id',$city_manager_id)->first();
        $citiesID=DB::table('city_managers')->select('city_id')->get()->pluck('city_id');
        $cities=DB::table('cities')->select('id','name')->whereNotIn('id',$citiesID)->get();
        $currentCityId=$cityManager->city_id;
        $currentCity=DB::table('cities')->select('id','name')->where('id',$currentCityId)->get();
        $mergedCities=$currentCity->merge($cities);
        return view('CityManager.show',['cityManager'=>$cityManager,'cities'=>$mergedCities]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($city_manager_id)
    {

        $cityManager =CityManager::where('city_manager_id',$city_manager_id)->first();
        $citiesID=DB::table('city_managers')->select('city_id')->get()->pluck('city_id');
        $cities=DB::table('cities')->select('id','name')->whereNotIn('id',$citiesID)->get();
        $currentCityId=$cityManager->city_id;
        $currentCity=DB::table('cities')->select('id','name')->where('id',$currentCityId)->get();
        $mergedCities=$currentCity->merge($cities);
        return view('CityManager.edit',['cityManager'=>$cityManager,'cities'=>$mergedCities]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCityManagerRequest $request, $city_manager_id)
    {
        $cityManager =CityManager::where('city_manager_id',$city_manager_id)->first();
        $imgName = $cityManager->avatar_image;
        $data=$request->all();
    if ($request->hasFile('avatar_image')) {

        if ($imgName != null) {
            unlink(public_path('images/'.$imgName));
        }
        $img = $request->file('avatar_image');
        $extension = $img->getClientOriginalExtension();
        $img->move(public_path("images/"), $imgName);
    }
        $user = User::where('id', '=', $city_manager_id)->first();
         $id=$user['id'];
       User::where('id',$user['id'])->update([
             'name'=>request('name'),
             'email'=>request('email'),
             'password'=>request('password')
        ]);


    CityManager::where('city_manager_id', $city_manager_id)->update([
        'national_id'=>$data['national_id'],
        'city_manager_id'=>$id,
        'city_id'=>$data['city_name'],
        'avatar_image'=>$imgName
    ]);

     return redirect(route('citiesManagers.index'))->with('success','Updated Successfully');


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($city_manager_id)
    {
        //$cityManager =CityManager::where('city_manager_id',$city_manager_id)->delete();
        $cityManager=CityManager::find($city_manager_id);
        //dd($cityManager);
        $cityManager->delete();
        $cityManager->user()->delete();
        Storage::delete('public/images/'.$cityManager->avatar_image);
        return redirect(route('citiesManagers.index'))->with('success','Deleted Successfully');

    }
}
