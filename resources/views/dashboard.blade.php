<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Atqiya's Fun Learning (AFL)</title>
  <link rel="icon" href="{!! asset('dist/img/large_logo.png') !!}"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/font-awesome/css/font-awesome.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/iCheck/flat/blue.css')}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{asset('plugins/morris/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker-bs3.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
</head>
  <body class="hold-transition sidebar-mini">
    <div class="wrapper">

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand border-bottom navbar-dark bg-success"> <!-- kalau mau warna hitam: bg-dark -->
        @include('layouts.navbar')
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/" class="brand-link bg-dark"> {{-- kalau mau hijau maka bg-success --}}
          @include('layouts.logo')
        </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          @include('layouts.avatar')
        </div>

        <!-- Sidebar Menu -->
        @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
          <nav class="mt-2">
            @include('layouts.sidebarmenu')
          </nav>
        @endif
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        {{-- menampilkan pesan error jika token yang dimasukan beda dengan yg seharusnya --}}
        @if(session('message'))
          <div class="alert alert-info">
            {{ session('message') }}
          </div>
        @endif

        <div class="card">
          <div class="card-body">
            @yield('content')
          </div>
        </div>
      </div>
      <!-- /.content-wrapper -->

      <!-- footer -->
      <footer class="main-footer">
        @include('layouts.footer')
      </footer>
      <!-- /.footer -->

    </div>

  <!-- jQuery -->
  <script src='{{ url('plugins/jquery/jquery.min.js')}}'></script>
  <!-- Sweet Alert -->
  <script src='{{ url('plugins/sweetalert/cdnsweetalert.js')}}'></script>
  <script>
        @if(session('success'))
					swal("{{session('success')}}", "", "success");
        @endif

				@if(session('info'))
					swal("{{session('info')}}", "", "info");
				@endif

				@if(session('error'))
					swal("{{session('error')}}", "", "error");
        @endif

        @if(session('warning'))
					swal("{{session('warning')}}", "", "warning");
        @endif
	</script>
  <!-- AdminLTE App -->
  <script src='{{ url('dist/js/adminlte.js')}}'></script>
  @stack('script')
  </body>
</html>
