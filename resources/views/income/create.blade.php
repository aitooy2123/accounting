@extends('layouts.app')
@section('title', 'เพิ่มรายรับ')

@section('content')

  <div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

      <h4 class="fw-bold mb-0">💰 เพิ่มรายรับ</h4>

      <a href="{{ route('income.index') }}" class="btn btn-outline-secondary">
        ← ย้อนกลับ
      </a>

    </div>
    
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="glass-card p-4">

      <form method="POST" action="{{ route('income.store') }}">
        @csrf

        <div class="row">

          {{-- วันที่ --}}
          <div class="col-md-6 mb-3">
            <label>วันที่</label>
            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', date('Y-m-d')) }}" required>
          </div>

          {{-- หมวดหมู่ --}}
          <div class="col-md-6 mb-3">
            <label>หมวดหมู่</label>
            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>

              <option value="">-- เลือกหมวดหมู่ --</option>

              @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                  {{ $cat->name }}
                </option>
              @endforeach

            </select>
          </div>

          {{-- จำนวนเงิน --}}
          <div class="col-md-6 mb-3">
            <label>จำนวนเงิน (บาท)</label>

            <input type="text" id="amount_display" class="form-control @error('amount') is-invalid @enderror" placeholder="0.00" value="{{ old('amount') ? number_format(old('amount'), 2) : '' }}" required>

            <input type="hidden" name="amount" id="amount_real" value="{{ old('amount') }}">
          </div>

          {{-- รายละเอียด --}}
          <div class="col-md-12 mb-4">
            <label>รายละเอียด</label>

            <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="เช่น รายรับจากการขายสินค้า / ค่าบริการ..." required>{{ old('description') }}</textarea>
          </div>

        </div>

        <div class="d-flex justify-content-end">
          {{-- <a href="{{ route('income.index') }}" class="btn btn-secondary mr-2">
            ยกเลิก
          </a> --}}

          <button class="btn btn-modern">
            บันทึกรายรับ
          </button>
        </div>

      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {

      const display = document.getElementById('amount_display');
      const real = document.getElementById('amount_real');

      function formatNumber(value) {
        return Number(value).toLocaleString('en-US', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });
      }

      display.addEventListener('focus', function() {
        this.value = this.value.replace(/,/g, '');
      });

      display.addEventListener('blur', function() {
        let value = this.value.replace(/,/g, '');
        if (!isNaN(value) && value !== '') {
          real.value = parseFloat(value);
          this.value = formatNumber(value);
        } else {
          real.value = '';
          this.value = '';
        }
      });

      if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
      }

    });
  </script>

@endsection
