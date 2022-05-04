<?php

namespace App\Http\Controllers;

use App\Models\CityManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\City;
use App\Models\User;
use App\Http\Requests\StoreCityManagerRequest;
use App\Http\Requests\UpdateCityManagerRequest;

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($city_manager_id)
    {

        $cityManager =CityManager::where('city_manager_id',$city_manager_id)->first();

        $cities =City::all();
        $users=User::all();

        return view('CityManager.edit',['cityManager'=>$cityManager,'cities'=>$cities,'users'=>$users]);
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
           $data=$request->all();
         $imgName = $cityManager->avatar_image;
        $coverImage = $request->file('avatar_image');
        $name = $coverImage->getClientOriginalName();
        unlink(storage_path('app/public/images/'.$imgName));
        $path = Storage::putFileAs(
            'public/images', $coverImage, $name
        );

        CityManager::where('city_manager_id', $city_manager_id)->update([
            'city_manager_id' => $data['city_manager'],
            'city_id' =>$data['city_name'] ,
            'national_id' => $data['national_id'],
            'avatar_image'=>$name
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
