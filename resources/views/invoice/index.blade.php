@extends('layouts.app')
@section('title', 'ใบแจ้งหนี้')

@section('content')


  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="mb-0 font-weight-bold text-primary">🧾 รายการใบแจ้งหนี้</h3>
      <small class="text-muted">Invoice Management</small>
    </div>

    <a href="{{ route('invoice.create') }}" class="btn btn-primary btn-modern shadow-sm">
      + สร้างใบแจ้งหนี้
    </a>
  </div>

  {{-- Summary --}}
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card-glass p-4 text-white" style="background:linear-gradient(135deg,#6366f1,#8b5cf6)">
        <h6>ยอดรวมทั้งหมด</h6>
        <h3>฿ {{ number_format(($data ?? collect())->sum('total'), 2) }}</h3>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card-glass p-4 text-white" style="background:linear-gradient(135deg,#10b981,#34d399)">
        <h6>ชำระแล้ว</h6>
        <h3>฿ {{ number_format(($data ?? collect())->sum('paid'), 2) }}</h3>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card-glass p-4 text-white" style="background:linear-gradient(135deg,#ef4444,#f87171)">
        <h6>คงเหลือ</h6>
        <h3>฿ {{ number_format(($data ?? collect())->sum('balance'), 2) }}</h3>
      </div>
    </div>
  </div>

  <div class="card-glass p-0">

    <div class="table-responsive">
      <table class="table table-borderless table-modern mb-0">
        <thead>
          <tr style="background:#f1f5f9;">
            <th class="pl-4">เลขที่</th>
            <th>ลูกค้า</th>
            <th>ยอดรวม</th>
            <th>ชำระแล้ว</th>
            <th>คงเหลือ</th>
            <th>ครบกำหนด</th>
            <th class="text-center" width="160">สถานะ</th>
            <th class="text-center" width="170">จัดการ</th>
          </tr>
        </thead>

        <tbody>
          @forelse($data ?? [] as $row)
            @php
              if ($row->balance <= 0) {
                  $status = 'ชำระครบ';
                  $color = '#10b981';
              } elseif ($row->due_date < now()->toDateString()) {
                  $status = 'เกินกำหนด';
                  $color = '#ef4444';
              } else {
                  $status = 'ค้างชำระ';
                  $color = '#f59e0b';
              }
            @endphp

            <tr>
              <td class="pl-4 font-weight-bold">
                {{ $row->invoice_no }}
              </td>

              <td>{{ $row->customer_name }}</td>

              <td class="text-primary font-weight-bold">
                ฿ {{ number_format($row->total, 2) }}
              </td>

              <td class="text-success font-weight-bold">
                ฿ {{ number_format($row->paid, 2) }}
              </td>

              <td class="text-danger font-weight-bold">
                ฿ {{ number_format($row->balance, 2) }}
              </td>

              <td>
                {{ \Carbon\Carbon::parse($row->due_date)->format('d/m/Y') }}
              </td>

              <td class="text-center">
                <span class="badge-modern text-white" style="background:{{ $color }}">
                  {{ $status }}
                </span>
              </td>

              <td class="text-center">

                <a href="{{ route('invoice.edit', $row->id) }}" class="btn btn-sm btn-outline-warning btn-modern mr-1">
                  แก้ไข
                </a>

                <a href="{{ route('invoice.show', $row->id) }}" class="btn btn-sm btn-outline-info btn-modern mr-1">
                  ดู
                </a>

                <form method="POST" action="{{ route('invoice.destroy', $row->id) }}" style="display:inline;" onsubmit="confirmDelete(this)">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger btn-modern">
                    ลบ
                  </button>
                </form>

              </td>
            </tr>

          @empty
            <tr>
              <td colspan="8" class="text-center py-5 text-muted">
                ไม่มีข้อมูลใบแจ้งหนี้
              </td>
            </tr>
          @endforelse

        </tbody>
      </table>
    </div>
  </div>

@endsection
