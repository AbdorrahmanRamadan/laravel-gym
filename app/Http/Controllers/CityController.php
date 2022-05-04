<?php

namespace App\Http\Controllers;

use App\DataTables\CityDataTable;
use App\Models\City;
use Illuminate\Http\Request;
 //use DataTables;
 use Yajra\DataTables\DataTables;
//use Yajra\DataTables\Facades\DataTables;


class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('Admin.cities.index');
    }
    public function getCities()

    {
        //$cities = City::query();
        $cities = City::select(['id', 'name','created_at', 'updated_at']);

        return datatables()->eloquent($cities)->addIndexColumn()->addColumn('action', function($city){
            return '
            <a href="'. route("cities.edit", $city->id) .'" class="edit btn btn-success btn-sm me-2">Edit</a>
            <form class="d-inline" action="'.route('cities.destroy',  $city->id).'" method="POST">
            '.csrf_field().'
            '.method_field("DELETE").'
            <button type="submit" class="btn btn-danger btn-sm me-2"
                onclick="return confirm(\'Are You Sure Want to Delete?\')"
            ">Delete</a>
            </form>
            ';
        })->rawColumns(['action'])->toJson();
    }
    //<a href="'. route("cities.destroy" .'" class="edit btn btn-danger btn-sm me-2" id="deleteCityBtn" data-id="'.$city->id.'">Delete</a>

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $city = new City();
        $city->name=request('city_name');
        $city->save();
        return redirect(route('cities.index'))->with('success','Added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $city=City::findorFail($id);
        return view('Admin.cities.show',compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city =City::findOrFail($id);


        return view('Admin.cities.edit',compact('city'));
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
        $city =City::findOrFail($id);
        $city->name=request('city_name');
        $city->save();
        return redirect(route('cities.index'))->with('success','Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        $city =City::findOrFail($id);
        $city->delete();
        return redirect(route('cities.index'))->with('success','Deleted Successfully');
    }


}