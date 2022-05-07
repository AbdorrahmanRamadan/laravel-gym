<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingPackageRequest;
use App\Http\Requests\UpdateTrainingPackageRequest;
use App\Models\TrainingPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TrainingPackageController extends Controller
{
    public function index()
    {
        $userRole = Auth::user()->roles->pluck('name')[0];
        if ($userRole == 'admin') {
            return view('TrainingPackages.index');
        } else {
            return view('403');
        }
    }

    public function getTrainingPackages()
    {
        $userRole = Auth::user()->roles->pluck('name')[0];
        if ($userRole == 'admin') {
            $TrainingPackages = TrainingPackage::query();
            return datatables()->eloquent($TrainingPackages)->addIndexColumn()->addColumn('action', function ($TrainingPackage) {
                return '
                <a href="' . route('TrainingPackages.show', $TrainingPackage->id) . '" class="btn btn-primary">View</a>
                <a href="' . route('TrainingPackages.edit', $TrainingPackage->id) . '" class="btn btn-success">Edit</a><a href="javascript:void(0)" class="btn btn-danger" onclick="deleteTrainingPackage(' . $TrainingPackage->id . ')">Delete</a>';
            })->editColumn('price', function ($TrainingPackage) {
                return $TrainingPackage->price / 100;
            })->rawColumns(['action'])->toJson();
        } else {
            return view('403');
        }
    }


    public function create()
    {
        $userRole = Auth::user()->roles->pluck('name')[0];
        if ($userRole == 'admin') {
            return view('TrainingPackages.create');
        } else {
            return view('403');
        }
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
        $userRole = Auth::user()->roles->pluck('name')[0];
        if ($userRole == 'admin') {
            $package = TrainingPackage::find($packageId);
            return view('TrainingPackages.show', [
                'package' => $package,
            ]);
        } else {
            return view('403');
        }
    }
    public function edit($packageId)
    {
        $userRole = Auth::user()->roles->pluck('name')[0];
        if ($userRole == 'admin') {
            $package = TrainingPackage::find($packageId);
            return view('TrainingPackages.edit', [
                'package' => $package,
            ]);
        } else {
            return view('403');
        }
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
        $userRole = Auth::user()->roles->pluck('name')[0];
        if ($userRole == 'admin') {
           try{
            TrainingPackage::find($packageId)->delete();
            //return to_route('TrainingPackages.index');
            return response()->json(['success' => "Training Package Deleted successfully."]);
        }
            catch(\throwable $th){
               // return redirect(route('TrainingPackages.index'))->with('danger', 'This Package Cannot Be Deleted It Assigned To Bought Package ');
               return response()->json(['danger' => "This Training Package Cannot Be Deleted It Purchased"]);


            }
        } else {
            return view('403');
        }
    }
}
