<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>@yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
      transition: .3s;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    body.dark-mode {
      background: #0f172a;
      color: #f1f5f9;
    }

    /* Sidebar */
    .sidebar {
      width: 230px;
      background: linear-gradient(180deg, #111827, #1f2937);
      min-height: 100vh;
      position: fixed;
      color: #fff;
      transition: .3s;
      z-index: 1001;
    }

    .sidebar.collapsed {
      width: 70px;
    }

    .sidebar h4 {
      padding: 18px;
      text-align: center;
      font-weight: 700;
    }

    .sidebar a {
      display: block;
      padding: 12px 18px;
      color: #cbd5e1;
      text-decoration: none;
      transition: .3s;
      border-left: 3px solid transparent;
      white-space: nowrap;
    }

    .sidebar a i {
      width: 20px;
    }

    .sidebar a:hover {
      background: rgba(99, 102, 241, .15);
      color: #fff;
      border-left: 3px solid #6366f1;
    }

    .sidebar a.active {
      background: #6366f1;
      color: #fff;
    }

    .sidebar.collapsed a span {
      display: none;
    }

    .menu-header {
      padding: 10px 18px;
      font-size: 11px;
      color: #9ca3af;
      text-transform: uppercase;
      margin-top: 15px;
    }

    /* Navbar */
    .top-navbar {
      margin-left: 230px;
      height: 60px;
      background: #ffffff;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 25px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, .05);
      transition: .3s;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    body.dark-mode .top-navbar {
      background: #1f2937;
      color: #fff;
    }

    .sidebar.collapsed+.top-navbar {
      margin-left: 70px;
    }

    /* Content */
    .content {
      margin-left: 230px;
      padding: 30px;
      flex: 1;
      transition: .3s;
    }

    .sidebar.collapsed~.content {
      margin-left: 70px;
    }

    /* Footer */
    .footer {
      margin-left: 230px;
      padding: 15px 30px;
      background: #ffffff;
      border-top: 1px solid #e5e7eb;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 14px;
      transition: .3s;
    }

    body.dark-mode .footer {
      background: #1f2937;
      border-top: 1px solid #374151;
      color: #cbd5e1;
    }

    .sidebar.collapsed~.footer {
      margin-left: 70px;
    }

    .btn-primary {
      background: linear-gradient(45deg, #4f46e5, #6366f1);
      border: none;
    }

    .sidebar-toggle {
      cursor: pointer;
      font-size: 18px;
    }
  </style>
</head>

<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4>💼 <span>Accounting</span></h4>

    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <i class="fas fa-chart-line"></i> <span>Dashboard</span>
    </a>

    <div class="menu-header">การเงิน</div>

    <a href="{{ route('income.index') }}" class="{{ request()->routeIs('income.*') ? 'active' : '' }}">
      <i class="fas fa-arrow-down"></i> <span>รายรับ</span>
    </a>

    <a href="{{ route('expense.index') }}" class="{{ request()->routeIs('expense.*') ? 'active' : '' }}">
      <i class="fas fa-arrow-up"></i> <span>รายจ่าย</span>
    </a>

    <a href="{{ route('invoice.index') }}" class="{{ request()->routeIs('invoice.*') ? 'active' : '' }}">
      <i class="fas fa-file-invoice"></i> <span>ใบแจ้งหนี้</span>
    </a>

    <a href="{{ route('payment.index') }}" class="{{ request()->routeIs('payment.*') ? 'active' : '' }}">
      <i class="fas fa-money-bill"></i> <span>รับชำระเงิน</span>
    </a>

    <div class="menu-header">ระบบบัญชี</div>

    <a href="{{ route('accounts.index') }}" class="{{ request()->routeIs('accounts.*') ? 'active' : '' }}">
      <i class="fas fa-book"></i> <span>ผังบัญชี</span>
    </a>

    <a href="{{ route('journals.index') }}" class="{{ request()->routeIs('journals.*') ? 'active' : '' }}">
      <i class="fas fa-clipboard-list"></i> <span>สมุดรายวัน</span>
    </a>

    <form method="POST" action="{{ route('logout') }}" class="p-3 mt-4">
      @csrf
      <button class="btn btn-danger btn-sm btn-block">
        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
      </button>
    </form>
  </div>

  <!-- Navbar -->
  <div class="top-navbar">
    <div>
      <i class="fas fa-bars sidebar-toggle" onclick="toggleSidebar()"></i>
      <strong class="ml-3">@yield('title')</strong>
    </div>

    <div>
      <button onclick="toggleDark()" class="btn btn-sm btn-light mr-3">
        <i class="fas fa-moon"></i>
      </button>

      <i class="fas fa-user-circle"></i>
      {{ auth()->user()->name ?? 'User' }}
    </div>
  </div>

  <!-- Content -->
  <div class="content">
    @yield('content')
  </div>

  <!-- Footer -->
  <div class="footer">
    <div>
      © {{ date('Y') }} Accounting System
    </div>

    <div>
      Version 1.0 | Laravel
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    function toggleSidebar() {
      document.querySelector('.sidebar').classList.toggle('collapsed');
    }

    function toggleDark() {
      document.body.classList.toggle('dark-mode');
      localStorage.setItem('darkMode',
        document.body.classList.contains('dark-mode'));
    }

    if (localStorage.getItem('darkMode') === 'true') {
      document.body.classList.add('dark-mode');
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
