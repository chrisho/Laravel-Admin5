<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Starter</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset(setting("admin.bootstrap.css"))}}/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset(setting("admin.font-awesome.css"))}}/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset(setting("admin.ionicons.css"))}}/ionicons.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset(setting("admin.plugins"))}}/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset(setting("admin.dist.css"))}}/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="{{asset(setting("admin.dist.css"))}}/skins/skin-blue.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset(setting("admin.plugins"))}}/datatables/dataTables.bootstrap.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset(setting("admin.plugins"))}}/iCheck/all.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset(setting("admin.dist.css"))}}/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        <script>
            var baseUrl = "{{asset(setting('adminstatic.root'))}}";
        </script>
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="/" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">A<b>5</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">Admin<b>5</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">菜单状态</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">              
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle glyphicon glyphicon-user" data-toggle="dropdown">           
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs">{{auth()->user()->username}}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <p>
                      {{auth()->user()->username}}
                      <small>{{auth()->user()->created_at}} 加入</small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{route("admin/user/password")}}" class="btn btn-default btn-flat">修改密码</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{route("logout")}}" class="btn btn-default btn-flat">退出</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">            

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">菜单</li>
            <!-- Optionally, you can add icons to the links -->
            @include('admin.common.menu')
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">

          @yield('content')

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        @yield('right-siderbar')
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>

      
    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="{{asset(setting("admin.plugins"))}}/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{asset(setting("admin.bootstrap.js"))}}/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{asset(setting("admin.dist.js"))}}/app.min.js"></script>
    
    <script src="{{asset(setting("admin.plugins"))}}/select2/select2.full.min.js"></script>
    <script src="{{asset(setting("admin.plugins"))}}/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset(setting("admin.plugins"))}}/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="{{asset(setting("admin.plugins"))}}/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="{{asset(setting("admin.plugins"))}}/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset(setting("admin.dist.js"))}}/demo.js"></script>
    <script src="{{asset(setting("admin.dist.js"))}}/xy.tables.js"></script>
    <script src="{{asset(setting("admin.dist.js"))}}/xy.form.js"></script>
    <script src="{{asset(setting("admin.dist.js"))}}/xy.modal.js"></script>    
    <!-- iCheck -->    
    <script src="{{asset(setting("admin.plugins"))}}/iCheck/icheck.min.js"></script>
    <script src="{{asset(setting("admin.dist.js"))}}/xy.input.js"></script>
    <!-- Validation -->
    <script src="{{asset(setting("admin.plugins"))}}/validation/jquery.validate.min.js"></script>
    <script src="{{asset(setting("admin.plugins"))}}/validation/localization/messages_zh.min.js"></script>
    <!-- FORM -->
    <script src="{{asset(setting("admin.plugins"))}}/form/jquery.form.js"></script> 

    <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. Slimscroll is required when using the
         fixed layout. -->
    @yield('script')
  </body>
</html>
