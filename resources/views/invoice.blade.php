@extends('layouts.common')

@section('sidebar')
<ul class="sidebar-menu">
  <li><a href="{{ route('home')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
  <li class="active"><a href="{{ route('transaction')}}"><i class="fa fa-pie-chart"></i><span>Transaction</span></a></li>
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
    <div class="page-title hidden-print">
      <div>
        <h1><i class="fa fa-file-text-o"></i> Invoice</h1>
        <p>A Printable Invoice Format</p>
      </div>
      <div>
        <ul class="breadcrumb">
          <li><i class="fa fa-home fa-lg"></i></li>
          <li><a href="#">Invoice</a></li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div id="invoice" class="col-md-12">
        <div class="card">
          <section class="invoice">
            <div class="row">
              <div class="col-xs-12">
                <h2 class="page-header"><i class="fa fa-globe"></i> Institute of Computing<small class="pull-right">Date: {{ $data[0]['Date'] }}</small></h2>
              </div>
            </div>
            <div class="row invoice-info">              
              <div class="col-xs-4">
                  <b>Official Receipt # @if($data['accounts'][0]->status == "Optional") OP @endif {{ $data[0]['OR'] }} </b><br><br>
                  <b>Name:</b> {{ $data[0]['Name'] }}<br><b>AY:</b> {{ $data[0]['academic_year'] }}<br><b>Semester:</b> {{ $data[0]['Semester'] }}<br>
                  <b>Course:</b> {{ $data[0]['Course'] }}<br><b>Year:</b> {{ $data[0]['Year'] }}
              </div>                 
              <div class="col-xs-4">
              </div>                   
              <div class="col-xs-4">Received by :
                <address><strong>ICLC {{ $data[0]['Cashier'] }}</strong></address>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <!-- <th>Qty</th> -->
                      <th>Accounts</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(!empty($data['accounts']))
                      @foreach($data['accounts'] as $index=>$account)
                    <tr>
                      <!-- <td>1</td> -->
                      <td>{{$account->name}}</td>
                      <td>{{$data['data'][$index]['payment']}}</td>
                    </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row hidden-print mt-20">
              <div class="col-xs-12 text-right"><a class="btn btn-primary" href="javascript:window.print();" target="_blank"><i class="fa fa-print"></i> Print</a></div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection