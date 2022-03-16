@extends('user.app')
@section('content')
<div class="card card radius-15">
    <div class="card-body">
        <div class="card-title">
            <h5 class="mb-0">Ad Codes </h5>
        </div>
        <hr/>
        <div class="row">
            @forelse ($adcodes as $adcode)
                <div class="col-12 mb-2 @if($loop->iteration > 1 ) mt-4 @endif">
                    <h5>
                        <span class="border-bottom border-primary">
                            {{$adcode->site->domain}}
                        </span>
                    </h5>
                </div>
                <hr>
                <div class="col-sm-12 col-md-6">
                    <p class="pb-0 mb-0">Ad Code for Wordpress:</p>
                    <textarea type="text" class="form-control" rows="10" readonly onclick="copyAdcode('wordpress')" id="wordpress">{{$adcode->ad_code!= null ? $adcode->ad_code : '-'}}</textarea>
                    <p id="wordpress-copied" class="d-none font-weight-bold py-2 text-success">Wordpress Ad Code Copied</p>
                </div>
                <div class="col-sm-12 col-md-6">
                    <p class="pb-0 mb-0">AdCode for Bloggers:</p>
                    <textarea type="text" class="form-control" rows="10" readonly onclick="copyAdcode('Bloggers')" id="Bloggers">{{$adcode->ad_code_footer != null ? $adcode->ad_code_footer : '-'}}</textarea>
                    <p id="Bloggers-copied" class="d-none font-weight-bold py-2 text-success">Bloggers Ad Code Copied</p>
                </div>
            @empty
                <p class="mx-4">
                    NO Code
                </p>
            @endforelse
        </div>
    </div><!-- end card body -->
</div><!-- end card -->

@endsection

