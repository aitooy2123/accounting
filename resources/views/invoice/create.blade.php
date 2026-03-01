@extends('layouts.app')
@section('title', 'สร้างใบแจ้งหนี้')

@section('content')

  <style>
    :root {
      --card-light: rgba(255, 255, 255, 0.75);
      --card-dark: rgba(30, 41, 59, 0.7);
    }

    body.dark-mode {
      background: #0f172a;
      color: #f1f5f9;
    }

    .glass-card {
      backdrop-filter: blur(14px);
      background: var(--card-light);
      border-radius: 20px;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    body.dark-mode .glass-card {
      background: var(--card-dark);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-modern {
      border-radius: 50px;
      padding: 8px 28px;
      background: linear-gradient(90deg, #3b82f6, #6366f1);
      border: none;
      color: #fff;
    }
  </style>

  <div class="container py-5">

    <h4 class="fw-bold mb-4">🧾 สร้างใบแจ้งหนี้</h4>

    <div class="glass-card p-4">

      <form method="POST" action="{{ route('invoice.store') }}">
        @csrf

        <div class="row">
          <div class="col-md-6 mb-3">
            <label>เลขที่ใบแจ้งหนี้</label>
            <input type="text" name="invoice_no" class="form-control" value="{{ old('invoice_no') }}" required>
          </div>

          <div class="col-md-6 mb-3">
            <label>วันที่</label>
            <input type="date" name="date" class="form-control" value="{{ old('date') }}" required>
          </div>
        </div>

        <div class="mb-3">
          <label>ลูกค้า</label>
          <select name="customer_id" class="form-control" required>
            <option value="">-- เลือกลูกค้า --</option>
            {{-- @foreach ($customers as $customer)
              <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                {{ $customer->name }}
              </option>
            @endforeach --}}
          </select>
        </div>

        <hr>

        <h6 class="mb-3">รายการสินค้า / บริการ</h6>

        <table class="table table-bordered" id="itemTable">
          <thead>
            <tr>
              <th>รายละเอียด</th>
              <th width="120">จำนวน</th>
              <th width="150">ราคา</th>
              <th width="150">รวม</th>
              <th width="50"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="text" name="items[0][description]" class="form-control" required></td>
              <td><input type="number" name="items[0][qty]" class="form-control qty" value="1"></td>
              <td><input type="number" step="0.01" name="items[0][price]" class="form-control price"></td>
              <td><input type="text" class="form-control total" readonly></td>
              <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
            </tr>
          </tbody>
        </table>

        <button type="button" class="btn btn-secondary mb-3" onclick="addRow()">
          + เพิ่มรายการ
        </button>

        <div class="text-end">
          <h5>รวมทั้งสิ้น: <span id="grandTotal">0.00</span></h5>
        </div>

        <button class="btn btn-modern mt-3">
          บันทึกใบแจ้งหนี้
        </button>

      </form>

    </div>

  </div>

  <script>
    let rowIndex = 1;

    function addRow() {
      let table = document.getElementById('itemTable').getElementsByTagName('tbody')[0];
      let row = table.insertRow();

      row.innerHTML = `
    <td><input type="text" name="items[${rowIndex}][description]" class="form-control" required></td>
    <td><input type="number" name="items[${rowIndex}][qty]" class="form-control qty" value="1"></td>
    <td><input type="number" step="0.01" name="items[${rowIndex}][price]" class="form-control price"></td>
    <td><input type="text" class="form-control total" readonly></td>
    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
  `;

      rowIndex++;
    }

    function removeRow(btn) {
      btn.closest('tr').remove();
      calculate();
    }

    document.addEventListener('input', function(e) {
      if (e.target.classList.contains('qty') || e.target.classList.contains('price')) {
        calculate();
      }
    });

    function calculate() {
      let rows = document.querySelectorAll('#itemTable tbody tr');
      let grand = 0;

      rows.forEach(row => {
        let qty = row.querySelector('.qty').value || 0;
        let price = row.querySelector('.price').value || 0;
        let total = qty * price;
        row.querySelector('.total').value = total.toFixed(2);
        grand += total;
      });

      document.getElementById('grandTotal').innerText = grand.toFixed(2);
    }

    // dark mode load
    if (localStorage.getItem('darkMode') === 'true') {
      document.body.classList.add('dark-mode');
    }
  </script>

@endsection
