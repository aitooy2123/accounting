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

    {{-- <div class="col-md-4">
    <div class="card-glass p-4 text-white" style="background:linear-gradient(45deg,#6366f1,#818cf8)">
      <h6 class="mb-1">จำนวนรายการ</h6>
      <h4>{{ $payments->count() }} รายการ</h4>
    </div>
  </div> --}}

    <div class="col-md-6">
      <div class="card-glass p-4 text-white" style="background:linear-gradient(45deg,#ef4444,#f87171)">
        <h6 class="mb-1">ยอดคงเหลือรวม</h6>
        <h4>
          ฿ {{ number_format($invoices->sum(fn($i) => $i->total - ($i->payments_sum_amount ?? 0)), 2) }}
        </h4>
      </div>
    </div>

  </div>

  <div class="glass-card p-0 shadow-sm">
    <div class="table-responsive">
      <table class="table table-bordered table-modern align-middle mb-0 table-hover">

        <thead style="background:#f8fafc;">
          <tr>
            <th class="pl-4">#</th>
            <th>Invoice</th>
            <th>ยอดทั้งหมด</th>
            <th>จ่ายงวดนี้</th>
            <th>ยอดสะสม</th>
            <th>คงเหลือ</th>
            <th>สถานะ</th>
            <th>วันที่</th>
            <th class="text-center pr-4" width="150">จัดการ</th>
          </tr>
        </thead>

        <tbody>

          @forelse($payments as $key => $payment)
            @php
              $invoice = $payment->invoice;
              $total = $invoice->total ?? 0;

              // 🔥 Running Balance (ถูกต้อง)
              $runningPaid = 0;

              foreach ($invoice->payments as $p) {
                  $runningPaid += $p->amount;

                  if ($p->id == $payment->id) {
                      break;
                  }
              }

              $balance = $total - $runningPaid;
            @endphp

            <tr>
              <td class="pl-4">
                <span class="badge badge-light">{{ $key + 1 }}</span>
              </td>

              <td class="font-weight-bold">
                {{ $invoice->invoice_no ?? '-' }}
              </td>

              <td>
                ฿ {{ number_format($total, 2) }}
              </td>

              <td class="text-success font-weight-bold">
                ฿ {{ number_format($payment->amount, 2) }}
              </td>

              <td>
                ฿ {{ number_format($runningPaid, 2) }}
              </td>

              <td class="font-weight-bold {{ $balance > 0 ? 'text-danger' : 'text-success' }}">
                ฿ {{ number_format($balance, 2) }}
              </td>

              <td>
                @if ($balance <= 0)
                  <span class="badge badge-success">✔ ชำระครบ</span>
                @elseif($runningPaid > 0)
                  <span class="badge badge-warning">⏳ บางส่วน</span>
                @else
                  <span class="badge badge-danger">❌ ค้าง</span>
                @endif
              </td>

              <td>
                {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}
              </td>
              <td class="text-center pr-4 text-nowrap">

                {{-- EDIT --}}
                <a href="{{ route('payment.edit', $payment->id) }}" class="btn btn-sm btn-warning mr-1" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ">
                  <i class="fas fa-edit"></i>
                </a>

                {{-- DELETE --}}
                <form action="{{ route('payment.destroy', $payment->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('ยืนยันการลบ?')">
                  @csrf
                  @method('DELETE')

                  <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </form>

              </td>
            </tr>

          @empty
            <tr>
              <td colspan="9" class="text-center text-muted">
                ไม่มีข้อมูลการรับชำระ
              </td>
            </tr>
          @endforelse

        </tbody>

      </table>


      <div class="d-flex justify-content-between align-items-center mt-3 px-3">

        <div>
          แสดง {{ $payments->firstItem() }} ถึง {{ $payments->lastItem() }}
          จาก {{ $payments->total() }} รายการ
        </div>

        <div>
          {{ $payments->links() }}
        </div>

      </div>

    </div>
  </div>

@endsection

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
