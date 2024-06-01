@extends('components.dashboard.layouts.master')
@section('title')
    {{__('dashboard.drawer')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{$drawer->name}}">
                <li class="breadcrumb-item"><a href="{{route('admin.drawer.index')}}">
                        {{__('dashboard.edit_drawer')}}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('dashboard.title edit')}} </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{route('admin.drawer.update',$drawer->id)}}" >
                                @csrf
                                @method('PATCH')
                               <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label for="name_en">{{__('dashboard.drawer_balance')}}
                                            <input type="number"  class="form-control" name="drawer_balance" placeholder="{{__('dashboard.drawer_balance')}}" value="{{$drawer->drawer_balance ?? old('drawer_balance')}}" />
                                            @error('drawer_balance')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <label for="name_en">{{__('dashboard.drawer_ton')}}
                                                <input type="number"  class="form-control" name="drawer_ton" placeholder="{{__('dashboard.drawer_ton')}}" value="{{$drawer->drawer_ton ?? old('drawer_ton')}}" />
                                                @error('drawer_ton')
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
