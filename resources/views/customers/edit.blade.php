@extends('layouts.app')
@section('title', 'แก้ไขลูกค้า')

@section('content')

  <div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold mb-0">✏️ แก้ไขลูกค้า</h4>

      <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
        ← ย้อนกลับ
      </a>
    </div>

    <div class="glass-card p-4">

      <form method="POST" action="{{ route('customers.update', $row->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label>รหัสลูกค้า</label>

          <input type="text" name="customer_code" class="form-control" value="{{ $row->customer_code }}">
        </div>

        <div class="mb-3">
          <label>ชื่อลูกค้า</label>

          <input type="text" name="name" class="form-control" value="{{ $row->name }}" required>
        </div>

        <div class="mb-3">
          <label>โทรศัพท์</label>

          <input type="text" name="phone" class="form-control" value="{{ $row->phone }}">
        </div>

        <div class="mb-3">
          <label>Email</label>

          <input type="text" name="email" class="form-control" value="{{ $row->email }}">
        </div>

        <div class="mb-4">
          <label>ที่อยู่</label>

          <textarea name="address" rows="3" class="form-control">{{ $row->address }}</textarea>
        </div>

        <button class="btn btn-primary">
          อัพเดทข้อมูล
        </button>

      </form>

    </div>
  </div>

@endsection
