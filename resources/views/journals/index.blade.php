@extends('layouts.app')

@section('content')
  <style>
    :root {
      --bg-light: #f1f5f9;
      --bg-dark: #0f172a;
      --card-light: rgba(255, 255, 255, 0.7);
      --card-dark: rgba(30, 41, 59, 0.6);
      --blur: blur(12px);
    }

    body.dark-mode {
      background: var(--bg-dark);
      color: #f1f5f9;
    }

    .glass-card {
      backdrop-filter: var(--blur);
      -webkit-backdrop-filter: var(--blur);
      background: var(--card-light);
      border-radius: 16px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      transition: all .3s ease;
    }

    body.dark-mode .glass-card {
      background: var(--card-dark);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .glass-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .table-modern {
      border-radius: 12px;
      overflow: hidden;
    }

    .table-modern th {
      background: linear-gradient(90deg, #3b82f6, #6366f1);
      color: #fff;
    }

    .badge-ref {
      background: linear-gradient(90deg, #f59e0b, #ef4444);
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 12px;
    }

    .toggle-btn {
      border-radius: 50px;
    }
  </style>

  {{-- <div class="container py-4"> --}}

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold">📘 สมุดรายวัน</h4>
    </div>

    @foreach ($journals as $journal)
      {{-- <div class="glass-card p-3 mb-4"> --}}

        <div class="d-flex justify-content-between mb-3">
          <div>
            <strong>📅 วันที่:</strong> {{ $journal->date }}
          </div>
          <div>
            <span class="badge-ref">
              Ref: {{ $journal->reference }}
            </span>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-modern align-middle mb-0">
            <thead>
              <tr>
                <th>บัญชี</th>
                <th class="text-end">Debit</th>
                <th class="text-end">Credit</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($journal->items as $item)
                <tr>
                  <td>{{ $item->account->name }}</td>
                  <td class="text-end text-success">
                    {{ number_format($item->debit, 2) }}
                  </td>
                  <td class="text-end text-danger">
                    {{ number_format($item->credit, 2) }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      {{-- </div> --}}
    @endforeach

  {{-- </div> --}}

@endsection
