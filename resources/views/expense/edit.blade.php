@extends('layouts.app')
@section('title', 'แก้ไขรายจ่าย')

@section('content')

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/css/bootstrap-datepicker.min.css">

  <div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold mb-0">✏️ แก้ไขรายจ่าย</h4>

      <a href="{{ route('expense.index') }}" class="btn btn-outline-secondary">
        ← ย้อนกลับ
      </a>
    </div>

    <div class="glass-card p-4">

      <form method="POST" action="{{ route('expense.update', $data->id) }}" onsubmit="return prepareAmount()">

        @csrf
        @method('PUT')

        <div class="mb-3">

          <label>วันที่</label>

          <input type="text" id="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', \Carbon\Carbon::parse($data->date)->format('d/m/Y')) }}" required>

          @error('date')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror

        </div>

        <div class="mb-3">

          <label>จำนวนเงิน</label>

          <input type="text" id="amount" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', number_format($data->amount)) }}" required>

          @error('amount')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror

          <small class="text-success" id="amount_text"></small>

        </div>

        <div class="mb-4">

          <label>รายละเอียด</label>

          <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $data->description) }}</textarea>

          @error('description')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror

        </div>

        <input type="hidden" name="category_id" value="{{ $data->category_id }}">

        <button id="submitBtn" class="btn btn-primary">
          อัพเดทข้อมูล
        </button>

      </form>

    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/js/bootstrap-datepicker.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/locales/bootstrap-datepicker.th.min.js"></script>

  <script>
    $('#date').datepicker({
      format: 'dd/mm/yyyy',
      language: 'th',
      thaiyear: true,
      autoclose: true,
      todayHighlight: true
    });

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

    function prepareAmount() {

      let input = document.getElementById('amount');

      input.value = input.value.replace(/,/g, '');

      document.getElementById('submitBtn').disabled = true;

      return true;

    }

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

    if (localStorage.getItem('darkMode') === 'true') {
      document.body.classList.add('dark-mode');
    }
  </script>

@endsection
