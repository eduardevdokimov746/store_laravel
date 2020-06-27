<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ asset('storage/images/images/favicon1.png') }}" type="image/png"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset($admin_source . '/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset($admin_source . '/bower_components/select2/dist/css/select2.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="{{ asset($admin_source . '/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset($admin_source . '/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset($admin_source . '/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset($admin_source . '/dist/css/skins/_all-skins.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel='stylesheet' href='{{ asset($admin_source . '/my.css') }}'>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{ route('admin.index') }}" class="logo">
            <span class="logo-mini"><b>A</b>LT</span>
            <span class="logo-lg"><b>Admin</b>LTE</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">У вас 4 сообщения</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="{{ asset($admin_source  . '/dist/img/user2-160x160.jpg') }}"
                                                     class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <!-- end message -->
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="{{ asset($admin_source . '/dist/img/user3-128x128.jpg') }}"
                                                     class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                AdminLTE Design Team
                                                <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="{{ asset($admin_source . '/dist/img/user4-128x128.jpg') }}'"
                                                     class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                Developers
                                                <small><i class="fa fa-clock-o"></i> Today</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="{{ asset($admin_source . '/dist/img/user3-128x128.jpg') }}"
                                                     class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                Sales Department
                                                <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="{{ asset($admin_source . '/dist/img/user4-128x128.jpg') }}"
                                                     class="img-circle" alt="User Image">
                                            </div>
                                            <h4>
                                                Reviewers
                                                <small><i class="fa fa-clock-o"></i> 2 days</small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">Смотреть все сообщения</a></li>
                        </ul>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ asset($admin_source . '/dist/img/user2-160x160.jpg') }}" class="user-image"
                                 alt="User Image">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{ asset($admin_source . '/dist/img/user2-160x160.jpg') }}" class="img-circle"
                                     alt="User Image">

                                <p>
                                    {{ Auth::user()->name }}
                                    <small>Админ с {{ Auth::user()->dateRegistration }}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('admin.users.edit', Auth::id()) }}"
                                       class="btn btn-default btn-flat">Профиль</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">Выход</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ asset($admin_source . '/dist/img/user2-160x160.jpg') }}" class="img-circle"
                         alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">Меню</li>
                <!-- Optionally, you can add icons to the links -->
                <li><a href="{{ route('admin.index') }}"><i class="fa fa-home"></i> <span>Главная</span></a></li>
                <li><a href="{{ route('admin.orders.index') }}"><i class="fa fa-shopping-cart"></i> <span>Заказы</span></a>
                </li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-navicon"></i> <span>Категории</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.categories.index') }}">Список категорий</a></li>
                        <li><a href="{{ route('admin.categories.create') }}">Добавить категорию</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-cubes"></i> <span>Товары</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.products.index') }}">Список товаров</a></li>
                        <li><a href="{{ route('admin.products.create') }}">Добавить товар</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('admin.cache.index') }}"><i class="fa fa-database"></i>
                        <span>Кэширование</span></a></li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-users"></i> <span>Пользователи</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.users.index') }}">Список пользователей</a></li>
                        <li><a href="{{ route('admin.users.create') }}">Добавить пользователя</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('admin.chats.index') }}"><i class="fa fa-envelope"></i>
                        <span>Тех. поддержка</span>
                        <small class="label pull-right bg-green" id="count-new-chats">{{ $count_new_chats }}</small>
                    </a>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->pull('success') }}
            </div>
        @endif

        @yield('content')

    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.4.0
        </div>
        <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<script>
    var host = '{{ route('index') }}',
        sytename = '{{ config('app.name') }}',
        adminpath = '{{ route('admin.index') }}',
        adminName = '{{ Auth::user()->name }}',
        adminId = '{{ Auth::id() }}';
</script>
<script src="{{ asset('js/app.js') }}"></script>
<script>

    window.Echo.channel('main').listen('UserConnected', function (data) {
        console.log(data);
        var regexp = /\/chats/;

        if (regexp.test(document.location.pathname)) {
            //Если на странице chats.index
            var table = $('.table-responsive');

            table.removeClass('hidden');
            var date = new Date();
            var string_date = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' ' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();

            var html = "<tr style='cursor: pointer' data-hash='" + data.hash + "'>";
            html += "<td>" + data.user_name + "</td>";
            html += "<td>" + string_date + "</td><td>";
            html += "<span class='label label-success'>Новое</span></td>";
            html += "<td>" + data.message + "</td>";

            table.find('tbody').prepend(html);
        }

        if ($('#count-new-chats').html()) {
            $('#count-new-chats').html(Number.parseInt($('#count-new-chats').html()) + 1);
        } else {
            $('#count-new-chats').html(1);
        }

        var audio = new Audio('{{ asset('storage/audio/Sound.mp3') }}');
        audio.play();
    });

</script>

<!-- jQuery 3 -->
<script src="{{ asset($admin_source . '/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('js/ajaxupload.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset($admin_source . '/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset($admin_source . '/bower_components/select2/dist/js/select2.full.js') }}"></script>
<script src="{{ asset($admin_source . '/js/validator.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset($admin_source . '/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset($admin_source . '/bower_components/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset($admin_source . '/bower_components/ckeditor/adapters/jquery.js') }}"></script>
<script type="text/javascript" src='{{ asset($admin_source . '/my.js') }}'></script>
</body>
</html>
