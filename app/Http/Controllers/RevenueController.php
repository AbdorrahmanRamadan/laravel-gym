<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Revenue;
use App\Models\BoughtPackage;
use App\Models\Gym;
use App\Models\CityManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    public function index(){

        $userRole = Auth::user()->roles->pluck('name')[0];

        if($userRole == 'admin'){
            $revenue=BoughtPackage::get()->sum('purchase_price');
        }
        // else if($userRole == 'city_manager'){
        //     $currentUserId=Auth::id();
        //     $city_id = CityManager::where('city_manager_id',$currentUserId)->value('city_id');
        //     $gymsId = Gym::where('city_id',$city_id)->value('id');  //array
        //     $revenue=DB::table('bought_packages')->select('purchase_price')->whereIn('gym_id',$gymsId)->sum('purchase_price');
        //     //$revenue=BoughtPackage::where()->sum('purchase_price');
        // }else if($userRole == 'gym_manager'){
        //     $gymId=Auth::id();
        //     $revenue=BoughtPackage::where('gym_id',$gymId)->sum('purchase_price');
        // }
        return view("Revenue.index",['revenue'=> $revenue]);
    }
}
