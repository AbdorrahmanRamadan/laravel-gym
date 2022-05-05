<?php

use Carbon\Carbon;
?>
@extends('layouts.app')
@section('page_content')
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Attendance for trainee</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="attendance" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Trainee Name</th>
                    <th>Session Name</th>
                    <th>Attending Date</th>
                    <th>Attending Day</th>
                    <th>Attending Time</th>

                  </tr>
                  </thead>


                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->


            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->



@endsection
@push('script')
    <script>
        $(function() {
            $('#attendance').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('Attendance.getAttendance') }}",
                columns: [
                    { data: 'user.name', name:'user.name',  orderable: true, searchable: true},
                    { data: 'training_session.name', name:'training_session.name',  orderable: true, searchable: true},
                    { data: 'attendance_date', name:'attendance_date',  orderable: true, searchable: true},
                    { data: 'attendance_day', name:'attendance_day',  orderable: true, searchable: true},
                    { data: 'attendance_time', name:'attendance_time',  orderable: true, searchable: true},




                ]
            });

        });
    </script>
@endpush
