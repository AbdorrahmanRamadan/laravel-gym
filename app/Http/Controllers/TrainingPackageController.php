<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingPackageRequest;
use App\Http\Requests\UpdateTrainingPackageRequest;
use App\Models\TrainingPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TrainingPackageController extends Controller
{
    public function index()
    {
        return view('TrainingPackages.index');
    }

    public function getTrainingPackages()
    {
        $TrainingPackages = TrainingPackage::query();
        return datatables()->eloquent($TrainingPackages)->addIndexColumn()->addColumn('action', function ($TrainingPackage) {
            return '
            <a href="' . route('TrainingPackages.show', $TrainingPackage->id) . '" class="btn btn-primary">View</a>
            <a href="' . route('TrainingPackages.edit', $TrainingPackage->id) . '" class="btn btn-success">Edit</a><form class="d-inline" action="' . route('TrainingPackages.destroy',  $TrainingPackage->id) . '" method="POST">
	            ' . csrf_field() . '
	            ' . method_field("DELETE") . '
	            <button type="submit" class="btn btn-danger"
	                onclick="return confirm(\'Are You Sure Want to Delete?\')"
	            ">Delete</a>
	            </form>';
        })->editColumn('price', function ($TrainingPackage) {
            return $TrainingPackage->price / 100;
        })->rawColumns(['action'])->toJson();
    }


    public function create()
    {
        return view('TrainingPackages.create');
    }

    public function store(StoreTrainingPackageRequest  $request)
    {
        TrainingPackage::create([
            'name' => $request['name'],
            'price' => $request['price'] * 100,
            'number_of_sessions' => $request['number_of_sessions'],
        ]);
        return to_route('TrainingPackages.index');
    }


    public function show($packageId)
    {
        $package = TrainingPackage::find($packageId);
        return view('TrainingPackages.show', [
            'package' => $package,
        ]);
    }
    public function edit($packageId)
    {
        $package = TrainingPackage::find($packageId);
        return view('TrainingPackages.edit', [
            'package' => $package,
        ]);
    }

    public function update(UpdateTrainingPackageRequest $request, $packageId)
    {
        TrainingPackage::where('id', $packageId)
            ->update([
                'name' => $request['name'],
                'price' => $request['price'] * 100,
                'number_of_sessions' => $request['number_of_sessions'],
            ]);
        return to_route('TrainingPackages.index');
    }

    public function destroy($packageId)
    {
        TrainingPackage::find($packageId)->delete();
        return to_route('TrainingPackages.index');
    }
}
