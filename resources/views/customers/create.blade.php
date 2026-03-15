@extends('layouts.app')
@section('title', 'เพิ่มลูกค้า')

@section('content')

  <div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold mb-0">👤 เพิ่มลูกค้า</h4>

      <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
        ← ย้อนกลับ
      </a>
    </div>

    <div class="glass-card p-4">

      <form method="POST" action="{{ route('customers.store') }}">
        @csrf

        <div class="mb-3">
          <label>รหัสลูกค้า</label>

          <input type="text" name="customer_code" class="form-control @error('customer_code') is-invalid @enderror" placeholder="เช่น CUS001" value="{{ old('customer_code') }}">

          @error('customer_code')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="mb-3">
          <label>ชื่อลูกค้า</label>

          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="ชื่อบริษัท / ชื่อลูกค้า" value="{{ old('name') }}" required>

          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="mb-3">
          <label>โทรศัพท์</label>

          <input type="text" name="phone" class="form-control" placeholder="เช่น 0812345678" value="{{ old('phone') }}">
        </div>

        <div class="mb-3">
          <label>Email</label>

          <input type="text" name="email" class="form-control" placeholder="example@email.com" value="{{ old('email') }}">
        </div>

        <div class="mb-4">
          <label>ที่อยู่</label>

          <textarea name="address" rows="3" class="form-control" placeholder="ที่อยู่ลูกค้า">{{ old('address') }}</textarea>

        </div>

        <button class="btn btn-primary">
          บันทึกข้อมูล
        </button>

      </form>

    </div>
  </div>

@endsection
