@extends('layouts.app')
@section('title', 'ใบแจ้งหนี้')

@section('content')
  <!-- Bootstrap 4 CSS -->
  {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/css/bootstrap.min.css"> --}}

  <!-- Font Awesome Free CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="mb-0 font-weight-bold text-primary">🧾 รายการใบแจ้งหนี้</h3>
      <small class="text-muted">Invoice Management</small>
    </div>

    <a href="{{ route('invoice.create') }}" class="btn btn-primary btn-modern2 shadow-sm">
      + สร้างใบแจ้งหนี้
    </a>

  </div>

  {{-- Summary --}}
  <div class="row">
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


  <div class="mb-3">
    <form method="GET" action="{{ route('invoice.index') }}" class="form-inline">
      <div class="form-group mr-2">
        <input type="text" name="customer" class="form-control" placeholder="ชื่อลูกค้า" value="{{ request('customer') }}">
      </div>

      <div class="form-group mr-2">
        <select name="status" class="form-control">
          <option value="" {{ request('status') === null ? 'selected' : '' }}>สถานะทั้งหมด</option>
          <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>ชำระครบ</option>
          <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>เกินกำหนด</option>
          <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>ค้างชำระ</option>
        </select>
      </div>

      <div class="form-group mr-2">
        <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
        <span class="mx-1">ถึง</span>
        <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
      </div>

      <button type="submit" class="btn btn-primary">กรอง</button>
      <a href="{{ route('invoice.index') }}" class="btn btn-secondary ml-1">รีเซ็ต</a>
    </form>
  </div>
  <div class="card-glass p-0">

    <div class="table-responsive">
      <table class="table table-borderless table-modern mb-0  table-hover">
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

              <td>{{ $row->customer->name ?? 'N/A' }}</td>

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
                <span class="badge badge-info" style="background:{{ $color }}">
                  {{ $status }}
                </span>
              </td>
              <td class="text-center text-nowrap">

                <!-- ใบเสนอราคา -->
                <a href="" class="btn btn-sm btn-success mr-1" data-toggle="tooltip" title="ใบเสนอราคา">
                  <i class="fas fa-file-invoice"></i> <!-- FA Free icon -->
                </a>

                <!-- แก้ไข -->
                <a href="{{ route('invoice.edit', $row->id) }}" class="btn btn-sm btn-warning mr-1" data-toggle="tooltip" title="แก้ไข">
                  <i class="fas fa-pen-square"></i>
                </a>

                {{-- ดู (commented out) --}}
                {{--
  <a href="{{ route('invoice.show', $row->id) }}" class="btn btn-sm btn-info mr-1" data-toggle="tooltip" title="ดู">
    <i class="fas fa-eye"></i>
  </a>
  --}}

                <!-- ลบ -->
                <form method="POST" action="{{ route('invoice.destroy', $row->id) }}" style="display:inline;" onsubmit="confirmDelete(this)">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger" data-toggle="tooltip" title="ลบ">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>

              </td>
            </tr>

          @empty
            <tr>
              <td colspan="8" class="text-center text-muted">
                ไม่มีข้อมูลใบแจ้งหนี้
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

@section('script')

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

  <!-- Bootstrap 4 JS -->
  {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.min.js"></script> --}}

  <!-- เรียกใช้งาน Tooltip -->
  <script>
    $(function() {
      $('[data-toggle="tooltip"]').tooltip();
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
