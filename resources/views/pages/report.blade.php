@extends('layouts.common')

@section('css')
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/search.css') }}">

@endsection

@section('sidebar')
<ul class="sidebar-menu">
  <li><a href="{{ route('home')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
  <li><a href="{{ route('transaction')}}"><i class="fa fa-pie-chart"></i><span>Transaction</span></a></li>
  <li class="treeview active"><a href="#"><i class="fa fa-th-list"></i><span>Records</span><i class="fa fa-angle-right"></i></a>
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
        <h1>Student Records</h1>
        <ul class="breadcrumb side">
          <li><i class="fa fa-home fa-lg"></i></li>
          <li><a href="#">Reports</a></li>
        </ul>
      </div>
      <div><a class="btn btn-primary btn-flat" id="pdf"><i class="fa fa-lg fa-file-pdf-o"></i></a><a id="csv" class="btn btn-info btn-flat"><i class="fa fa-lg fa-table"></i></a></div>
    </div>
        <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row">            
              <div class="col-md-12">      
                <label class="control-label col-md-3">Filter by:</label>         
              </div>
              <div class="form-group{{ $errors->has('academicYear') ? ' has-error' : '' }}">    
                <div class="col-md-3">
                  <select class="form-control report" type="text" name="academicYear" required>
                    <option value="" disabled="true" selected>Academic Year</option>
                    <option value="">All</option>
                    @if(!empty($acadyear))
                      @foreach($acadyear as $index=>$data)
                      <option value="{{$data->id}}">{{$data->description}}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
                <div class="col-md-3">
                  <select class="form-control report" type="text" name="department" required>
                    <option value="" disabled="true" selected>Department</option>
                    <option value="">All</option>
                    @if(!empty($department))
                      @foreach($department as $index=>$data)
                      <option value="{{$data->id}}">{{$data->description}}</option>
                      @endforeach
                    @endif
                  </select>
                </div>                        
                <div class="col-md-3">
                  <select class="form-control report" type="text" name="semester" required>
                    <option value="" disabled="true" selected>Semester</option>
                    <option value="">All</option>
                    @if(!empty($semester))
                      @foreach($semester as $index=>$data)
                      <option value="{{$data->id}}">{{$data->description}}</option>
                      @endforeach
                    @endif
                  </select>
                </div>                  
                <div class="col-md-3">
                  <select class="form-control report" type="text" name="course" required>
                    <option value="" disabled="true" selected>Course</option>
                    <option value="">All</option>
                    @if(!empty($course))
                      @foreach($course as $index=>$data)
                      <option value="{{$data->id}}">{{$data->name}}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
              </div>
            </div>
            </br>
            <table class="table table-hover table-bordered bulk_action" id="sampleTable">
                <thead>
                  <tr>
                    <th hidden>ID #</th>
                    <th hidden>Semester</th>
                    <th hidden>Academic Year</th>
                    <th hidden>Course</th>
                    <th>Receipt No.</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th hidden>ID #</th>
                    <th hidden>Semester</th>
                    <th hidden>Academic Year</th>
                    <th hidden>Course</th>
                    <th>Receipt No.</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Date</th>
                  </tr>
                </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section("js")
  <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/plugins/DataTable_Button/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('js/plugins/DataTable_Button/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/DataTable_Button/js/buttons.flash.min.js') }}"></script>
  <script src="{{ asset('js/plugins/DataTable_Button/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('js/plugins/DataTable_Button/js/select.dataTable.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script language="javascript">
  $(document).ready(function(){
    var table = $('#sampleTable').DataTable({
      dom: 'Bfrtip',
      select: true,
      buttons: [
          // {
          //     text: 'JSON',
          //     action: function ( e, dt, button, config ) {
          //         var data = dt.buttons.exportData();

          //         $.fn.dataTable.fileSave(
          //             new Blob( [ JSON.stringify( data ) ] ),
          //             'Export.json'
          //         );
          //     }
          // },
          {
              text: '<i class="fa fa-lg fa-print"></i> Excel',
              extend: 'excelHtml5',
              className: 'btn btn-info btn-flat',
              customize: function( xlsx ) {
                  var sheet = xlsx.xl.worksheets['sheet1.xml'];
   
                  $('row c[r^="C"]', sheet).attr( 's', '2' );
                  $('c[r=A2] t', sheet).text( 'Custom text' );
              }
          },
          "pageLength",
          {
            text: 'Delete',
            action: function(e, dt, node, config){              
                table.rows('.selected').remove().draw(false);
                table.button( 2 ).enable(false);
            },
            enabled: false
          }
      ],
      "ajax": "/report/receipt",    
      "columnDefs": [
          {
              "targets": [ 0 ],
              "visible": false,
              "searchable": false
          },
          {
              "targets": [ 1 ],
              "visible": false
          },
          {
              "targets": [ 2 ],
              "visible": false
          },
          {
              "targets": [ 3 ],
              "visible": false
          }
      ],
      select: {
          style: 'mobile',
          selector: 'tr'
      },
      // createdRow: function( row, data, dataIndex ) {
      //     $( row ).attr("onclick", "window.location.href = 'student/transaction/"+data[0]+"'");
      // }
    });

    table.on( 'deselect', function () {
        var selectedRows = table.rows( { selected: true } ).count();
 
        table.button( 2 ).enable( selectedRows > 0 );
    } );

    table.on( 'select', function () {
        var selectedRows = table.rows( { selected: true } ).count();
 
        table.button( 2 ).enable( selectedRows > 0 );
    } );

    // Configure Print Button
    // new $.fn.dataTable.Buttons( table, {
    //     buttons: [
    //         {
    //             text: '<i class="fa fa-lg fa-print"></i> Print Assets',
    //             extend: 'print',
    //             className: 'btn btn-primary btn-sm m-5 width-140 assets-select-btn export-print'
    //         }
    //     ]
    // } );
     
    // // Add the Print button to the toolbox
    // console.log(table.buttons( 1, null ).container().appendTo( '.page-title' ));

    $('select[name="semester"]').change(function(){
      $('#sampleTable').DataTable().column(1).search($(this).val()).draw();
    });

    $('select[name="academicYear"]').change(function(){
      $('#sampleTable').DataTable().column(2).search($(this).val()).draw();
    });

    $('select[name="course"]').change(function(){
      $('#sampleTable').DataTable().column(3).search($(this).val()).draw();
    });

  });
  // $($('#sampleTable').DataTable().column(3).footer()).text('321312');
  // $($('#sampleTable').DataTable().column(3).header()).text('321312');
  // $('#sampleTable').DataTable().ajax.url('/studentlist').load();
  </script>
@endsection