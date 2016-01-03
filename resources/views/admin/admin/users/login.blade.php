<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin5 我要登录</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{setting("admin.bootstrap.css")}}/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{setting("admin.font-awesome.css")}}/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{setting("admin.ionicons.css")}}/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{setting("admin.dist.css")}}/AdminLTE.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a>Admin<b>5</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">登录您的帐号</p>
        <form action="{{route("postlogin")}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="form-group has-feedback">
            <input type="text" name="username" class="form-control" placeholder="电话号码" value="{{old('username')}}">
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="密码">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
                <a class="text-red"></a>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="{{setting("admin.plugins")}}/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{setting("admin.bootstrap.js")}}/bootstrap.min.js"></script>
  </body>
</html>
