@extends('layouts.app', ['activePage' => 'setting', 'titlePage' => __('Settings')])
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
      <form method="post" action="" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Settings') }}</h4>
                <p class="card-category">{{ __('Custimise your settings') }}</p>
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
                  <label class="col-sm-2 col-form-label">{{ __('Working Exp:') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('workexp') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('workexp') ? ' is-invalid' : '' }}" name="workexp" id="input-workexp" type="text" placeholder="{{ __('Working Exp') }}" value="{{ old('workexp',$setting[0]->work_exp)}}"  required/>
                      @if ($errors->has('workexp'))
                        <span id="workexp-error" class="error text-danger" for="input-workexp">{{ $errors->first('workexp') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                @php
                  $timev = explode('-',$setting[0]->working_hour);
                @endphp
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Working Hour:') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('strhour') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('strhour') ? ' is-invalid' : '' }}" name="strhour" id="input-strhour" type="text" placeholder="{{ __('Start Hour') }}" value="{{ old('strhour',$setting[0]->working_hour)}}"  required/>
                      @if ($errors->has('strhour'))
                        <span id="strhour-error" class="error text-danger" for="input-strhour">{{ $errors->first('strhour') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                @if($user_type == 'shop')
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Home Delivery') }}</label>
                  <div class="col-sm-7">
                    <label class="switch">
                        <input type="checkbox" class="form-control hidden_check"  {{  ($setting[0]->home_delivery ? "checked" : '') }} />
                        <span class="slider round"></span>
                    </label>
                  </div>
                </div>
                @endif
                <div id="hiddenable">
                @if($setting[0]->home_delivery || $user_type == 'worker')
                <div class="card">
                  <div class="card-header card-header-success">
                    <h4 class="card-title">{{ __('Working area List') }}</h4>
                    <p class="card-category">{{ __('Custimize you settings') }}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 text-right">
                    <a  class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addArea">{{ __('Add') }}</a>
                  </div>
                </div>
                <table class="table">
                  <thead class="text-primary">
                    <th>Area</th>
                    <th>Least Price</th>
                    <th class="text-right">Action</th>
                  </thead>
                  <tbody>
                    @foreach($area as $msg)
                    <tr>
                      <td>{{$msg->area_name}}</td>
                      <td><i class="fas fa-rupee-sign"></i><span> {{$msg->mini_price}}</span></td>
                      <td class="td-action text-right">
                        <a class="btn btn-primary btn-link btn-sm" data-toggle="modal" data-target="#UpdateArea{{$msg->arealist_id}}"><i class="material-icons">edit</i></a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                @endif
                </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
              </div>
            </div>
          </form> 
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addArea">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
      
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Work Area</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" action="{{url('/setting/update')}}" enctype="multipart/form-data">
                    <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                    <input type="hidden" name="wlist_id" value=""/>
                    <div class="form-group">
                        <span for="areaname">Select work list</span>
                        <select class="form-control" name="name" required>
                          @foreach($addableArea as $msg)
                            <option value="{{$msg->arealist_id}}">{{$msg->area_name}}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                      <span for="price">Mini price for home delivery (<i class="fas fa-rupee-sign"></i>)</span>
                      <input type="number" class="form-control" id="price" name="price" required/> 
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" > Add </button>
                    </div>
                </form>
            </div>   
        </div>
	</div>
</div>

@foreach($area as $msg)
<div class="modal fade" id="UpdateArea{{$msg->arealist_id}}">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
      
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Work Area</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" action="{{url('/setting/update')}}" enctype="multipart/form-data">
                    <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                    <input type="hidden" name="wlist_id" value="{{$msg->wor_service_area_id}}"/>
                    <div class="form-group">
                        <span for="areaname">Select work list</span>
                        <select class="form-control" name="name" required>
                          @foreach($addableArea as $msg1)
                            @if($msg1->area_name == $msg->area_name)
                              <option value="{{$msg1->arealist_id}}" selected>{{$msg1->area_name}}</option>
                            @else
                              <option value="{{$msg1->arealist_id}}">{{$msg1->area_name}}</option>
                            @endif
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                      <span for="price">Mini price for home delivery (<i class="fas fa-rupee-sign"></i>)</span>
                      <input type="number" class="form-control" id="price" name="price" value="{{$msg->mini_price}}" required/> 
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" > Add </button>
                    </div>
                </form>
            </div>   
        </div>
	</div>
</div>
@endforeach

@endsection