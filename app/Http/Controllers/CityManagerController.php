<?php

namespace App\Http\Controllers;

use App\Models\CityManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\City;
use App\Models\User;
use App\Http\Requests\StoreCityManagerRequest;

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
        $citiesManagers = CityManager::query();
        return datatables()->eloquent($citiesManagers)->addIndexColumn()->addColumn('action', function($citiesManagers){
            return '
            <a href="'. route("citiesManagers.edit", $citiesManagers->city_manager_id) .'"  class="edit btn btn-success btn-sm me-2">Edit</a>
            <form class="d-inline" action="'.route('citiesManagers.destroy',  $citiesManagers->city_manager_id).'" method="POST">
            '.csrf_field().'
            '.method_field("DELETE").'
            <button type="submit" class="btn btn-danger btn-sm me-2"
                onclick="return confirm(\'Are You Sure Want to Delete?\')"
            ">Delete</a>
            </form>';


        })->editColumn('city_id', function($citiesManagers){
            return $citiesManagers->cities->name;
        })->rawColumns(['action'])->toJson();
    }

    //<a href="'. route("citiesManagers.destroy", $citiesManagers->city_manager_id) .'" class="edit btn btn-danger btn-sm">Delete</a>
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities =City::all();
        $cityManagers=User::all();
        return view('CityManager.create',compact(['cities','cityManagers']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCityManagerRequest $request)
    {
        $cityManager = new CityManager();
        $file = $request->file('avatar_image');
        $imageName = $file->getClientOriginalName();
        $path = Storage::putFileAs('public/images', $request->file('avatar_image'), $imageName);
        $cityManager->city_manager_id=request('city_manager');
        $cityManager->city_id=request('city_name');
        $cityManager->avatar_image=$imageName;
        $cityManager->national_id=request('national_id');
        $cityManager->save();
        return redirect(route('citiesManagers.index'))->with('success','Added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cityManager =CityManager::findOrFail($id);
        $cities =City::all();
        return view('CityManager.index',compact(['cityManager','cities']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($city_manager_id)
    {

        // $cityManager =CityManager::where('city_manager_id',$city_manager_id)->first();
        // $cities = City::all();
        // $users=User::all();
        // return view('CityManager.edit', [
        //     'cityManager'=>$cityManager,
        //     'cities'=>$cities,
        //     'users'=>$users
        // ]);

        // $cityManager =CityManager::where('city_manager_id',$city_manager_id)->first();
        // $cities =City::all();

        // return view('CityManager.edit',['cityManager'=>$cityManager,'cities'=>$cities,'users'=>$users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $city_manager_id)
    {
        // $cityManager =CityManager::where('city_manager_id',$city_manager_id)->first();
        // //$cityManager = request()->all();

        // if ($request->hasFile('avatar_image')){
        //     $file = $request->file('avatar_image');
        //     $imageName = $file->getClientOriginalName();
        //     $path = Storage::putFileAs('public/images', $request->file('avatar_image'), $imageName);
        //     $cityManager->avatar_image=$imageName;
        // }


        // $cityManager->city_manager_id=request('city_manager');
        // $cityManager->city_id=request('city_name');
        // $cityManager->national_id=request('national_id');
        // $cityManager->save();
        // return redirect(route('citiesManagers.index'))->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$cityManager =CityManager::findOrFail($id);
        // $cityManager =CityManager::where('city_manager_id',$id)->first();
        // $cityManager->delete();
        // Storage::delete('images/'.$cityManager->avatar_image);

        return redirect(route('citiesManagers.index'))->with('success','Deleted Successfully');

    }
}
