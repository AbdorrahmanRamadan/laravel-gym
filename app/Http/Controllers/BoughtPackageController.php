<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BoughtPackage;
use App\Models\Gym;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Trainee;
use App\Models\TrainingPackage;
use Stripe;
use Session;

class BoughtPackageController extends Controller
{
    public function index()
    {
        $packages = BoughtPackage::all();
        return view('Boughtpackages.index', ['packages' => $packages]);
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

    public function create()
    {
        $gyms = Gym::all();
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
}
