@extends('layouts.app', ['activePage' => 'profile', 'titlePage' => __('User Profile')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('profile.update') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Add Work List') }}</h4>
                <p class="card-category">{{ __('Update information') }}</p>
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
                  <label class="col-sm-2 col-form-label">{{ __('Work Type') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('cat_name') ? ' has-danger' : '' }}">
                        <select class="form-control" name="cat_name" id="cat_name" required>
                            @foreach($cat as $msg)
                                <option value="{{$msg->wor_cat_id}}">{{$msg->wor_cat_name}} </option>
                            @endforeach
                        </select>
                      @if ($errors->has('cat_name'))
                        <span id="cat_name-error" class="error text-danger" for="input-cat_name">{{ $errors->first('cat_name') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Work Sub Type') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('sub_name') ? ' has-danger' : '' }}">
                      <select name="sub_name" id="sub_id" class="form-control" required>
                        @foreach($subcat as $msg)
                            <option value="{{$msg->wor_subcat_id}}">{{$msg->subcat_name}}</option>
                        @endforeach 
                      </select>
                      @if ($errors->has('sub_name'))
                        <span id="sub_name-error" class="error text-danger" for="input-sub_name">{{ $errors->first('sub_name') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                @if(sizeof($worklist,1))
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Work name') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                    <select name="name" class="form-control" id="input-name" required>
                        @foreach($worklist as $msg)
                            <option value="{{$msg->wor_list_id}}">{{$msg->work_name}}</option>
                        @endforeach
                    </select>  
                      @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name')}}</span>
                      @endif
                    </div>
                  </div>
                </div> 
                <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Service Charge')}} :<i class="fas fa-rupee-sign"></i> </label>
                    <div class="col-sm-7">
                        <div class="form-group{{ $errors->has('price') ? 'has-denger' : '' }}">
                            <input type="number" class="form-control" id="input-price" name="price" placeholder="{{ __('Enter Price')}}"  value="{{ old('price')}}" required/>
                            @if($errors->has('price'))
                                <span id="price-error" class="errortext-denger" for="input-price" >{{ $errors->first('price') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                    <p>No work is found</p>
                @endif
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
@endsection