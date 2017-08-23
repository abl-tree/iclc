<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/search.css') }}">

    <title>ICLC System</title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--if lt IE 9
    script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    script(src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    -->
  </head>
  <body class="sidebar-mini fixed">
    <!-- Navbar-->
      <header class="main-header hidden-print"><a class="logo" href="/homestudent?idnumber={{$id}}">ICLC System</a>
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button--><a class="sidebar-toggle" href="#" data-toggle="offcanvas"></a>
          <!-- Navbar Right Menu-->
          <div class="navbar-custom-menu">
            <ul class="top-nav">
              <!-- User Menu-->
              <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu">                  
                  <li>
                    <a href="/login"><i class="fa fa-sign-out fa-lg"></i> Logout
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
<!-- 
        <div class="toggle-flip">
                <label>
                  <input type="checkbox"><span class="flip-indecator" data-toggle-off="FACEBOOK" style="position: absolute;" data-toggle-on="TWITTER"></span>
                </label>
        </div> -->
        </nav>
      </header>
      <!-- Side-Nav-->
     <aside class="main-sidebar hidden-print">
        <section class="sidebar">
          <div class="user-panel">
            <div class="pull-left image"><img class="img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image"></div>
            <div class="pull-left info">
              <p> @if(!empty($students))
                      @foreach($students as $student){{$student->Student_Name}}  
          @endforeach
                    @endif </p>
              <p class="designation">@if(!empty($students))
                      @foreach($students as $student) {{$student->Student_No}} 
          @endforeach
                    @endif</p>
            </div>
          </div>
          <!-- Sidebar Menu-->
          <ul class="sidebar-menu">
            <li class="active"><a href="/homestudent?idnumber={{$id}}"><i class="fa fa-pie-chart"></i><span>Transaction</span></a></li>
           
          
          </ul>
        </section>
      </aside> 
<div id='dynamic'>
        @yield('content')
</div>

  </body>
    <!-- Javascripts-->
    <script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('js/essential-plugins.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/pace.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
        @yield('js')
    <script type="text/javascript" src="{{ asset('js/plugins/chart.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/bootstrap-notify.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>

    <!-- Javascripts-->
   
</html>