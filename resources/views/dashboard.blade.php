@extends('layouts.common')

@section('sidebar')
<ul class="sidebar-menu">
  <li class="active"><a href="{{ route('home')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
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
    <div class="page-title">
      <div>
        <h1><i class="fa fa-pie-chart"></i> ICLC Payment Status</h1>
      </div>
    </div>
    <div class="row">
      <div class="clearfix"></div>
      <div class="col-md-8">
        <div class="card">
          <h3 class="card-title">Payment Report</h3>
          <div class="embed-responsive embed-responsive-16by9">
            <canvas class="embed-responsive-item" id="pieChartDemo"></canvas>
            <!-- <div class="embed-responsive-item">
              <img class="img-responsive" src="{{ URL::to("/images/ajax-loader.gif")}}" style="margin: 0px auto; height: 90%;">
            </div> -->
          </div>
          <div id="js-legend" class="chart-legend"></div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <h3 class="card-title">Summary</h3>          
            <div class="widget-small info"><i class="icon fa fa-thumbs-o-up fa-2x"></i>
              <div class="info">
                <h4>Paid</h4>
                <p> <b class="paid_value">{{$Paid}}</b></p>
              </div>
            </div>    
            <div class="widget-small warning"><i class="icon fa fa-star-half-full fa-2x"></i>
              <div class="info">
                <h4>Partially paid</h4>
                <p> <b class="partial_value">{{$Partial}}</b></p>
              </div>
            </div>
            <div class="widget-small danger"><i class="icon fa fa-thumbs-o-down fa-2x"></i>
              <div class="info">
                <h4>Unpaid</h4>
                <p> <b class="unpaid_value">{{$Unpaid}}</b></p>
              </div>
            </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section('js')
<script type="text/javascript" src="{{ asset('js/plugins/chart.js') }}"></script>
<script>
  var paid = 0;
  var unpaid = 0;
  var partial = 0;
  var barChart;     
     
  graph();  
  setInterval("update()", 1000);

  function graph(){
    $.ajax({
              type: "GET",
              url: "/stats",
              success: function(data){ 
                paid = data['Paid'];
                unpaid = data['Unpaid'];
                partial = data['Partial'];

                var pdata = [
                {
                  value: paid,
                  color: "#2196F3",
                  highlight: "#1A78C2",
                  label: "No. of Fully Paid Students"
                },
                {
                  value: unpaid,
                  color:"#F44336",
                  highlight: "#C3362B",
                  label: "No. of Unpaid Students"
                },
                {
                  value: partial,
                  color: "#FF9800",
                  highlight: "#CC7A00",
                  label: "No. of Partially Paid Students"
                }
              ]

              var options = {
                tooltipEvents: [],
                showTooltips: true,
                onAnimationComplete: function(){
                  this.showTooltip(this.segments, false);
                },
                tooltipTemplate: "<%= label %> - <%= value %>"
              }

              var ctxp = $("#pieChartDemo").get(0).getContext("2d");
              barChart = new Chart(ctxp).Pie(pdata);
              },  
              error: function(e) {
                console.log("Cannot connect to the server.");
              }
        });
  }

  function update(){
    $.ajax({
              type: "GET",
              url: "/stats",
              success: function(data){   
                if(data['Partial'] != partial || data['Paid'] != paid)
                {
                  paid = data['Paid'];
                  unpaid = data['Unpaid'];
                  partial = data['Partial'];

                  $(".paid_value").text(paid);
                  $(".partial_value").text(partial);
                  $(".unpaid_value").text(unpaid);
  
                  barChart.segments[0].value = paid;
                  barChart.segments[1].value = unpaid;
                  barChart.segments[2].value = partial;
                  barChart.update();
                }
              },  
              error: function(e) {
                console.log("Cannot connect to the server.");
              }
        });
  }
</script>
@endsection
