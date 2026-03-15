@extends('layouts.app')
@section('title', 'แก้ไขบัญชีธนาคาร')

@section('content')

<div class="container py-5">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">✏️ แก้ไขบัญชีธนาคาร</h4>

    <a href="{{ route('banks.index') }}" class="btn btn-outline-secondary">
      ← ย้อนกลับ
    </a>
  </div>

  <div class="glass-card p-4">

    <form action="{{ route('banks.update',$bank->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-3">

        <label>ธนาคาร</label>

        <select name="ref_bank_id" class="form-control @error('ref_bank_id') is-invalid @enderror" required>

          <option value="">-- เลือกธนาคาร --</option>

          @foreach ($refBanks as $refBank)
            <option value="{{ $refBank->id }}"
              {{ old('ref_bank_id',$bank->ref_bank_id) == $refBank->id ? 'selected' : '' }}>
              {{ $refBank->name }}
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

        <input type="text"
          name="account_name"
          class="form-control @error('account_name') is-invalid @enderror"
          value="{{ old('account_name',$bank->account_name) }}"
          required>

        @error('account_name')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>


      <div class="mb-3">
        <label>เลขบัญชี</label>

        <input type="text"
          name="account_number"
          class="form-control @error('account_number') is-invalid @enderror"
          value="{{ old('account_number',$bank->account_number) }}"
          required>

        @error('account_number')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>


      <button class="btn btn-warning">
        อัปเดตข้อมูล
      </button>

    </form>

  </div>

</div>

@endsection
