@extends('layouts.app')
@section('title', 'Suppliers')

@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="mb-0 font-weight-bold text-danger">🏭 รายชื่อ Supplier</h3>
      <small class="text-muted">Supplier Management</small>
    </div>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-modern2 shadow-sm">
      + เพิ่ม Supplier
    </a>

  </div>

  <div class="card card-modern border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead style="background:#f8fafc;">



            <tr>

              <th>รหัสผู้ขาย</th>
              <th>ชื่อผู้ขาย</th>
              <th>เบอร์โทร</th>
              <th>อีเมล</th>
              <th width="150">จัดการ</th>

            </tr>
          </thead>

          <tbody>

            @foreach ($data as $row)
              <tr>

                <td>{{ $row->supplier_code }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->phone }}</td>
                <td>{{ $row->email }}</td>

                <td>

                  <a href="{{ route('suppliers.edit', $row->id) }}" class="btn btn-sm btn-warning">
                    Edit
                  </a>

                  <form action="{{ route('suppliers.destroy', $row->id) }}" method="POST" style="display:inline">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-sm btn-danger">
                      Delete
                    </button>

                  </form>

                </td>

              </tr>
            @endforeach

          </tbody>

        </table>

      </div>
    </div>
  </div>

@endsection
