<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="https://ppcash.net/assets/img/ppico.png">        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
      
        <meta name="description" content="">
        <meta name="author" content="">
            <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
      
        <title>SignUp PPCash</title>
      
        <!-- External fonts -->
        <link href="https://brick.a.ssl.fastly.net/Montserrat:300,400,500,600,700" rel="stylesheet">
      
        <!-- NPM Packages -->
        <link href="css/app.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
      
        <link href="css/login.css" rel="stylesheet">
      
      
      
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body id="app">
            <div class="container-fluid">
                    <div class="row no-gutter">
                    <div class="col-md-8 col-lg-6">
                            <div class="login d-flex align-items-center py-5">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-9 col-lg-8 mx-auto">
                                            <img src="https://ppcash.net/assets/img/logo-blue.png" alt="PPCash" class="mx-auto" style="width: 150px" />
                                            <h3 class="login-heading mb-4">Welcome to PPcash!</h3>
                                            <form method="POST" action="{{ route('register') }}">
                                                @csrf

                                                <div class="form-label-group">
                                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                                    @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    <label for="name" class="form-label-group ">{{ __('Name') }}</label>
                                                </div>

                                                <div class="form-label-group">
                                                    <input id="skype" type="text" class="form-control @error('skype') is-invalid @enderror" name="skype_id" value="{{ old('skype_id') }}" required>
                                                    @error('skype_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    <label for="skype" class="form-label-group ">{{ __('Skype') }}</label>
                                                </div>

                                                <div class="form-label-group">
                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    <label for="inputEmail" class="form-label-group ">{{ __('E-Mail Address') }}</label>
                                                </div>

                                                <div class="form-label-group">
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    <label for="password" class="col-md-4 form-label-group ">{{ __('Password') }}</label>
                                                </div>

                                                <div class="form-label-group">
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                                    <label for="password-confirm" class="form-label-group ">{{ __('Confirm Password') }}</label>
                                                </div>
                                                <button type="submit" class="btn btn-lg btn-success btn-block btn-login text-uppercase font-weight-bold mb-2">
                                                    {{ __('Register') }}
                                                </button>
                                            </form>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
            </div>
        </div> 
    </body>
                    <script src="js/jquery.min.js"></script>
                    <script src="js/bootstrap.min.js"></script>
</html>