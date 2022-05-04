<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\City;
use Illuminate\Http\Request;
use App\DataTables\GymDataTable;
use App\Http\Requests\StoreGymRequest;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Carbon;
use Auth;
use Illuminate\Support\Facades\Storage;
class GymController extends Controller
{
    public function index(){
        return view("Admin.gyms.index");
    }
    public function getGyms()

    {
        $gyms = Gym::query();
        return datatables()->eloquent($gyms)->addIndexColumn()->addColumn('action', function($gym){
            return '<a href="#" class="edit btn btn-primary btn-sm me-2">Edit</a><a href="#" class="edit btn btn-danger btn-sm">Delete</a>';
        })->editColumn('created_at', function($gym){
            return Carbon::parse($gym->created_at)->toDateString();
        })->editColumn('city_id', function($gym){
            return $gym->user->name;
        })->rawColumns(['action'])->toJson();
    }
    public function create(){
        $cities = City::all();
        return view("Admin.gyms.create",[
            'cities'=>$cities
        ]);
    }
    public function store(StoreGymRequest $request){
        $gymInfo = request()->all();
        $coverImage = $request->file('cover-image');
        $name = $coverImage->getClientOriginalName();
        $path = Storage::putFileAs(
            'public/gymImages', $coverImage, $name
        );
        Gym::create([
            'name'=>$gymInfo['name'],
            'cover_image'=>$name,
            'created_by'=>Auth::id(),
            'city_id'=>$gymInfo['city'],
        ]);
        
       return redirect('/Admin/gyms')->with('status', 'Gym is inserted successfully');
    }
    
}
