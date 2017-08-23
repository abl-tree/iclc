@extends('layouts.common')

@section('content')

<div class="wrapper">
  <div class="content-wrapper">
    <div class="page-title">
      <div>
        <h1><i class="fa fa-edit"></i> Update</h1>
        <p>Student</p>
      </div>
      <div>
        <ul class="breadcrumb">
          <li><a href="{{ route('home')}}"><i class="fa fa-home fa-lg"></i></a></li>
          <li><a href="{{ route('students')}}">Students</a></li>
          <li><a href="#">Update</a></li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <h3 class="card-title">Update</h3>
          <div class="card-body">
            <form class="form-horizontal">
              <div class="form-group">
                <label class="control-label col-md-3">Student ID</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter ID number">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Name</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter full name">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Course</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter full name">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Year</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter full name">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Gender</label>
                <div class="col-md-9">
                  <div class="radio-inline">
                    <label>
                      <input type="radio" name="gender">Male
                    </label>
                  </div>
                  <div class="radio-inline">
                    <label>
                      <input type="radio" name="gender">Female
                    </label>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-md-8 col-md-offset-3">
                <button class="btn btn-primary icon-btn" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-default icon-btn" href="#"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection