<?php

namespace App\Http\Controllers;

use App\Models\GymManager;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
class GymManagerController extends Controller
{
    public function index(){
        return view("Admin.GymManagers.index");
    }
    public function getGymManagers()

    {
        $gymManagers =  GymManager::with('user', 'gym')->select('gym_managers.*');
        return datatables()->eloquent($gymManagers)->addIndexColumn()->addColumn('action', function($gymManager){
            return '<a href="'.route('Admin.GymManagers.edit', $gymManager->id).'" class="edit btn btn-primary btn-sm me-2">Edit</a><form class="d-inline" action="'.route('Admin.GymManagers.destroy',  $gymManager->id ).'" method="POST">
            '.csrf_field().'
            '.method_field("DELETE").'
            <button type="submit" class="btn btn-danger btn-sm me-2"
                onclick="return confirm(\'Are You Sure Want to Delete?\')"
            ">Delete</a>
            </form>';
        })->editColumn('name', function($gymManager){
            return $gymManager->user->name;
        })->editColumn('email', function($gymManager){
            return $gymManager->user->email;
        })->editColumn('created_at', function($gymManager){
            return Carbon::parse($gymManager->created_at)->toDateString();
        })->editColumn('gym_id', function($gymManager){
            return $gymManager->gym->name;
        })->rawColumns(['action'])->toJson();
    }

    public function destroy($gymManagerId)
    {
        $gymManager = GymManager::find($gymManagerId);
        $gymManager->delete();
        if (Storage::exists('public/gymManagers/'.$gymManager->cover_image)) {
            Storage::delete('public/gymManagers/'.$gymManager->cover_image);
        }
        return redirect('/admin/gym-managers')->with('status', 'Gym Manager is deleted successfully');
    }
}
