@extends('layouts.app')
@section('title', 'ผังบัญชี')

@section('content')

  {{-- <style>
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
  </style> --}}

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="mb-0 font-weight-bold">📊 ผังบัญชี</h3>
      <small class="text-muted">ระบบบัญชีคู่ (Double Entry)</small>
    </div>

    <div>
      <a href="{{ route('accounts.create') }}" class="btn btn-primary btn-modern2 shadow-sm">
        + เพิ่มบัญชี
      </a>
    </div>
  </div>

  <div class="glass-card p-0 shadow-sm">
    <div class="table-responsive">
      <table class="table table-bordered table-modern align-middle mb-0 table-hover">
        <thead>
          <tr>
            <th class="text-center pl-4">รหัสบัญชี</th>
            <th>ชื่อบัญชี</th>
            <th>ประเภท</th>
            <th class="text-right pr-4">ยอดคงเหลือ</th>
            <th class="text-center pr-4" width="140">จัดการ</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($accounts as $account)

            <tr>
              <td class="text-center">{{ $account->code }}</td>

              <td>
                {{ $account->name }}
              </td>

              <td>{{ $account->type }}</td>

              <td class="text-right">
                {{ number_format($account->balance, 2) }}
              </td>

              <td class="text-center text-nowrap">
                <a href="{{ route('accounts.edit', $account) }}" class="btn btn-warning btn-modern2">แก้ไข</a>

                <form action="{{ route('accounts.destroy', $account) }}" method="POST" style="display:inline;" onsubmit="confirmDelete(this)">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger btn-modern2">ลบ</button>
                </form>
              </td>
            </tr>

            @if ($account->children && $account->children->count())
              @foreach ($account->children as $child)
                <tr>
                  <td class="text-center">{{ $child->code }}</td>

                  <td>
                    &nbsp;&nbsp;&nbsp;&nbsp; └─ {{ $child->name }}
                  </td>

                  <td>{{ $child->type }}</td>

                  <td class="text-right">
                    {{ number_format($child->balance, 2) }}
                  </td>

                  <td class="text-center text-nowrap">
                    <a href="{{ route('accounts.edit', $child) }}" class="btn btn-warning btn-modern2">แก้ไข</a>

                    <form action="{{ route('accounts.destroy', $child) }}" method="POST" style="display:inline;" onsubmit="confirmDelete(this)">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger btn-modern2">ลบ</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            @endif

          @empty
            <tr>
              <td colspan="5" class="text-center text-muted py-4">
                ไม่พบข้อมูลบัญชี
              </td>
            </tr>
          @endforelse

        </tbody>
      </table>

      <div class="d-flex justify-content-between align-items-center mt-3 px-3">

        <div>
          แสดง {{ $accounts->firstItem() }} ถึง {{ $accounts->lastItem() }}
          จาก {{ $accounts->total() }} รายการ
        </div>

        <div>
          {{ $accounts->links() }}
        </div>

      </div>

    </div>
  </div>


@endsection
