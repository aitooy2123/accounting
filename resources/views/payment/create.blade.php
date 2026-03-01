@extends('layouts.app')

@section('title', 'เพิ่มรับชำระเงิน')

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
      background: linear-gradient(90deg, #16a34a, #22c55e);
      border: none;
      color: #fff;
    }
  </style>

  <div class="container py-4">

    <h4 class="fw-bold mb-4">💳 เพิ่มการรับชำระเงิน</h4>

    <div class="glass-card p-4">

      <form action="{{ route('payment.store') }}" method="POST" onsubmit="disableBtn()">
        @csrf

        <div class="mb-3">
          <label>เลือก Invoice</label>
          <select name="invoice_id" id="invoiceSelect" class="form-control" required>
            <option value="">-- เลือกใบแจ้งหนี้ --</option>
            @foreach ($invoices as $inv)
              <option value="{{ $inv->id }}" data-total="{{ $inv->total }}" data-paid="{{ $inv->payments->sum('amount') }}">
                {{ $inv->invoice_no }}
                ({{ number_format($inv->total, 2) }})
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label>ยอดคงเหลือ</label>
          <input type="text" id="balance" class="form-control" readonly>
        </div>

        <div class="mb-3">
          <label>วันที่รับเงิน</label>
          <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
          <label>จำนวนเงิน</label>
          <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
        </div>

        <button id="submitBtn" class="btn btn-modern">
          บันทึกการรับเงิน
        </button>

      </form>

    </div>
  </div>

  <script>
    let invoiceSelect = document.getElementById('invoiceSelect');
    let balanceInput = document.getElementById('balance');
    let amountInput = document.getElementById('amount');

    invoiceSelect.addEventListener('change', function() {
      let selected = this.options[this.selectedIndex];
      let total = parseFloat(selected.getAttribute('data-total') || 0);
      let paid = parseFloat(selected.getAttribute('data-paid') || 0);
      let balance = total - paid;

      balanceInput.value = balance.toFixed(2);
      amountInput.max = balance;
    });

    amountInput.addEventListener('input', function() {
      if (parseFloat(this.value) > parseFloat(this.max)) {
        this.value = this.max;
      }
    });

    function disableBtn() {
      document.getElementById('submitBtn').disabled = true;
    }

    // โหลด dark mode
    if (localStorage.getItem('darkMode') === 'true') {
      document.body.classList.add('dark-mode');
    }
  </script>

@endsection
