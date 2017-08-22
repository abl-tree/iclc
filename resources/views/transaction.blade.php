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
          @if(!empty($students))
            <li><a href="{{ route('students')}}">Student</a></li>
            <li><a href="#">Transaction</a></li>
          @endif
        </ul>
      </div>
    </div>
    <div class="row">
      <form class="form-horizontal" id="print-email" role="form">
      {{ csrf_field() }}
      <div class="col-md-6">
        <div class="card">
          <h3 class="card-title">Student Info</h3>
          <div class="card-body">  
              <div class="form-group">       
                <label class="control-label">Academic Year</label>         
                <select class="form-control report" type="text" name="academicYear" required>
                  <option disabled="true">Academic Year</option>
                  @if(!empty($acadyears))
                    @foreach($acadyears as $index=>$acadyear)
                    <option value="{{$acadyear->academic_year}}">{{$acadyear->academic_year}}</option>
                    @endforeach
                  @endif
                  <option>Add</option>
                  <option>Add</option>
                </select>
              </div>    
              <div class="clearfix"></div>
              <div class="form-group">
                <label class="control-label">Student ID</label>
                <input id="student_no" name="student_id" autocomplete="off" class="form-control" type="text" "@if(!empty($students)) disabled @else placeholder='Enter student ID' @endif" value="@if(!empty($students))@foreach($students as $student){{$student->Student_No}}@endforeach"+"@endif" required autofocus>
              </div>
              <div id="stud_name" class="form-group">
                <label class="control-label">Name</label>
                <input id="student_name" name="student_name" class="form-control" type="text" disabled placeholder='Student name' value="@if(!empty($students) && $students != '')@foreach($students as $student){{$student->Student_Name}}@endforeach"+"@endif" required>
              </div>
              
              <div class="form-group">
                <label class="control-label">Semester &nbsp;&nbsp;&nbsp;&nbsp;</label>
                <div class="radio-inline">
                  <label>
                    <input type="radio" checked="checked" name="semester" value="1" required>1st
                  </label>
                </div>
                <div class="radio-inline">
                  <label>
                    <input type="radio" name="semester" value="2" required>2nd
                  </label>
                </div>
              </div>  

              <div class="form-group" id="optionals">
                <label class="control-label">Optional Items:</label>
                @if(!empty($optionals))
                  @foreach($optionals as $index=>$optional)
                    <div class="animated-checkbox">
                      <label>
                        &nbsp;&nbsp;&nbsp;&nbsp;<input id="checkbox" type="checkbox" data-price="{{$optional->price}}" name="optional[{{$index}}]" value="{{$optional->name}} - {{$optional->price}}" ><span class="label-text">{{$optional->name}} - {{$optional->price}}</span>
                      </label>
                    </div>
                  @endforeach
                @else
                  <div class="animated-checkbox">
                    <label>
                      &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" disabled=""><span class="label-text">No items available</span>
                    </label>
                  </div>
                @endif  
              </div>  
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card">
          <h3 class="card-title">Payment</h3>
          <div class="card-body">
              <div class="form-group">
                <label class="control-label col-md-3">Total</label>
                <div id="totalbalance" class="col-md-8">
                  <input id="cashbalance" name="cashbalance" class="form-control" type="text" disabled placeholder="Total payment" value="@if($payments >= 0){{$payments}}@endif">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Cash</label>
                <div class="col-md-8">
                  <input id="cashamount" name="cashamount" type="number" autocomplete="off" class="form-control col-md-8" type="text" placeholder="Enter Amount" required>
                </div>
              </div>
              <div id="changeDIV" class="form-group">
                <label id="changelabel" class="control-label col-md-3">Change</label>
                <div class="col-md-8">
                  <input id="cashchange" name="cashchange" type="text" class="form-control col-md-8" type="text" disabled placeholder="Change">
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
            <table class="table table-hover table-bordered">
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
                  <tbody id="payment_history">
                  @if(!empty($histories))
                    @foreach($histories as $history)
                      <tr>                        
                        <td> {{$history->or_no}} </td>
                        <td> {{$history->created_at}} </td>
                        <td> {{$history->academic_year}} </td>
                        <td> {{$history->semester}} </td>
                        <td> {{$history->total}} </td>
                        <td> {{$history->cashier}} </td>
                        <td> <div class="btn-group"><a class="btn btn-primary" href="{{ route('receipt', ['mandatory', $history->or_no, $history->academic_year, $history->semester]) }}"><i class="fa fa-print"></i></a><a class="btn btn-info" onclick="send('mandatory', {{$history->or_no}})"><i class="fa fa-paper-plane-o"></i></a></div> </td>
                      </tr>
                    @endforeach              
                  @endif 

                  @if(!empty($optionalHistories))
                    @foreach($optionalHistories as $history)
                      <tr>                        
                        <td> OPT{{$history->or_no}} </td>
                        <td> {{$history->created_at}} </td>
                        <td> {{$history->academic_year}} </td>
                        <td> {{$history->semester}} </td>
                        <td> {{$history->total}} </td>
                        <td> {{$history->cashier}} </td>
                        <td> <div class="btn-group"><a class="btn btn-primary" href="{{ route('receipt', ['optional', $history->or_no, $history->academic_year, $history->semester]) }}"><i class="fa fa-print"></i></a><a class="btn btn-info" onclick="send('optional', {{$history->or_no}})"><i class="fa fa-paper-plane-o"></i></a></div> </td>
                      </tr>
                    @endforeach    
                  @endif
                  </tbody>
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

      <div id="acad_year_modal" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">      
            <form id="acadyear" class="form-horizontal" role="form">    
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h3 class="modal-title">Academic Year</h3>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('itemName') ? ' has-error' : '' }}">
                      <label class="control-label col-md-3">Academic Year</label>
                      <div class="col-md-8">
                        <input class="form-control" type="text" placeholder="Enter academic year" id="acad_year" name="acad_year" value="{{ old('acad_year') }}" required autofocus>
                      </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="card-footer">
                  <div class="row">
                    <div class="col-md-8 col-md-offset-3">
                      <button class="btn btn-primary icon-btn" type="submit"><i class="fa fa-fw fa-lg fa-send"></i>Send</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-default icon-btn"  class="close" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
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
<script type="text/javascript">$('#sampleTable').DataTable();</script>
<script>
var currentBal = parseFloat($("#cashbalance").val());
var payment_switch = 0;
var or_no = 0;
var options = "";

$(document).ready(function(){
if($("#cashamount").val().length == 0){
    $("#submitBttn").prop("disabled", true);
}

$("#cashamount").on("input", function(){
  if($("#cashbalance").val() == 0 || $("#cashamount").val() == 0 || $("#cashamount").val().length == 0){
    $("#submitBttn").prop("disabled", true);
  }else{        
    $("#submitBttn").prop("disabled", false);
  }
});

$("select[name='academicYear']").change(function(){
  if(this.value == "Add"){
    $("#acad_year_modal").modal("show");
  }else{    
        var stud_id = $("input[name='student_id']").val();
        var semester = $('input[type=radio][name=semester]:checked').val();
        var acad_year = this.value;

        $("#submitBttn").loadingBtn({text : "Retrieving"});

        filter(stud_id, semester, acad_year);
  }
});

$("#student_no").on("input", function(){
  var stud_id = $(this).val().replace(' ', '');
  var semester = $('input[type=radio][name=semester]:checked').val();
  var acad_year = $("select[name='academicYear'] option:selected").text();
  $("#submitBttn").loadingBtn({text : "Retrieving"});
  filter(stud_id, semester, acad_year);
});

$('input[type=radio][name=semester]').change(function() {
    var stud_id = $("input[name='student_id']").val();
    var semester = this.value;
    var acad_year = $("select[name='academicYear'] option:selected").text();

    $("#submitBttn").loadingBtn({text : "Retrieving"});

    filter(stud_id, semester, acad_year);
});

function filter(stud_id, semester, acad_year){
  $.ajax({
    type: "GET",
    url: "/temp/"+semester+"/"+acad_year+"/"+stud_id,
    success: function(data){       
      if($(data).find("#student_name").val() != ""){
        if($(data).find("#payment_history>tr").text() != "")
        $("tbody#payment_history").load(this.url + " tbody#payment_history>tr", function(){
          $("tbody#payment_history").fadeIn();
        });
        else $("#payment_history").html('<tr class="odd"><td class="dataTables_empty" valign="top" colspan="6">No matching records found</td></tr>');


        $('#submitBttn').loadingBtnComplete({ html : '<i class="fa fa-fw fa-lg fa-check-circle"></i>Submit'});
        //$("#optionals").load(this.url + " #optionals>*")
        $("#student_name").val($(data).find("#student_name").val());
        $("#cashbalance").val($(data).find("#cashbalance").val());
        $("#cashchange").val($(data).find("#cashchange").val());
        $("#cashchange").val("");
        $("#cashchange").attr("placeholder", "Change");
        $("#changelabel").text("Change");
        $("#changeDIV").attr("class", "form-group");
        currentBal = $(data).find("#cashbalance").val();        
        $('input[type="checkbox"]').removeAttr('checked');

        if($(data).find("#cashbalance").val() == "0"){
          $("#submitBttn").prop("disabled", true);
        }else{        
          $("#submitBttn").prop("disabled", false);
        }
        
      }else if($("#student_no").val() == ""){
        $('#submitBttn').loadingBtnComplete({ html : '<i class="fa fa-fw fa-lg fa-check-circle"></i>Submit'});
      }else{ 
        $('#submitBttn').loadingBtnComplete({ html : '<i class="fa fa-fw fa-lg fa-check-circle"></i>Not found'});
        $("#cashbalance").val('');
        $("#student_name").val('');
        
        $("#payment_history").html('<tr class="odd"><td class="dataTables_empty" valign="top" colspan="6">No matching records found</td></tr>');
        
      } 
    }, 
    error: function(e) {
      swal({
      title:"Try Again!", 
      text:"Something went wrong.", 
      type:"error"},
      function(){
        location.reload();
      });
    }
  });
}

$("#cashamount").on("input", function cashChangeEvent(){

  var cash = parseFloat($(this).val());
  var total = parseFloat($("#cashbalance").val());
  var change = parseFloat(cash - total).toFixed(2);

  if(cash > total){
    $("#cashchange").val(change);
    $("#changelabel").text("Change");
    $("#changeDIV").attr("class", "form-group has-warning");
  }else if(change == 0){
    $("#cashchange").val(change);
    $("#changelabel").text("Exact amount");
    $("#changeDIV").attr("class", "form-group has-success");
  }else if($(this).val() == "" || $(this).val() == "NaN"){
    $("#cashchange").val("");
    $("#cashchange").attr("placeholder", "Change");
    $("#changelabel").text("Change");
    $("#changeDIV").attr("class", "form-group");
  }else {
    $("#cashchange").val(change.replace('-', ''));
    $("#changelabel").text("Balance");
    $("#changeDIV").attr("class", "form-group has-error");        
  }

});
function email(){
  $('#email').modal("show");
}

$("#acad_year_modal").on("hidden.bs.modal", function(){
  $("select option:eq(1)").prop('selected', true);
});

$("input[type='checkbox']").change(function(){
  var amount = parseInt($(this).data('price'));
  if(this.checked){
    payment_switch = 1;
    if($("input[type='checkbox']:checked").size() == 1){
      $("#cashbalance").val(0);
    }
    amount = parseInt($("#cashbalance").val()) + amount;
    $("#cashbalance").val(amount);
    $("#cashchange").val(amount);
    $("#cashamount").val(0);
    $("#submitBttn").prop("disabled", true);
    $("#changelabel").text("Balance");
    $("#changeDIV").attr("class", "form-group has-error");    
  }
  else{
    amount = $("#cashbalance").val() - amount;
    $("#cashbalance").val(amount);
  }

  if($("input[type='checkbox']:checked").size() == 0){
    $("#cashbalance").val(currentBal);
    payment_switch = 0;
    $("#cashchange").val("");
    $("#cashchange").attr("placeholder", "Change");
    $("#changelabel").text("Change");
    $("#changeDIV").attr("class", "form-group");
  }
});


$('#print-email').submit(function(e){

  e.preventDefault();    
  var form = $(this).serialize();

  if($("#changelabel").text() == "Balance"){
    $("#print-email input[disabled]").each(function(){
      form = form + "&" + $(this).attr("name") + "=" + $(this).val().replace(" ", "");
    });

    form = form + "&" + $("#cashamount").attr("name") + "=" + $("#cashamount").val().replace(" ", "");
  }else{
      form = form + "&" + $("#cashchange").attr("name") + "=" + "0";
      form = form + "&" + $("#student_no").attr("name") + "=" + $("#student_no").val().replace(" ", "");
      form = form + "&" + $("#cashamount").attr("name") + "=" + $("#cashbalance").val().replace(" ", "");
  }
  if(payment_switch == 0)
  $.ajax({
    type: "POST",
    url: "/students/receipt",
    data: form,
    success: function(data){   
      swal({
      title:"Successful!", 
      text:"Transactions successfully added to the database.", 
      type:"success"},
      function(){
        location.reload();
      });
    },  
    error: function(e) {
      swal({
      title:"Try Again!", 
      text:"Something went wrong.", 
      type:"error"},
      function(){
        location.reload();
      });
    }
  });
  else if(payment_switch == 1 && $("#cashamount").val() >= $("#cashbalance").val())
  $.ajax({
    type: "POST",
    url: "/students/receipt",
    data: form,
    success: function(data){   
      swal({
      title:"Successful!", 
      text:"Transactions successfully added to the database.", 
      type:"success"},
      function(){
        location.reload();
      });
    },  
    error: function(e) {
      swal({
      title:"Try Again!", 
      text:"Something went wrong.", 
      type:"error"},
      function(){
        location.reload();
      });
    }
  });
   
});

$('#acadyear').submit(function(e){
  e.preventDefault();    
  var form = $(this).serialize();

  console.log(form);
  $.ajax({
    type: "POST",
    url: "/acadyear",
    data: form,
    success: function(data){   
      console.log(data);
      swal({
      title:"Successful!", 
      text:"Academic Year successfully added to the database.", 
      type:"success"},
      function(){
        location.reload();
      });
    },  
    error: function(e) {
      swal({
      title:"Try Again!", 
      text:"Something went wrong.", 
      type:"error"},
      function(){
        location.reload();
      });
    }
  });
   
});

$("#sendForm").submit(function(e){
  e.preventDefault();   
  var form = $(this).serialize();

  $("#sendBttn").loadingBtn({text : "Sending"}); 

  $.ajax({
    type: "POST",
    url: "/postcontact/"+options+"/"+or_no,
    data: form,
    success: function(data){   
      console.log(data);
      swal({
      title:"Successful!", 
      text:"Sent Successfully.", 
      type:"success"},
      function(){
        location.reload();
      });
    },  
    error: function(e) {
      console.log(this.url);
      swal({
      title:"Try Again!", 
      text:"Something went wrong.", 
      type:"error"},
      function(){
        location.reload();
      });
    }
  });
})
});

function send(a, b){
  $("#email_modal").modal("show");
  or_no = a;
  options = b;

}
</script>
@endsection