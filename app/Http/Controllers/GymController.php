<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\City;
use App\Models\CityManager;

use Illuminate\Http\Request;
use App\DataTables\GymDataTable;
use App\Http\Requests\StoreGymRequest;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class GymController extends Controller
{
    public function index(){
        return view("Gyms.index");
    }
    public function getGyms()
    {
        $userRole = Auth::user()->roles->pluck('name')[0];
        if($userRole == 'admin'){
            $gyms =  Gym::with('user')->select('gyms.*');
            return datatables()->eloquent($gyms)->addIndexColumn()->addColumn('action', function($gym){
                return '<a href="'.route('Gyms.edit', $gym->id).'" class="edit btn btn-primary btn-sm me-2">Edit</a><form class="d-inline" action="'.route('Gyms.destroy',  $gym->id ).'" method="POST">
            '.csrf_field().'
            '.method_field("DELETE").'
            <button type="submit" class="btn btn-danger btn-sm me-2"
                onclick="return confirm(\'Are You Sure Want to Delete?\')"
            ">Delete</a>
            </form>';
            })->editColumn('created_at', function($gym){
                return Carbon::parse($gym->created_at)->toDateString();
            })->editColumn('created_by', function($gym){
                return $gym->user->name;
            })->editColumn('city_manager', function($gym){
                return $gym->city->city_manager->user->name;
            })->rawColumns(['action', 'created_by'])->toJson();
        }else if($userRole == 'city_manager') {
            $currentId=Auth::id();
            $cityId=CityManager::where('city_manager_id',$currentId)->value('city_id');
            $gyms=Gym::with('user')->select('*')->where('city_id', $cityId);
           return datatables()->eloquent($gyms)->addIndexColumn()->addColumn('action', function($gym){
               return '<a href="'.route('Gyms.edit', $gym->id).'" class="edit btn btn-primary btn-sm me-2">Edit</a><form class="d-inline" action="'.route('Gyms.destroy',  $gym->id ).'" method="POST">
            '.csrf_field().'
            '.method_field("DELETE").'
            <button type="submit" class="btn btn-danger btn-sm me-2"
                onclick="return confirm(\'Are You Sure Want to Delete?\')"
            ">Delete</a>
            </form>';
            })->editColumn('created_at', function($gym){
                return Carbon::parse($gym->created_at)->toDateString();
            })->editColumn('created_by', function($gym){
                return $gym->user->name;
            })->rawColumns(['action', 'created_by'])->toJson();
        }
    }
    public function create(){
        $userRole = Auth::user()->roles->pluck('name')[0];
        if($userRole == 'admin'){
            $cities = City::all();

        }else if($userRole == 'city_manager') {
            $currentId=Auth::id();
            $cityId=CityManager::where('city_manager_id',$currentId)->value('city_id');
            $cities = City::where('id',$cityId)->get();
        }
        return view("Gyms.create",[
            'cities'=>$cities,
        ]);
    }
    public function store(StoreGymRequest $request){
        $coverImage=$path=$name='';
        if($request->file('cover_image')){
            $coverImage = $request->file('cover_image');
            $name = $coverImage->getClientOriginalName();
            $path = Storage::putFileAs('public/gymImages', $request->file('cover_image'), $name);
        }
        $gymInfo = request()->all();
        Gym::create([
            'name'=>$gymInfo['name'],
            'cover_image'=>$name,
            'created_by'=>Auth::id(),
            'city_id'=>$gymInfo['city'],
        ]);

       return redirect(route('Gyms.index'))->with('status', 'Gym is inserted successfully');
    }
    public function edit($gymId){
        $userRole = Auth::user()->roles->pluck('name')[0];
        if($userRole == 'admin'){
            $cities = City::all();

        }else if($userRole == 'city_manager') {
            $currentId=Auth::id();
            $cityId=CityManager::where('city_manager_id',$currentId)->value('city_id');
            $cities = City::where('id',$cityId)->get();
        }
        $gymInfo = Gym::find($gymId);
        return view('Gyms.edit', [
            'gym' => $gymInfo,
            'cities'=>$cities,
        ]);
    }

    public function update(StoreGymRequest $request, $gymId)
    {
        $oldImage = Gym::find($gymId)->cover_image;
        if($oldImage)
            unlink(storage_path('app/public/gymImages/'.$oldImage));
        $coverImage=$path=$name='';
        if($request->file('cover_image')){
            $coverImage = $request->file('cover_image');
            $name = $coverImage->getClientOriginalName();
            $path = Storage::putFileAs('public/gymImages', $request->file('cover_image'), $name);
        }
        $gymInfo = request()->all();
        Gym::where('id', $gymId)->update([
            'name'=>$gymInfo['name'],
            'cover_image'=>$name,
            'created_by'=>Auth::id(),
            'city_id'=>$gymInfo['city']
        ]);
        return redirect(route('Gyms.index'))->with('status', 'Gym Data is updated successfully');
    }

    public function destroy($gymId)
    {
        $gym = Gym::find($gymId);
        $gym->delete();
        Storage::delete('public/gymImages/'.$gym->cover_image);
        return redirect(route('Gyms.index'))->with('status', 'Gym is deleted successfully');
    }

}
