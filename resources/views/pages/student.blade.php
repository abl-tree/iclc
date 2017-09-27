@extends('layouts.common')

@section('sidebar')
<ul class="sidebar-menu">
  <li><a href="{{ route('home')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
  <li><a href="{{ route('transaction')}}"><i class="fa fa-calculator"></i><span>Transaction</span></a></li>
  <li class="treeview active"><a href="#"><i class="fa fa-th-list"></i><span>Record</span><i class="fa fa-angle-right"></i></a>
    <ul class="treeview-menu">
      <li><a href="{{ route('students')}}"><i class="fa fa-circle-o"></i> Student</a></li>
      <li><a href="{{ route('cashiers')}}"><i class="fa fa-circle-o"></i> Cashier</a></li>
      <li><a href="{{ route('items')}}"><i class="fa fa-circle-o"></i> Item</a></li>
    </ul>
  </li>
  <li class="treeview"><a href="#"><i class="fa fa-file-text"></i><span>Report</span><i class="fa fa-angle-right"></i></a>
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
          <li>Records</li>
          <li class="active"><a href="#">Student</a></li>
        </ul>
      </div>      
      <div class="btn-group">
        <form class="btn-group" id="upload" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
            <label rel="tooltip" data-toggle="tooltip" class="btn btn-default btn-upload" title="Upload excel file">
              <input type="file" class="sr-only" name="excel" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
              <span>
                <span id="upload_icon" class="fa fa-upload"></span>
              </span>
            </label>
        </form>
        <a type="submit" data-toggle="modal" data-target="#add_student" class="btn btn-primary btn-flat" rel="tooltip" data-toggle="tooltip" title="Add student"><i class="fa fa-lg fa-plus"></i></a>
        <a id="delete-selected-row" class="btn btn-danger btn-flat disabled" rel="tooltip" data-toggle="tooltip" title="Delete selected rows"><i class="fa fa-lg fa-trash-o"></i></a>
        <a type="submit" data-toggle="modal" data-target=".update_student" rel="tooltip" data-toggle="tooltip" title="Update selected row" id="update-selected-row" class="btn btn-info btn-flat disabled"><i class="fa fa-lg fa-edit"></i></a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">  
          <div class="card-body">
            <table class="table table-hover table-bordered" id="sampleTable" style="width: 100%;">
                <thead>
                  <tr>
                    <th style="display: none;">ID</th>
                    <th>ID #</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Course</th>
                    <th>Year</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th style="display: none;">ID</th>
                    <th>ID #</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Course</th>
                    <th>Year</th>
                  </tr>
                </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Item Modal -->

<div id="add_student" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">      
      <form class="form-horizontal" id="add-student-form" role="form">    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Add Student</h3>
      </div>
      <div class="modal-body">
          <div class="card-body">
              {{ csrf_field() }}

              <div class="form-group{{ $errors->has('studNum') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Student No.</label>
                <div class="col-md-9">
                  <input class="form-control" type="text" placeholder="Enter Student Number" id="studNum" name="studNum" value="{{ old('studNum') }}" required autofocus>
                </div>
              </div>
              <div class="form-group{{ $errors->has('firstName') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Name</label>
                <div class="col-md-9">
                  <input class="form-control" type="text" placeholder="Lastname, Firstname MI." id="first_name" name="firstName" value="{{ old('firstName') }}" required>
                </div>
              </div>            
              <div class="form-group{{ $errors->has('studCourse') ? ' has-error' : '' }}">       
                <label class="control-label col-md-3">Course</label>         
                <div class="col-md-9">
                  <select class="form-control report" type="text" name="studCourse" required>
                    <option value="" disabled="true" selected>Selected option</option>
                    @if(!empty($course))
                      @foreach($course as $index=>$data)
                      <option value="{{$data->id}}">{{$data->name}}</option>
                      @endforeach
                    @endif
                    <option value="add">Add</option>
                  </select>
                </div>
              </div>             
              <div class="form-group{{ $errors->has('studYear') ? ' has-error' : '' }}">       
                <label class="control-label col-md-3">Year</label>         
                <div class="col-md-9">
                  <select class="form-control report" type="text" name="studYear" required>
                    <option value="" disabled="true" selected>Selected option</option>
                    <option value="1">1st Year</option>
                    <option value="2">2nd Year</option>
                    <option value="3">3rd Year</option>
                    <option value="4">4th Year</option>
                  </select>
                </div>
              </div>
              <div class="form-group{{ $errors->has('studGender') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Gender</label>
                <div class="col-md-9">
                  <div class="radio-inline">
                    <label>
                      <input type="radio" name="studGender" id="studGender" value="M" required>Male
                    </label>
                  </div>
                  <div class="radio-inline">
                    <label>
                      <input type="radio" name="studGender" id="studGender" value="F" required>Female
                    </label>
                  </div>
                </div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
          <div class="card-footer">
            <div class="row">
              <div class="col-md-8 col-md-offset-3">
                <button class="btn btn-primary icon-btn" type="submit"><i class="fa fa-fw fa-lg fa-plus"></i>Add</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-default icon-btn"  class="close" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
              </div>
            </div>
          </div>
      </div>
    </form>
    </div>
  </div>
</div> 


<!-- Update Student Modal -->

<div id="update_student" class="modal fade update_student">
  <div class="modal-dialog">
    <div class="modal-content">      
      <form class="form-horizontal" id="update-student-form" role="form">    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Update Student</h3>
      </div>
      <div class="modal-body">
          <div class="card-body">
              {{ csrf_field() }}
              <input type="hidden" name="student_id">
              <div class="form-group{{ $errors->has('update-studNum') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Student No.</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter Student Number" id="update-studNum" name="update-studNum" value="{{ old('update-studNum') }}" required autofocus>
                </div>
              </div>
              <div class="form-group{{ $errors->has('update-studName') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Name</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter Student Name" id="update-studName" name="update-studName" value="{{ old('update-studName') }}" required>
                </div>
              </div>
              <div class="form-group{{ $errors->has('update-studCourse') ? ' has-error' : '' }}">       
                <label class="control-label col-md-3">Course</label>         
                <div class="col-md-8">
                  <select class="form-control report" type="text" name="update-studCourse" required>
                    <option disabled="true">Course</option>
                    @if(!empty($course))
                      @foreach($course as $index=>$data)
                      <option value="{{$data->id}}">{{$data->name}}</option>
                      @endforeach
                    @endif
                    <option>Add</option>
                  </select>
                </div>
              </div>
              <div class="form-group{{ $errors->has('update-studYear') ? ' has-error' : '' }}">       
                <label class="control-label col-md-3">Year</label>         
                <div class="col-md-8">
                  <select class="form-control report" type="text" name="update-studYear" required>
                    <option value="1">1st Year</option>
                    <option value="2">2nd Year</option>
                    <option value="3">3rd Year</option>
                    <option value="4">4th Year</option>
                  </select>
                </div>
              </div>
              <div class="form-group{{ $errors->has('update-studGender') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Gender</label>
                <div class="col-md-9">
                  <div class="radio-inline">
                    <label>
                      <input type="radio" name="update-studGender" id="update-studGender" value="M" required>Male
                    </label>
                  </div>
                  <div class="radio-inline">
                    <label>
                      <input type="radio" name="update-studGender" id="update-studGender" value="F" required>Female
                    </label>
                  </div>
                </div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
          <div class="card-footer">
            <div class="row">
              <div class="col-md-8 col-md-offset-3">
                <button class="btn btn-primary icon-btn" type="submit"><i class="fa fa-fw fa-lg fa-plus"></i>Update</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-default icon-btn"  class="close" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
              </div>
            </div>
          </div>
      </div>
    </form>
    </div>
  </div>
</div> 
<!-- Delete Item Modal -->

<div id="delete_student" class="modal fade delete_student">
  <div class="modal-dialog">
    <div class="modal-content">      
      <form class="form-horizontal" id="delete-student-form" role="form">    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Delete Student</h3>
      </div>
      <div class="modal-body">
          <div class="card-body">
              {{ csrf_field() }}

              <div class="form-group{{ $errors->has('studNum') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Student No.</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter Student Number" id="studNum" name="studNum" value="{{ old('studNum') }}" required autofocus>
                </div>
              </div>
        
          </div>
      </div>
      <div class="modal-footer">
          <div class="card-footer">
            <div class="row">
              <div class="col-md-8 col-md-offset-3">
                <button class="btn btn-primary icon-btn" type="submit"><i class="fa fa-fw fa-lg fa-plus"></i>Delete</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-default icon-btn"  class="close" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
              </div>
            </div>
          </div>
      </div>
    </form>
    </div>
  </div>
</div> 

<!-- Course Modal -->
<div id="course_modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">      
      <form id="add-course-form" class="form-horizontal" role="form">    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Add Course</h3>
      </div>
      <div class="modal-body">
          <div class="card-body">
              {{ csrf_field() }}

              <div class="form-group{{ $errors->has('courseDescription') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Description</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter course description" id="course" name="courseDescription" value="{{ old('courseDescription') }}" required autofocus>
                </div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
          <div class="card-footer">
            <div class="row">
              <div class="col-md-8 col-md-offset-3">
                <button class="btn btn-primary icon-btn" type="submit"><i class="fa fa-fw fa-lg fa-plus"></i>Add</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-default icon-btn"  class="close" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
              </div>
            </div>
          </div>
      </div>
    </form>
    </div>
  </div>
</div> 

@endsection
@section('js')
<script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/plugins/DataTable_Button/js/select.dataTable.min.js') }}"></script>
<script>
$(document).ready(function(){
  var table = $('#sampleTable').DataTable({
    "ajax": "/studentlist",
    select: true,
    select: {
        style: 'mobile',
        selector: 'tr'
    },
    "columnDefs": [
        {
            "targets": [ 0 ],
            "visible": false,
            "searchable": false
        },
        // {
        //   "targets": [ 4 ],
        //   createdCell: function(td, cellData, rowData, row, col){
        //     var a = $(td).find(">:first-child");
        //     var delete_button = $(a.children()[1]);
        //     delete_button.attr('id', 'delete-button');
        //     // a.attr("data-id", rowData[0]);
        //     // a.attr("data-target", '.purchase-modal');
        //     // a.attr("data-toggle", 'modal');
        //     // a.attr("type", 'submit');
        //     $('#delete-button').click(function(){
        //       alert('dsadsadsa');
        //     });
        //   },
        //   render: function ( data, type, row, meta ) {
        //     return data;
        //   }
        // }
    ],
    // createdRow: function( row, data, dataIndex ) {
    //     $( row ).attr("data-id", data[0]);
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
    var ids = $.map(table.rows('.selected').data(), function (data) {
                  return data[0]
              });    

    var data = $('#update-student-form').serializeArray();
    data.push({name: 'student_id', value: ids});

    swal({
      title: "Are you sure?",
      text: "The student will be deleted in the database!",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel it!",
      closeOnConfirm: true,
      closeOnCancel: false
    }, function(isConfirm) {
      if (isConfirm) {        
        $.ajax({
            url: '/student/delete',
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function(data){
              table.rows('.selected').remove().draw(false);  
              swal({
                title:"Deleted!", 
                text:"Student record has been deleted.", 
                type:"success"
              }); 
            }
          })   
      } else {
        swal({
          title:"Cancelled!", 
          text:"Student records are safe :)", 
          type:"error"
        });
      }
    });
  })

  $('#add-student-form').submit(function(e){
    e.preventDefault();
    $.ajax({
          type: "POST",
          url: "/student/add",
          data: $(this).serialize(),
          success: function(data){   
            table.ajax.url('/studentlist').load();
            swal({
            title:"Added!", 
            text:"Student has been added to the database.", 
            type:"success"},
            function(){
                $('#add_student').modal("hide");
            });
          },  
          error: function(e) {
            console.log("----------" + e);
          }
    });
  });

$('#update-student-form').submit(function(e){
    e.preventDefault();
    console.log($(this).serialize());

    $.ajax({
          type: "POST",
          url: "/student/update",
          data: $(this).serialize(),
          success: function(data){   
            console.log(data);
            table.ajax.reload();
            swal({
              title:"Updated!", 
              text:"Student has been updated to the database.", 
              type:"success"
            });
          },  
          error: function(e) {
            console.log("----------" + e);
          }
    });
  });

$('#delete-student-form').submit(function(e){
    e.preventDefault();
    $.ajax({
          type: "POST",
          url: "/students/delete",
          data: $(this).serialize(),
          success: function(data){   
            console.log(data);
            swal({
            title:"Deleted!", 
            text:"Student has been deleted to the database.", 
            type:"success"},
            function(){
                $('#delete_student').modal("hide");
                $('#dynamic').load("/student");
            });
          },  
          error: function(e) {
            console.log("----------" + e);
          }
    });
  });

  $('#add-course-form').submit(function(e){
    e.preventDefault();
    
    $.ajax({
          type: "POST",
          url: "/course/add",
          data: $(this).serialize(),
          dataType: 'json',
          success: function(data){
            console.log(data.name);
            if(data)
            $('<option>')
                .text(data.name)
                .attr('value', data.id)
                .insertBefore($('option[value="add"]', $('select[name="studCourse"]')));

            swal({
            title:"Added!", 
            text:"Course has been added to the database.", 
            type:"success"},
            function(){
                $('#course_modal').modal("hide");
            });
          },  
          error: function(e) {
            console.log("----------" + e);
          }
    });
  });

  $('select[name="studCourse"]').change(function(){
    if ($(this).val() == 'add'){      
        $('#course_modal').modal('show');
        $(this).val('');
    }
  });

  $('.update_student').on('shown.bs.modal', function(e){
    var id = table.rows('.selected').data()[0][0];
    var url = "/student/"+id;

    $.getJSON(url, function(data){
      $('input[name="student_id"]').val(data[0].id);
      $('input[name="update-studNum"]').val(data[0].student_number);
      $('input[name="update-studName"]').val(data[0].name);
      $('input[name="update-studGender"][value="'+data[0].gender+'"]').prop('checked', true);
      $('select[name="update-studCourse"]').val(data[0].course_id);
      $('select[name="update-studYear"]').val(data[0].year);
    });
  })

  $('.update_student').on('hidden.bs.modal', function(e){
      $('#update-student-form')[0].reset();
  })

  $('input[name="file"]').change(function(){
    $('#upload').submit();
  });

  $('#upload').submit(function(e){
    e.preventDefault();
    $('#upload_icon').attr('class', 'fa fa-spinner fa-spin');
    $.ajax({   
        url:'/student/upload',  
        method:'POST',  
        data:new FormData(this),  
        contentType: false,  
        cache: false,  
        processData:false,  
        success:function(data){  
          table.ajax.url('/studentlist').load();
          $('#upload_icon').attr('class', 'fa fa-upload');
        },
        error: function(){
          $('#upload_icon').attr('class', 'fa fa-upload');
        }
    });  
  });

  $('input[type="file"]').change(function(){
    $('#upload').submit();
  });

});
</script>
@endsection