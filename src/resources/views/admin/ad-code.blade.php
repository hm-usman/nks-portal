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
  <div class="card radius-15 col-lg-6">
    <div class="card-body">
      <div class="d-flex flex-column mb-2">
        <div>
          <p class="mb-0 font-weight-bold">Actve Domain For Ads:</p>
        </div>
        <div class="align-self-start mt-2 w-100">
          <form class="" method="POST" action="{{ route('update-active-domain') }}">
            @csrf
              <div class="input-group">
                <input type="url" type="url" name="url" placeholder="Enter Domain URL" class="form-control" required value="{{$activeDomain->url}}">
                <div class="input-group-append">
                  <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-telegram"></i></button>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>
<div class="card radius-15">
    <div class="card-body">
      <div class="card-title">
        <h5 class="mb-0">AdCodes for Users </h5>
      </div>
      <hr/>
        <form method="POST" action="{{route('create-adcode')}}">
        @csrf
        <div id="accordion">
        @foreach ($users as $user)
            <div class="card mb-1 border-0 shadow-none">
              <div class="card-header my-0 py-2" id="card{{$user->id}}">
                <h5 class="mb-0">
                  <a class="text-secondary px-0 py-2" style="cursor: pointer" data-toggle="collapse" data-target="#collapse{{$user->id}}" aria-expanded="true" aria-controls="collapse{{$user->id}}">
                    {{$user->name}}
                  </a>
                </h5>
              </div>
          
              <div id="collapse{{$user->id}}" class="collapse" aria-labelledby="card{{$user->id}}" data-parent="#accordion">
                <div class="card-body">
                  @foreach ($user->websites as $domain)
                      @if ($domain->codes)
                        <ad-code 
                              rote="{{ route('update-adcode') }}"
                              csrf="{{csrf_token()}}"
                              user="{{$user->id}}"
                              domain="{{$domain->id}}"
                              website="{{$domain->domain}}"
                              wp='@if($domain->codes->ad_code) {{$domain->codes->ad_code}} @else &lt;script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"&gt;&lt;/script&gt;&lt;script&gt;function downloadNow(){$.ajax({url:"{{$activeDomain->url}}",type:"POST",data:{tc:{{$user->tc.'-dt'.$domain->id}} },success:function(t){}})}&lt;/script&gt; @endif'
                              blg='@if($domain->codes->ad_code_footer) {{$domain->codes->ad_code_footer}} @else &lt;script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"&gt;&lt;/script&gt;&lt;script&gt;function downloadNow(){$.ajax({url:"{{$activeDomain->url}}",type:"POST",data:{tc:{{$user->tc.'-dt'.$domain->id}} },success:function(t){}})}&lt;/script&gt; @endif'
                        ></ad-code>
                      @else
                        <ad-code  
                              rote="{{ route('update-adcode') }}"
                              csrf="{{csrf_token()}}"
                              user="{{$user->id}}"
                              domain="{{$domain->id}}"
                              website="{{$domain->domain}}"
                              domain="{{$domain->domain}}"
                              wp='&lt;script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"&gt;&lt;/script&gt;&lt;script&gt;function downloadNow(){$.ajax({url:"{{$activeDomain->url}}",type:"POST",data:{tc:{{$user->tc.'-dt'.$domain->id}} },success:function(t){}})}&lt;/script&gt;'
                              blg='&lt;script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"&gt;&lt;/script&gt;&lt;script&gt;function downloadNow(){$.ajax({url:"{{$activeDomain->url}}",type:"POST",data:{tc:{{$user->tc.'-dt'.$domain->id}} },success:function(t){}})}&lt;/script&gt;'
                        ></ad-code>
                      @endif
                  @endforeach 
                </div> 
              </div>
            </div>
        @endforeach
        </div>
        </form>
        {{$users->links()}}
    </div><!-- end card body -->
</div><!-- end card -->

@endsection
