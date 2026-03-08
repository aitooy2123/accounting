@extends('layouts.app')
@section('title', 'รายรับ')

@php
  $totalAmount = 0;
  $totalVat = 0;
  $totalGrand = 0;

  foreach ($data ?? [] as $row) {
      $date = \Carbon\Carbon::parse($row->date);
      $vatRate = $date->year >= 2026 ? 0.1 : 0.07;

      $vat = $row->amount * $vatRate;
      $grand = $row->amount + $vat;

      $totalAmount += $row->amount;
      $totalVat += $vat;
      $totalGrand += $grand;
  }
@endphp

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

    <div>
      <h3 class="mb-0 font-weight-bold text-success">📥 รายการรายรับ</h3>
      <small class="text-muted">Income Management (Auto VAT)</small>
    </div>

    <a href="{{ route('income.create') }}" class="btn  btn-primary shadow-sm">
      + เพิ่มรายรับ
    </a>

  </div>


  {{-- SUMMARY --}}
  <div class="row mb-4">

    <div class="col-md-4 mb-3">
      <div class="card-glass p-4 text-white" style="background:linear-gradient(135deg,#10b981,#34d399)">
        <h6>ยอดรวมก่อน VAT</h6>
        <h3>฿ {{ number_format($totalAmount, 2) }}</h3>
      </div>
    </div>

    <div class="col-md-4 mb-3">
      <div class="card-glass p-4 text-white" style="background:linear-gradient(135deg,#f59e0b,#fbbf24)">
        <h6>VAT รวม</h6>
        <h3>฿ {{ number_format($totalVat, 2) }}</h3>
      </div>
    </div>

    <div class="col-md-4 mb-3">
      <div class="card-glass p-4 text-white" style="background:linear-gradient(135deg,#6366f1,#818cf8)">
        <h6>ยอดสุทธิรวม</h6>
        <h3>฿ {{ number_format($totalGrand, 2) }}</h3>
      </div>
    </div>

  </div>


  <div class="card-glass p-0">

    <div class="table-responsive">

      <table class="table table-borderless table-modern mb-0">

        <thead style="background:#f1f5f9;">
          <tr>
            <th class="pl-4">วันที่</th>
            <th>หมวดหมู่</th>
            <th>จำนวนเงิน</th>
            <th>VAT</th>
            <th>VAT Amount</th>
            <th>รวมสุทธิ</th>
            {{-- <th>รายละเอียด</th> --}}
            <th class="text-center pr-4" width="150">จัดการ</th>
          </tr>
        </thead>


        <tbody>

          @forelse($data ?? [] as $row)
            @php
              $date = \Carbon\Carbon::parse($row->date);
              $vatRate = $date->year >= 2026 ? 0.1 : 0.07;

              $vat = $row->amount * $vatRate;
              $grand = $row->amount + $vat;
            @endphp

            <tr>

              <td class="pl-4 align-middle">
                {{ $date->format('d/m/Y') }}
              </td>

              <td class="align-middle">
                <span class="badge-modern">
                  {{ $row->category->name ?? '-' }}
                </span>
              </td>

              <td class="align-middle font-weight-bold text-success">
                ฿ {{ number_format($row->amount, 2) }}
              </td>

              <td class="align-middle text-info font-weight-bold">
                +{{ $vatRate * 100 }}%
              </td>

              <td class="align-middle text-warning font-weight-bold">
                ฿ {{ number_format($vat, 2) }}
              </td>

              <td class="align-middle font-weight-bold text-primary">
                ฿ {{ number_format($grand, 2) }}
              </td>

              {{-- <td class="align-middle text-muted">
                {{ $row->description }}
              </td> --}}

              <td class="align-middle text-center pr-4 text-nowrap">

                <a href="{{ route('income.edit', $row->id) }}" class="btn btn-sm btn-warning  mr-1">
                  แก้ไข
                </a>

                <form method="POST" action="{{ route('income.destroy', $row->id) }}" style="display:inline;">
                  @csrf
                  @method('DELETE')

                  <button type="button" class="btn btn-sm btn-danger  btn-delete">
                    ลบ
                  </button>

                </form>

              </td>

            </tr>

          @empty

            <tr>
              <td colspan="8" class="text-center py-5 text-muted">
                ไม่มีข้อมูลรายรับ
              </td>
            </tr>
          @endforelse

        </tbody>

      </table>

    </div>

  </div>

@endsection



@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {

      const buttons = document.querySelectorAll('.btn-delete');

      buttons.forEach(btn => {

        btn.addEventListener('click', function() {

          const form = this.closest('form');

          Swal.fire({
            title: 'ยืนยันการลบ?',
            text: 'ข้อมูลนี้จะไม่สามารถกู้คืนได้',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'ลบเลย',
            cancelButtonText: 'ยกเลิก'
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit();
            }
          });

        });

      });

    });
  </script>
@endpush
