<!DOCTYPE html>
<html>
  <head>
    <!-- <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- CSS--><!-- 
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/search.css') }}"> -->

    <title>ICLC Payment System</title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--if lt IE 9
    script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    script(src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    -->
  </head>
  <body class="sidebar-mini fixed">
    <div class="wrapper">
      
      <div class="content-wrapper">
       <table class="table table-hover table-bordered" id="sampleTable">
                  <thead>
                    <tr>
                      <th>ID #</th>
                      <th>Name</th>
                      <th>Year</th>
                      <th>Course</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(!empty($data))
                      @foreach($data as $student)
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
</body>
</html>