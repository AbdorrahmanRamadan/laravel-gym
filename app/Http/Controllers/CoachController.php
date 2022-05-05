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
        //$coaches = Coach::all();
       // dd(Coach::where('coach_id', 2)->first()->training_sessions);
        //return view('Admin.Coaches.index',['coaches'=>$coaches]);
    }

    public function create()
    {
        return view('Admin.Coaches.create');
    }

    public function store(StoreCoachRequest $request)
    {
        $submitted_data = request()->all();

        $User=User::create([
            'name'=>$submitted_data['name'],
            'email'=>$submitted_data['email'],
            'password'=>Hash::make($submitted_data['password']),
            // :coach - city! - gym!
        ]);

        Coach::create([
            'coach_id'=> $User['id'],
            'national_id'=> $submitted_data['national_id'],
        ]);

        return to_route('Admin.Coaches.index');
    }

    public function edit($coach_id)
    {
       $coach = Coach::where('coach_id', $coach_id)->first();

       return view('Admin.Coaches.edit',['coach'=> $coach]);
    }

    public function update(StoreCoachRequest $request, $coach_id)
    {
        $modified_data = request()->all();

        Coach::where('coach_id', $coach_id)->update([
            'national_id'=>$modified_data['national_id'],
        ]);

        User::where('id', $coach_id)->update([
            'name'=>$modified_data['name'],
            'email'=>$modified_data['email'],
            'password'=>Hash::make($modified_data['password']),
        ]);

        return to_route('Admin.Coaches.index');
    }


    public function destroy($coach_id)
    {
        Coach::where('coach_id',$coach_id)->delete();

        User::find($coach_id)->delete();

        return to_route('Admin.Coaches.index');
    }

}
