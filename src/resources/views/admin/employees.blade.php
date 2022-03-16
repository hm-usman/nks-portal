@extends('layouts.app')
@section('content')
@if (session('status'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('status') }}
  </div>
@endif
<div class="row">
  <div class="col-sm-12 col-md-4 grid-margin stretch-card">
    <div class="card card-rounded">
      <div class="card-body">
        <h4 class="card-title">Filter</h4>
        <form method="GET">
            <div class="row">
                <div class="col-md-10">
                  <div class="form-group">
                      <label>Status:</label>
                      <select class="form-control" name="status">
                          <option value="" {{empty($status) ? 'selected' : ''}}>All</option>
                          <option value="1" {{$status == 1 ? 'selected' : ''}}>In-active</option>
                          <option value="2" {{$status == 2 ? 'selected' : ''}}>Active</option>
                      </select>
                  </div>
                  <button class="btn btn-sm btn-primary">Filter</button>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card card-rounded">
      <div class="card-body">
        <h4 class="card-title d-flex justify-content-between">
          Employees
          <a class="btn btn-sm btn-primary mb-3 float-right" href="{{route('create-employee')}}">New Employee </a>
        </h4>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Designation</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Joined</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($employees as $employee)
              <tr>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->designation }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->phone }}</td>
                <td>{{ date('M d, Y',strtotime($employee->created_at)) }}</td>
                <td>
                    @if ($employee->status == '1')
                      <label class="badge badge-danger">In-Active</label>
                    @else
                      <label class="badge badge-success">Active</label>
                    @endif
                </td>
                <td>
                  <a  class="btn btn-primary btn-rounded btn-icon" 
                      href="{{route('view-employee', ['id'=>$employee->id])}}">
                      View
                  </a>
                  <a  class="btn btn-danger btn-rounded btn-icon" 
                      href="{{route('delete-employee', ['id'=>$employee->id])}}" 
                      onclick="return confirm('Are you sure you want to delete {{$employee->name}}')">
                      Delete
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {{$employees->appends($_GET)->links()}}
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
