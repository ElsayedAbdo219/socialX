@extends('components.dashboard.layouts.master')
@section('title')
    {{__('dashboard.registration_requests')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{__('dashboard.edit_registration_request')}}">
                <li class="breadcrumb-item"><a href="{{route('admin.registration_requests.index')}}">
                        {{__('dashboard.registration_requests_list')}}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('dashboard.edit_registration_request')}}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{route('admin.registration_requests.update',$RegisterationRequest->id)}}" >
                                @csrf
                                @method('PATCH')
                              <!--  <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label for="name_en">{{__('dashboard.name')}}
                                            <input type="text"  class="form-control" name="name" placeholder="{{__('dashboard.name')}}" value="{{$RegisterationRequest->name ?? old('name')}}" />
                                            @error('name')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label> -->
                                    </div>
                                     <div class="form-group col-sm-3">
                                        <label style="width: 100%" for="statusArray">{{__('dashboard.status')}}
                                            <select class="form-control select2 statusArray" name="status" >
                                                @foreach($statusArray as $key => $value)
                                                    <option @if($RegisterationRequest->status == $key) selected @endif value="{{$key}}" class="status_option">{{$value}}</option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label> 

                                    </div> 
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1" class="edit">{{__('dashboard.edit')}}</button>
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


   
    </script>
@endsection