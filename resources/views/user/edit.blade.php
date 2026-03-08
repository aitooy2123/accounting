@extends('layouts.app')

@section('title', 'แก้ไขผู้ใช้งาน')

@section('content')

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="mb-0 font-weight-bold text-warning">✏️ แก้ไขผู้ใช้งาน</h3>
      <small class="text-muted">Edit User</small>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">
      กลับ
    </a>
  </div>

  <div class="card card-modern border-0 shadow-sm">
    <div class="card-body">

      <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label>ชื่อผู้ใช้งาน</label>
          <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">

          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">

          @error('email')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">

          <small class="text-muted">
            ถ้าไม่ต้องการเปลี่ยนรหัสผ่านให้เว้นว่าง
          </small>

          @error('password')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <button class="btn btn-warning mt-3">
          อัพเดทข้อมูล
        </button>

      </form>

    </div>
  </div>

@endsection
