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
            </div>
                    <form method="POST" enctype="multipart/form-data" 
                          action="{{ route('store-employee') }}">
                        @csrf 
  
                        <div class="form-group">
                            <label for="name" class="control-label">Name</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="designation" class="control-label">Destignation</label>
                            <input id="designation" type="text" class="form-control" name="designation" value="{{ old('designation') }}" required>
                        </div>
  
                        <div class="form-group">
                            <label for="email" class="control-label">Email</label>
                            <input id="email" type="email" class="form-control @error( 'email' ) is-invalid @endcan" name="email" value="{{ old('email') }}" required>
                            @error( 'email')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <input id="password" type="text" class="form-control @error( 'password' ) is-invalid @endcan" name="password" value="{{ old('password') }}" required>
                            @error( 'password' )
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
  
                        <div class="form-group">
                            <label for="phone" class="control-label">Phone</label>
                            <input id="phone" type="text" class="form-control @error( 'phone') is-invalid @endcan" name="phone" value="{{ old('phone') }}" required>
                            @error( 'phone')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="photo" class="control-label">Photo</label>
                            <input id="photo" type="file" class="form-control" name="photo" value="{{ old('photo') }}">
                        </div>
                            <div class="form-group">
                                <label for="Status" class="control-label">Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="1">In-active</option>
                                    <option value="2" selected>Active</option>
                                </select>
                            </div>
   
                        <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                        </div>
                    </form>
        </div><!-- end card body -->
    </div><!-- end card -->
    </div>
</div>
@endsection