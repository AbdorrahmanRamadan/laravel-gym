<?php

namespace App\Http\Controllers;

use App\DataTables\CityDataTable;
use App\Models\City;
use App\Models\User;
use App\Notifications\Welcome;
use Illuminate\Http\Request;
//use DataTables;
use Yajra\DataTables\DataTables;
//use Yajra\DataTables\Facades\DataTables;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\CityStoreRequest;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Cities.index');
    }
    public function getCities()

    {
        $cities = City::select(['id', 'name', 'created_at', 'updated_at']);

        return datatables()->eloquent($cities)->addIndexColumn()->addColumn('action', function ($city) {
            return '
            <a href="' . route("Cities.show", $city->id) . '" class="edit btn btn-primary btn-sm me-2">View</a>
            <a href="' . route("Cities.edit", $city->id) . '" class="edit btn btn-success btn-sm me-2">Edit</a>
            <form class="d-inline" action="' . route('Cities.destroy',  $city->id) . '" method="POST">
            ' . csrf_field() . '
            ' . method_field("DELETE") . '
            <button type="submit" class="btn btn-danger btn-sm me-2"
                onclick="return confirm(\'Are You Sure Want to Delete?\')"
            ">Delete</a>
            </form>
            ';
        })->rawColumns(['action'])->toJson();
    }
    public function create()
    {
        return view('Cities.create');
    }


    public function store(CityStoreRequest $request)
    {
        $city = new City();
        $city->name = request('city_name');
        $city->save();
        return redirect(route('Cities.index'))->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city = City::findorFail($id);
        return view('Cities.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::findOrFail($id);


        return view('Cities.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $city->name = request('city_name');
        $city->save();
        return redirect(route('Cities.index'))->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $city = City::findOrFail($id);
            $city->delete();
            return redirect(route('Cities.index'))->with('success', 'Deleted Successfully');
        } catch (\Throwable $e) {
            return redirect(route('Cities.index'))->with('danger', 'This City Cannot Be Deleted It Assigned To City Manager ');
        }
    }
}
