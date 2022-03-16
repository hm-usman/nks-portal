@extends('layouts.app')
@section('content')
@if (session('status'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('status') }}
  </div>
@endif
<div class="row">
  <div class="col-12 grid-margin stretch-card">
    <div class="card card-rounded">
      <div class="card-body">
        <h4 class="card-title">Filter</h4>
        <form method="GET">
            <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                      <label>Status:</label>
                      <select class="form-control" name="status">
                          <option value="" {{$status == null ? 'selected' : ''}}>All</option>
                          <option value="1" {{$status == 1 ? 'selected' : ''}}>Assigned</option>
                          <option value="2" {{$status == 2 ? 'selected' : ''}}>Started</option>
                          <option value="3" {{$status == 3 ? 'selected' : ''}}>Submitted</option>
                          <option value="4" {{$status == 4 ? 'selected' : ''}}>In Review</option>
                          <option value="5" {{$status == 5 ? 'selected' : ''}}>Completed</option>
                      </select>
                  </div>
                </div>
                @can('isAdmin')
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Employees:</label>
                        <select class="form-control" name="employee">
                          <option value="">-Select Employee-</option>
                            @forelse ($employees as $emp)
                                <option value="{{$emp->id}}" {{$emp->id == $employee ? 'selected' : ''}}>{{$emp->name}}</option>
                            @empty
                                
                            @endforelse
                          </select>
                        </div>
                      </div>
                  @else
                    <input type="hidden" value="{{Auth::user()->id}}" class="form-control">
                  @endcan
                <div class="col-md-3">
                  <div class="form-group">
                      <label>Created On:</label>
                      <input type="date" class="form-control" value="{{$created_at}}" name="created_at">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                      <label>Due Date:</label>
                      <input type="date" class="form-control" value="{{$due_date}}" name="due_date">
                  </div>
                </div>
              </div>
              <button class="btn btn-sm btn-primary">Filter</button>
              <a href="{{route('tasks')}}">
                <button class="btn btn-sm btn-danger" type="button">Reset</button>
              </a>
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
          Tasks
          @can('isAdmin')
            <button class="btn btn-sm btn-primary mb-3 float-right" data-bs-toggle="modal" data-bs-target="#exampleModal">New Task </button>
          @endcan
        </h4>
        <!-- Modal -->
        <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Task</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <form method="POST" action="{{ route('task-save') }}">
                @csrf
                <div class="modal-body">
                  <div class="form-group">
                    <label>Employee</label>
                    <select class="form-control" name="employee_id" required>
                      <option value="">-Select Employee-</option>
                      @forelse ($employees as $emp)
                          <option value="{{$emp->id}}">{{$emp->name}}</option>
                      @empty
                          
                      @endforelse
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter Title of Task" required>
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" placeholder="Enter Description of Task" style="height: 150px" required></textarea>
                  </div>
                  <div class="form-group">
                    <label>Due Date</label>
                    <input type="datetime-local" name="due_date" class="form-control" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Submit</button>
                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Employee</th>
                <th>Title</th>
                <th>Assigned at</th>
                <th>Due Date</th>
                <th>Submitted at</th>
                <th>Completed at</th>
                <th>File</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($tasks as $task)
              <tr>
                <td>{{ $task->employee->name }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ date('M d, Y g:iA',strtotime($task->created_at)) }}</td>
                <td>{{ date('M d, Y g:iA',strtotime($task->due_date)) }}</td>
                <td>{{ $task->submitted_at ? date('M d, Y g:iA',strtotime($task->submitted_at)) : '-' }}</td>
                <td>{{ $task->completed_at ? date('M d, Y g:iA',strtotime($task->completed_at)) : '-' }}</td>
                <td>
                  @can('isAdmin')
                    @if ($task->uploaded_file)
                        <a href="/media/{{$task->uploaded_file}}"> Vew File </a>
                    @else
                      -
                    @endif  
                    
                    @else
                    {{ $task->uploaded_file ? 'File Uploaded' : '-' }}
                  
                  @endcan
                </td>
                <td>
                  <div class="dropdown">
                    <button 
                            class="btn btn-sm dropdown-toggle
                            @if ($task->status == '1')
                              btn-dark
                            @elseif ($task->status == '2')
                              btn-info
                            @elseif ($task->status == '3')
                              btn-primary
                              @elseif ($task->status == '4')
                              btn-warning
                            @else
                              btn-success
                            @endif
                            " 
                            type="button" 
                            id="status{{$task->id}}" 
                            data-bs-toggle="dropdown" 
                            aria-haspopup="true" 
                            aria-expanded="false">
                            @if ($task->status == '1')
                              Assigned
                            @elseif ($task->status == '2')
                              Started
                            @elseif ($task->status == '3')
                              Submitted
                            @elseif ($task->status == '4')
                              In Review
                            @else
                              Completed
                            @endif
                    </button>
                    @can('isUser')
                      @if ($task->status < 3)
                        <div class="dropdown-menu" aria-labelledby="status{{$task->id}}">
                            @if ($task->status == 1)
                              <a class="dropdown-item text-info" href="{{route('task-status-update', ['id'=>$task->id, 'status' => 'started'])}}">Started</a>
                            @endif
                            @if ($task->status == 2)
                              <a class="dropdown-item text-primary" href="{{route('task-status-update', ['id'=>$task->id, 'status' => 'submitted'])}}">Submitted</a>
                            @endif
                        </div>
                      @endif
                    @endcan
                    @can('isAdmin')
                    @if ($task->status < 5 && $task->status > 2)
                    <div class="dropdown-menu" aria-labelledby="status{{$task->id}}">
                        @if ($task->status == 3)
                          <a class="dropdown-item text-warning" href="{{route('task-status-update', ['id'=>$task->id, 'status' => 'review'])}}">In-Review</a>
                        @endcan
                        @if ($task->status == 3 || $task->status == 4)
                          <a class="dropdown-item text-success" href="{{route('task-status-update', ['id'=>$task->id, 'status' => 'completed'])}}">Completed</a>
                        @endcan
                      </div>
                      @endif
                    @endcan
                  </div>
                </td>
                <td>
                  <a  class="btn btn-sm btn-info btn-rounded btn-icon" 
                      data-bs-toggle="modal" data-bs-target="#time{{$task->id}}">
                      <i class="mdi mdi-timer"></i>
                  </a>
                  <div class="modal fade show" id="time{{$task->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Tasks Timeline</h5>
                          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                          <div class="modal-body py-2">
                              <h4 class="pt-2">
                                <span class="border-bottom">
                                  {{$task->title}}
                                </span>
                              </h4>
                              <p class="py-2">
                                <span class="border-bottom text-capitalize">
                                  {{$task->employee->name}}
                                </span>
                              </p>
                                <div class="row">
                                      <div class="col-3 h6">
                                        Assigned
                                      </div>
                                      <div class="col-3 h6">
                                        {{ date('M d, Y g:iA',strtotime($task->created_at)) }}
                                      </div>
                                </div>
                                <div class="row">
                                      <div class="col-3 h6">
                                        Started
                                      </div>
                                      <div class="col-3 h6">
                                        {{ $task->started_at ? date('M d, Y g:iA',strtotime($task->started_at)) : '-' }}
                                      </div>
                                </div>
                                <div class="row">
                                      <div class="col-3 h6">
                                        Diff
                                      </div>
                                      <div class="col-6 h6">
                                        @php
                                          if($task->started_at){
                                            $cs1 = new DateTime($task->created_at);
                                            $cs2 = new DateTime($task->started_at);
                                            $interval = $cs1->diff($cs2);
                                            $dif = '';
                                              $interval->y > 0 ? $dif .= $interval->y.'Y,' : '';
                                              $interval->m > 0 ? $dif .= $interval->m.'M,' : '';
                                              $interval->d > 0 ? $dif .= $interval->d.'D, ' : '';
                                              $interval->h > 0 ? $dif .= $interval->h.'H, ' : '';
                                              $interval->i > 0 ? $dif .= $interval->i.'min, ' : '';
                                              $interval->s > 0 ? $dif .= $interval->s.'sec. ' : '';
                                              echo $dif;   
                                          }else{
                                            echo '-';
                                          }
                                        @endphp
                                      </div>
                                </div>
                                <hr />
                                <div class="row">
                                      <div class="col-3 h6">
                                        Started
                                      </div>
                                      <div class="col-3 h6">
                                        {{ $task->started_at ? date('M d, Y g:iA',strtotime($task->started_at)) : '-' }}
                                      </div>
                                </div>
                                <div class="row">
                                      <div class="col-3 h6">
                                        Submitted
                                      </div>
                                      <div class="col-3 h6">
                                        {{ $task->submitted_at ? date('M d, Y g:iA',strtotime($task->submitted_at)) : '-' }}
                                      </div>
                                </div>
                                <div class="row">
                                      <div class="col-3 h6">
                                        Diff
                                      </div>
                                      <div class="col-6 h6">
                                        @php
                                          if($task->submitted_at && $task->started_at){
                                            $cs3 = new DateTime($task->started_at);
                                            $cs4 = new DateTime($task->submitted_at);
                                            $interval2 = $cs3->diff($cs4);
                                            $dif2 = '';
                                              $interval2->y > 0 ? $dif2 .= $interval2->y.'Y,' : '';
                                              $interval2->m > 0 ? $dif2 .= $interval2->m.'M,' : '';
                                              $interval2->d > 0 ? $dif2 .= $interval2->d.'D, ' : '';
                                              $interval2->h > 0 ? $dif2 .= $interval2->h.'H, ' : '';
                                              $interval2->i > 0 ? $dif2 .= $interval2->i.'min, ' : '';
                                              $interval2->s > 0 ? $dif2 .= $interval2->s.'sec. ' : '';
                                              echo $dif2;   
                                          }else{
                                            echo '-';
                                          }
                                        @endphp
                                      </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                      <div class="col-3 h6">
                                        Submitted
                                      </div>
                                      <div class="col-3 h6">
                                        {{ $task->submitted_at ? date('M d, Y g:iA',strtotime($task->submitted_at)) : '-' }}
                                      </div>
                                </div>
                                <div class="row">
                                      <div class="col-3 h6">
                                        Completed
                                      </div>
                                      <div class="col-3 h6">
                                        {{ $task->completed_at ? date('M d, Y g:iA',strtotime($task->completed_at)) : '-' }}
                                      </div>
                                </div>
                                <div class="row">
                                      <div class="col-3 h6">
                                        Diff
                                      </div>
                                      <div class="col-6 h6">
                                        @php
                                          if($task->submitted_at && $task->completed_at){
                                            $cs5 = new DateTime($task->submitted_at );
                                            $cs6 = new DateTime($task->completed_at);
                                            $interval3 = $cs5->diff($cs6);
                                            $dif3 = '';
                                              $interval3->y > 0 ? $dif3 .= $interval3->y.'Y,' : '';
                                              $interval3->m > 0 ? $dif3 .= $interval3->m.'M,' : '';
                                              $interval3->d > 0 ? $dif3 .= $interval3->d.'D, ' : '';
                                              $interval3->h > 0 ? $dif3 .= $interval3->h.'H, ' : '';
                                              $interval3->i > 0 ? $dif3 .= $interval3->i.'min, ' : '';
                                              $interval3->s > 0 ? $dif3 .= $interval3->s.'sec. ' : '';
                                              echo $dif3;   
                                          }else{
                                            echo '-';
                                          }
                                        @endphp
                                      </div>
                                    </div>
                                    <hr />
                                    <div class="row">
                                      <div class="col-3 h6">
                                        Completed
                                      </div>
                                      <div class="col-3 h6">
                                        {{ $task->completed_at ? date('M d, Y g:iA',strtotime($task->completed_at)) : '-' }}
                                      </div>
                                    </div>
                                <div class="row">
                                  <div class="col-3 h6">
                                    Due Date
                                  </div>
                                  <div class="col-3 h6">
                                    {{ $task->due_date ? date('M d, Y g:iA',strtotime($task->due_date)) : '-' }}
                                  </div>
                                </div>
                                <div class="row">
                                      <div class="col-3 h6">
                                        Diff
                                      </div>
                                      <div class="col-6 h6">
                                        @php
                                          if($task->completed_at){
                                            $cs7 = new DateTime($task->completed_at);
                                            $cs8 = new DateTime($task->due_date);
                                            $interval4 = $cs7->diff($cs8);
                                            $dif4 = '';
                                              $interval4->y > 0 ? $dif4 .= $interval4->y.'Y,' : '';
                                              $interval4->m > 0 ? $dif4 .= $interval4->m.'M,' : '';
                                              $interval4->d > 0 ? $dif4 .= $interval4->d.'D, ' : '';
                                              $interval4->h > 0 ? $dif4 .= $interval4->h.'H, ' : '';
                                              $interval4->i > 0 ? $dif4 .= $interval4->i.'min, ' : '';
                                              $interval4->s > 0 ? $dif4 .= $interval4->s.'sec. ' : '';
                                              echo $dif4;   
                                          }else{
                                            echo '-';
                                          }
                                        @endphp
                                      </div>
                                    </div>
                                    <hr />
                                </div>
                          {{-- <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          </div> --}}
                      </div>
                    </div>
                  </div>
                  <a  class="btn btn-sm btn-primary btn-rounded btn-icon" 
                      data-bs-toggle="modal" data-bs-target="#view{{$task->id}}">
                      <i class="mdi mdi-eye"></i>
                  </a>
                  <div class="modal fade show" id="view{{$task->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Task Details</h5>
                          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <form method="POST" enctype="multipart/form-data"
                              @can('isUser') action="{{ route('upload-file', ['id' => $task->id]) }} " @endcan
                              @can('isAdmin') action="{{ route('update-task', ['id' => $task->id]) }} " @endcan
                              >
                          @csrf
                          <div class="modal-body py-2">
                            <div class="form-group">
                              <h4>
                                {{$task->employee->name}}
                              </h4>
                            </div>
                            <div class="form-group">
                              <label>Title</label>
                              <input type="text" name="title" value="{{$task->title}}" class="form-control" placeholder="Enter Title of Task" @can('isUser') disabled @endcan>
                            </div>
                            <div class="form-group">
                              <label>Description</label>
                              <textarea name="description" class="form-control" placeholder="Enter Description of Task" style="height: 150px" required @can('isUser') disabled @endcan>{{$task->description}}</textarea>
                            </div>
                            <div class="form-group">
                              <label>Due Date</label>
                              <input type="datetime-local" value="{{ date('Y-m-d\TH:i:s', strtotime($task->due_date)) }}" name="due_date" class="form-control" @can('isUser') disabled @endcan>
                            </div>
                            @can('isUser')
                              <div class="form-group">
                                <label>File</label>
                                <input type="file" name="uploaded_file" class="form-control" required>
                              </div>
                            @endcan
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Update</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  @can('isAdmin')
                    <a  class="btn btn-sm btn-danger btn-rounded btn-icon" 
                        href="{{route('delete-task', ['id'=>$task->id])}}" 
                        onclick="return confirm('Are you sure you want to delete {{$task->title}}')">
                        <i class="mdi mdi-delete-forever"></i>
                    </a> 
                  @endcan
                </td>
              </tr>
              @empty
              @endforelse
            </tbody>
          </table>
          {{$tasks->appends($_GET)->links()}}
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
