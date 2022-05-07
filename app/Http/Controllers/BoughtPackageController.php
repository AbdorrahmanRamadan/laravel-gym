<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BoughtPackage;
use App\Models\Gym;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Trainee;
use App\Models\TrainingPackage;
use App\Models\CityManager;
use Stripe;
use Session;
use Illuminate\Support\Facades\Auth;


class BoughtPackageController extends Controller
{
    public function index()
    {
        $userRole = Auth::user()->roles->pluck('name')[0];
        $currentUserId = Auth::id();
        if ($userRole == 'admin') {
            $packages = BoughtPackage::all();
        } else if ($userRole == 'city_manager') {
            $city_id = CityManager::where('city_manager_id', $currentUserId)->value('city_id');
            $gymsId = Gym::where('city_id', $city_id)->get()->pluck('id');
            $packages = DB::table('bought_packages')->select('*')->whereIn('gym_id', $gymsId)->get();
        } else if ($userRole == 'gym_manager') {
            $gymId = Gym::where('id', $currentUserId)->value('city_id');
            $packages = DB::table('bought_packages')->select('*')->where('gym_id', $gymId)->get();
        }

        return view('Boughtpackages.index', ['packages' => $packages]);
    }

    public function create()
    {

        $userRole = Auth::user()->roles->pluck('name')[0];
        $currentUserId = Auth::id();
        if ($userRole == 'admin') {
            $gyms = Gym::all();
        } else if ($userRole == 'city_manager') {
            $city_id = CityManager::where('city_manager_id', $currentUserId)->value('city_id');
            $gyms = Gym::where('city_id', $city_id)->get();
        } else if ($userRole == 'gym_manager') {
            $gyms = Gym::where('id', $currentUserId)->get();
        }
        $training_packages = TrainingPackage::all();
        $trainees = Trainee::all();
        return view("Boughtpackages.create", [
            'gyms' => $gyms,
            'training_packages' => $training_packages,
            'trainees' => $trainees
        ]);
    }
    public function store(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $bought_package = request()->all();
            $price = TrainingPackage::select('price')->where('id', $bought_package['package'])->pluck('price');
            $num_of_sessions = TrainingPackage::select('number_of_sessions')->where('id', $bought_package['package'])->pluck('number_of_sessions');


            Stripe\Charge::create([
                "amount" => 100 * 150,
                "currency" => "inr",
                "source" => $request->stripeToken,
                "description" => "Making test payment."
            ]);

            $pack_obj = BoughtPackage::create([
                'trainee_id' => $bought_package['trainee'],
                'gym_id' => $bought_package['gym'],
                'training_package_id' => $bought_package['package'],
                'purchase_price' => $price[0] / 100,
            ]);
            DB::table('trainees')->where('trainee_id', $pack_obj->trainee_id)->update(['remaining_sessions' => $num_of_sessions[0]]);

            return redirect(route('Boughtpackages.index'))->with('status', 'Package Bought Successfully');
        } catch (\Throwable $th) {
            Session::flash('error', 'Payment has been failed.');
            return back();
        }
    }

    public function destroy($packId)
    {
        $package = BoughtPackage::find($packId);
        $package->delete();
        return redirect(route('Boughtpackages.index'))->with('status', 'Bought Package is deleted successfully');
    }


    // public function getBoughtPackages(){

    //     $packages = BoughtPackage::with('user','gym','training_package')->select('bought_packages.*');
    //     return datatables()->eloquent($packages)->addIndexColumn()
    //     ->addColumn('action', function($pack){
    //         return '<form class="d-inline" action="'.route('Boughtpackages.destroy',  $pack->id ).'" method="POST">
    //         '.csrf_field().'
    //         '.method_field("DELETE").'
    //         <button type="submit" class="btn btn-danger btn-sm me-2"
    //             onclick="return confirm(\'Are You Sure Want to Delete?\')"
    //         ">Delete</a>
    //         </form>';

    //     })
    //     ->editColumn('trainee_id', function($pack){
    //         return $pack->user->name;
    //    })
    //     ->editColumn('gym_id', function($pack){
    //         return $pack->gym->name;
    //    })
    //     ->editColumn('training_package_id', function($pack){
    //         return $pack->training_package->name;
    //    })
    //     ->toJson();
    // }
}
