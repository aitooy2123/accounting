@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
  <h3 class="mb-4">📊 Dashboard</h3>

  {{-- เลือกปี --}}
  <form method="GET" class="mb-4 d-flex align-items-center gap-2">
    <label for="year" class="mb-0 font-weight-bold">เลือกปี:</label>
    <input type="number" id="year" name="year" min="2000" max="{{ date('Y') }}" value="{{ $year }}" class="form-control" style="width:120px;">
    <button type="submit" class="btn btn-primary">แสดง</button>
  </form>

  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card-glass p-4 text-white" style="background:linear-gradient(45deg,#10b981,#34d399)">
        <h6>รายรับรวม</h6>
        <h3>฿ {{ number_format($totalIncome, 2) }}</h3>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-glass p-4 text-white" style="background:linear-gradient(45deg,#ef4444,#f87171)">
        <h6>รายจ่ายรวม</h6>
        <h3>฿ {{ number_format($totalExpense, 2) }}</h3>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-glass p-4 text-white" style="background:linear-gradient(45deg,#6366f1,#818cf8)">
        <h6>กำไรสุทธิ</h6>
        <h3>฿ {{ number_format($profit, 2) }}</h3>
      </div>
    </div>
  </div>

  <div class="card-glass p-4 mb-4">
    <canvas id="incomeExpenseChart" height="120"></canvas>
  </div>
@endsection

@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('incomeExpenseChart').getContext('2d');
    const chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: @json($labels),
        datasets: [{
            label: 'รายรับ',
            data: @json($incomeData),
            backgroundColor: '#10b981',
            borderRadius: 5
          },
          {
            label: 'รายจ่าย',
            data: @json($expenseData),
            backgroundColor: '#ef4444',
            borderRadius: 5
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top'
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return '฿ ' + context.raw.toLocaleString();
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return '฿ ' + value.toLocaleString();
              }
            }
          }
        }
      }
    });
  </script>
@endsection
