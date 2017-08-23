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
          <li><a href="#">Reports</a></li>
        </ul>
      </div>
      <div><a class="btn btn-primary btn-flat" id="pdf"><i class="fa fa-lg fa-file-pdf-o"></i></a><a id="csv" class="btn btn-info btn-flat"><i class="fa fa-lg fa-table"></i></a></div>
    </div>
        <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
          <form>
            <div class="row">
            <div class="col-lg-3">
            <select class="form-control report" name="year">
              <option disabled>Year levels</option>
              <option value="All">All</option>
              @if(!empty($yearlevels))
                @foreach($yearlevels as $yearlevel)
                  <option value="{{$yearlevel->year}}">{{$yearlevel->year}}</option>
                @endforeach
              @endif 
            </select>
            </div>
            <div class="col-md-3">
            <select class="form-control report" name="sem">
              <option disabled="true">Semesters</option>
              <option value="All">All</option>
              <option value="1">1st Semester</option>
              <option value="2">2nd Semester</option>
            </select>
            </div>
            <div class="col-md-3">
            <select class="form-control report" name="academic-year">
              <option disabled="true">Academic Year</option>
              <option value="All">All</option>
              @if(!empty($academic_years))
                @foreach($academic_years as $academic_year)
                  <option value="{{$academic_year->academic_year}}">{{$academic_year->academic_year}}</option>
                @endforeach
              @endif 
            </select>
            </div>
            <div class="col-md-3">
            <select class="form-control report" name="course">
              <option disabled="true">Course</option>
              <option value="All">All</option>
              @if(!empty($courses))
                @foreach($courses as $course)
                  <option value="{{$course->course}}">{{$course->course}}</option>
                @endforeach
              @endif 
            </select>
            </div>
            </div>
          </form><br>
            <table class="table table-hover table-bordered" id="sampleTable">
                  <thead>
                    <tr>
                      <th>ID #</th>
                      <th>Name</th>
                      <th>Year</th>
                      <th>Course</th>
                      <th>Amount Paid</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(!empty($students))
                      @foreach($students as $student)
                      <tr>
                        <td> {{$student->Student_No}} </td>
                        <td> {{$student->Student_Name}} </td>
                        <td> {{$student->Year}} </td>
                        <td> {{$student->Course}} </td>
                        <td> {{$student->status}} </td>
                      </tr>
                      @endforeach
                    @endif 
                  </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section("js")
  <script language="javascript">
  $(document).ready(function(){
    var filter = "All/All/All/All";
    $(".report").change(function(){
      var year = $("select[name='year']").val();
      var sem = $("select[name='sem']").val();
      var academic_year = $("select[name='academic-year']").val();
      var course = $("select[name='course']").val();

      filter = year+"/"+sem+"/"+academic_year+"/"+course;

      $("tbody").html('<tr class="odd"><td class="dataTables_empty" valign="top" colspan="6">Please wait...</td></tr>');
      
      $.ajax({
        type: "GET",
        url: "/reports/filter/" + filter,
        success: function(data){   
          console.log(data.length);
          $("tbody").empty();
          for (i=0; i<data.length; i++){
           $("<tr><td>" + data[i].Student_No + "</td><td>" + data[i].Student_Name + "</td><td>" + data[i].Year + "</td><td>" + data[i].Course + "</td><td>" + data[i].status + "</td></tr>").appendTo("tbody");
          }
          if(data.length == 0){
            $("tbody").html('<tr class="odd"><td class="dataTables_empty" valign="top" colspan="6">No records found</td></tr>');
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

     });

    $("#csv").click(function(){
      $(this).loadingBtn({text : "Downloading"}); 
      $.ajax({
        type: "GET",
        url: "/reports/csv/" + filter,
        success: function(data){                 
          window.location.href=this.url;  
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
      }).done(function(){        
          $('#csv').loadingBtnComplete({ html : '<i class="fa fa-lg fa-table"></i>'});
      });
    });

    $("#pdf").click(function(){
      $(this).loadingBtn({text : "Downloading"}); 
      $.ajax({
        type: "GET",
        url: "/reports/pdf/" + filter,
        success: function(data){                  
          $('#pdf').loadingBtnComplete({ html : '<i class="fa fa-lg fa-file-pdf-o"></i>'});
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
  });
  </script>
@endsection