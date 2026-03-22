@extends('layouts.app')

@section('title', 'แก้ไขรับชำระเงิน')

@section('content')

  <style>
    .glass-card {
      backdrop-filter: blur(14px);
      background: rgba(255, 255, 255, 0.75);
      border-radius: 20px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      transition: .3s;
    }

    body.dark-mode .glass-card {
      background: rgba(30, 41, 59, 0.7);
      color: #f1f5f9;
    }

    .btn-modern {
      border-radius: 50px;
      padding: 8px 28px;
      background: linear-gradient(90deg, #f59e0b, #fbbf24);
      border: none;
      color: #fff;
    }

    .is-invalid {
      border: 1px solid red;
      background-color: #fee2e2;
    }
  </style>

  <div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold mb-4">✏️ แก้ไขการรับชำระ</h4>

      <a href="{{ route('payment.index') }}" class="btn btn-outline-secondary">
        ← ย้อนกลับ
      </a>
    </div>

    <div class="glass-card p-4">

      <form action="{{ route('payment.update', $payment->id) }}" method="POST" onsubmit="disableBtn()">
        @csrf
        @method('PUT')

        {{-- Invoice --}}
        <div class="mb-3">
          <label>เลือก Invoice</label>

          <select name="invoice_id" id="invoiceSelect" class="form-control @error('invoice_id') is-invalid @enderror" required>

            @foreach ($invoices as $inv)
              @php
                $paidWithoutCurrent = $inv->payments->where('id', '!=', $payment->id)->sum('amount');
              @endphp

              <option value="{{ $inv->id }}" data-total="{{ $inv->total }}" data-paid="{{ $paidWithoutCurrent }}" {{ old('invoice_id', $payment->invoice_id) == $inv->id ? 'selected' : '' }}>

                {{ $inv->invoice_no }}
                ({{ number_format($inv->total, 2) }})
              </option>
            @endforeach

          </select>

          @error('invoice_id')
            <div class="text-danger mt-1">{{ $message }}</div>
          @enderror
        </div>

        {{-- Balance --}}
        <div class="mb-3">
          <label>ยอดคงเหลือ</label>
          <input type="text" id="balance" class="form-control" readonly placeholder="คำนวณอัตโนมัติ">
        </div>

        {{-- Date --}}
        <div class="mb-3">
          <label>วันที่รับเงิน</label>
          <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror" value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}" required>

          @error('payment_date')
            <div class="text-danger mt-1">{{ $message }}</div>
          @enderror
        </div>

        {{-- Amount --}}
        <div class="mb-3">
          <label>จำนวนเงิน</label>
          <input type="number" step="0.01" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', $payment->amount) }}" placeholder="กรอกจำนวนเงิน เช่น 1000.00" required>

          @error('amount')
            <div class="text-danger mt-1">
              {{ $message }}
            </div>
          @enderror
        </div>

        <button id="submitBtn" class="btn btn-modern">
          อัปเดตข้อมูล
        </button>

      </form>

    </div>
  </div>

  <script>
    let invoiceSelect = document.getElementById('invoiceSelect');
    let balanceInput = document.getElementById('balance');
    let amountInput = document.getElementById('amount');
    let submitBtn = document.getElementById('submitBtn');

    function calculateBalance() {
      let selected = invoiceSelect.options[invoiceSelect.selectedIndex];

      let total = parseFloat(selected.getAttribute('data-total') || 0);
      let paid = parseFloat(selected.getAttribute('data-paid') || 0);

      let currentAmount = parseFloat(amountInput.value || 0);

      let balance = total - paid;

      balanceInput.value = balance.toFixed(2);

      // 🔥 รองรับ edit
      amountInput.max = balance + currentAmount;
    }

    invoiceSelect.addEventListener('change', calculateBalance);

    amountInput.addEventListener('input', function() {
      let max = parseFloat(this.max || 0);
      let val = parseFloat(this.value || 0);

      if (val > max) {
        this.classList.add('is-invalid');
        submitBtn.disabled = true;
      } else {
        this.classList.remove('is-invalid');
        submitBtn.disabled = false;
      }
    });

    function disableBtn() {
      submitBtn.disabled = true;
    }

    // โหลดครั้งแรก
    window.onload = calculateBalance;

    // dark mode
    if (localStorage.getItem('darkMode') === 'true') {
      document.body.classList.add('dark-mode');
    }
  </script>

@endsection
