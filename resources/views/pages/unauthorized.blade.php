@extends('layouts.common')

@section('sidebar')
<ul class="sidebar-menu">
  <li class="active"><a href="#"><i class="fa fa-home"></i><span>Home</span></a></li>
</ul>
@endsection

@section('content')
  <div class="content-wrapper">
    <div class="page-title">
      <div>
        <h1><i class="fa fa-home"></i> Home</h1>
      </div>
      <div>
        <ul class="breadcrumb">
          <li><i class="fa fa-home fa-lg"></i></li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h4><i class="fa fa-ban"></i> Your account is not authorized to perform transaction!</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection