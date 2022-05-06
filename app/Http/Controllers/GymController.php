<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use App\Models\City;
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
        $gyms =  Gym::with('user')->select('gyms.*');
        return datatables()->eloquent($gyms)->addIndexColumn()->addColumn('action', function($gym){
            return '
            <a href="'.route('Gyms.show', $gym->id).'" class="edit btn btn-primary btn-sm me-2">View</a>
            <a href="'.route('Gyms.edit', $gym->id).'" class="edit btn btn-success btn-sm me-2">Edit</a><form class="d-inline" action="'.route('Gyms.destroy',  $gym->id ).'" method="POST">
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
    public function create(){
        $cities = City::all();
        return view("Gyms.create",[
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

       return redirect(route('Gyms.index'))->with('status', 'Gym is inserted successfully');
    }

    public function show($gymId){
        $gymInfo = Gym::find($gymId);
        $cities = City::all();
        return view('Gyms.show', [
            'gym' => $gymInfo,
            'cities'=>$cities
        ]);
    }
    public function edit($gymId){
        $gymInfo = Gym::find($gymId);
        $cities = City::all();
        return view('Gyms.edit', [
            'gym' => $gymInfo,
            'cities'=>$cities
        ]);
    }

    public function update(StoreGymRequest $request, $gymId)
    {
        $gymInfo = request()->all();
        $oldImage = Gym::find($gymId)->cover_image;
        $coverImage = $request->file('cover-image');
        $name = $coverImage->getClientOriginalName();
        unlink(storage_path('app/public/gymImages/'.$oldImage));
        $path = Storage::putFileAs(
            'public/gymImages', $coverImage, $name
        );
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
