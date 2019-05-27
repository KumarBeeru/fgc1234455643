@extends('layouts.app', ['activePage' => 'account', 'titlePage' => __('Account')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header card-header-primary">
        <h3 class="card-title">Account  Balance : <i class="fas fa-rupee-sign"></i> {{ $account }}</h3>
        <p class="card-category">Remains balance </p>
      </div>
      <div class="card-body">
        <h4>Last 10 transaction</h4>
        <table class="table">
          <thead class="text-primary">
            <th>Transaction id</th>
            <th>Transaction type</th>
            <th>Amount</th>
            <th>Date</th>
          </thead>
          <tbody>
              @foreach($transaction as $msg)
                <tr>
                   <td>{{ $msg->trans_id }}</td>
                   <td>{{ $msg->trans_type }}</td>
                   <td>{{ $msg->trans_amt }}</td>
                   <td>{{ $msg->created_at }} </td>
                </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
