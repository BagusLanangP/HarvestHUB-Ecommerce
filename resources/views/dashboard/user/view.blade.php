@extends('dashboard.layouts.main')

@section('container')

<div class="table-responsive small">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Role</th>
          <th scope="col">Phone</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ $user->id }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->role_id}}</td>
          <td>{{ $user->phone}}</td>
        </tr>
      </tbody>
    </table>
  </div>
    

@endsection