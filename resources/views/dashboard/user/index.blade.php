@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard | Welcome Back {{ auth()->user()->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
      </div>
      <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
        <svg class="bi"><use xlink:href="#calendar3"/></svg>
        This week
      </button>
    </div>
  </div>


  <div class="table-responsive small">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Role</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach( $users as $user)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->role_id}}</td>
          <td>
            <a href="/dashboard/user/{{ $user->slug }}" class=" badge bg-info">
                <i class="bi bi-eye"></i>
            </a>
            <a href="/dashboard/user/{{ $user->id }}" class=" badge bg-warning">
                <i class="bi bi-pencil-square"></i>
            </a>
            <a href="/dashboard/user/{{ $user->id }}" class=" badge bg-danger">
                <i class="bi bi-x-circle"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
@endsection