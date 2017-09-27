<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ICLC System</title>

    <!-- Styles -->
    <link href="{{ asset('css/search.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
     <div>
        <h1 style="color: white; text-align: : left; font-size: 100px; font-family: Arial Black, Gadget, sans-serif  ">ICLC</h1><hr>  
           <h1 style="color: white; text-align: : left">Payment System</h1>
      </div>
      <div class="login-box">
          <form class="login-form" role="form" method="POST" action="{{ route('login') }}">
              {{ csrf_field() }}

            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
              <label for="username" class="control-label">Username</label>
              <input name="username" id="username" class="form-control" type="name" placeholder="Username" value="{{ old('username')}}" required autofocus>

              @if($errors->has('username'))
                  <span class="help-block">
                      <strong>{{ $errors->first('username') }}</strong>
                  </span>    
              @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password" class="control-label">PASSWORD</label>
              <input id="password" class="form-control" type="password" placeholder="Password" name="password" required>            
            </div>

            <div class="form-group">
              <div class="utility">
                <div class="animated-checkbox">
                  <label class="semibold-text">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}><span class="label-text">Remember me</span>
                  </label>
                </div>
                <p class="semibold-text mb-0"><a id="toFlip" href="#">Forgot Password ?</a></p>
              </div>
            </div>
            <div class="form-group btn-container">
              <button type="submit" class="btn btn-primary btn-block">SIGN IN <i class="fa fa-sign-in fa-lg"></i></button>
            </div>
          </form>
          <form class="forget-form" action="index.html">
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
            <div class="form-group">
              <label class="control-label">EMAIL</label>
              <input class="form-control" type="text" placeholder="Email">
            </div>
            <div class="form-group btn-container">
              <button class="btn btn-primary btn-block">RESET <i class="fa fa-unlock fa-lg"></i></button>
            </div>
            <div class="form-group mt-20">
              <p class="semibold-text mb-0"><a id="noFlip" href="#"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
            </div>
          </form>
      </div>
    </section>
</body>
<script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('js/essential-plugins.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/plugins/pace.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
</html>
