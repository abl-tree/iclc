@extends('layouts.common')

@section('css')
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/search.css') }}">

@endsection

@section('sidebar')
<ul class="sidebar-menu">
  <li><a href="{{ route('transaction')}}"><i class="fa fa-calculator"></i><span>Transaction</span></a></li>
  <li class="treeview"><a href="#"><i class="fa fa-th-list"></i><span>Record</span><i class="fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a href="{{ route('students')}}"><i class="fa fa-circle-o"></i> Student</a></li>
      <li><a href="{{ route('cashiers')}}"><i class="fa fa-circle-o"></i> Cashier</a></li>
      <li><a href="{{ route('items')}}"><i class="fa fa-circle-o"></i> Item</a></li>
    </ul>
  </li>
  <li class="treeview active"><a href="#"><i class="fa fa-file-text"></i><span>Report</span><i class="fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a href="{{ route('reports')}}"><i class="fa fa-circle-o"></i><span>Receipt</span></a></li>
    </ul>
    <ul class="treeview-menu">
      <li><a href="{{ route('item-reports')}}"><i class="fa fa-circle-o"></i><span>Item</span></a></li>
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
      <div>
        <a id="delete-selected-row" class="btn btn-primary btn-flat disabled"><i class="fa fa-lg fa-trash-o"></i></a>
        <a id="update-selected-row" class="btn btn-info btn-flat disabled"><i class="fa fa-lg fa-edit"></i></a>
      </div>
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
                      <option value="{{$data->description}}">{{$data->description}}</option>
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
                      <option value="{{$data->description}}">{{$data->description}}</option>
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
                      <option value="{{$data->name}}">{{$data->name}}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
              </div>
            </div>
            </br>
            <table class="table table-hover table-bordered bulk_action" id="sampleTable" style="width: 100%;">
                <thead>
                  <tr>
                    <th hidden>ID #</th>
                    <th>Receipt No.</th>
                    <th>Name</th>
                    <th hidden>Semester</th>
                    <th hidden>Academic Year</th>
                    <th hidden>Course</th>
                    <th>Amount</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th hidden>ID #</th>
                    <th>Receipt No.</th>
                    <th>Name</th>
                    <th hidden>Semester</th>
                    <th hidden>Academic Year</th>
                    <th hidden>Course</th>
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
  <script src="{{ asset('js/jszip.min.js')}}"></script>
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
              text: '<i class="fa fa-print"></i> Excel',
              extend: 'excelHtml5',
              customize: function( xlsx ) {
                  var sheet = xlsx.xl.worksheets['sheet1.xml'];
   
                  $('row c[r^="C"]', sheet).attr( 's', '2' );
              }
          },
          "pageLength",
          // {
          //   text: 'Delete',
          //   action: function(e, dt, node, config){              
          //       table.rows('.selected').remove().draw(false);
          //       table.button( 2 ).enable(false);
          //   },
          //   enabled: false
          // }
      ],
      "ajax": "/report/receipt",    
      "columnDefs": [
          {
              "targets": [ 0 ],
              "visible": false,
              "searchable": false
          },
          {
              "targets": [ 3 ],
              "visible": false
          },
          {
              "targets": [ 4 ],
              "visible": false
          },
          {
              "targets": [ 5 ],
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
 
        if( selectedRows > 0 ){
          $('#delete-selected-row').removeClass('disabled');
          if(selectedRows === 1){
            $('#update-selected-row').removeClass('disabled');
          }else{
            $('#update-selected-row').addClass('disabled');
          }
        }else{
          $('#delete-selected-row').addClass('disabled');
          $('#update-selected-row').addClass('disabled');
        }
    } );

    table.on( 'select', function () {
        var selectedRows = table.rows( { selected: true } ).count();
 
        if( selectedRows > 0 ){
          $('#delete-selected-row').removeClass('disabled');
          if(selectedRows === 1){
            $('#update-selected-row').removeClass('disabled');
          }else{
            $('#update-selected-row').addClass('disabled');
          }
        }else{
          $('#delete-selected-row').addClass('disabled');
          $('#update-selected-row').addClass('disabled');
        }
    } );

    $('#delete-selected-row').click(function(){       
      table.rows('.selected').remove().draw(false);
    })

    $('select[name="semester"]').change(function(){
      $('#sampleTable').DataTable().column(3).search($(this).val()).draw();
    });

    $('select[name="academicYear"]').change(function(){
      $('#sampleTable').DataTable().column(4).search($(this).val()).draw();
    });

    $('select[name="course"]').on('change', function(){
      $('#sampleTable').DataTable().column(5).search($(this).val()).draw();
    });
   
    $('select[name="academicYear"] option:last').prop('selected', 'selected').trigger('change');


  });
  // $($('#sampleTable').DataTable().column(3).footer()).text('321312');
  // $($('#sampleTable').DataTable().column(3).header()).text('321312');
  // $('#sampleTable').DataTable().ajax.url('/studentlist').load();
  </script>
@endsection