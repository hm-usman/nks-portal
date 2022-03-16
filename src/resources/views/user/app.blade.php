<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="https://ppcash.net/assets/img/ppico.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PPCash') }}</title>

    <!-- Scripts -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    {{-- <link href="{{ asset('analytics/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('analytics/css/style.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('css/style.css') }}" rel="stylesheet"> --}}
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet"  />

</head>
<body>
    <div id="app">                      
      	<!-- wrapper -->
	<div class="wrapper">
		<!--sidebar-wrapper-->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div class="">
					<img src="https://ppcash.net/assets/img/ppico.png" class="logo-icon-2" alt="" />
				</div>
				<div>
					<h4 class="logo-text">CASH</h4>
				</div>
				<a href="javascript:;" class="toggle-btn ml-auto"> <i class="fa fa-bars"></i>
				</a>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				<li class="{{Request::is('analytics/home') ? 'mm-active' : ''}}">
					<a href="{{ route('home') }}">
						<div class="parent-icon icon-color-9"><i class="fa fa-home"></i></div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>
        <li class="{{Request::is('analytics/websites') ? 'mm-active' : ''}}">
					<a href="{{ route('websites') }}">
						<div class="parent-icon icon-color-9"><i class="fa fa-desktop"></i></div>
						<div class="menu-title">Websites</div>
					</a>
				</li>
        <li class="{{Request::is('analytics/ad-codes') ? 'mm-active' : ''}}">
					<a href="{{ route('my-adcodes') }}">
						<div class="parent-icon icon-color-9"><i class="fa fa-database"></i></div>
						<div class="menu-title">AdCodes</div>
					</a>
				</li>
        <li class="{{Request::is('analytics/payments') ? 'mm-active' : ''}}">
					<a href="{{ route('payments') }}">
						<div class="parent-icon icon-color-9"><i class="fa fa-money"></i></div>
						<div class="menu-title">Payments</div>
					</a>
				</li>
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar-wrapper-->
		<!--header-->
		<header class="top-header">
			<nav class="navbar navbar-expand">
				<div class="left-topbar d-flex align-items-center">
					<a href="javascript:;" class="toggle-btn">	<i class="fa fa-bars"></i>
					</a>
				</div>
				<div class="right-topbar ml-auto">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link position-relative" href="skype:live:.cid.99ef58139767b4c9?chat">	
                <i class="fa fa-skype icon-color-9 vertical-align-middle"></i>
							</a>
						</li>
						<li class="nav-item dropdown dropdown-user-profile">
							<a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-toggle="dropdown">
								<div class="media user-box align-items-center">
									<div class="media-body user-info">
										<p class="user-name mb-0 text-capitalize">{{Auth::user()->name}}</p>
									</div>
									<img src="https://via.placeholder.com/110x110" class="user-img" alt="user avatar">
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-right">	
								<a class="dropdown-item" href="{{ route('profile') }}">
									<i class="fa fa-user"></i>
									<span>Profile</span>
								</a>
								<div class="dropdown-divider mb-0"></div>
								<a class="dropdown-item" href="{{ route('settings') }}">
									<i class="fa fa-cogs"></i>
									<span>Change Password</span>
								</a>
								<div class="dropdown-divider mb-0"></div>	
								<a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#logoutModal">
									<i class="fa fa-sign-out"></i>
									<span>Logout</span>
								</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<!--end header-->
		<!--page-wrapper-->
		<div class="page-wrapper">
			<!--page-content-wrapper-->
			<div class="page-content-wrapper">
				<div class="page-content">
          @yield('content')
				</div>
			</div>
			<!--end page-content-wrapper-->
		</div>
		<!--end page-wrapper-->
		<!--start overlay-->
		<div class="overlay toggle-btn-mobile"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='fa fa-arrow-up'></i></a>
		<!--End Back To Top Button-->
		<!--footer -->
		<!-- end footer -->
	</div>
	<!-- end wrapper -->



  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
            </a>                            
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
        </div>
      </div>
    </div>
  </div>

	</div>

  	<script src="{{ asset('js/jquery.min.js') }}"></script>
  	<script src="{{ asset('js/bootstrap.min.js')}}"></script>
  	<script src="{{ asset('js/domains.js') }}"></script>
  	<script src="{{ asset('js/simplebar.min.js') }}"></script>
	<script src="{{ asset('js/metisMenu.min.js') }}"></script>
	<script src="{{ asset('js/perfect-scrollbar.js') }}"></script>
	<script src="{{ asset('js/theme.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>
  <script>
    function copyAdcode(id) {
      var copyText = document.getElementById(id);
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");
      document.getElementById(id+"-copied").classList.remove("d-none");
    }
</script>

</body>

</html>
