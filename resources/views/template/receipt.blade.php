<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS--><!-- 
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}"> -->
    <style>
      html {
      font-size: 10px;
      -webkit-tap-highlight-color: transparent;
      }
          /*@media all and (min-width:768px)*/
      .sidebar-collapse .content-wrapper {
          margin-left: 0px;
      }
      .fixed .content-wrapper {
          margin-top: 50px;
      }
      .content-wrapper {
          height: 100%;
          z-index: 800;
          background-color: #e5e5e5;
          margin-left: 230px;
          z-index: 820;
          padding: 30px;
          transition: all 0.3s ease-in-out;
      }
      body {
          font-family: "Lato","Segoe UI",sans-serif;
          font-size: 14px;
          line-height: 1.4285;
          color: #333;
          background-color: white;
      }
      .row {
          margin-left: -15px;
          margin-right: -15px;
      }
      /*@media all and (min-width:992px)*/
      .col-md-12 {
          width: 100%;
      }
      /*@media all and (min-width:992px)*/
      .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
          float: left;
      }
      .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
          position: relative;
          min-height: 1px;
          padding-left: 15px;
          padding-right: 15px;
      }
      .card {
          position: relative;
          background: #ffffff;
          border-radius: 3px;
          padding: 20px;
          box-shadow: 0px 2px 2px 0px rgba(0,0,0,0.14), 0px 1px 5px 0px rgba(0,0,0,0.12), 0px 3px 1px -2px rgba(0,0,0,0.2);
          margin-bottom: 30px;
          transition: all 0.3s ease-in-out;
      }
      .col-xs-4 {
          width: 33.33%;
      }
      address {
          margin-bottom: 20px;
          font-style: normal;
          line-height: 1.4285;
      }
      b, strong {
          font-weight: bold;
      }
      .mt-20 {
          margin-top: 20px !important;
      }
      article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
          display: block;
      }
      .table-responsive {
          overflow-x: auto;
          min-height: 0.01%;
      }
      .col-xs-12 {
          width: 100%;
      }
      .table {
          width: 100%;
          max-width: 100%;
          margin-bottom: 20px;
      }
      table {
          background-color: transparent;
      }
      table {
          border-collapse: collapse;
          border-spacing: 0px;
      }
      .table > caption + thead > tr:first-child > th, .table > caption + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > td, .table > thead:first-child > tr:first-child > th, .table > thead:first-child > tr:first-child > td {
          border-top: 0;
      }
      .table > thead > tr > th {
          vertical-align: bottom;
          border-bottom: 2px solid #ddd;
      }
      .table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
          padding: 8px;
          line-height: 1.4285;
          vertical-align: top;
          border-top: 1px solid #ddd;
      }
      th {
          text-align: left;
      }
      .table-striped > tbody > tr:nth-of-type(2n+1) {
          background-color: #f9f9f9;
      }
      .page-header {
          padding-bottom: 9px;
          margin: 40px 0 20px;
          border-bottom: 1px solid #eee;
      }
      h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
          font-family: inherit;
          font-weight: 500;
          line-height: 1.1;
          color: inherit;
      }
      h2, .h2 {
          font-size: 30px;
      }
      .fa {
          display: inline-block;
          font: normal normal normal 14px/1 FontAwesome;
          font-size: inherit;
          text-rendering: auto;
          -webkit-font-smoothing: antialiased;
          -moz-osx-font-smoothing: grayscale;
      }
      .pull-right {
          float: right !important;
      }
      h1 small, h1 .small, .h1 small, .h1 .small, h2 small, h2 .small, .h2 small, .h2 .small, h3 small, h3 .small, .h3 small, .h3 .small {
          font-size: 100%;
      }
      h1 small, h1 .small, h2 small, h2 .small, h3 small, h3 .small, h4 small, h4 .small, h5 small, h5 .small, h6 small, h6 .small, .h1 small, .h1 .small, .h2 small, .h2 .small, .h3 small, .h3 .small, .h4 small, .h4 .small, .h5 small, .h5 .small, .h6 small, .h6 .small {
          font-weight: normal;
          line-height: 1;
          color: #777;
      }
      small, .small {
          font-size: 85%;
      }
      article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
          display: block;
      }
      * {
          box-sizing: border-box;
      }
      h1 small, h1 .small, h2 small, h2 .small, h3 small, h3 .small, h4 small, h4 .small, h5 small, h5 .small, h6 small, h6 .small, .h1 small, .h1 .small, .h2 small, .h2 .small, .h3 small, .h3 .small, .h4 small, .h4 .small, .h5 small, .h5 .small, .h6 small, .h6 .small {
          font-weight: normal;
          line-height: 1;
          color: #777;
      }
      .pull-right {
          float: right !important;
      }

    </style>

    <title>ICLC Pay-4-Less</title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--if lt IE 9
    script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    script(src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    -->
  </head>
  <body class="sidebar-collapse fixed">
    <div class="row">
      <div class="col-md-12">
        <section>
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header"><i class="fa fa-globe"></i> Institute of Computing Local Council
              <small class="pull-right">Date: {{ $data[0]['Date'] }}</small></h2>
            </div>
          </div>
          <div class="row invoice-info">              
            <div class="col-xs-4">
                <b>Official Receipt # {{ $data[0]['OR'] }} </b><br><br>
                <b>Name:</b> {{ $data[0]['Name'] }}<br><b>Semester:</b> {{ $data[0]['Semester'] }}<br>
                <b>Course:</b> {{ $data[0]['Course'] }}<br><b>Year:</b> {{ $data[0]['Year'] }}<br><br>
            </div> 
          </div>
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Qty</th>
                    <th>Accounts</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                  @if(!empty($data['accounts']))
                    @foreach($data['accounts'] as $index=>$account)
                  <tr>
                    <td>1</td>
                    <td>{{$account->name}}</td>
                    <td>{{$data['data'][$index]['payment']}}</td>
                  </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <h3 style="margin-right: 20%; float: right;"><b>Received by:</b><br><br>ICLC {{ $data[0]['Cashier'] }}</h3>
            </div>
          </div>
        </section>
      </div>
    </div>
  </body>
</html>
