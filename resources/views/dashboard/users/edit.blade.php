@extends('components.dashboard.layouts.master')
@section('title')
    {{ __('dashboard.edit_user') }}
@endsection
<!-- BEGIN: Content-->
@section('content')
    @if (session('success'))
        <script>
            toastr.success('{{ session('success') }}');
        </script>
    @endif
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{ $user->name}}">
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">
                        {{ __('dashboard.edit_user') }}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> {{ __('dashboard.edit_user') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{ route('admin.users.update',$user->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">

                                    <div class="form-group col-sm-3">
                                        <label for="name">{{ __('dashboard.name') }}
                                            <input type="text" class="form-control" name="name"
                                                placeholder="{{ __('dashboard.name') }}" value={{ $user->name}} />
                                            @error('name')
                                                <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </label>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="name_en">{{ __('dashboard.phone') }}
                                            <input type="number" class="form-control" name="mobile"
                                                placeholder="{{ __('dashboard.phone') }}" value={{ $user->mobile}} />
                                            @error('mobile')
                                                <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label style="width: 100%" for="statusArray">{{__('dashboard.status')}}
                                            <select class="form-control select2 statusArray" name="is_active" >
                                                @foreach($statusArray as $key => $value)
                                                    <option @if($user->status == $key) selected @endif value="{{$key}}" class="status_option">{{$value}}</option>
                                                @endforeach
                                            </select>
                                            @error('is_active')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label> 

                                    </div> 



                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1"
                                        class="store">{{ __('dashboard.submit') }}</button>
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
  
@endsection
