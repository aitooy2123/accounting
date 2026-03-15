@extends('layouts.app')
@section('title', 'แก้ไขใบแจ้งหนี้')

@section('content')

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/css/bootstrap-datepicker.min.css">

  <div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

      <h4 class="fw-bold mb-0">🧾 แก้ไขใบแจ้งหนี้</h4>

      <a href="{{ route('invoice.index') }}" class="btn btn-outline-secondary">
        ← ย้อนกลับ
      </a>

    </div>

    <div class="glass-card p-4">

      <form method="POST" action="{{ route('invoice.update', $invoice->id) }}">
        @csrf
        @method('PUT')

        <div class="row">

          <div class="col-md-6 mb-3">

            <label>เลขที่ใบแจ้งหนี้</label>

            <input type="text" name="invoice_no" class="form-control @error('invoice_no') is-invalid @enderror" value="{{ old('invoice_no', $invoice->invoice_no) }}">

            @error('invoice_no')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror

          </div>

          <div class="col-md-6 mb-3">

            <label>วันที่ครบกำหนด</label>

            <input type="text" id="due_date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date', date('d/m/Y', strtotime($invoice->due_date))) }}">

            @error('due_date')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror

          </div>

        </div>

        <div class="mb-3">

          <label>ลูกค้า</label>

          <select name="customer_id" class="form-control">

            <option value="">-- เลือกลูกค้า --</option>

            @foreach ($customers as $customer)
              <option value="{{ $customer->id }}" {{ old('customer_id', $invoice->customer_id) == $customer->id ? 'selected' : '' }}>

                {{ $customer->name }}

              </option>
            @endforeach

          </select>

        </div>

        <div class="row">

          <div class="col-md-6 mb-3">

            <label>สถานะ</label>

            <select id="status" name="status" class="form-control">

              <option value="0" {{ old('status', $invoice->status) == 0 ? 'selected' : '' }}>
                ยังไม่ชำระ
              </option>

              <option value="1" {{ old('status', $invoice->status) == 1 ? 'selected' : '' }}>
                ชำระแล้ว
              </option>

            </select>

          </div>

          <div class="col-md-6 mb-3" id="paid_box">

            <label>ชำระแล้ว</label>

            <input type="text" name="paid" class="form-control" value="{{ old('paid', number_format($invoice->paid, 2)) }}">

          </div>

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

            @if ($invoice->items)

              @foreach ($invoice->items as $i => $item)
                <tr>

                  <td>
                    <input type="text" name="items[{{ $i }}][description]" class="form-control" value="{{ $item['description'] }}">
                  </td>

                  <td>
                    <input type="number" name="items[{{ $i }}][qty]" class="form-control qty" value="{{ $item['qty'] }}">
                  </td>

                  <td>
                    <input type="text" name="items[{{ $i }}][price]" class="form-control price" value="{{ number_format($item['price'], 2) }}">
                  </td>

                  <td>
                    <input type="text" class="form-control total" value="{{ number_format($item['total'], 2) }}" readonly>
                  </td>

                  <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button>
                  </td>

                </tr>
              @endforeach

            @endif

          </tbody>

        </table>

        <button type="button" class="btn btn-secondary mb-3" onclick="addRow()">
          + เพิ่มรายการ
        </button>

        <div class="text-end">

          <h5>
            รวมทั้งสิ้น : <span id="grandTotal">0</span>
          </h5>

          <small class="text-success" id="amount_text"></small>

        </div>

        <button class="btn btn-primary mt-3">
          อัปเดตข้อมูล
        </button>

      </form>

    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/js/bootstrap-datepicker.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/locales/bootstrap-datepicker.th.min.js"></script>

  <script>
    $('#due_date').datepicker({
      format: 'dd/mm/yyyy',
      language: 'th',
      thaiyear: true,
      autoclose: true
    });

    let rowIndex = {{ $invoice->items ? count($invoice->items) : 1 }};

    function addRow() {

      let table = document.getElementById('itemTable').getElementsByTagName('tbody')[0];

      let row = table.insertRow();

      row.innerHTML = `
<td><input type="text" name="items[${rowIndex}][description]" class="form-control"></td>
<td><input type="number" name="items[${rowIndex}][qty]" class="form-control qty" value="1"></td>
<td><input type="text" name="items[${rowIndex}][price]" class="form-control price"></td>
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

        let price = row.querySelector('.price').value.replace(/,/g, '') || 0;

        price = Number(price);

        let total = qty * price;

        row.querySelector('.total').value = Number(total).toLocaleString('en-US');

        grand += total;

      });

      document.getElementById('grandTotal').innerText = Number(grand).toLocaleString('en-US');

      document.getElementById('amount_text').innerText = numberToThaiText(grand);

    }

    function togglePaid() {

      let status = document.getElementById('status').value;
      let box = document.getElementById('paid_box');

      if (status == 1) {
        box.style.display = 'block';
      } else {
        box.style.display = 'none';
      }

    }

    document.getElementById('status').addEventListener('change', togglePaid);

    togglePaid();

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

    window.onload = function() {
      calculate();
    };
  </script>

@endsection
