@extends('layouts.app')
@section('title', 'รายรับ')

@section('content')

  <style>
    :root {
      --primary: #6366f1;
      --success: #10b981;
    }

    body.dark-mode {
      background: #0f172a;
      color: #f1f5f9;
    }

    .card-glass {
      background: rgba(255, 255, 255, .75);
      backdrop-filter: blur(14px);
      border-radius: 18px;
      border: 1px solid rgba(255, 255, 255, .3);
      box-shadow: 0 15px 35px rgba(0, 0, 0, .08);
      transition: .3s;
    }

    body.dark-mode .card-glass {
      background: rgba(30, 41, 59, .7);
      border: 1px solid rgba(255, 255, 255, .08);
    }

    .card-glass:hover {
      transform: translateY(-4px);
    }

    .table-modern tbody tr {
      transition: .2s;
    }

    .table-modern tbody tr:hover {
      background: rgba(99, 102, 241, .05);
    }

    .badge-modern {
      padding: 6px 14px;
      border-radius: 50px;
      font-size: 12px;
      font-weight: 500;
      background: rgba(99, 102, 241, .1);
      color: #6366f1;
    }

    .btn-modern {
      border-radius: 50px;
      padding: 6px 16px;
      font-weight: 500;
    }
  </style>

  @php
    $totalAmount = 0;
    $totalVat = 0;
    $totalGrand = 0;

    foreach ($data ?? [] as $row) {
        $vat = $row->amount * 0.07;
        $grand = $row->amount + $vat;

        $totalAmount += $row->amount;
        $totalVat += $vat;
        $totalGrand += $grand;
    }
  @endphp

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="mb-0 font-weight-bold text-success">📥 รายการรายรับ</h3>
      <small class="text-muted">Income Management (VAT 7%)</small>
    </div>

    <a href="{{ route('income.create') }}" class="btn btn-primary btn-modern shadow-sm">
      + เพิ่มรายรับ
    </a>
  </div>

  {{-- Summary --}}
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card-glass p-4 text-white" style="background:linear-gradient(135deg,#10b981,#34d399)">
        <h6>ยอดรวมก่อน VAT</h6>
        <h3>฿ {{ number_format($totalAmount, 2) }}</h3>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card-glass p-4 text-white" style="background:linear-gradient(135deg,#f59e0b,#fbbf24)">
        <h6>VAT รวม</h6>
        <h3>฿ {{ number_format($totalVat, 2) }}</h3>
      </div>
    </div>

    <div class="col-md-4">
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
            <th>VAT 7%</th>
            <th>รวมสุทธิ</th>
            <th>รายละเอียด</th>
            <th class="text-center pr-4" width="150">จัดการ</th>
          </tr>
        </thead>

        <tbody>
          @forelse($data ?? [] as $row)
            @php
              $vat = $row->amount * 0.07;
              $grand = $row->amount + $vat;
            @endphp

            <tr>
              <td class="pl-4 align-middle">
                {{ \Carbon\Carbon::parse($row->date)->format('d/m/Y') }}
              </td>

              <td class="align-middle">
                <span class="badge-modern">
                  {{ $row->category->name ?? '-' }}
                </span>
              </td>

              <td class="align-middle font-weight-bold text-success">
                ฿ {{ number_format($row->amount, 2) }}
              </td>

              <td class="align-middle text-warning font-weight-bold">
                ฿ {{ number_format($vat, 2) }}
              </td>

              <td class="align-middle font-weight-bold text-primary">
                ฿ {{ number_format($grand, 2) }}
              </td>

              <td class="align-middle text-muted">
                {{ $row->description }}
              </td>

              <td class="align-middle text-center pr-4 text-nowrap">
                <a href="{{ route('income.edit', $row->id) }}" class="btn btn-sm btn-outline-warning btn-modern mr-1">
                  แก้ไข
                </a>

                <form method="POST" action="{{ route('income.destroy', $row->id) }}" style="display:inline;" class="delete-form">
                  @csrf
                  @method('DELETE')
                  <button type="button" class="btn btn-sm btn-outline-danger btn-modern btn-delete">
                    ลบ
                  </button>
                </form>
              </td>
            </tr>

          @empty
            <tr>
              <td colspan="7" class="text-center py-5 text-muted">
                ไม่มีข้อมูลรายรับ
              </td>
            </tr>
          @endforelse

        </tbody>
      </table>
    </div>
  </div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {

    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
      button.addEventListener('click', function() {

        const form = this.closest('form');

        Swal.fire({
          title: 'ยืนยันการลบ?',
          text: "ข้อมูลนี้จะไม่สามารถกู้คืนได้",
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

@if (session('success'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {

      Swal.fire({
        icon: 'success',
        title: 'สำเร็จ',
        text: '{{ session('success') }}',
        confirmButtonColor: '#10b981'
      });

    });
  </script>
@endif
