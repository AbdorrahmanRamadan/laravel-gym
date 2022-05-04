@extends('layouts.admin')

@section('page_content')

    <div class="text-center">
            <a href="{{ route('Admin.Trainees.create') }}" class="mt-4 btn btn-success">Create New Trainee</a>


    <div class="text-center">
            <a href="{{ route('Admin.Trainees.create') }}" class="mt-4 btn btn-success">Create/Add New Trainee</a>

        </div>
        <table class="table mt-4">
            <thead>
              <tr>

                <th scope="col">#</th>


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
            @foreach ( $trainees as $trainee)  
              <tr>
                <td>{{ $trainee->trainee_id }}</td>
                <td>{{ $trainee->user->name }}</td>
                <td>{{ $trainee->user->email }}</td>
                <td>{{ $trainee->birth_date }}</td>
                <td>{{ $trainee->gender }}</td>
                <td>{{ $trainee->remaining_sessions }}</td>
                <td> <img src="{{ asset('storage/trainees_images/'.$trainee->avatar_image) }}" class="mr-2" width="100px" height="100px" ></td>

                <!-- ajax delete!!! -->
                <td>
                    <form style="display: inline" method="POST" action="{{ route('Admin.Trainees.destroy', ['trainee'=> $trainee['trainee_id']]) }}">
                    @method('DELETE')
                    @csrf
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this trainee?');" class="btn btn-danger">Delete</button>
                    </form>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>

            <tbody>

          
              <tr>
                <td>{{ $users->name }}</td>
                <td>{{ $users->email }}</td>
              </tr>
            

            </tbody>
          </table>



@endsection
