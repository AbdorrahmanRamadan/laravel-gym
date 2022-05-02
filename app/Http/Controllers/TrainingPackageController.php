<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingPackageRequest;
use App\Http\Requests\UpdateTrainingPackageRequest;
use App\Models\TrainingPackage;
use Illuminate\Http\Request;

class TrainingPackageController extends Controller
{
    public function index()
    {
        $TrainingPackages = TrainingPackage::paginate(7);
        return view('Admin.TrainingPackages.index',['TrainingPackages' =>$TrainingPackages]);
    }

    public function create()
    {
        return view('Admin.TrainingPackages.create');
    }

    public function store(StoreTrainingPackageRequest  $request)
    {
        TrainingPackage::create([
            'name'=>$request['name'],
            'price'=>$request['price']*100,
            'number_of_sessions'=>$request['number_of_sessions'],
        ]);
        return to_route('Admin.TrainingPackages.index');
    }
    public function edit($packageId)
    {
        $package=TrainingPackage::find($packageId);
        return view('Admin.TrainingPackages.edit',[
            'package' => $package,
        ]);
    }

    public function update(UpdateTrainingPackageRequest $request,$packageId)
    {
        TrainingPackage::where('id',$packageId)
            ->update([
                'name'=>$request['name'],
                'price'=>$request['price']*100,
                'number_of_sessions'=>$request['number_of_sessions'],
            ]);
        return to_route('Admin.TrainingPackages.index');
    }

    public function destroy($packageId)
    {
        TrainingPackage::find($packageId)->delete();
        return to_route('Admin.TrainingPackages.index');
    }
}
