<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>@yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  @include('layouts.css')
</head>

<body>

  <!-- Sidebar -->
  @include('layouts.sidebar')

  <!-- Navbar -->
  @include('layouts.navbar')

  <!-- Content -->
  <div class="content">
    @yield('content')
  </div>

  <!-- Footer -->
  @include('layouts.footer')

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.querySelector(".sidebar-toggle").onclick = function() {

      document.querySelector(".sidebar").classList.toggle("collapsed");

    }

    function toggleDark() {

      document.body.classList.toggle("dark-mode");

    }

    function mobileMenu() {

      document.querySelector(".sidebar").classList.toggle("active");

    }
  </script>
  @if (session('success'))
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2500,
          timerProgressBar: true
        });

        Toast.fire({
          icon: 'success',
          title: '{{ session('success') }}'
        });
      });
    </script>
  @endif

</body>

</html>
