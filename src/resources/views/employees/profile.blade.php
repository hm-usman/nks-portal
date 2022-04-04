@extends('layouts.app')
@section('content')
@if (session('status'))
<div class="alert alert-success alert-dismissible">
    {{ session('status') }}
</div>
@endif
<div class="row">
    <div class="col-12 col-md-6 grid-margin stretch-card">
    <div class="card card-rounded">
        <div class="card-body">
            <div class="card-title">
                <h5 class="mb-0">Profile</h5>
            </div>
            <div class="d-flex justify-content-center">
                <img src="/images/employees/{{$user->photo}}" alt="profile" style="width: 250px;" class="rounded-circle mb-3">
            </div>
                    <form method="POST" enctype="multipart/form-data" 
                          action="
                          @can('isAdmin')
                            {{ route('update-employee', ['id' => $user->id]) }}
                            @else
                            {{ route('update-profile', ['id' => $user->id]) }}
                          @endcan
                          ">
                        @csrf 
   
                         @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                         @endforeach 
  
                        <div class="form-group">
                            <label for="name" class="control-label">Name</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{$user->name}}" required>
                        </div>

                        <div class="form-group">
                            <label for="designation" class="control-label">Destignation</label>
                            <input id="designation" type="text" class="form-control" name="designation" value="{{$user->designation}}" required>
                        </div>
  
                        <div class="form-group">
                            <label for="email" class="control-label">Email</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{$user->email}}" required>
                        </div>
  
                        <div class="form-group">
                            <label for="phone" class="control-label">Phone</label>
                            <input id="phone" type="text" class="form-control" name="phone" value="{{$user->phone}}" required>
                        </div>

                        <div class="form-group">
                            <label for="photo" class="control-label">Photo</label>
                            <input id="photo" type="file" class="form-control" name="photo" value="{{$user->photo}}">
                            <input type="hidden" name="oldPhoto" value="{{$user->photo}}">
                        </div>
                        @can('isAdmin')
                            <div class="form-group">
                                <label for="Status" class="control-label">Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="" {{!$user->status ? 'selected' : ''}}>All</option>
                                    <option value="1" {{$user->status == 1 ? 'selected' : ''}}>In-active</option>
                                    <option value="2" {{$user->status == 2 ? 'selected' : ''}}>Active</option>
                                </select>
                            </div>
                        @endcan
   
                        <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                        </div>
                    </form>
        </div><!-- end card body -->
    </div><!-- end card -->
    </div>
</div>
@endsection