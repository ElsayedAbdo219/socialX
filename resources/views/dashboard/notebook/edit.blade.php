@extends('components.dashboard.layouts.master')
@section('title')
    {{__('dashboard.notebook')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{$notebook->name}}">
                <li class="breadcrumb-item"><a href="{{route('admin.notebook.index')}}">
                        {{__('dashboard.edit_notebook')}}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('dashboard.title edit')}} </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{route('admin.notebook.update',$notebook->id)}}" >
                                @csrf
                                @method('PATCH')
                               <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label for="name_en">{{__('dashboard.notebook_balance')}}
                                            <input type="number"  class="form-control" name="notebook_balance" placeholder="{{__('dashboard.notebook_balance')}}" value="{{$notebook->notebook_balance ?? old('notebook_balance')}}" />
                                            @error('notebook_balance')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <label for="name_en">{{__('dashboard.notebook_ton')}}
                                                <input type="number"  class="form-control" name="notebook_ton" placeholder="{{__('dashboard.notebook_ton')}}" value="{{$notebook->notebook_ton ?? old('notebook_ton')}}" />
                                                @error('notebook_ton')
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
