@extends('components.dashboard.layouts.master')
@section('title')
    {{__('dashboard.add_sponser')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{__('dashboard.add_sponser')}}">
                <li class="breadcrumb-item"><a href="{{route('admin.sponsers.index')}}">{{__('dashboard.sponsers_list')}}</a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('dashboard.add_sponser')}}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{route('admin.sponsers.store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label class="w-100" for="image">{{ __('dashboard.image') }}
                                            <input type="file" min='0' class="form-control" name="image" placeholder="{{ __('dashboard.image') }}" value="{{ old('image')}}" required/>
                                            @error('image')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="name_en">{{ __('dashboard.company') }}</label>
                                        <select class="form-control" name="user_id" id="user_id">
                                            
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-4">
                                        <label class="w-100" for="days_number">{{__('dashboard.days_number')}} 
                                            <input type="number"  class="form-control" name="days_number" placeholder="{{__('dashboard.days_number')}}" value="{{old('days_number')}}" required />
                                            @error('days_number')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                      <div class="form-group col-4">
                                        <label class="w-100" for="slogo">{{ __('dashboard.price') }}
                                            <input type="number"  class="form-control" name="price" placeholder="{{ __('dashboard.price') }}" value="{{old('price')}}" required />
                                            @error('price')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

<div class="form-group col-sm-3">
                                        <label for="status">{{ __('dashboard.status') }}</label>
                                        <select class="form-control" name="status" id="status">
                                            
                                            @foreach ($statusTypes as $key => $val)
                                                <option value="{{ $val }}">{{ $key }}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="payment_status">{{ __('dashboard.payment_status') }}</label>
                                        <select class="form-control" name="payment_status" id="payment_status">
                                            
                                            @foreach ($paymentStatusTypes as $key => $val)
                                                <option value="{{ $val }}">{{ $key }}</option>
                                            @endforeach
                                        </select>
                                        @error('payment_status')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">{{__('dashboard.add')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>

    </script>
@endsection
