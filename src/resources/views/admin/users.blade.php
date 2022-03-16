@extends('admin.app')
@section('content')
@if (session('status'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('status') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
                <div class="card radius-15">
                  <div class="card-body">
                    <div class="card-title">
                      <h5 class="mb-0">Users </h5>
                    </div>
                    <hr/>
                    <div class="table-responsive">
                            <table class="table table-borderless table-hover">
                              <thead>
                                <tr>
                                  <th>User ID</th>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Joind On</th>
                                  <th>Delete</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($users as $user)
                                <tr>
                                  <td>{{ $user->id }}</td>
                                  <td>{{ $user->name }}</td>
                                  <td>{{ $user->email }}</td>
                                  <td>{{ date('M d, Y',strtotime($user->created_at)) }}</td>
                                  <td>
                                    <a href="/admin/delete-user/{{$user->id}}" class="btn btn-sm btn-danger" onclick="return confirm('are you sure you want to delete {{$user->name}}')">Delete</a>
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                            {{$users->links()}}
                  </div><!-- table responsive -->
                </div><!-- end card body -->
              </div><!-- end card -->




@endsection
