@extends('layouts.app')
@section('title', 'เพิ่ม Supplier')

@section('content')

  <div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold mb-0">🏭 เพิ่ม Supplier</h4>

      <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">
        ← ย้อนกลับ
      </a>
    </div>

    <div class="glass-card p-4">

      <form method="POST" action="{{ route('suppliers.store') }}">
        @csrf

        <div class="mb-3">

          <label>Supplier Code</label>

          <input type="text" name="supplier_code" class="form-control" placeholder="เช่น SUP001" value="{{ old('supplier_code') }}">

        </div>

        <div class="mb-3">

          <label>Supplier Name</label>

          <input type="text" name="name" class="form-control" required value="{{ old('name') }}">

        </div>

        <div class="mb-3">

          <label>Phone</label>

          <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">

        </div>

        <div class="mb-3">

          <label>Email</label>

          <input type="text" name="email" class="form-control" value="{{ old('email') }}">

        </div>

        <div class="mb-4">

          <label>Address</label>

          <textarea name="address" rows="3" class="form-control">{{ old('address') }}</textarea>

        </div>

        <button class="btn btn-primary">
          บันทึกข้อมูล
        </button>

      </form>

    </div>

  </div>

@endsection
