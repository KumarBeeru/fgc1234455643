@extends('layouts.app', ['activePage' => 'profile', 'titlePage' => __('User Profile')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Edit Profile') }}</h4>
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
                  <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('Name') }}" value="{{ old('name', $profile[0]->shop_name) }}" required="true" aria-required="true"/>
                      @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" readonly />
                      @if ($errors->has('email'))
                        <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('City') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                    <select name="city" class="form-control select_city" required>
                      <option value="SAP" >Select Option</option>
                      @if(sizeof($city,1))
                        @foreach($city as $msg)
                            @if($msg->city_name == $profile[0]->city)
                              <option value="{{$msg->city_id}}" selected>{{$msg->city_name}}</option>
                            @else
                              <option value="{{$msg->city_id}}">{{$msg->city_name}}</option>
                            @endif
                        @endforeach
                      @else
                        <option value="SAP">Select Option</option>
                      @endif
                    </select>  
                      @if ($errors->has('city'))
                        <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('city')}}</span>
                      @endif
                    </div>
                  </div>
                </div> 
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Area') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('area') ? ' has-danger' : '' }}">
                    <select name="area" class="form-control select_area" required>
                      <option value="SAP">Select Option</option>
                      @if(sizeof($area))
                        @foreach($area as $msg)
                            @if($msg->area_name == $profile[0]->area)
                              <option value="{{$msg->arealist_id}}" selected>{{$msg->area_name}}</option>
                            @else
                              <option value="{{$msg->arealist_id}}">{{$msg->area_name}}</option>
                            @endif
                        @endforeach
                      @else
                        <option value="SAP">Select Option</option>
                      @endif  
                    </select>  
                      @if ($errors->has('area'))
                        <span id="email-error" class="error text-danger" for="input-area">{{ $errors->first('area') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Phone (+91)') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('phone1') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('phone1') ? ' is-invalid' : '' }}" name="phone1" id="input-phone1" type="number" size="10" placeholder="{{ __('Phone 1') }}" value="{{ old('phone1',$profile[0]->phone1)}}"  required/>
                      @if ($errors->has('phone1'))
                        <span id="phone1-error" class="error text-danger" for="input-phone1">{{ $errors->first('phone1') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Phone2 (+91)') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('phone2') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('phone2') ? ' is-invalid' : '' }}" name="phone2" id="input-phone2" type="number" maxlength="10" minlength="10"  placeholder="{{ __('Phone 2') }}" value="{{ old('phone2',$profile[0]->phone2)}}" required/>
                      @if ($errors->has('phone2'))
                        <span id="phone2-error" class="error text-danger" for="input-phone2">{{ $errors->first('phone2') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Address') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                      <textarea rows="4" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" id="input-address"  placeholder="{{ __('At- XXXXX , Post- XXX etc') }}" required>
                      {{ old('address',$profile[0]->address)}}
                      </textarea>
                      @if ($errors->has('address'))
                        <span id="address-error" class="error text-danger" for="input-address">{{ $errors->first('address') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Pincode') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('pincode') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('pincode') ? ' is-invalid' : '' }}" name="pincode" id="input-pincode" type="number"  placeholder="{{ __('Ex : 812007') }}" value="{{ old('pincode',$profile[0]->pincode)}}" required/>
                      @if ($errors->has('pincode'))
                        <span id="pincode-error" class="error text-danger" for="input-pincode">{{ $errors->first('pincode') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Aadhar Card:') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('aadhar') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('aadhar') ? ' is-invalid' : '' }}" name="aadhar" id="input-aadhar" type="number"  placeholder="{{ __('Ex : 0000 0000 0000') }}" value="{{ old('aadhar',$profile[0]->aadhar_no)}}" required/>
                      @if ($errors->has('aadhar'))
                        <span id="aadhar-error" class="error text-danger" for="input-aadhar">{{ $errors->first('aadhar') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Photo') }}</label>
                  <div class="col-sm-7">
                    <input type="file" name="image" accept="image/*"  required>
                  </div>
                </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('profile.password') }}" class="form-horizontal">
            @csrf
            @method('put')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Change password') }}</h4>
                <p class="card-category">{{ __('Password') }}</p>
              </div>
              <div class="card-body ">
                @if (session('status_password'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status_password') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-current-password">{{ __('Current Password') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" input type="password" name="old_password" id="input-current-password" placeholder="{{ __('Current Password') }}" value="" required />
                      @if ($errors->has('old_password'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('old_password') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password">{{ __('New Password') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="input-password" type="password" placeholder="{{ __('New Password') }}" value="" required />
                      @if ($errors->has('password'))
                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password-confirmation">{{ __('Confirm New Password') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="password_confirmation" id="input-password-confirmation" type="password" placeholder="{{ __('Confirm New Password') }}" value="" required />
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Change password') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function(){
      $.url="{{url('/')}}";
      $.token = "{{csrf_token()}}";
    })
  </script>
@endsection