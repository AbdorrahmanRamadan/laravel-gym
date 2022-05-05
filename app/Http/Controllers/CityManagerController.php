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
        return datatables()->eloquent($cityManagers)->addIndexColumn()->addColumn('action', function($cityManagers){
            return '
            <a href="'. route("citiesManagers.edit", $cityManagers->city_manager_id) .'"  class="edit btn btn-success btn-sm me-2">Edit</a>
            <form class="d-inline" action="'.route('citiesManagers.destroy',  $cityManagers->city_manager_id).'" method="POST">
            '.csrf_field().'
            '.method_field("DELETE").'
            <button type="submit" class="btn btn-danger btn-sm me-2"
                onclick="return confirm(\'Are You Sure Want to Delete?\')"
            ">Delete</a>
            </form>';


        })->editColumn('city_id', function($cityManagers){
            return $cityManagers->cities->name;
        })->editColumn('name', function($cityManagers){
            return $cityManagers->user->name;
        })->editColumn('email', function($cityManagers){
            return $cityManagers->cities->email;
        })->rawColumns(['action'])->toJson();
    }

    public function create()
    {

       $citiesID=DB::table('city_managers')->select('city_id')->get()->pluck('city_id');
        $filtered=DB::table('cities')->select('id','name')->whereNotIn('id',$citiesID)->get();
        $cityManagers=User::all();
        return view('CityManager.create',compact(['cityManagers','filtered']));
    }

public function store(Request $request)
    {

            $cityManagerInfo = request()->all();
            $file = $request->file('avatar_image');
            $imageName = $file->getClientOriginalName();
            $path = Storage::putFileAs('public/images', $request->file('avatar_image'), $imageName);
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
            $cityManager= User::where(['id'=>$id])->first();

            $cityManager->assignRole('city_manager');

            return redirect(route('citiesManagers.index'))->with('success','Added Successfully');



    }


    public function edit($city_manager_id)
    {

        $cityManager =CityManager::where('city_manager_id',$city_manager_id)->first();
        $citiesID=DB::table('city_managers')->select('city_id')->get()->pluck('city_id');
        $cities=DB::table('cities')->select('id','name')->whereNotIn('id',$citiesID)->get();
        return view('CityManager.edit',['cityManager'=>$cityManager,'cities'=>$cities]);
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
        //dd($data);
    if ($request->hasFile('avatar_image')) {

        if ($imgName != null) {
            unlink(public_path('images/'.$imgName));
        }
        $img = $request->file('avatar_image');
        $extension = $img->getClientOriginalExtension();
        $img->move(public_path("images/"), $imgName);
    }
        $user = User::where('name', '=', $data['name'])->where('email',$data['email'])->first();
        $id=$user->id;
       User::where('id',$id)->update([
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
        $cityManager =CityManager::where('city_manager_id',$city_manager_id)->delete();
        return redirect(route('citiesManagers.index'))->with('success','Deleted Successfully');

    }
}
