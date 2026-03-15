@extends('layouts.app')
@section('title', 'บัญชีธนาคาร')

@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="mb-0 font-weight-bold text-primary">🏦 บัญชีธนาคาร</h3>
      <small class="text-muted">Bank Account Management</small>
    </div>

    <a href="{{ route('banks.create') }}" class="btn btn-primary btn-modern2 shadow-sm">
      + เพิ่มบัญชี
    </a>
  </div>



  <div class="glass-card p-0 shadow-sm">

    <div class="table-responsive">

      <table class="table table-bordered table-modern align-middle mb-0 table-hover">

        <thead style="background:#f8fafc;">
          <tr>
            <th class="pl-4">ธนาคาร</th>
            <th>ชื่อบัญชี</th>
            <th>เลขบัญชี</th>
            <th class="text-center pr-4" width="150">จัดการ</th>
          </tr>
        </thead>

        <tbody>

          @forelse($banks as $bank)
            <tr>

              <td class="pl-4 align-middle">

                <div class="d-flex align-items-center">

                  <img src="{{ asset('images/banks/' . $bank->refBank->logo) }}" width="36" class="mr-2">

                  <div>
                    {{ $bank->refBank->name }}
                    <small class="text-muted">
                      ({{ $bank->refBank->code }})
                    </small>
                  </div>

                </div>

              </td>


              <td class="align-middle">
                {{ $bank->account_name }}
              </td>


              <td class="align-middle font-weight-bold">
                {{ $bank->account_number }}
              </td>


              <td class="align-middle text-nowrap text-center pr-4">

                <a href="{{ route('banks.edit', $bank->id) }}" class="btn btn-sm btn-warning mr-1">
                  แก้ไข
                </a>

                <form action="{{ route('banks.destroy', $bank->id) }}" method="POST" style="display:inline" onsubmit="return confirm('ลบข้อมูลบัญชี?')">

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
              <td colspan="4" class="text-center text-muted">
                ไม่มีข้อมูลบัญชีธนาคาร
              </td>
            </tr>
          @endforelse

        </tbody>

      </table>

    </div>

  </div>

@endsection
