<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingSessionRequest;
use App\Models\Coach;
use App\Models\CoachSession;
use App\Models\Gym;
use App\Models\TrainingSession;
use App\Models\CityManager;
use App\Models\GymManager;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $userRole = Auth::user()->roles->pluck('name')[0];
        $currentUserId = Auth::id();

        if ($userRole == 'admin') {
            $TrainingSessions = TrainingSession::with('gym', 'coaches')->select('training_sessions.*');
        } else if ($userRole == 'city_manager') {
            $city_id = CityManager::where('city_manager_id', $currentUserId)->value('city_id');
            $gymsId = Gym::where('city_id', $city_id)->get()->pluck('id');
            $TrainingSessions = TrainingSession::with('gym', 'coaches')->select('*')->whereIn('gym_id', $gymsId);
        } else if ($userRole == 'gym_manager') {
            $gymId = GymManager::select('gym_id')->where('id', $currentUserId)->get()->pluck('gym_id')[0];
            $TrainingSessions = TrainingSession::select('*')->where('gym_id', $gymId);
        }
        return datatables()->eloquent($TrainingSessions)->addIndexColumn()->addColumn('action', function ($TrainingSession) {
            return '
            <a href="' . route('TrainingSessions.show', $TrainingSession->id) . '" class="btn btn-primary">View</a>
            <a href="' . route('TrainingSessions.edit', $TrainingSession->id) . '" class="btn btn-success">Edit</a><form class="d-inline" action="' . route('TrainingSessions.destroy', $TrainingSession->id) . '" method="POST">
	            ' . csrf_field() . '
	            ' . method_field("DELETE") . '
	            <button type="submit" class="btn btn-danger"
	                onclick="return confirm(\'Are You Sure Want to Delete?\')"
	            ">Delete</a>
	            </form>';
        })->editColumn('gym_id', function ($TrainingSession) {
            return $TrainingSession->gym->name;
        })->editColumn('coach', function ($TrainingSession) {
            $session_coaches = '';
            foreach (User::find($TrainingSession->coaches->pluck('id'))->pluck('name') as $coach) {
                $session_coaches .= $coach . ', ';
            }
            return substr($session_coaches, 0, -2);;
        })->rawColumns(['action'])->toJson();
    }

    public function create()
    {
        $userRole = Auth::user()->roles->pluck('name')[0];
        $currentUserId = Auth::id();
        if ($userRole == 'admin') {
            $gyms = Gym::all();
        } else if ($userRole == 'city_manager') {
            $currentId = Auth::id();
            $cityId = CityManager::where('city_manager_id', $currentId)->value('city_id');
            $gyms = Gym::select('*')->where('city_id', $cityId);
        } else if ($userRole == 'gym_manager') {
            $gymId = GymManager::select('gym_id')->where('id', $currentUserId)->get()->pluck('gym_id')[0];
            $gyms = Gym::where('id', $gymId)->get();
        }
        $coaches = Coach::all();
        return view('TrainingSessions.create', [
            'coaches' => $coaches,
            'gyms' => $gyms,
        ]);
    }

    public function store(StoreTrainingSessionRequest  $request)
    {
        $trainingSession = TrainingSession::create([
            'name' => $request['name'],
            'start_at' => $request['start_at'],
            'end_at' => $request['end_at'],
            'gym_id' => $request['gym_id'],
        ]);
        foreach ($request['coach'] as $coach) {
            CoachSession::create([
                'coach_id' => $coach,
                'training_session_id' => $trainingSession->id,
            ]);
        }
        return to_route('TrainingSessions.index');
    }

    public function show($SessionId)
    {
        $coaches = Coach::all();
        $gyms = Gym::all();
        $session = TrainingSession::find($SessionId);
        $selectedGym = Gym::find($session['gym_id']);
        $selectedCoaches = User::find(TrainingSession::find($SessionId)->coaches->pluck('id'));
        return view('TrainingSessions.show', [
            'coaches' => $coaches,
            'selectedCoaches' => $selectedCoaches,
            'session' => $session,
            'gyms' => $gyms,
            'selectedGym' => $selectedGym,
        ]);
    }
    public function edit($SessionId)
    {
        $userRole = Auth::user()->roles->pluck('name')[0];
        $currentUserId = Auth::id();
        $coaches = Coach::all();
        $session = TrainingSession::find($SessionId);
        $gymId = $session->gym_id;
        if ($userRole == 'admin') {
            $gyms = Gym::all();
        } else if ($userRole == 'city_manager') {
            $city_id = CityManager::where('city_manager_id', $currentUserId)->value('city_id');
            $gyms = Gym::where('city_id', $city_id)->get();
        } else if ($userRole == 'gym_manager') {
            $gyms = Gym::where('id', $gymId)->get();
        }

        $selectedGym = Gym::find($session['gym_id']);
        $selectedCoaches = User::find(TrainingSession::find($SessionId)->coaches->pluck('id'));
        return view('TrainingSessions.edit', [
            'coaches' => $coaches,
            'selectedCoaches' => $selectedCoaches,
            'session' => $session,
            'gyms' => $gyms,
            'selectedGym' => $selectedGym,
        ]);
    }

    public function update(StoreTrainingSessionRequest $request, $SessionId)
    {
        TrainingSession::where('id', $SessionId)
            ->update([
                'name' => $request['name'],
                'start_at' => $request['start_at'],
                'end_at' => $request['end_at'],
                'gym_id' => $request['gym_id'],
            ]);
        CoachSession::where('training_session_id', $SessionId)
            ->delete();
        foreach ($request['coach'] as $coach) {
            CoachSession::create([
                'coach_id' => $coach,
                'training_session_id' => $SessionId,
            ]);
        }
        return to_route('TrainingSessions.index');
    }

    public function destroy($SessionId)
    {
        CoachSession::where('training_session_id', $SessionId)->delete();
        TrainingSession::find($SessionId)->delete();
        return to_route('TrainingSessions.index');
    }
}
