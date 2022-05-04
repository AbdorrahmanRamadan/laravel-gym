<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingSessionRequest;
use App\Http\Requests\UpdateTrainingSessionRequest;
use App\Models\Gym;
use App\Models\TrainingSession;
use Illuminate\Http\Request;

class TrainingSessionController extends Controller
{
    public function index()
    {
        return view('Admin.TrainingSessions.index');
    }

    public function getTrainingSessions()
    {
        $TrainingSessions = TrainingSession::with('gym')->select('training_sessions.*');
        return datatables()->eloquent($TrainingSessions)->addIndexColumn()->addColumn('action', function ($TrainingSession) {
            return '<a href="' . route('Admin.TrainingSessions.edit', $TrainingSession->id) . '" class="btn btn-primary">Edit</a><form class="d-inline" action="' . route('Admin.TrainingSessions.destroy', $TrainingSession->id) . '" method="POST">
	            ' . csrf_field() . '
	            ' . method_field("DELETE") . '
	            <button type="submit" class="btn btn-danger"
	                onclick="return confirm(\'Are You Sure Want to Delete?\')"
	            ">Delete</a>
	            </form>';
        })->editColumn('gym_id', function($TrainingSession){
            return $TrainingSession->gym->name;
            })->rawColumns(['action'])->toJson();
    }

    public function create()
    {
        $gyms = Gym::all();

        return view('Admin.TrainingSessions.create',[
            'gyms' => $gyms,
        ]);
    }

    public function store(StoreTrainingSessionRequest  $request)
    {
        TrainingSession::create([
            'name'=>$request['name'],
            'start_at'=>$request['start_at'],
            'end_at'=>$request['end_at'],
            'gym_id'=>$request['gym_id'],
        ]);
        return to_route('Admin.TrainingSessions.index');
    }
    public function edit($SessionId)
    {
        $gyms = Gym::all();
        $session=TrainingSession::find($SessionId);
        $selectedGym=Gym::find($session['gym_id']);
        return view('Admin.TrainingSessions.edit',[
            'session' => $session,
            'gyms' => $gyms,
            'selectedGym' => $selectedGym,
        ]);
    }

    public function update(UpdateTrainingSessionRequest $request,$SessionId)
    {
        TrainingSession::where('id',$SessionId)
            ->update([
                'name'=>$request['name'],
                'start_at'=>$request['start_at'],
                'end_at'=>$request['end_at'],
                'gym_id'=>$request['gym_id'],
            ]);
        return to_route('Admin.TrainingSessions.index');
    }

    public function destroy($SessionId)
    {
        TrainingSession::find($SessionId)->delete();
        return to_route('Admin.TrainingSessions.index');
    }
}
