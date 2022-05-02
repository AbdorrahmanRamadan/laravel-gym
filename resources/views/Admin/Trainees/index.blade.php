@extends('layouts.admin')

@section('page_content')

    <div class="text-center">
            <a href="{{ route('Admin.Trainees.create') }}" class="mt-4 btn btn-success">Create/Add New Trainee</a>
        </div>
        <table class="table mt-4">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Birth Date</th>
                <th scope="col">Gender</th>
                <th scope="col">Remaining Sessions</th>
                <th scope="col">Profile Image</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>

          
              <tr>
                <td>{{ $users->name }}</td>
                <td>{{ $users->email }}</td>
              </tr>
            

            </tbody>
          </table>


@endsection
