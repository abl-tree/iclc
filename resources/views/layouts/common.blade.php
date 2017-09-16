<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select.dataTable.min.css') }}">
    @yield('css')

    <title>ICLC System</title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--if lt IE 9
    script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    script(src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    -->
  </head>
  <body class="sidebar-mini fixed">
    <!-- Navbar-->
      <header class="main-header hidden-print"><a class="logo" href="{{ route('home')}}">ICLC System </a>
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button--><a class="sidebar-toggle" href="#" data-toggle="offcanvas"></a>
          <!-- Navbar Right Menu-->
          <div class="navbar-custom-menu">
            <ul class="top-nav">
              <!-- User Menu-->
              <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu">                  
                  <li><a href="{{ route('edit')}}"><i class="fa fa-cog fa-lg"></i> Settings</a></li>
                  <li>
                    <a href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-lg"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                  </li>
                </ul>
              </li>
            </ul>
          </div>          
        </nav>
      </header>
      <!-- Side-Nav-->
      <aside class="main-sidebar hidden-print">
        <section class="sidebar">
          <div class="user-panel">
            <div class="pull-left image"><img class="img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image"></div>
            <div class="pull-left info">
              <p>{{ Auth::user()->username }}</p>
              <p class="designation">{{ Auth::user()->position }}</p>
            </div>
          </div>
          <!-- Sidebar Menu-->
          @yield('sidebar')
        </section>
      </aside>     
      <div id='dynamic'>
        @yield('content')
      </div>

<!-- Javascripts-->
<script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
@yield('js')
<script src="{{ asset('js/essential-plugins.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/plugins/pace.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/bootstrap-notify.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
<script type="text/javascript">
  $('body').tooltip({
    selector: '[rel="tooltip"]'
  });  
</script>
<!-- Javascripts-->
</body>

</html>