<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Coach;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreCoachRequest;

class CoachController extends Controller
{
    public function index()
    {
        return view('Coaches.index');
    }

    public function getCoaches()
    {
        $coaches = Coach::with('user')->select('coaches.*');
        return datatables()->eloquent($coaches)->addIndexColumn()->addColumn('action', function ($coach) {
            return '
            <a href="' . route('Coaches.show', $coach->id) . '" class="edit btn btn-primary btn-sm me-2">View</a>
            <a href="' . route('Coaches.edit', $coach->id) . '" class="edit btn btn-success btn-sm me-2">Edit</a><a href="javascript:void(0)" class="btn btn-danger" onclick="deleteCoach(' . $coach->id . ')">Delete</a>';
        })->editColumn('id', function ($coach) {
            return $coach->user->name;
        })->editColumn('id', function ($coach) {
            return $coach->user->email;
        })->rawColumns(['action'])->toJson();
    }

    public function create()
    {
        return view('Coaches.create');
    }

    public function store(StoreCoachRequest $request)
    {
        $submitted_data = request()->all();

        $User = User::create([
            'name' => $submitted_data['name'],
            'email' => $submitted_data['email'],
            'password' => Hash::make($submitted_data['password']),
            // :coach - city! - gym!
        ]);

        Coach::create([
            'id' => $User['id'],
            'national_id' => $submitted_data['national_id'],
        ]);

        return to_route('Coaches.index');
    }


    public function show($coach_id)
    {
        $coach = Coach::where('id', $coach_id)->first();

        return view('Coaches.show', ['coach' => $coach]);
    }

    public function edit($coach_id)
    {
        $coach = Coach::where('id', $coach_id)->first();

        return view('Coaches.edit', ['coach' => $coach]);
    }

    public function update(StoreCoachRequest $request, $coach_id)
    {
        $modified_data = request()->all();

        Coach::where('id', $coach_id)->update([
            'national_id' => $modified_data['national_id'],
        ]);

        User::where('id', $coach_id)->update([
            'name' => $modified_data['name'],
            'email' => $modified_data['email'],
            'password' => Hash::make($modified_data['password']),
        ]);

        return to_route('Coaches.index');
    }


    public function destroy($coach_id)
    {
        try{
        Coach::where('id', $coach_id)->delete();

        User::find($coach_id)->delete();

       // return to_route('Coaches.index');
       return response()->json(['success' => "Coach Deleted successfully."]);
    }catch(\throwable $th){
       // return redirect('Coashes.index');
       //return response()->json(['danger' => "This Coach Cannot Be Deleted It Assigned To City Manager"]);

    }
    }
}
