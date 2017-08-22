@extends('layouts.common')

@section('sidebar')
<ul class="sidebar-menu">
  <li><a href="{{ route('home')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
  <li><a href="{{ route('transaction')}}"><i class="fa fa-pie-chart"></i><span>Transaction</span></a></li>
  <li class="treeview"><a href="#"><i class="fa fa-th-list"></i><span>Records</span><i class="fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a href="{{ route('students')}}"><i class="fa fa-circle-o"></i> Student</a></li>
      <li><a href="{{ route('cashiers')}}"><i class="fa fa-circle-o"></i> Cashier</a></li>
      <li><a href="{{ route('items')}}"><i class="fa fa-circle-o"></i> Items</a></li>
      <li><a href="{{ route('reports')}}"><i class="fa fa-circle-o"></i><span>Reports</span></a></li>
    </ul>
  </li>
</ul>
@endsection

@section('content')

<div class="wrapper">
  <div class="content-wrapper">
    <div class="row user">
      <div class="col-md-12">
        <div class="profile">
          <div class="info"><img class="user-img" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/128.jpg">
            <h4>{{ Auth::user()->name }}</h4>
            <p>{{ Auth::user()->position }}</p>
          </div>
          <div class="cover-image"></div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card p-0">
          <ul class="nav nav-tabs nav-stacked user-tabs">
            <li class="active"><a href="#user-settings" data-toggle="tab">Settings</a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-9">
        <div class="tab-content">
          <div class="tab-pane active" id="user-settings">
            <div class="card user-settings">
              <h4 class="line-head">Settings</h4>
              <form class="form-horizontal" role="form" method="POST" action="{{ route('account') }}">
               {{ csrf_field() }}

                <div class="row mb-20">
                  <div class="col-md-4{{ $errors->has('fName') ? ' has-error' : '' }}">
                    <label>First Name</label>
                    <input class="form-control" type="text" id="fName" name="fName" value="{{ old('fName') }}" required autofocus>
                  </div>
                  <div class="col-md-4{{ $errors->has('lName') ? ' has-error' : '' }}">
                    <label>Last Name</label>
                    <input class="form-control" type="text" id="lName" name="lName" value="{{ old('lName') }}" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8 mb-20{{ $errors->has('lName') ? ' has-error' : '' }}">
                    <label>Username</label>
                    <input class="form-control" type="text" id="username" name="username" value="{{ old('username') }}" required>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-md-8 mb-20{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password" required>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-md-8 mb-20{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label>Confirm Password</label>
                    <input class="form-control" type="password" id="password-confirm" name="password_confirmation" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>
                <div class="row mb-10">
                  <div class="col-md-12">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i> Save</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection