<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use Illuminate\Http\Request;
use App\DataTables\GymDataTable;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Carbon;
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
        return view("Admin.gyms.create");
    }
    
}
