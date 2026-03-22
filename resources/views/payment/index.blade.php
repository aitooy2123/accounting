@extends('layouts.app')

@section('title', 'รายการรับชำระ')

@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="mb-0 font-weight-bold text-success">💳 รายการรับชำระ</h3>
      <small class="text-muted">Payment Management</small>
    </div>

    <a href="{{ route('payment.create') }}" class="btn btn-primary btn-modern2 shadow-sm">
      + เพิ่มการรับชำระ
    </a>
  </div>

  {{-- Summary --}}
  <div class="row mb-4">
    <div class="col-md-6">
      <div class="card-glass p-4 text-white" style="background:linear-gradient(45deg,#10b981,#34d399)">
        <h6 class="mb-1">ยอดรับชำระรวม</h6>
        <h4>฿ {{ number_format($payments->sum('amount'), 2) }}</h4>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card-glass p-4 text-white" style="background:linear-gradient(45deg,#6366f1,#818cf8)">
        <h6 class="mb-1">จำนวนรายการ</h6>
        <h4>{{ $payments->count() }} รายการ</h4>
      </div>
    </div>
  </div>

  <div class="glass-card p-0 shadow-sm">
    <div class="table-responsive">
      <table class="table table-bordered table-modern align-middle mb-0 table-hover">
        <thead style="background:#f8fafc;">
          <tr>
            <th class="pl-4">#</th>
            <th>เลขที่ใบแจ้งหนี้</h>
            <th>จำนวนเงิน</th>
            <th>วันที่ชำระ</th>
            <th class="text-center pr-4" width="150">จัดการ</th>
          </tr>
        </thead>
        <tbody>
          @forelse($payments as $key => $payment)
            <tr>
              <td class="pl-4 align-middle">
                <span class="badge badge-light">
                  {{ $key + 1 }}
                </span>
              </td>

              <td class="align-middle font-weight-bold">
                {{ $payment->invoice->invoice_no ?? '-' }}
              </td>

              <td class="align-middle text-success font-weight-bold">
                ฿ {{ number_format($payment->amount, 2) }}
              </td>

              <td class="align-middle">
                {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}
              </td>

              <td class="align-middle text-center pr-4 text-nowrap">

                <a href="{{ route('payment.edit', $payment->id) }}" class="btn btn-sm btn-warning mr-1">
                  แก้ไข
                </a>

                <form action="{{ route('payment.destroy', $payment->id) }}" method="POST" style="display:inline;" onsubmit="confirmDelete(this)">
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
              <td colspan="5" class="text-center  text-muted">
                ไม่มีข้อมูลการรับชำระ
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

@endsection
