@extends('layouts.app')

@section('page_content')
    <div class="text-center">
            <a href="{{ route('Coaches.create') }}" class="mt-4 btn btn-success">Create New Coach</a>
        </div>
        <table class="table mt-4">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">National ID</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>

            <tbody>
            @foreach ( $coaches as $coach)
              <tr>
                <td>{{ $coach->coach_id }}</td>
                <td>{{ $coach->user->name }}</td>
                <td>{{ $coach->user->email }}</td>
                <td>{{ $coach->national_id }}</td>
                <!-- ajax delete!!! -->
                <td>
                <a href="{{ route('Coaches.edit', ['coach' => $coach['coach_id']]) }}" class="btn btn-primary">Edit</a>

                    <form style="display: inline" method="POST" action="{{ route('Coaches.destroy', ['coach'=> $coach['coach_id']]) }}">
                    @method('DELETE')
                    @csrf
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this coach?');" class="btn btn-danger">Delete</button>
                    </form>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
@endsection
