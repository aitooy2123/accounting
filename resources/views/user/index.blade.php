@extends('layouts.app')

@section('title', 'ผู้ใช้งาน')

@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="mb-0 font-weight-bold text-primary">👤 ผู้ใช้งานระบบ</h3>
      <small class="text-muted">User Management</small>
    </div>

    <a href="{{ route('users.create') }}" class="btn btn-primary btn-modern shadow-sm">
      + เพิ่มผู้ใช้งาน
    </a>
  </div>


  <div class="card card-modern border-0 shadow-sm">
    <div class="card-body p-0">

      <div class="table-responsive">

        <table class="table table-bordered table-modern align-middle mb-0 table-striped">

          <thead>
            <tr>
              <th class="pl-4">#</th>
              <th>ชื่อ</th>
              <th>Email</th>
              <th class="text-center pr-4" width="160">จัดการ</th>
            </tr>
          </thead>

          <tbody>

            @forelse($users as $key => $user)
              <tr>

                <td class="pl-4 align-middle">
                  <span class="badge badge-light">
                    {{ $key + 1 }}
                  </span>
                </td>

                <td class="align-middle font-weight-bold">
                  {{ $user->name }}
                </td>

                <td class="align-middle">
                  {{ $user->email }}
                </td>

                <td class="align-middle text-center pr-4">

                  <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning mr-1">
                    แก้ไข
                  </a>

                  <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline;" class="delete-form">
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
                <td colspan="4" class="text-center py-4 text-muted">
                  ไม่มีข้อมูลผู้ใช้งาน
                </td>
              </tr>
            @endforelse

          </tbody>

        </table>

      </div>

    </div>
  </div>

@endsection

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
