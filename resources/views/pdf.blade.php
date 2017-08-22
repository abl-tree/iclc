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

    <title>Vali Admin</title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--if lt IE 9
    script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    script(src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    -->
  </head>
  <body class="sidebar-mini fixed">
    <div class="wrapper">
      
      <div class="content-wrapper">
        <div class="row user">
          <!-- <div class="col-md-12">
            <div class="profile">
              <div class="info"><img width='100px' class="user-img" src="@if(!empty($data)) {{ $data[0]['user']['profile_image_url_https']}} @else http://reza.moheimani.org/lab/wp-content/uploads/blank-profile-300x300.png @endif">
                <h4 id="social_media_name" class='username'>@if(!empty($data)){{ $data[0]['user']['name']}} @else Name @endif</h4>
                <p id="social_media_desc" class='user-desc'>@if(!empty($data)) @ {{ $data[0]['user']['screen_name']}} @else Screen_name @endif</p>
              </div>
              <div class="cover-image"></div>
            </div>
          </div> -->
          <div class="col-md-9">
            <div id="postarea" class="tab-content">

              <div class="tab-pane active" id="user-timeline">
              @if(!empty($data))
                  @foreach($data as $key => $value)
                <div class="timeline">
                  <div class="post">
                    <div class="post-media"><img class="user-img" src="{{ $value['user']['profile_image_url_https']}}">
                      <div class="content">
                        <h5 width="50px" class="username">{{ $value['user']['name']}}</a></h5>
                        <p class="text-muted"><small>{{ $value['created_at']}}</small></p>
                      </div>
                    </div>
                    <div class="post-content">
                      <p>{{ $value['text']}}</p>
                    </div>
                    <ul class="post-utility">
                      <li class="likes"><a href="#"><i class="fa fa-fw fa-lg fa-thumbs-o-up"></i>{{ $value['favorite_count']}}</a></li>
                      <li class="shares"><a href="#"><i class="fa fa-fw fa-lg fa-share"></i>{{ $value['favorite_count']}}</a></li>
                      <li class="comments"><i class="fa fa-fw fa-lg fa-comment-o"></i> 5 Comments</li>
                    </ul>
                  </div>
                </div>
                  @endforeach
              @else 
                <div class="timeline">
                  <div class="post">
                    <div class="post-content">
                      <p style="text-align: center;">Nothing to show</p>
                    </div>
                  </div>
                </div>
              @endif
              </div>

            </div>
          </div>
</body>
</html>