<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\TrainingSession;
use App\Models\Gym;
use App\Models\CityManager;
use App\Models\GymManager;

use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Carbon;


class AttendanceController extends Controller
{
    //
    public function index()
    {
        return view('Attendance.index');
    }
    public function getAttendance()
    {
        $userRole = Auth::user()->roles->pluck('name')[0];
        $currentUserId = Auth::id();

        if ($userRole == 'admin') {
            $attendance =  Attendance::with('user', 'training_session')->select('attendances.*');
        } else if ($userRole == 'city_manager') {
            $city_id = CityManager::where('city_manager_id', $currentUserId)->value('city_id');
            $gymsId = Gym::where('city_id', $city_id)->get()->pluck('id');
            $sessions = TrainingSession::select('id')->whereIn('gym_id', $gymsId)->pluck('id');
            $attendance = Attendance::with('user', 'training_session')->select('*')->whereIn('training_session_id', $sessions);
        } else if ($userRole == 'gym_manager') {
            $gymId = GymManager::select('gym_id')->where('id', $currentUserId)->get()->pluck('gym_id')[0];
            $sessions = TrainingSession::select('id')->where('gym_id', $gymId)->pluck('id');
            $attendance = Attendance::with('user', 'training_session')->select('*')->whereIn('training_session_id', $sessions);
        }
        return datatables()->eloquent($attendance)->addIndexColumn()
            ->editColumn('trainee_id', function ($attend) {
                return $attend->user->name;
            })->editColumn('training_session_id', function ($attend) {
                return $attend->training_session->name;
            })->editColumn('attendance_date', function ($attend) {
                return Carbon::parse($attend->attendance_time)->format('m/d');
            })->editColumn('attendance_day', function ($attend) {
                return Carbon::parse($attend->attendance_time)->format('D');
            })->editColumn('attendance_time', function ($attend) {
                return Carbon::parse($attend->attendance_time)->format('H:i:s');
            })
            ->toJson();
    }
}
