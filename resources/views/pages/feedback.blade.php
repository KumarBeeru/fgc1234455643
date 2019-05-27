@extends('layouts.app', ['activePage' => 'feedback', 'titlePage' => __('Feedback')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Fedback & Ratting</h4>
            <p class="card-category">Your feedback and ratting given by the user</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th>Lot id</th>
                  <th>Feedback</th>
                  <th>Ratting</th>
                  <th>User Name</th>
                  <th>Remark</th>
                </thead>
                <tbody>
                  @foreach($feedback as $msg)
                  <tr>
                    <td> {{$msg->lot_id}} </td>
                    <td> {{$msg->feedback}} </td>
                    <td> {{$msg->ratting}} </td>
                    <td> {{$msg->cname}} </td>
                    <td> {{$msg->remark}} </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection