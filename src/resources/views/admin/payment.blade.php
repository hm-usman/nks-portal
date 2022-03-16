@extends('admin.app')
@section('content')
          
@if (session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
  @endif
                <div class="card radius-15">
                  <div class="card-body">
                    <div class="card-title">
                      <h5 class="mb-0">Payments </h5>
                    </div>
                    <hr/>
                    <div class="table-responsive-sm">
                            <table class="table table-borderless table-hover">
                              <thead>
                                <tr>
                                  <th>User</th>
                                  <th>From</th>
                                  <th>Till</th>
                                  <th>Revenue</th>
                                  <th>Requested</th>
                                  <th>Paid</th>
                                  <th>Method</th>
                                  <th>Status</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($payments as $payment)
                                <tr>
                                  <td>{{ $payment->user->name }}</td>
                                  <td>{{ date('M d, Y',strtotime($payment->paymentFrom ))}}</td>
                                  <td>{{ date('M d, Y',strtotime($payment->paymentTill ))}}</td>
                                  <td>${{ $payment->totalRevenue }}</td>
                                  <td>{{ date('M d, Y',strtotime($payment->payoutRequest_at ))}}</td>
                                  <td>{{ $payment->paid_at != null ? date('M d, Y',strtotime($payment->paid_at)) : '-'}}</td>
                                  <td class="text-capitalize">
                                    {{ $payment->payoutMethod }}
                                  </td>
                                  <td>
                                    
                                    <a class="text-dark" data-toggle="modal" href="#payment{{$payment->id}}">
                                      @if (empty($payment->paid_at))
                                        <i class="fa fa-spinner text-secondary pr-1"></i>Pending
                                      @else
                                        <i class="fa fa-check text-success pr-1"></i>Paid at {{ $payment->payoutMethod }}
                                      @endif
                                    </a>
                                    <div class="modal fade" id="payment{{$payment->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title text-capitalize" id="exampleModalLabel">{{$payment->user->name}}</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <form method="POST" action="https://ppcash.net/analytics/payment-status/{{$payment->id}}">
                                            <div class="modal-body">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                  <div class="row">
                                                    <h6 class="col-6 col-md-4">From: {{ date('M d, Y',strtotime($payment->paymentFrom ))}}</h6>
                                                    <h6 class="col-6 col-md-4">To: {{ date('M d, Y',strtotime($payment->paymentTill ))}}</h6>
                                                  </div>
                                                  <h4>
                                                    Revenue: <b>${{ $payment->totalRevenue }}</b>
                                                  </h4>
                                                  <h5>
                                                    Method: <b class="text-capitalize">{{ $payment->payoutMethod }}</b>
                                                  </h5>
                                                  <p>
                                                    Details: 
                                                    <br>
                                                    {{ $payment->methodDetails }}
                                                  </p>
                                                  <input type="date" class="form-control" value="{{ date('Y-m-d')}}" name="paid_at">
                                                  <select class="form-control mt-2" name="status" required>
                                                    <option value="">Pending</option>
                                                    <option value="1" @if (!empty($payment->paid_at)) selected @endif>Paid</option>
                                                  </select>
                                                </div>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <input type="submit" value="submit" class="btn btn-success">
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                            {{$payments->links()}}
                  </div><!-- table responsive -->
                </div><!-- end card body -->
              </div><!-- end card -->




@endsection
