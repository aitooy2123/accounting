@extends('layouts.app')
@section('title', 'เพิ่มบัญชี')

@section('content')

  <style>
    .glass-card {
      backdrop-filter: blur(14px);
      background: rgba(255, 255, 255, 0.75);
      border-radius: 20px;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    body.dark-mode .glass-card {
      background: rgba(30, 41, 59, 0.7);
      color: #f1f5f9;
    }

    .btn-modern {
      border-radius: 50px;
      padding: 8px 28px;
      background: linear-gradient(90deg, #0ea5e9, #6366f1);
      border: none;
      color: #fff;
    }
  </style>

  <div class="container py-4">

    <h4 class="fw-bold mb-4">📘 เพิ่มบัญชี (Chart of Accounts)</h4>

    <div class="glass-card p-4">

      <form action="{{ route('accounts.store') }}" method="POST" onsubmit="disableBtn()">
        @csrf

        <div class="mb-3">
          <label>รหัสบัญชี</label>
          <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}" required>
          @error('code')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="mb-3">
          <label>ชื่อบัญชี</label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
          @error('name')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="mb-3">
          <label>ประเภท</label>
          <select name="type" class="form-control" required>
            <option value="">-- เลือกประเภท --</option>
            <option value="asset" {{ old('type') == 'asset' ? 'selected' : '' }}>สินทรัพย์</option>
            <option value="liability" {{ old('type') == 'liability' ? 'selected' : '' }}>หนี้สิน</option>
            <option value="equity" {{ old('type') == 'equity' ? 'selected' : '' }}>ทุน</option>
            <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>รายได้</option>
            <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>ค่าใช้จ่าย</option>
          </select>
        </div>

        {{-- เผื่อรองรับผังบัญชีแบบ Parent --}}
        <div class="mb-4">
          <label>บัญชีแม่ (ถ้ามี)</label>
          <select name="parent_id" class="form-control">
            <option value="">-- ไม่มี --</option>
            @isset($parents)
              @foreach ($parents as $parent)
                <option value="{{ $parent->id }}">
                  {{ $parent->code }} - {{ $parent->name }}
                </option>
              @endforeach
            @endisset
          </select>
        </div>

        <button id="submitBtn" class="btn btn-modern">
          บันทึกบัญชี
        </button>

      </form>

    </div>
  </div>

  <script>
    // ป้องกัน submit ซ้ำ
    function disableBtn() {
      document.getElementById('submitBtn').disabled = true;
    }

    // auto format code (เอาเฉพาะตัวเลข)
    document.getElementById('code').addEventListener('input', function() {
      this.value = this.value.replace(/[^0-9\-]/g, '');
    });

    // โหลด dark mode
    if (localStorage.getItem('darkMode') === 'true') {
      document.body.classList.add('dark-mode');
    }
  </script>

@endsection
