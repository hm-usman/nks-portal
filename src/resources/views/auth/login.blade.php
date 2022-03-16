<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>NSKHOST </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/typicons/typicons.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/simple-line-icons/css/simple-line-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
  <link rel="stylesheet" href="{{ asset('js/select.dataTables.min.css') }}">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}"/>
</head>
    <body>
        {{-- new page --}}
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
              <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                  <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                      <div class="brand-logo">
                        {{-- <img src="{{asset('images/logo.svg')}}" alt="logo"> --}}
                        <b>NSKHOST</b>
                      </div>
                      <h4>Hello! let's get started</h4>
                      <h6 class="fw-light">Sign in to continue.</h6>
                      <form class="pt-3" method="POST" action="{{ route('login') }}">
                        @csrf 
                        <div class="form-group">
                          <input type="email" class="form-control form-control-lg  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required id="exampleInputEmail1" placeholder="Email" >
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                          <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required id="exampleInputPassword1" placeholder="Password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mt-3">
                          <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                        </div>
                        <div class="my-2 d-flex justify-content-between align-items-center">
                          <div class="form-check">
                            <label class="form-check-label text-muted">
                              <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                              Keep me signed in
                            </label>
                          </div>
                            @if (Route::has('password.request'))
                                <a class="auth-link text-black" href="{{ route('password.request') }}">
                                    {{ __('Forgot Password?') }}
                                </a>
                            @endif
                        </div>
                        @if (Route::has('register'))
                            <div class="text-center mt-4 fw-light">
                            Don't have an account? <a href="{{route('register')}}" class="text-primary">Create</a>
                            </div>
                        @endif
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- content-wrapper ends -->
            </div>
            <!-- page-body-wrapper ends -->
          </div>
          <!-- container-scroller -->
        {{-- end new page --}}
           
        <!-- plugins:js -->
        <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="{{ asset('vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('vendors/progressbar.js/progressbar.min.js') }}"></script>

        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="{{ asset('js/off-canvas.js') }}"></script>
        <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
        <script src="{{ asset('js/template.js') }}"></script>
        <script src="{{ asset('js/settings.js') }}"></script>
        <script src="{{ asset('js/todolist.js') }}"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
    </body>
    
</html>