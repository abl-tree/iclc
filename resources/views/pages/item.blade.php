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
        <h1>Item Records</h1>
        <ul class="breadcrumb side">
          <li><i class="fa fa-home fa-lg"></i></li>
          <li>Records</li>
          <li class="active"><a href="#">Items</a></li>
        </ul>
      </div>
      <div><a class="btn btn-primary btn-flat" id="add-item"><i class="fa fa-lg fa-plus"></i> Add Item</a></div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-hover table-bordered" id="itemTable" style="width: 100%;">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Options</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Options</th>
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

<div id="add_item" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">      
      <form class="form-horizontal" id="add-item-form" role="form">    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Add Item</h3>
      </div>
      <div class="modal-body">
          <div class="card-body">
              {{ csrf_field() }}

              <div class="form-group{{ $errors->has('itemName') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Name</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter item name" id="itemName" name="itemName" value="{{ old('itemName') }}" required autofocus>
                </div>
              </div>
              <div class="form-group{{ $errors->has('department') ? ' has-error' : '' }}">       
                <label class="control-label col-md-3">Department</label>         
                <div class="col-md-8">
                  <select class="form-control report" type="text" name="department" required>
                    <option value="" disabled="true" selected>Select option</option>
                    @if(!empty($department))
                      @foreach($department as $index=>$data)
                      <option value="{{$data->id}}">{{$data->description}}</option>
                      @endforeach
                    @endif
                    <option value="add">Add</option>
                  </select>
                </div>
              </div>
              <div class="form-group{{ $errors->has('semester') ? ' has-error' : '' }}">       
                <label class="control-label col-md-3">Semester</label>         
                <div class="col-md-8">
                  <select class="form-control report" type="text" name="semester" required>
                    <option value="" disabled="true" selected>Select option</option>
                    @if(!empty($semester))
                      @foreach($semester as $index=>$data)
                      <option value="{{$data->id}}">{{$data->description}}</option>
                      @endforeach
                    @endif
                    <option value="add">Add</option>
                  </select>
                </div>
              </div>   
              <div class="form-group{{ $errors->has('academicYear') ? ' has-error' : '' }}">       
                <label class="control-label col-md-3">Academic Year</label>         
                <div class="col-md-8">
                  <select class="form-control report" type="text" name="academicYear" required>
                    <option value="" disabled="true" selected>Select option</option>
                    @if(!empty($acadyear))
                      @foreach($acadyear as $index=>$data)
                      <option value="{{$data->id}}">{{$data->description}}</option>
                      @endforeach
                    @endif
                    <option value="add">Add</option>
                  </select>
                </div>
              </div>   
              <div class="form-group{{ $errors->has('itemAmount') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Amount</label>
                <div class="col-md-8">
                  <input class="form-control" type="number" step="any" placeholder="Enter item price" id="itemAmount" name="itemAmount" value="{{ old('itemAmount') }}" required>
                </div>
              </div>
              <div class="form-group{{ $errors->has('itemStatus') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Status</label>
                <div class="col-md-9">
                  <div class="radio-inline">
                    <label>
                      <input type="radio" name="itemStatus" id="itemStatus" value="1" required>Optional
                    </label>
                  </div>
                  <div class="radio-inline">
                    <label>
                      <input type="radio" name="itemStatus" id="itemStatus" value="2" required>Mandatory
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

<div id="update_item" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" id="update-item-form" role="form">      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Update Item</h3>
      </div>
      <div class="modal-body">
          <div class="card-body">
              {{ csrf_field() }}

              
              <div class="form-group{{ $errors->has('itemName') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Name</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter item name" id="itemName" name="itemName" value="{{ old('itemName') }}" required autofocus>
                </div>
              </div>
              <div class="form-group{{ $errors->has('itemPrice') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Price</label>
                <div class="col-md-8">
                  <input class="form-control" type="number" step="any" placeholder="Enter item price" id="itemPrice" name="itemPrice" value="{{ old('itemPrice') }}" required>
                </div>
              </div>
              <div class="form-group{{ $errors->has('itemStatus') ? ' has-error' : '' }}" >
                <label class="control-label col-md-3">Status</label>
                <div class="col-md-9">
                  <div class="radio-inline">
                    <label>
                      <input type="radio" name="itemStatus" id="itemStatus" value="Optional"  required>Optional
                    </label>
                  </div>
                  <div class="radio-inline">
                    <label>
                      <input type="radio" name="itemStatus" id="itemStatus" value="Mandatory" required>Mandatory
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
                <button class="btn btn-primary icon-btn" type="submit"><i class="fa fa-fw fa-lg fa-refresh"></i>Update</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-default icon-btn"  class="close" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
              </div>
            </div>
          </div>
      </div>
      </form>
    </div>
  </div>
</div> 

<!-- Delete Item Modal -->

<div id="delete_item" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" id="delete-item-form" role="form">      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Delete Item</h3>
      </div>
      <div class="modal-body">
          <div class="card-body">
              {{ csrf_field() }}

              
              <div class="form-group{{ $errors->has('itemName') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Name</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter item name" id="itemName" name="itemName" value="{{ old('itemName') }}" required autofocus>
                </div>
              </div>
              
              
          </div>
      </div>
      <div class="modal-footer">
          <div class="card-footer">
            <div class="row">
              <div class="col-md-8 col-md-offset-3">
                <button class="btn btn-primary icon-btn" type="submit"><i class="fa fa-fw fa-lg fa-refresh"></i>Delete</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-default icon-btn"  class="close" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
              </div>
            </div>
          </div>
      </div>
      </form>
    </div>
  </div>
</div> 

<!-- Semester Modal -->
<div id="semester_modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">      
      <form id="add-semester-form" class="form-horizontal" role="form">    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Add Semester</h3>
      </div>
      <div class="modal-body">
          <div class="card-body">
              {{ csrf_field() }}

              <div class="form-group{{ $errors->has('semesterDescription') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Description</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter semester description" id="course" name="semesterDescription" value="{{ old('semesterDescription') }}" required autofocus>
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

<!-- Department Modal -->
<div id="department_modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">      
      <form id="add-department-form" class="form-horizontal" role="form">    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Add Department</h3>
      </div>
      <div class="modal-body">
          <div class="card-body">
              {{ csrf_field() }}

              <div class="form-group{{ $errors->has('departmentDescription') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Description</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter department description" id="course" name="departmentDescription" value="{{ old('departmentDescription') }}" required autofocus>
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

<!-- Academic Year Modal -->
<div id="acadyear_modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">      
      <form id="add-acadyear-form" class="form-horizontal" role="form">    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Add Academic Year</h3>
      </div>
      <div class="modal-body">
          <div class="card-body">
              {{ csrf_field() }}

              <div class="form-group{{ $errors->has('acadyearDescription') ? ' has-error' : '' }}">
                <label class="control-label col-md-3">Description</label>
                <div class="col-md-8">
                  <input class="form-control" type="text" placeholder="Enter academic year description" id="course" name="acadyearDescription" value="{{ old('acadyearDescription') }}" required autofocus>
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
$(document).ready(function(){
  var table = $('#itemTable').DataTable({
              'ajax': '/itemlist'
            });

  $('#add-item').click(function(){    
    $('#add_item').modal("show");
  });

  $('#add-semester-form').submit(function(e){
    e.preventDefault();
    
    $.ajax({
          type: "POST",
          url: "/semester/add",
          data: $(this).serialize(),
          dataType: 'json',
          success: function(data){
            console.log(data.name);
            if(data)
            $('<option>')
                .text(data.name)
                .attr('value', data.id)
                .insertBefore($('option[value="add"]', $('select[name="semester"]')));

            swal({
            title:"Added!", 
            text:"Course has been added to the database.", 
            type:"success"},
            function(){
                $('#semester_modal').modal("hide");
            });
          },  
          error: function(e) {
            console.log("----------" + e);
          }
    });
  });

  $('select[name="semester"]').change(function(){
    if ($(this).val() == 'add'){      
        $('#semester_modal').modal('show');
        $(this).val('');
    }
  });

  $('#add-department-form').submit(function(e){
    e.preventDefault();
    
    $.ajax({
          type: "POST",
          url: "/department/add",
          data: $(this).serialize(),
          dataType: 'json',
          success: function(data){
            console.log(data.name);
            if(data)
            $('<option>')
                .text(data.name)
                .attr('value', data.id)
                .insertBefore($('option[value="add"]', $('select[name="department"]')));

            swal({
            title:"Added!", 
            text:"Course has been added to the database.", 
            type:"success"},
            function(){
                $('#department_modal').modal("hide");
            });
          },  
          error: function(e) {
            console.log("----------" + e);
          }
    });
  });

  $('select[name="department"]').change(function(){
    if ($(this).val() == 'add'){      
        $('#department_modal').modal('show');
        $(this).val('');
    }
  });
  
  $('#add-acadyear-form').submit(function(e){
    e.preventDefault();
    
    $.ajax({
          type: "POST",
          url: "/semester/acadyear",
          data: $(this).serialize(),
          dataType: 'json',
          success: function(data){
            console.log(data.name);
            if(data)
            $('<option>')
                .text(data.name)
                .attr('value', data.id)
                .insertBefore($('option[value="add"]', $('select[name="academicYear"]')));

            swal({
            title:"Added!", 
            text:"Course has been added to the database.", 
            type:"success"},
            function(){
                $('#acadyear_modal').modal("hide");
            });
          },  
          error: function(e) {
            console.log("----------" + e);
          }
    });
  });

  $('select[name="academicYear"]').change(function(){
    if ($(this).val() == 'add'){      
        $('#acadyear_modal').modal('show');
        $(this).val('');
    }
  });

  // $('#add_item').on('hidden.bs.modal', function(e){
  //   alert('closed');
  // });

  $('#delete-item-form').submit(function(e){
    swal({
      title: "Are you sure?",
      text: "The item will be deleted in the database!",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel it!",
      closeOnConfirm: false,
      closeOnCancel: false
    }, function(isConfirm) {
      if (isConfirm) {
        $.ajax({
              type: "POST",
              url: "/items/delete",
              data: $("#delete-item-form").serialize(),
              success: function(data){   
                console.log(data);           
                swal({
                  title:"Deleted!", 
                  text:"Item has been updated.", 
                  type:"success"},
                  function(){
                      $('#delete_item').modal("hide");
                      $('#dynamic').load("/items");
                });
              },  
              error: function(e) {
                console.log("----------" + e);
              }
        });
      
      } else {
        swal({
          title:"Cancelled!", 
          text:"Item is safe :)", 
          type:"error"},
          function(){
              $('#delete_item').modal("hide");
          });
      }
    });
  });

  $('#update-item-form').submit(function(e){

    e.preventDefault();

    swal({
      title: "Are you sure?",
      text: "The item will be updated in the database!",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, update it!",
      cancelButtonText: "No, cancel it!",
      closeOnConfirm: false,
      closeOnCancel: false
    }, function(isConfirm) {
      if (isConfirm) {        
        $.ajax({
          type: "POST",
          url: "/items/update",
          data: $("#update-item-form").serialize(),
          success: function(data){   
            console.log(data);           
            swal({
              title:"Updated!", 
              text:"Item has been updated.", 
              type:"success"},
              function(){
                  $('#update_item').modal("hide");
                  $('#dynamic').load("/items");
            });
          },  
          error: function(e) {
            console.log("----------" + e);
          }
        });
      } else {
        swal({
          title:"Cancelled!", 
          text:"No changes are made :)", 
          type:"error"},
          function(){
              $('#update_item').modal("hide");
          });
      }
    });
  });

  $('#add-item-form').submit(function(e){

    e.preventDefault();

    $.ajax({
      type: "POST",
      url: "/item/add",
      data: $(this).serialize(),
      dataType: 'json',
      success: function(data){   
        console.log(data);
        table.row.add( [
          data.name,
          data.amount,
          data.status,
          '<div class="btn-group"><button type="submit" class="btn btn-info" id="update-item-button" data-id="'+data.id+'">'+
          '<i class="fa fa-lg fa-edit"></i></button><button type="submit" class="btn btn-warning" id="delete-item-button" data-id="'+data.id+'">'+
          '<i class="fa fa-lg fa-trash"></i></button></div>'
        ] ).draw(true);

        swal({
        title:"Added!", 
        text:"Item has been added to the database.", 
        type:"success"},
        function(){
            $('#add_item').modal("hide");
        });
      },  
      error: function(e) {
        console.log("----------" + e);
      }
    });
  });
  
});

</script>
@endsection