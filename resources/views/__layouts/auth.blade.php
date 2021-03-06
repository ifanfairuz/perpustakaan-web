<!DOCTYPE html>
<html lang="id">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>@yield('title')</title>

  <link rel="shortcut icon" href="/img/privos.png" type="image/png">
  <!-- Custom fonts for this template-->
  <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gray-100">

  <div class="container d-flex flex-column justify-content-center" style="min-height: 100vh">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              @yield('content')
            </div>
          </div>
        </div>

      </div>

    </div>

    <!-- Footer -->
    <footer class="sticky-footer">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright &copy; {{ site('name') }} {{ date('Y') }}</span>
        </div>
      </div>
    </footer>
    <!-- End of Footer -->

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('sbadmin/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('sbadmin/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
