<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    //
    public function index()
    {
        $attendance = Attendance::paginate(10);

        return view('Admin.Attendance.index', [
            'attendance' => $attendance,
        ]);
    }
}
