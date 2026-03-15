@extends('layouts.app')

@section('title', 'บัญชีธนาคาร')

@section('content')

  <div class="container py-4">

    <div class="d-flex justify-content-between mb-3">
      <h4>บัญชีธนาคาร</h4>

      <a href="{{ route('banks.create') }}" class="btn btn-primary">
        เพิ่มบัญชี
      </a>
    </div>

    <div class="card">
      <div class="card-body p-0">

        <table class="table table-bordered mb-0">

          <thead class="thead-light">
            <tr>
              <th width="80">Logo</th>
              <th>ธนาคาร</th>
              <th>ชื่อบัญชี</th>
              <th>เลขบัญชี</th>
              <th width="150">จัดการ</th>
            </tr>
          </thead>

          <tbody>

            @forelse($banks as $bank)
              <tr>

                <td>
                  <img src="{{ asset('images/banks/' . $bank->refBank->logo) }}" width="40">
                </td>

                <td>
                  {{ $bank->refBank->name }}
                </td>

                <td>
                  {{ $bank->account_name }}
                </td>

                <td>
                  {{ $bank->account_number }}
                </td>

                <td>

                  <a href="{{ route('banks.edit', $bank->id) }}" class="btn btn-sm btn-warning">
                    แก้ไข
                  </a>

                  <form action="{{ route('banks.destroy', $bank->id) }}" method="POST" style="display:inline">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-sm btn-danger" onclick="return confirm('ลบข้อมูล?')">
                      ลบ
                    </button>

                  </form>

                </td>

              </tr>

            @empty

              <tr>
                <td colspan="5" class="text-center">
                  ไม่มีข้อมูล
                </td>
              </tr>
            @endforelse

          </tbody>

        </table>

      </div>
    </div>

  </div>

@endsection
