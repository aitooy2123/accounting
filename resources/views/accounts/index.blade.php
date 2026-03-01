@extends('layouts.app')
@section('title', 'ผังบัญชี')

@section('content')

  <style>
    :root {
      --card-light: rgba(255, 255, 255, 0.8);
      --card-dark: rgba(30, 41, 59, 0.7);
    }

    body.dark-mode {
      background: #0f172a;
      color: #f1f5f9;
    }

    .glass-card {
      backdrop-filter: blur(14px);
      background: var(--card-light);
      border-radius: 18px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      transition: .3s;
    }

    body.dark-mode .glass-card {
      background: var(--card-dark);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .badge-type {
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 12px;
    }

    .type-asset {
      background: #dbeafe;
      color: #1e3a8a;
    }

    .type-liability {
      background: #fee2e2;
      color: #7f1d1d;
    }

    .type-equity {
      background: #e9d5ff;
      color: #581c87;
    }

    .type-income {
      background: #dcfce7;
      color: #14532d;
    }

    .type-expense {
      background: #fef9c3;
      color: #713f12;
    }

    .toggle-btn {
      border-radius: 50px;
    }
  </style>

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="mb-0 font-weight-bold">📊 ผังบัญชี</h3>
      <small class="text-muted">ระบบบัญชีคู่ (Double Entry)</small>
    </div>

    <div>
      <a href="{{ route('accounts.create') }}" class="btn btn-primary shadow-sm">
        + เพิ่มบัญชี
      </a>

      <button onclick="toggleDark()" class="btn btn-outline-secondary ml-2 toggle-btn">
        🌙 Dark Mode
      </button>
    </div>
  </div>

  <div class="glass-card p-0 shadow-sm">
    <div class="table-responsive">
      <table class="table table-bordered table-modern align-middle mb-0">
        <thead>
          <tr>
            <th class="pl-4">รหัสบัญชี</th>
            <th>ชื่อบัญชี</th>
            <th>ประเภท</th>
            <th class="text-right pr-4">ยอดคงเหลือ</th>
            <th class="text-center pr-4" width="140">จัดการ</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($accounts as $account)
            @include('accounts.partials.row', [
                'account' => $account,
                'level' => 0,
            ])
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <script>
    function toggleDark() {
      document.body.classList.toggle('dark-mode');
      localStorage.setItem('darkMode',
        document.body.classList.contains('dark-mode'));
    }

    if (localStorage.getItem('darkMode') === 'true') {
      document.body.classList.add('dark-mode');
    }
  </script>

@endsection
