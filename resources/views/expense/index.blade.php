@extends('layouts.app')
@section('title', 'รายจ่าย')

@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="mb-0 font-weight-bold text-danger">📤 รายการรายจ่าย</h3>
      <small class="text-muted">Expense Management</small>
    </div>

    <a href="{{ route('expense.create') }}" class="btn btn-primary btn-modern2 shadow-sm">
      + เพิ่มรายจ่าย
    </a>
  </div>

  {{-- Summary --}}
  <div class="row mb-4">
    <div class="col-md-6">
      <div class="card-glass p-4 text-white" style="background:linear-gradient(45deg,#ef4444,#f87171)">
        <h6 class="mb-1">ยอดรายจ่ายรวมทั้งหมด</h6>
        <h4>฿ {{ number_format(($data ?? collect())->sum('amount'), 2) }}</h4>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card-glass p-4 text-white" style="background:linear-gradient(45deg,#6b7280,#9ca3af)">
        <h6 class="mb-1">จำนวนรายการ</h6>
        <h4>{{ ($data ?? collect())->count() }} รายการ</h4>
      </div>
    </div>
  </div>

  <div class="glass-card p-0 shadow-sm">
    <div class="table-responsive">
      <table class="table table-bordered table-modern align-middle mb-0  table-hover">
        <thead style="background:#f8fafc;">
          <tr>
            <th class="pl-4">วันที่</th>
            <th>หมวดหมู่</th>
            <th>จำนวนเงิน</th>
            <th>รายละเอียด</th>
            <th class="text-center pr-4" width="150">จัดการ</th>
          </tr>
        </thead>
        <tbody>
          @forelse($data ?? [] as $row)
            <tr>
              <td class="pl-4 align-middle">
                {{ \Carbon\Carbon::parse($row->date)->format('d/m/Y') }}
              </td>

              <td class="align-middle">
                <span class="badge badge-light px-3 py-2">
                  {{ $row->category->name ?? '-' }}
                </span>
              </td>

              <td class="align-middle text-danger font-weight-bold">
                ฿ {{ number_format($row->amount, 2) }}
              </td>

              <td class="align-middle text-muted">
                {{ $row->description }}
              </td>

              <td class="align-middle text-nowrap text-center pr-4">

                <a href="{{ route('expense.edit', $row->id) }}" class="btn btn-sm btn-warning mr-1">
                  แก้ไข
                </a>

                <form action="{{ route('expense.destroy', $row->id) }}" method="POST" style="display:inline;" onsubmit="confirmDelete(this)">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">
                    ลบ
                  </button>
                </form>

              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">
                ไม่มีข้อมูลรายจ่าย
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

@endsection
