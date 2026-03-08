@extends('layouts.app')
@section('title', 'เพิ่มรายรับ')

@section('content')

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/css/bootstrap-datepicker.min.css">

  <div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold mb-0">💰 เพิ่มรายรับ</h4>

      <a href="{{ route('expense.index') }}" class="btn btn-outline-secondary">
        ← ย้อนกลับ
      </a>
    </div>

    <div class="glass-card p-4">

      <form method="POST" action="{{ route('expense.store') }}" onsubmit="return prepareAmount()">
        @csrf

        <div class="mb-3">
          <label>วันที่</label>

          <input type="text" id="date" name="date" class="form-control @error('date') is-invalid @enderror" placeholder="เลือกวันที่" value="{{ old('date') }}" required>

          @error('date')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror

        </div>

        <div class="mb-3">

          <label>จำนวนเงิน</label>

          <input type="text" id="amount" name="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="เช่น 1,500" value="{{ old('amount') }}" required>

          @error('amount')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror

          <small class="text-success" id="amount_text"></small>

        </div>

        <div class="mb-4">

          <label>รายละเอียด</label>

          <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="เช่น รายรับจากการขายสินค้า">{{ old('description') }}</textarea>

          @error('description')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror

        </div>

        <input type="hidden" name="category_id" value="2">

        <button id="submitBtn" class="btn btn-primary">
          บันทึกข้อมูล
        </button>

      </form>

    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/js/bootstrap-datepicker.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/locales/bootstrap-datepicker.th.min.js"></script>

  <script>
    // Datepicker TH
    $('#date').datepicker({
      format: 'dd/mm/yyyy',
      language: 'th',
      thaiyear: true,
      autoclose: true,
      todayHighlight: true
    });


    // format เงิน
    const amountInput = document.getElementById('amount');
    const textBox = document.getElementById('amount_text');

    amountInput.addEventListener('input', function(e) {

      let value = e.target.value.replace(/,/g, '');

      if (!isNaN(value) && value !== '') {
        e.target.value = Number(value).toLocaleString('en-US');
        textBox.innerText = numberToThaiText(value);
      } else {
        textBox.innerText = '';
      }

    });


    // ลบ comma ก่อน submit
    function prepareAmount() {

      let input = document.getElementById('amount');

      input.value = input.value.replace(/,/g, '');

      document.getElementById('submitBtn').disabled = true;

      return true;

    }


    // แปลงเลขเป็นตัวหนังสือ
    function numberToThaiText(num) {

      num = parseInt(num);

      if (!num) return '';

      const txtnum = ["ศูนย์", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า"];
      const txtdigit = ["", "สิบ", "ร้อย", "พัน", "หมื่น", "แสน", "ล้าน"];

      let result = '';
      let i = 0;

      while (num > 0) {

        let n = num % 10;

        if (i == 1 && n == 1) {
          result = "สิบ" + result;
        } else if (i == 1 && n == 2) {
          result = "ยี่สิบ" + result;
        } else if (i > 0 && n == 1) {
          result = "เอ็ด" + txtdigit[i] + result;
        } else if (n > 0) {
          result = txtnum[n] + txtdigit[i] + result;
        }

        num = Math.floor(num / 10);
        i++;

      }

      return result + "บาท";

    }


    // dark mode
    if (localStorage.getItem('darkMode') === 'true') {
      document.body.classList.add('dark-mode');
    }
  </script>

@endsection
