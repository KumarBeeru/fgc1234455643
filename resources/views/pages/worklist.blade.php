@extends('layouts.app', ['activePage' => 'worklist', 'titlePage' => __('Worklist')])
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card ">
            <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Work List') }}</h4>
                <p class="card-category">{{ __('') }}</p>
            </div>
            <div class="card-body ">
                @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                        </button>
                            <span>{{ session('status') }}</span>
                        </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="{{ url('/setting/addwork') }}" class="btn btn-sm btn-primary" >{{ __('Add') }}</a>
                  </div>
                </div>
                <table class="table">
                  <thead class="text-primary">
                    <th>Work</th>
                    <th>Charge</th>
                    <th class="text-right">Action</th>
                  </thead>
                  <tbody>
                    @foreach($work_list as $msg)
                    <tr>
                      <td>{{$msg->work_name}}</td>
                      <td><i class="fas fa-rupee-sign"></i> {{$msg->price}} </td>
                      <td class="td-action text-right">
                        <form > 
                            <input type="hidden" name="wor_list_id" value="{{$msg->wor_list_id}}" />    
                            <button type="button" rel = "tooltip" title="Edit List" class="btn btn-primary btn-link btn-sm">
                                <i class="material-icons">delete</i>
                            </button>
                        </form>
                      </td>
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

@endsection