```blade
@extends('layouts.app')
@section('title', 'เพิ่มผู้ใช้งาน')

@section('content')

  <div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

      <div>
        <h4 class="fw-bold mb-0">👤 เพิ่มผู้ใช้งาน</h4>
        <small class="text-muted">Create User</small>
      </div>

      <a href="{{ route('users.index') }}" class="btn btn-secondary">
        กลับ
      </a>

    </div>

    <div class="glass-card p-4">

      <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label class="form-label">ชื่อผู้ใช้งาน</label>

          <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>

          @error('name')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>

          <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>

          @error('email')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
        </div>

        <div class="mb-4">
          <label class="form-label">Password</label>

          <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>

          @error('password')
            <small class="text-danger">
              {{ $message }}
            </small>
          @enderror
        </div>

        <div class="text-end">
          <button id="submitBtn" class="btn btn-modern">
            บันทึกข้อมูล
          </button>
        </div>

      </form>

    </div>

  </div>

  <script>
    // ป้องกัน submit ซ้ำ
    document.querySelector("form").addEventListener("submit", function() {
      document.getElementById("submitBtn").disabled = true;
    })
  </script>

@endsection
```
