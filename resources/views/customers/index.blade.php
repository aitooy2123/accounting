@extends('layouts.app')
@section('title', 'ลูกค้า')

@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="mb-0 font-weight-bold text-primary">👤 ลูกค้า</h3>
      <small class="text-muted">Customer Management</small>
    </div>

    <a href="{{ route('customers.create') }}" class="btn btn-primary btn-modern2 shadow-sm">
      + เพิ่มลูกค้า
    </a>
  </div>

  <div class="glass-card p-0 shadow-sm">
    <div class="table-responsive">
      <table class="table table-bordered table-modern align-middle mb-0 table-hover">
        <thead style="background:#f8fafc;">
          <tr>
            <th class="pl-4">รหัส</th>
            <th>ชื่อลูกค้า</th>
            <th>โทรศัพท์</th>
            <th>Email</th>
            <th class="text-center pr-4" width="150">จัดการ</th>
          </tr>
        </thead>

        <tbody>

          @forelse($data as $row)
            <tr>

              <td class="pl-4">{{ $row->customer_code }}</td>

              <td>{{ $row->name }}</td>

              <td>{{ $row->phone }}</td>

              <td>{{ $row->email }}</td>

              <td class="text-center text-nowrap pr-4">

                <a href="{{ route('customers.edit', $row->id) }}" class="btn btn-sm btn-warning mr-1">
                  แก้ไข
                </a>

                <form action="{{ route('customers.destroy', $row->id) }}" method="POST" style="display:inline;">
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
              <td colspan="5" class="text-center py-4 text-muted">
                ไม่มีข้อมูลลูกค้า
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
