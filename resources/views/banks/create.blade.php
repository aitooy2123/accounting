@extends('layouts.app')
@section('title', 'เพิ่มบัญชีธนาคาร')

@section('content')

  <div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold mb-0">🏦 เพิ่มบัญชีธนาคาร</h4>

      <a href="{{ route('banks.index') }}" class="btn btn-outline-secondary">
        ← ย้อนกลับ
      </a>
    </div>

    <div class="glass-card p-4">

      <form action="{{ route('banks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">

          <label>ธนาคาร</label>

          <select name="ref_bank_id" class="form-control @error('ref_bank_id') is-invalid @enderror" required>

            <option value="">-- เลือกธนาคาร --</option>

            @foreach ($refBanks as $bank)
              <option value="{{ $bank->id }}" {{ old('ref_bank_id') == $bank->id ? 'selected' : '' }}>
                {{ $bank->name }}
              </option>
            @endforeach

          </select>

          @error('ref_bank_id')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror

        </div>


        <div class="mb-3">
          <label>ชื่อบัญชี</label>

          <input type="text" name="account_name" class="form-control @error('account_name') is-invalid @enderror" value="{{ old('account_name') }}" placeholder="ชื่อเจ้าของบัญชี" required>

          @error('account_name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror

        </div>


        <div class="mb-3">
          <label>เลขบัญชี</label>

          <input type="text" name="account_number" class="form-control @error('account_number') is-invalid @enderror" value="{{ old('account_number') }}" placeholder="เช่น 123-4-56789-0" required>

          @error('account_number')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror

        </div>


        {{-- <div class="mb-4">
          <label>รูปธนาคาร</label>

          <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">

          @error('image')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror

        </div> --}}


        <button class="btn btn-primary">
          บันทึกข้อมูล
        </button>

      </form>

    </div>

  </div>

@endsection
