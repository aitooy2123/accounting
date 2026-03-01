@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

  <h3 class="mb-4">Dashboard</h3>

  <div class="row mb-4">

    <div class="col-md-4">
      <div class="card-modern p-4 text-white" style="background:linear-gradient(45deg,#10b981,#34d399)">
        <h6>รายรับรวม</h6>
        <h3>฿ 120,000</h3>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card-modern p-4 text-white" style="background:linear-gradient(45deg,#ef4444,#f87171)">
        <h6>รายจ่ายรวม</h6>
        <h3>฿ 75,000</h3>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card-modern p-4 text-white" style="background:linear-gradient(45deg,#6366f1,#818cf8)">
        <h6>กำไรสุทธิ</h6>
        <h3>฿ 45,000</h3>
      </div>
    </div>

  </div>

@endsection
