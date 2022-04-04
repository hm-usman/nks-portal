<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NSKHOST</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicon.png')}}">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body>
  <div id="app">

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
  <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

      <!--**********************************
          Nav header start
      ***********************************-->
      <div class="nav-header">
          <div class="brand-logo">
              <a href="/">
                  <b class="logo-abbr"><img src="{{asset('images/nsk-250.png')}}" alt="" style="width: 200"> </b>
                  <span class="logo-compact"><img src="{{asset('images/nsk-250.png')}}" alt=""></span>
                  <span class="brand-title">
                      <img src="{{asset('images/nsk-250.png')}}" alt="" style="width: 200px">
                  </span>
              </a>
          </div>
      </div>
      <!--**********************************
          Nav header end
      ***********************************-->

      <!--**********************************
          Header start
      ***********************************-->
      <div class="header">    
          <div class="header-content clearfix">
              
              <div class="nav-control">
                  <div class="hamburger">
                      <span class="toggle-icon"><i class="icon-menu"></i></span>
                  </div>
              </div>
              <div class="header-left">
                  
              </div>
              <div class="header-right">
                  <ul class="clearfix">
                      <navbar-messenger user="{{auth::user()}}"></navbar-messenger>
                      <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                              <i class="mdi mdi-bell-outline"></i>
                              <span class="badge badge-pill gradient-2">3</span>
                          </a>
                          <div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
                              <div class="dropdown-content-heading d-flex justify-content-between">
                                  <span class="">2 New Notifications</span>  
                                  <a href="javascript:void()" class="d-inline-block">
                                      <span class="badge badge-pill gradient-2">5</span>
                                  </a>
                              </div>
                              <div class="dropdown-content-body">
                                  <ul>
                                      <li>
                                          <a href="javascript:void()">
                                              <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-present"></i></span>
                                              <div class="notification-content">
                                                  <h6 class="notification-heading">Events near you</h6>
                                                  <span class="notification-text">Within next 5 days</span> 
                                              </div>
                                          </a>
                                      </li>
                                      <li>
                                          <a href="javascript:void()">
                                              <span class="mr-3 avatar-icon bg-danger-lighten-2"><i class="icon-present"></i></span>
                                              <div class="notification-content">
                                                  <h6 class="notification-heading">Event Started</h6>
                                                  <span class="notification-text">One hour ago</span> 
                                              </div>
                                          </a>
                                      </li>
                                      <li>
                                          <a href="javascript:void()">
                                              <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-present"></i></span>
                                              <div class="notification-content">
                                                  <h6 class="notification-heading">Event Ended Successfully</h6>
                                                  <span class="notification-text">One hour ago</span>
                                              </div>
                                          </a>
                                      </li>
                                      <li>
                                          <a href="javascript:void()">
                                              <span class="mr-3 avatar-icon bg-danger-lighten-2"><i class="icon-present"></i></span>
                                              <div class="notification-content">
                                                  <h6 class="notification-heading">Events to Join</h6>
                                                  <span class="notification-text">After two days</span> 
                                              </div>
                                          </a>
                                      </li>
                                  </ul>
                                  
                              </div>
                          </div>
                      </li>
                      <li class="icons dropdown">
                          <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
                              <span class="activity active"></span>
                              <img src="/images/employees/{{Auth::user()->photo}}" height="40" width="40" alt="">
                          </div>
                          <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                              <div class="dropdown-content-body">
                                  <ul>
                                      <li>
                                          <a href="{{route('my-profile')}}"><i class="icon-user"></i> <span>Profile</span></a>
                                      </li>
                                      <li>
                                          <a href="{{route('settings')}}">
                                              <i class="icon-wrench"></i> <span>Settings</span>
                                          </a>
                                      </li>
                                      
                                      <hr class="my-2">
                                        <li>
                                          <a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon-key"></i> <span>Logout</span></a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                  </ul>
                              </div>
                          </div>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <!--**********************************
          Header end ti-comment-alt
      ***********************************-->

      <!--**********************************
          Sidebar start
      ***********************************-->
      <div class="nk-sidebar">           
          <div class="nk-nav-scroll">
              <ul class="metismenu" id="menu">
                  <li class="nav-label">Dashboard</li>
                  @can('isAdmin')
                  <li>
                    <a href="/admin/employees" aria-expanded="false">
                        <i class="icon-user menu-icon"></i><span class="nav-text">Employees</span>
                    </a>
                  </li>
                  @endcan  
                  <li>
                    <a href="/tasks" aria-expanded="false">
                        <i class="icon-note menu-icon"></i><span class="nav-text">Tasks</span>
                    </a>
                  </li>
              </ul>
          </div>
      </div>
      <!--**********************************
          Sidebar end
      ***********************************-->

      <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

          <div class="container-fluid">
            @yield('content')
          </div>
          <!-- #/ container -->
      </div>
      <!--**********************************
          Content body end
      ***********************************-->
    <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
          <div class="copyright">
              <p>Copyright &copy; <a href="https://nskhost.com">NSKHOST</a> {{date('Y')}}</p>
          </div>
      </div>
      <!--**********************************
          Footer end
      ***********************************-->
  </div>
  <!--**********************************
      Main wrapper end
  ***********************************-->

  </div>
  <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{ asset('js/app.js')}}"></script>
    <script src="{{ asset('plugins/common/metismenu.min.js')}}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/custom.min.js')}}"></script>
    <script src="{{ asset('js/gleek.js')}}"></script>
    <script src="{{ asset('js/styleSwitcher.js')}}"></script>


</body>

</html>

