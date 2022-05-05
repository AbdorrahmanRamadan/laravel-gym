<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Carbon;


class AttendanceController extends Controller
{
    //
    public function index()
    {
        return view('Attendance.index');

    }
    public function getAttendance(){
        $attendance =  Attendance::with('user','training_session')->select('attendances.*');
        return datatables()->eloquent($attendance)->addIndexColumn()
        ->editColumn('trainee_id', function($attend){
           return $attend->user->name;
        })->editColumn('training_session_id', function($attend){
           return $attend->training_session->name;
       })->editColumn('attendance_date', function($attend){
        return Carbon::parse($attend->attendance_time)->format('m/d');
    })->editColumn('attendance_day', function($attend){
        return Carbon::parse($attend->attendance_time)->format('D');
    })->editColumn('attendance_time', function($attend){
        return Carbon::parse($attend->attendance_time)->format('H:i:s');
    })
        ->toJson();
    }
}
