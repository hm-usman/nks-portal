<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>NSKHOST</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.html">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
</head>
    <body class="h-100">
          <!--*******************
            Preloader start
        ********************-->
        <div id="preloader">
            <div class="loader">
                <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
                </svg>
            </div>
        </div>
      <!--*******************
          Preloader end
          ********************-->

    <div class="login-form-bg h-100">
            <div class="container h-100">
              <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                  <div class="form-input-content">
                    <div class="card login-form mb-0">
                      <div class="card-body pt-5">
                        <a class="text-center" href="javascript:void(0)"> 
                          <h4>
                            <b>NSKHOST</b>
                          </h4>
                        </a>
                    {{-- <img src="{{asset('images/logo.svg')}}" alt="logo"> --}}
                     @if (session('status'))
                        <div class="alert alert-success mt-2 alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                  <h6 class="fw-light">Enter Your Email to Reset Password.</h6>
                  <form class="pt-3" method="POST" action="{{ route('password.email') }}">
                    @csrf 
                    <div class="form-group">
                      <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required id="exampleInputEmail1" placeholder="Email" >
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mt-3">
                      <button type="submit" class="btn login-form__btn submit w-100">Send Password Reset Link</button>
                    </div>
                  </form>
                </div>

                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
      </div>
  




  <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{ asset('plugins/common/common.min.js')}}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/custom.min.js')}}"></script>
    <script src="{{ asset('js/gleek.js')}}"></script>
    <script src="{{ asset('js/styleSwitcher.js')}}"></script>

  </body>
    
</html>