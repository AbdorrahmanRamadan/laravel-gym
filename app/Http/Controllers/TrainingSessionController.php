<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingSessionRequest;
use App\Models\Coach;
use App\Models\CoachSession;
use App\Models\Gym;
use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Http\Request;

class TrainingSessionController extends Controller
{
    public function index()
    {
        //Coach::all()->sessions->pluck('name');
       /* $arr = array();
        foreach (Coach::all() as $coach){
           $arr[] = $coach->sessions->pluck('name');
        }
        dd($arr);*/
        /*$arr = array();
        foreach (TrainingSession::all() as $coach){
            $arr[] = User::find($coach->coaches->pluck('id'))->pluck('name');
        }
        dd($arr);*/
        return view('TrainingSessions.index');
    }

    public function getTrainingSessions()
    {
        $TrainingSessions = TrainingSession::with('gym','coaches')->select('training_sessions.*');
        return datatables()->eloquent($TrainingSessions)->addIndexColumn()->addColumn('action', function ($TrainingSession) {
            return '<a href="' . route('TrainingSessions.edit', $TrainingSession->id) . '" class="btn btn-primary">Edit</a><form class="d-inline" action="' . route('TrainingSessions.destroy', $TrainingSession->id) . '" method="POST">
	            ' . csrf_field() . '
	            ' . method_field("DELETE") . '
	            <button type="submit" class="btn btn-danger"
	                onclick="return confirm(\'Are You Sure Want to Delete?\')"
	            ">Delete</a>
	            </form>';
        })->editColumn('gym_id', function($TrainingSession){
            return $TrainingSession->gym->name;
        })->editColumn('coach', function($TrainingSession) {
            $session_coaches = '';
            foreach (User::find($TrainingSession->coaches->pluck('id'))->pluck('name') as $coach){
                $session_coaches.=$coach.', ';
            }
            return substr($session_coaches,0,-2);;
            })->rawColumns(['action'])->toJson();
    }

    public function create()
    {
        $gyms = Gym::all();
        $coaches= Coach::all();
        return view('TrainingSessions.create',[
            'coaches'=>$coaches,
            'gyms' => $gyms,
        ]);
    }

    public function store(StoreTrainingSessionRequest  $request)
    {
        $trainingSession=TrainingSession::create([
            'name'=>$request['name'],
            'start_at'=>$request['start_at'],
            'end_at'=>$request['end_at'],
            'gym_id'=>$request['gym_id'],
        ]);
        foreach ($request['coach'] as $coach){
            CoachSession::create([
                'coach_id'=>$coach,
                'training_session_id'=>$trainingSession->id,
            ]);
        }
        return to_route('TrainingSessions.index');
    }
    public function edit($SessionId)
    {
        $coaches= Coach::all();
        $gyms = Gym::all();
        $session=TrainingSession::find($SessionId);
        $selectedGym=Gym::find($session['gym_id']);
        $selectedCoaches=User::find(TrainingSession::find($SessionId)->coaches->pluck('id'));
        return view('TrainingSessions.edit',[
            'coaches'=>$coaches,
            'selectedCoaches' => $selectedCoaches,
            'session' => $session,
            'gyms' => $gyms,
            'selectedGym' => $selectedGym,
        ]);
    }

    public function update(StoreTrainingSessionRequest $request,$SessionId)
    {
        TrainingSession::where('id',$SessionId)
            ->update([
                'name'=>$request['name'],
                'start_at'=>$request['start_at'],
                'end_at'=>$request['end_at'],
                'gym_id'=>$request['gym_id'],
            ]);
        CoachSession::where('training_session_id',$SessionId)
            ->delete();
        foreach ($request['coach'] as $coach){
            CoachSession::create([
                'coach_id'=>$coach,
                'training_session_id'=>$SessionId,
            ]);
        }
        return to_route('TrainingSessions.index');
    }

    public function destroy($SessionId)
    {
        CoachSession::where('training_session_id',$SessionId)->delete();
        TrainingSession::find($SessionId)->delete();
        return to_route('TrainingSessions.index');
    }
}
