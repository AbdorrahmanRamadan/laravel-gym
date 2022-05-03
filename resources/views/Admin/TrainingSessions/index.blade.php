@extends('layouts.admin')
@section('title') Training Sessions @endsection
@section('page_content')

    <div class="text-center">
            <a href="{{ route('Admin.TrainingSessions.create') }}" class="mt-4 btn btn-success">Create A New Session</a>
        </div>
        <table class="table mt-4">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Starting Time</th>
                <th scope="col">End Time</th>
                <th scope="col">Gym</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
            @foreach ( $TrainingSessions as $TrainingSession)
              <tr>
                  <td>{{$TrainingSession['name']}}</td>
                  <td>{{$TrainingSession['start_at']}}</td>
                  <td>{{$TrainingSession['end_at']}}</td>
                  <td>{{$TrainingSession->gym->name}}</td>
                  <td>
                      <a class="btn btn-primary" href="{{ route('Admin.TrainingSessions.edit', ['session' => $TrainingSession['id']]) }}"> Edit </a>
                      <form method="POST" action="{{route('Admin.TrainingSessions.destroy',['session'=>$TrainingSession['id']])}}" style="display: inline">
                          @csrf
                          @method('delete')
                          <button class="btn btn-danger" type="submit" onclick="return confirm('you are about to delete this record \nif you are sure press ok')">Delete</button>
                      </form>
                  </td>
              </tr>
            @endforeach

            </tbody>
          </table>


@endsection
