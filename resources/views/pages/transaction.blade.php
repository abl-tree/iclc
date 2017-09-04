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
    <div class="page-title">
      <div>
        <h1><i class="fa fa-edit"></i> Transaction</h1>
        <p>Student</p>
      </div>
      <div>
        <ul class="breadcrumb">
          <li><a href="{{ route('home')}}"><i class="fa fa-home fa-lg"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="row">
      <form class="form-horizontal" id="student-info" role="form">
        <!-- {{ csrf_field() }} -->
        <div class="col-md-6">
          <div class="card">
            <h3 class="card-title">Student Info</h3>
            <div class="card-body">  
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
                <div class="form-group{{ $errors->has('semester') ? ' has-error' : '' }}">       
                  <label class="control-label col-md-3">Semester</label>         
                  <div class="col-md-8">
                    <select class="form-control report" type="text" name="semester" disabled="true" required>
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
                <div class="clearfix"></div>               
                <div class="form-group{{ $errors->has('studentID') ? ' has-error' : '' }}">
                  <label class="control-label col-md-3">Student ID</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" step="any" placeholder="Enter student ID" name="studentID" value="{{ old('studentID') }}" disabled="true" required>
                    <input class="form-control" type="hidden" step="any" name="student-id">
                  </div>
                </div>
                <div class="form-group{{ $errors->has('studentName') ? ' has-error' : '' }}">
                  <label class="control-label col-md-3">Student Name</label>
                  <div class="col-md-8">
                    <input class="form-control" type="text" step="any" placeholder="Student name" name="studentName" value="{{ old('studentName') }}" required readonly>
                  </div>
                </div>
            </div>          
            <div class="card-footer">
              <div class="row">
                <div class="col-md-8 col-md-offset-4">
                  <button id="submitBttn" class="btn btn-primary icon-btn" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Generate</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
      <form class="form-horizontal" id="payment-info" role="form">
      {{ csrf_field() }}
      <div class="col-md-6">
        <div class="card">
          <h3 class="card-title">Payment</h3>
          <div class="card-body">
              <div class="form-group">
                <label class="control-label col-md-3">Total</label>
                <div id="totalbalance" class="col-md-8">
                  <input id="total-amount" name="total-amount" class="form-control" type="text" readonly placeholder="Total payment" value="" required>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Cash</label>
                <div class="col-md-8">
                  <input id="cash-amount" name="cash-amount" type="number" autocomplete="off" class="form-control col-md-8" type="text" placeholder="Enter Amount" required>
                </div>
              </div>
              <div id="changeDIV" class="form-group">
                <label id="changelabel" class="control-label col-md-3">Change</label>
                <div class="col-md-8">
                  <input id="cash-change" name="cash-change" type="text" class="form-control col-md-8" type="text" readonly placeholder="Change" required>
                </div>
              </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-md-8 col-md-offset-4">
                <button id="submitBttn" class="btn btn-primary icon-btn" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      </form>
      <div class="clearfix"></div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-hover table-bordered" id="payment-history" style="width: 100%">
                  <thead>
                    <tr>
                      <th>OR #</th>
                      <th>Date</th>
                      <th>Academic Year</th>
                      <th>Semester</th>
                      <th>Total Payment</th>
                      <th>Cashier</th>
                      <th>Options</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>OR #</th>
                      <th>Date</th>
                      <th>Academic Year</th>
                      <th>Semester</th>
                      <th>Total Payment</th>
                      <th>Cashier</th>
                      <th>Options</th>
                    </tr>
                  </tfoot>
            </table>
          </div>
        </div>
      </div>
          
      <div id="email_modal" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">      
            <form id="sendForm" class="form-horizontal" role="form">    
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h3 class="modal-title">Email</h3>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('itemName') ? ' has-error' : '' }}">
                      <label class="control-label col-md-3">Email Address</label>
                      <div class="col-md-8">
                        <input class="form-control" type="email" placeholder="Enter email address" id="email" name="email" value="{{ old('email') }}" required autofocus>
                      </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="card-footer">
                  <div class="row">
                    <div class="col-md-8 col-md-offset-3">
                      <button id="sendBttn" class="btn btn-primary icon-btn" type="submit"><i class="fa fa-fw fa-lg fa-send"></i>Send</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-default icon-btn"  class="close" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
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

    </div>
  </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-notify.min.js') }}"></script>
<script>
  $(document).ready(function(){
    var stud_info = '';

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
      }else{
          $('select[name="semester"]').removeAttr('disabled');
      }
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
      }else{
          $('input[name="studentID"]').removeAttr('disabled');
      }
    });

    $('input[name="studentID"]').on('input', function(){
      $('input[name="studentName"]').val('Retrieving...');
      $.ajax({
        url: '/student/search',
        method: 'GET',
        dataType: 'json',
        data: {id: $(this).val()},
        success: function(data){
          if(data.status === 'exists'){
            $('input[name="studentName"]').val(data.info['first_name']+" "+data.info['last_name']);
            $('input[name="student-id"]').val(data.info['id']);
          }else if(data.status === 'not exists'){
            $('input[name="studentName"]').val("ID does not exist");
            $('input[name="student-id"]').val('');
          }else{
            $('input[name="studentName"]').val("");
            $('input[name="student-id"]').val('');
          }
        }
      });
    });

    $('#student-info').submit(function(e){
      e.preventDefault();
      stud_info = $(this).serialize();

      $.ajax({
        type: 'GET',
        dataType: 'json',
        data: $(this).serialize(),
        url: '/transaction/payment',
        success: function(data){
          $('input[name="total-amount"]').val(data.item - data.payment);
        },
        error: function(){
          $('input[name="total-amount"]').val('');
        }
      });
    });

    $('input[name="cash-amount"]').on('input', function(){
      var amount = $(this).val();
      var fee = $('input[name="total-amount"]').val();
      var change = amount - fee;

      if(amount)
        $('input[name="cash-change"]').val(change);

      if(!$(this).val()){
        $('input[name="cash-change"]').val(0);
      }

    });

    $('#payment-info').submit(function(e){
      e.preventDefault();
      var total = parseFloat($('input[name="total-amount"]').val());
      var cash = parseFloat($('input[name="cash-amount"]').val());
      var payment_details = $(this).serialize()+'&'+stud_info;

      if($('input[name="student-id"]').val() && total <= cash){
        $.ajax({
          url: 'transaction/confirm',
          method: 'post',
          data: payment_details,
          dataType: 'json',
          success: function(data){
            console.log(data);
            $.notify({
                title: "Transaction Complete : ",
                message: "Transaction is added!",
                icon: 'fa fa-check' 
              },{
                type: "success"
              });
          }
        });
      }else if($('input[name="student-id"]').val() && total > cash){
        $.notify({
            title: "Error : ",
            message: "Not enough cash amount.",
            icon: 'fa fa-check' 
          },{
            type: "warning"
          });
      }else{
        $.notify({
            title: "Error : ",
            message: "Add student info!",
            icon: 'fa fa-check' 
          },{
            type: "warning"
          });
      }
    });

    $('#payment-history').DataTable();

  });
</script>
@endsection