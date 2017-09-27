@extends('layouts.common')

@section('css')
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/buttons.dataTables.min.css') }}">

@endsection

@section('sidebar')
<ul class="sidebar-menu">
  <li><a href="{{ route('home')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
  <li class="active"><a href="{{ route('transaction')}}"><i class="fa fa-calculator"></i><span>Transaction</span></a></li>
  <li class="treeview"><a href="#"><i class="fa fa-th-list"></i><span>Record</span><i class="fa fa-angle-right"></i></a>
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
        {{ csrf_field() }}
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
                      <option class="acad-add" value="add">Add</option>
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
                  <button id="submitBttn" class="btn btn-primary icon-btn disabled" type="button" data-toggle="modal" data-target="#add_item_modal"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add Item</button>
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
                  <input id="cash-amount" name="cash-amount" type="number" autocomplete="off" class="form-control col-md-8" type="text" readonly placeholder="Enter Amount" required>
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
                <div class="btn-group">
                  <button id="submitBttn" class="btn btn-primary icon-btn disabled" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
                </div>
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
                      <th>Total Payment</th>
                      <th>Cashier</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>OR #</th>
                      <th>Date</th>
                      <th>Total Payment</th>
                      <th>Cashier</th>
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
      <!-- End Academic Year Modal -->

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
      <!-- End Semester Modal -->

      <!-- Add Item Modal -->
      <div id="add_item_modal" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">      
            <form id="add-item-form" class="form-horizontal" role="form">    
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h3 class="modal-title">Add Item</h3>
            </div>
            <div class="modal-body">
                <div class="card-body">
                  <table class="table table-hover table-bordered" id="itemTable" style="width: 100%">
                        <thead>
                          <tr>
                            <th hidden>ID</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th hidden>ID</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Status</th>
                          </tr>
                        </tfoot>
                  </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="card-footer">
                  <div class="row">
                    <div class="col-md-4 text-left item_total">
                      <h5><strong>Total:</strong></h5><span>PHP 0</span>
                    </div>
                    <div class="col-md-8">
                      <a class="btn btn-success icon-btn"  class="close" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-check-circle"></i>Continue</a>
                    </div>
                  </div>
                </div>
            </div>
          </form>
          </div>
        </div>
      </div> 
      <!-- End Add Item Modal -->

      <!-- Add Receipt Modal -->
      <div id="receipt_modal" class="modal fade">
        <div class="modal-dialog">
          <div class="modal-content">       
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h3 class="modal-title">Receipt</h3>
            </div>
            <div class="modal-body">
              <div class="row">
              <div class="col-md-12">
                <div class="card">
                    <section class="invoice">
                      <div class="row">
                        <div class="col-xs-12">
                          <h2 class="page-header"><i class="fa fa-globe"></i> Vali<small class="pull-right">Date: 01/01/2016</small></h2>
                        </div>
                      </div>
                      <div class="row invoice-info">
                        <div class="col-xs-4">From
                          <address><strong>Vali Ltd.</strong><br>518 Akshar Avenue<br>Gandhi Marg<br>New Delhi<br>Email: hello@vali.com</address>
                        </div>
                        <div class="col-xs-4">To
                          <address><strong>John Doe</strong><br>            795 Folsom Ave, Suite 600<br>            San Francisco, CA 94107<br>            Phone: (555) 539-1037<br>            Email: john.doe@example.com</address>
                        </div>
                        <div class="col-xs-4"><b>Invoice #007612</b><br><br><b>Order ID:</b> 4F3S8J<br><b>Payment Due:</b> 2/22/2014<br><b>Account:</b> 968-34567</div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12 table-responsive">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>Qty</th>
                                <th>Product</th>
                                <th>Serial #</th>
                                <th>Description</th>
                                <th>Subtotal</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>1</td>
                                <td>Call of Duty</td>
                                <td>455-981-221</td>
                                <td>El snort testosterone trophy driving gloves handsome</td>
                                <td>$64.50</td>
                              </tr>
                              <tr>
                                <td>1</td>
                                <td>Need for Speed IV</td>
                                <td>247-925-726</td>
                                <td>Wes Anderson umami biodiesel</td>
                                <td>$50.00</td>
                              </tr>
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
            <div class="modal-footer">
                <div class="card-footer">
                  <div class="row">
                    <div class="col-md-4 text-left item_total">
                      <h5><strong>Total:</strong></h5><span>PHP 0</span>
                    </div>
                    <div class="col-md-8">
                      <a class="btn btn-success icon-btn"  class="close" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-check-circle"></i>Continue</a>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div> 
      <!-- End Receipt Modal -->

    </div>
  </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('js/plugins/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('js/plugins/DataTable_Button/js/select.dataTable.min.js') }}"></script>
<script src="{{ asset('js/plugins/DataTable_Button/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/plugins/DataTable_Button/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/plugins/DataTable_Button/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('js/plugins/DataTable_Button/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/plugins/DataTable_Button/js/select.dataTable.min.js') }}"></script>
<script>
  $(document).ready(function(){
    var table = $('#payment-history').DataTable({
      "columnDefs": [
        {
            "targets": [ 0 ],
            "visible": false,
            "searchable": false
        }
      ]
    });    
    var item_table = $('#itemTable').DataTable({
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
                  }
                ],
                dom: 'Bfrtip',
                buttons: [
                  {
                    text: 'Select All',
                    action: function(e, dt, node, config){              
                        item_table.rows().select();  
                        var total = 0;
                        var rowData = item_table.rows('.selected').data();
                        $.each(rowData,function(key,value){
                            total += parseFloat(value[2]);
                        })

                        $('.item_total span').text('PHP: '+total);
                    },
                    enabled: true
                  },
                  {
                    text: 'Unselect All',
                    action: function(e, dt, node, config){              
                        item_table.rows().deselect();
                        var total = 0;
                        var rowData = item_table.rows('.selected').data();
                        $.each(rowData,function(key,value){
                            total += parseFloat(value[2]);
                        })

                        $('.item_total span').text('PHP: '+total);
                    },
                    enabled: true
                  },
                  'pageLength'
                ]
              });

    item_table.on( 'deselect', function () {
        var total = 0;
        var rowData = item_table.rows('.selected').data();
        $.each(rowData,function(key,value){
            total += parseFloat(value[2]);
        })

        if(item_table.rows('.selected').count() > 0){
          $('input[name="cash-amount"]').attr('readonly', false);
        }else{
          if(!$('input[name="cash-amount"]').attr('readonly'))
            $('input[name="cash-amount"]').attr('readonly', true)
        }

        $('.item_total span').text('PHP '+total);
    } );

    item_table.on( 'select', function () {
        var total = 0;
        var rowData = item_table.rows('.selected').data();
        $.each(rowData,function(key,value){
            total += parseFloat(value[2]);
        })

        if(item_table.rows('.selected').count() > 0){
          $('input[name="cash-amount"]').attr('readonly', false);
        }else{
          if(!$('input[name="cash-amount"]').attr('readonly'))
            $('input[name="cash-amount"]').attr('readonly', true)
        }

        $('.item_total span').text('PHP '+total);
    } );

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
          if($('input[name="student-id"]').val()){
            $('#student-info').submit();
            $('input[name="total-amount"]').val('');
            $('input[name="cash-change"]').val('');
          }
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
          if($('input[name="student-id"]').val()){
            $('input[name="total-amount"]').val('');
            $('input[name="cash-change"]').val('');
            $('#student-info').submit();
          }
      }
    });

    $('#student-info').submit(function(e){
      e.preventDefault();
      if(!$('#student-info #submitBttn').hasClass('disabled')){
        $('#student-info #submitBttn').addClass('disabled');
      }

      $.ajax({
        type: 'GET',
        dataType: 'json',
        data: $(this).serialize(),
        url: '/transaction/payment',
        success: function(data){
          if($('#student-info #submitBttn').hasClass('disabled')){
            $('#student-info #submitBttn').removeClass('disabled');
          }

          table.ajax.url(data.link).load();
          var data = $('#student-info').serialize();
          var total = 0;

          console.log(data);

          item_table.ajax.url('/transaction/unpaid?'+data).load();
          $('.item_total span').text('PHP '+total);
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

      $('input[name="cash-change"]').val(change);

      if(change < 0){
          if(!$('#payment-info #submitBttn').hasClass('disabled'))
            $('#payment-info #submitBttn').addClass('disabled');
      }else{
          if($('#payment-info #submitBttn').hasClass('disabled'))
            $('#payment-info #submitBttn').removeClass('disabled');
      }
    });

    $('#payment-info').submit(function(e){
      e.preventDefault();
      var total = parseFloat($('input[name="total-amount"]').val());
      var cash = parseFloat($('input[name="cash-amount"]').val());
      var ids = $.map(item_table.rows('.selected').data(), function (item) {
            return item[0]
        });      
      var data = $('#student-info, #payment-info').serializeArray();
      data.push({name: 'item_id', value: ids});

      if($('input[name="cash-change"]').val()>=0)
      if($('input[name="student-id"]').val()){
        $.ajax({
          url: 'transaction/confirm',
          method: 'post',
          data: data,
          dataType: 'json',
          success: function(data){
            table.ajax.url(data.link).load();
            $.notify({
                title: "Transaction Complete : ",
                message: "Transaction is added!",
                icon: 'fa fa-check' 
              },{
                type: "success"
              });

            $('#payment-info')[0].reset();           
            item_table.rows().deselect();
            item_table.ajax.reload();
          },
          error: function(xhr){
            var error = JSON.parse(xhr.responseText);
            
            $.notify({
                title: "Transaction Error : ",
                message: error.item_id,
                icon: 'fa fa-close' 
              },{
                type: "danger"
              });

            $('#payment-info')[0].reset();  
          }
        });
      }else{
        $.notify({
            title: "Error : ",
            message: "Add student.",
            icon: 'fa fa-check' 
          },{
            type: "warning"
          });
      }else{
        $.notify({
            title: "Error : ",
            message: "Amount is not enough!",
            icon: 'fa fa-check' 
          },{
            type: "warning"
          });
      }
    });    

    $('input[name="studentID"]').on('input', function(){
      $('input[name="studentName"]').val('Retrieving...');
      table.clear().draw();
      if(!$('#student-info #submitBttn').hasClass('disabled')){
        $('#student-info #submitBttn').addClass('disabled');
      }
    });

    (function($){
        $.fn.extend({
            donetyping: function(callback,timeout){
                timeout = timeout || 1e3; // 1 second default timeout
                var timeoutReference,
                    doneTyping = function(el){
                        if (!timeoutReference) return;
                        timeoutReference = null;
                        callback.call(el);
                    };
                return this.each(function(i,el){
                    var $el = $(el);
                    // Chrome Fix (Use keyup over keypress to detect backspace)
                    // thank you @palerdot
                    $el.is(':input') && $el.on('keyup keypress paste',function(e){
                        // This catches the backspace button in chrome, but also prevents
                        // the event from triggering too preemptively. Without this line,
                        // using tab/shift+tab will make the focused element fire the callback.
                        if (e.type=='keyup' && e.keyCode!=8) return;
                        
                        // Check if timeout has been set. If it has, "reset" the clock and
                        // start over again.
                        if (timeoutReference) clearTimeout(timeoutReference);
                        timeoutReference = setTimeout(function(){
                            // if we made it here, our timeout has elapsed. Fire the
                            // callback
                            doneTyping(el);
                        }, timeout);
                    }).on('blur',function(){
                        // If we can, fire the event since we're leaving the field
                        doneTyping(el);
                    });
                });
            }
        });
    })(jQuery);

    $('input[name="studentID"]').donetyping(function(){
      $.ajax({
            url: '/student/search',
            method: 'GET',
            dataType: 'json',
            data: {id: $(this).val()},
            success: function(data){
              if(data.status === 'exists'){
                $('input[name="studentName"]').val(data.info['name']);
                $('input[name="student-id"]').val(data.info['id']);
                $('#student-info #submitBttn').removeClass('disabled');
                $('#student-info').submit();
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

    $('#add_item_modal').on('hidden.bs.modal', function(){
      var ids = $.map(item_table.rows('.selected').data(), function (item) {
            return item[0]
        });
      var data = $('#student-info').serializeArray();
      data.push({name: 'item_id', value: ids});

      $.ajax({
        url: '/transaction/add_item',
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function(data){
          $('input[name="total-amount"]').val(data[0].bal);
          $('input[name="cash-change"]').val($('input[name="cash-amount"]').val()-data[0].bal);
          $('#add_item_modal').modal('hide');
        }
      })
    })
  });
</script>
@endsection