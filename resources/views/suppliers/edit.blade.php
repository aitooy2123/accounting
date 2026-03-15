@extends('layouts.app')
@section('title', 'แก้ไขข้อมูลผู้ขาย')

@section('content')

  <div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold mb-0">✏️ แก้ไขข้อมูลผู้ขาย</h4>

      <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">
        ← ย้อนกลับ
      </a>
    </div>

    <div class="glass-card p-4">

      <form method="POST" action="{{ route('suppliers.update', $row->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">

          <label>รหัสผู้ขาย</label>

          <input type="text" name="supplier_code" class="form-control @error('supplier_code') is-invalid @enderror" value="{{ old('supplier_code', $row->supplier_code) }}">

          @error('supplier_code')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror

        </div>

        <div class="mb-3">

          <label>ชื่อผู้ขาย</label>

          <input type="text" name="name" required class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $row->name) }}">

          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror

        </div>

        <div class="mb-3">

          <label>เบอร์โทรศัพท์</label>

          <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $row->phone) }}">

          @error('phone')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror

        </div>

        <div class="mb-3">

          <label>อีเมล</label>

          <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $row->email) }}">

          @error('email')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror

        </div>

        <div class="mb-4">

          <label>ที่อยู่</label>

          <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $row->address) }}</textarea>

          @error('address')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror

        </div>

        <button class="btn btn-primary">
          อัปเดตข้อมูล
        </button>

      </form>

    </div>

  </div>

@endsection
