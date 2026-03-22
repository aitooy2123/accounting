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
  <div class="row">

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

  <form method="GET" class="mb-3">
    <div class="row">

      {{-- ค้นหาหมวด --}}
      <div class="col-md-3">
        <input type="text" name="category" value="{{ request('category') }}" class="form-control" placeholder="🔍 หมวดหมู่">
      </div>

      {{-- วันที่เริ่ม --}}
      <div class="col-md-2">
        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="form-control">
      </div>

      {{-- วันที่สิ้นสุด --}}
      <div class="col-md-2">
        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="form-control">
      </div>

      {{-- จำนวนเงิน --}}
      <div class="col-md-2">
        <input type="number" name="amount" value="{{ request('amount') }}" class="form-control" placeholder="💰 จำนวนเงิน">
      </div>

      <div class="col-md-3 d-flex">
        <button class="btn btn-primary mr-2">
          🔍 ค้นหา
        </button>

        <a href="{{ route('income.index') }}" class="btn btn-secondary">
          รีเซ็ต
        </a>
      </div>

    </div>
  </form>

  <div class="card-glass p-0">

    <div class="table-responsive">

      <table class="table table-borderless table-modern mb-0 table-hover">

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

                {{-- EDIT --}}
                <a href="{{ route('income.edit', $row->id) }}" class="btn btn-sm btn-warning mr-1" data-toggle="tooltip" data-placement="top" title="แก้ไขรายการ">
                  <i class="fas fa-edit"></i>
                </a>

                {{-- DELETE --}}
                <form method="POST" action="{{ route('income.destroy', $row->id) }}" style="display:inline;">
                  @csrf
                  @method('DELETE')

                  <button type="button" class="btn btn-sm btn-danger btn-delete" data-toggle="tooltip" data-placement="top" title="ลบรายการ">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </form>

              </td>

            </tr>

          @empty

            <tr>
              <td colspan="8" class="text-center text-muted">
                ไม่มีข้อมูลรายรับ
              </td>
            </tr>
          @endforelse

        </tbody>

      </table>


      <div class="d-flex justify-content-between align-items-center mt-3 px-3">

        <div>
          แสดง {{ $data->firstItem() }} ถึง {{ $data->lastItem() }}
          จาก {{ $data->total() }} รายการ
        </div>

        <div>
          {{ $data->links() }}
        </div>

      </div>
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

@section('scripts')
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Bootstrap 4 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(function() {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>

  <script>
    $(document).on('click', '.btn-delete', function() {

      let form = $(this).closest('form');

      Swal.fire({
        title: 'ยืนยันการลบ?',
        text: "ข้อมูลจะถูกลบถาวร!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'ลบเลย',
        cancelButtonText: 'ยกเลิก',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });

    });
  </script>


  <script>
    let dateFrom = document.getElementById('date_from');
    let dateTo = document.getElementById('date_to');

    function updateDateToMin() {
      if (dateFrom.value) {
        dateTo.min = dateFrom.value;

        // ถ้า date_to น้อยกว่า date_from → reset
        if (dateTo.value && dateTo.value < dateFrom.value) {
          dateTo.value = dateFrom.value;
        }
      }
    }

    dateFrom.addEventListener('change', updateDateToMin);

    // โหลดครั้งแรก
    window.onload = updateDateToMin;
  </script>
@endsection
