@extends('user.app')
@section('content')
@if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
    @endif
    <div class="row col-12">
        <button class="btn btn-primary mb-4 dropdown-toggle" data-toggle="collapse" data-target="#paymetMethods">Payment Methods</button>
    </div>
      <div class="row collapse" id="paymetMethods">
        <div class="col-12 col-lg-7">
          <div class="card radius-15">
            <div class="card-body">
              <form action="{{route('payment-methods')}}" method="POST">
                <div class="row">
                  @csrf
                  <div class="col-12 col-lg-6">
                    <p class="mb-0 font-weight-bold">PayPal</p>
                      <div class="form-group">
                        <input name="paypal" placeholder="Enter PayPal Email" value="{{$methods != null ? $methods->paypal : ''}}" class="form-control mt-1">
                        <button type="submit" class="btn btn-sm btn-primary mt-2">Update</button>
                      </div>
                  </div>
                  <div class="col-12 col-lg-6">
                    <p class="mb-0 font-weight-bold">Payoneer</p>
                      <div class="form-group">
                        <input name="payoneer" placeholder="Enter Payoneer Email" value="{{$methods != null ? $methods->payoneer : ''}}" class="form-control mt-1">
                      </div>
                  </div>
                </div>
                </form>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-5">
          <div class="card radius-15">
            <div class="card-body">
              <div>
                <p class="mb-0 font-weight-bold">Bank</p>
                <form action="{{route('payment-methods')}}" method="POST">
                  @csrf
                  <div class="form-group">
                    <input name="bank" placeholder="Enter Bank Name" value="{{$methods != null ? $methods->bank : ''}}" class="form-control mt-1">
                    <textarea name="bank_details" placeholder="Enter Bank Details" class="form-control mt-2" rows="5">{{$methods != null ? $methods->bank_details : ''}}</textarea>
                    <button type="submit" class="btn btn-sm btn-primary mt-2">Update</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  <div class="card radius-15">
    <div class="card-body">
      <div class="card-title">
        <h5 class="mb-0">Payments </h5>
      </div>
      <hr/>
      <div class="table-responsive">
        <table class="table table-borderless table-hover">
          <thead>
            <tr>
              <th>Payment From</th>
              <th>Payment Till</th>
              <th>Total Revenue</th>
              <th>Payout Request Date</th>
              <th>Payment Date </th>
              <th>Payout Method</th>
              <th>Payment Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($payments as $payment)
            <tr>
              <td>{{ date('M d, Y',strtotime($payment->paymentFrom) ) }}</td>
              <td>{{ date('M d, Y',strtotime($payment->paymentTill) ) }}</td>
              <td>${{ $payment->totalRevenue }}</td>
              <td>{{ date('M d, Y',strtotime($payment->payoutRequest_at) ) }}</td>
              <td>
                @if ($payment->paid_at != null)
                  {{date('M d, Y',strtotime($payment->paid_at) )}}
                @else 
                <span class="text-primary font-weight-bold">In-Process</span>
                @endif
              </td>
              <td class="text-capitalize">{{ $payment->payoutMethod }}</td>
              <td>
                @if ($payment->paid_at != null)
                <i class="fa fa-check text-success pr-1"></i>Paid
                @else
                <i class="fa fa-spinner text-secondary pr-1"></i>Pending
                @endif
              </td>
            </tr>
            @endforeach
            {{$payments->links()}}
          </tbody>
        </table>
    </div><!-- table responsive -->
  </div><!-- end card body -->
</div><!-- end card -->
@endsection
