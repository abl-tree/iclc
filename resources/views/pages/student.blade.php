@extends('layouts.common')

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
          <li>Records</li>
          <li class="active"><a href="#">Student</a></li>
        </ul>
      </div>
      <div><a class="btn btn-primary btn-flat" id="add-student-button"><i class="fa fa-lg fa-plus"></i> Add student</a></div>
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
                    <th>Year</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th style="display: none;">ID</th>
                    <th>ID #</th>
                    <th>Name</th>
                    <th>Year</th>
                    <th>Option</th>
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
                <div class="col-md-3">
                  <input class="form-control" type="text" placeholder="Firstname" id="first_name" name="firstName" value="{{ old('firstName') }}" required>
                </div>
                <div class="col-md-3">
                  <input class="form-control" type="text" placeholder="Middlename" id="middle_name" name="middleName" value="{{ old('middleName') }}" required>
                </div>
                <div class="col-md-3">
                  <input class="form-control" type="text" placeholder="Lastname" id="last_name" name="lastName" value="{{ old('lastName') }}" required>
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


<!-- Update Item Modal -->

<div id="update_student" class="modal fade">
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

              <div class="form-group{{ $errors->has('studNum') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Student No.</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter Student Number" id="studNum" name="studNum" value="{{ old('studNum') }}" required autofocus>
                </div>
              </div>
              <div class="form-group{{ $errors->has('studName') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Name</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter Student Name" id="studName" name="studName" value="{{ old('studName') }}" required>
                </div>
              </div>
              <div class="form-group{{ $errors->has('studCourse') ? ' has-error' : '' }}">       
                <label class="control-label col-md-3">Course</label>         
                <div class="col-md-8">
                  <select class="form-control report" type="text" name="studCourse" required>
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
              <div class="form-group{{ $errors->has('studYear') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Year</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter Student Year" id="studYear" name="studYear" value="{{ old('studYear') }}" required>
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

<div id="delete_student" class="modal fade">
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
<script type="text/javascript">
</script>
<script>
$(document).ready(function(){
  $('#sampleTable').DataTable({
    "ajax": "/studentlist",    
    "columnDefs": [
        {
            "targets": [ 0 ],
            "visible": false,
            "searchable": false
        }
    ],
    // createdRow: function( row, data, dataIndex ) {
    //     $( row ).attr("onclick", "window.location.href = 'student/transaction/"+data[0]+"'");
    // }
  });

  $('#add-student-form').submit(function(e){
    e.preventDefault();
    $.ajax({
          type: "POST",
          url: "/student/add",
          data: $(this).serialize(),
          success: function(data){   
            console.log(data);
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
    $.ajax({
          type: "POST",
          url: "/students/update",
          data: $(this).serialize(),
          success: function(data){   
            console.log(data);
            swal({
            title:"Updated!", 
            text:"Student has been updated to the database.", 
            type:"success"},
            function(){
                $('#update_student').modal("hide");
                $('#dynamic').load("/student");
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

  // $('#course_modal').on('hidden.bs.modal', function(e){
  //   // $('select[name="studCourse"]').val('');
  // })

  // --Begin-- Students' Modal Functions
    $('#add-student-button').click(function(){
      $('#add_student').modal("show");
    });

    $('#update-student-button').click(function(){
      $('#update_student').modal("show");
    });

    $('#delete-student-button').click(function(){
      $('#delete_student').modal("show");
    });
  // --End-- Students' Modal Functions

});
</script>
@endsection