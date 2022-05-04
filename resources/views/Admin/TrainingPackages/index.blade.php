@extends('layouts.admin')
@section('title') Training Packages @endsection
@section('page_content')

    <div class="text-center">
            <a href="{{ route('Admin.TrainingPackages.create') }}" class="mt-4 btn btn-success">Create A New Package</a>
        </div>
        <table class="table mt-4">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">price</th>
                <th scope="col">Number of sessions</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
            @foreach ( $TrainingPackages as $TrainingPackage)
              <tr>
                  <td>{{$TrainingPackage['name']}}</td>
                  <td>{{$TrainingPackage['price']/100}}</td>
                  <td>{{$TrainingPackage['number_of_sessions']}}</td>
                  <td>
                      <a class="btn btn-primary" href="{{ route('Admin.TrainingPackages.edit', ['package' => $TrainingPackage['id']]) }}"> Edit </a>
                      <form method="POST" action="{{route('Admin.TrainingPackages.destroy',['package'=>$TrainingPackage['id']])}}" style="display: inline">
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
