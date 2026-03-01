@extends('layouts.app')
@section('title', 'เพิ่มรายรับ')

@section('content')

  <style>
    :root {
      --bg-light: #f1f5f9;
      --bg-dark: #0f172a;
      --card-light: rgba(255, 255, 255, 0.75);
      --card-dark: rgba(30, 41, 59, 0.7);
    }

    body.dark-mode {
      background: var(--bg-dark);
      color: #f1f5f9;
    }

    .glass-card {
      backdrop-filter: blur(14px);
      -webkit-backdrop-filter: blur(14px);
      background: var(--card-light);
      border-radius: 20px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      transition: all .3s ease;
    }

    body.dark-mode .glass-card {
      background: var(--card-dark);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .input-modern {
      border-radius: 12px;
      transition: .2s;
    }

    .input-modern:focus {
      border-color: #6366f1;
      box-shadow: 0 0 0 3px rgba(99, 102, 241, .2);
    }

    .btn-modern {
      border-radius: 50px;
      padding: 8px 28px;
      background: linear-gradient(90deg, #3b82f6, #6366f1);
      border: none;
      transition: .3s;
      color: #fff;
    }

    .btn-modern:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 20px rgba(99, 102, 241, .3);
    }
  </style>

  <div class="container py-5">

    <h4 class="fw-bold mb-4">💰 เพิ่มรายรับ</h4>

    <div class="glass-card p-4">

      <form method="POST" action="{{ route('income.store') }}" onsubmit="disableBtn()">
        @csrf

        <div class="mb-3">
          <label>วันที่</label>
          <input type="date" name="date" class="form-control input-modern" value="{{ old('date') }}" required autofocus>
          @error('date')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="mb-3">
          <label>หมวดหมู่</label>
          <select name="category_id" class="form-control input-modern" required>
            <option value="">-- เลือกหมวดหมู่ --</option>
            @foreach ($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label>จำนวนเงิน</label>
          <input type="text" id="amount" name="amount" class="form-control input-modern" value="{{ old('amount') }}" required>
          @error('amount')
            <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="mb-4">
          <label>รายละเอียด</label>
          <input type="text" name="description" class="form-control input-modern" value="{{ old('description') }}">
        </div>

        <button id="submitBtn" class="btn btn-modern">
          บันทึกข้อมูล
        </button>

      </form>

    </div>
  </div>

  <script>
    // ป้องกันกดซ้ำ
    function disableBtn() {
      document.getElementById('submitBtn').disabled = true;
    }

    // format เงิน realtime
    document.getElementById('amount').addEventListener('input', function(e) {
      let value = e.target.value.replace(/,/g, '');
      if (!isNaN(value) && value !== '') {
        e.target.value = Number(value).toLocaleString('en-US');
      }
    });

    // dark mode load
    if (localStorage.getItem('darkMode') === 'true') {
      document.body.classList.add('dark-mode');
    }
  </script>

@endsection
