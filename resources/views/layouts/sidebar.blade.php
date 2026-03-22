<div class="sidebar">

  <h4>💼 <span>Accounting</span></h4>

  <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <i class="fas fa-chart-line"></i> <span>Dashboard</span>
  </a>


  {{-- <div class="menu-header">ลูกหนี้ / เจ้าหนี้</div> --}}

  <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">
    <i class="fas fa-users"></i> <span>ลูกค้า</span>
  </a>

  {{-- <a href="{{ route('suppliers.index') }}" class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
    <i class="fas fa-truck"></i> <span>ซัพพลายเออร์</span>
  </a> --}}

  {{-- <div class="menu-header">การเงิน</div> --}}

  {{-- <a href="{{ route('income.index') }}" class="{{ request()->routeIs('income.*') ? 'active' : '' }}">
    <i class="fas fa-arrow-down"></i> <span>รายรับ</span>
  </a> --}}

  {{-- <a href="{{ route('expense.index') }}" class="{{ request()->routeIs('expense.*') ? 'active' : '' }}">
    <i class="fas fa-arrow-up"></i> <span>รายจ่าย</span>
  </a> --}}

  <a href="{{ route('invoice.index') }}" class="{{ request()->routeIs('invoice.*') ? 'active' : '' }}">
    <i class="fas fa-file-invoice"></i> <span>ใบแจ้งหนี้</span>
  </a>

  {{-- <a href="{{ route('payment.index') }}" class="{{ request()->routeIs('payment.*') ? 'active' : '' }}">
    <i class="fas fa-money-bill-wave"></i> <span>รับชำระเงิน</span>
  </a> --}}


  <div class="menu-header">ระบบบัญชี</div>

  <a href="{{ route('accounts.index') }}" class="{{ request()->routeIs('accounts.*') ? 'active' : '' }}">
    <i class="fas fa-book"></i> <span>ผังบัญชี</span>
  </a>
  <a href="{{ route('banks.index') }}" class="{{ request()->routeIs('banks.*') ? 'active' : '' }}">
    <i class="fas fa-university"></i> <span>บัญชีธนาคาร</span>
  </a>
  <a href="{{ route('journals.index') }}" class="{{ request()->routeIs('journals.*') ? 'active' : '' }}">
    <i class="fas fa-clipboard-list"></i> <span>สมุดรายวัน</span>
  </a>



  {{-- <div class="menu-header">รายงาน</div>

  <a href="{{ route('reports.trial_balance') }}" class="{{ request()->routeIs('reports.trial_balance') ? 'active' : '' }}">
    <i class="fas fa-balance-scale"></i> <span>งบทดลอง</span>
  </a>

  <a href="{{ route('reports.profit_loss') }}" class="{{ request()->routeIs('reports.profit_loss') ? 'active' : '' }}">
    <i class="fas fa-chart-pie"></i> <span>งบกำไรขาดทุน</span>
  </a>

  <a href="{{ route('reports.balance_sheet') }}" class="{{ request()->routeIs('reports.balance_sheet') ? 'active' : '' }}">
    <i class="fas fa-landmark"></i> <span>งบดุล</span>
  </a>

  <a href="{{ route('reports.cashflow') }}" class="{{ request()->routeIs('reports.cashflow') ? 'active' : '' }}">
    <i class="fas fa-wallet"></i> <span>กระแสเงินสด</span>
  </a> --}}

  <div class="menu-header">ตั้งค่า</div>

  <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
    <i class="fas fa-user"></i> <span>ผู้ใช้งาน</span>
  </a>

  {{-- <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
    <i class="fas fa-cog"></i> <span>ตั้งค่าระบบ</span>
  </a> --}}

</div>
