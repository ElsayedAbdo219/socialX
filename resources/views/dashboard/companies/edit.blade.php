@extends('components.dashboard.layouts.master')
@section('title')
    {{__('dashboard.edit_company')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{__('dashboard.edit_company')}}">
                <li class="breadcrumb-item"><a href="{{route('admin.companies.index')}}">
                        {{__('dashboard.companies_list')}}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('dashboard.edit_company')}}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                                <form class="form form-vertical" method="POST" action="{{route('admin.companies.update',$Company->id)}}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="row">


                                    <div class="form-group col-4">
                                        <label class="w-100" for="slogo">الحالة
                                            <select class="form-control" name="is_Active" value="{{ $Company->is_Active ?? old('is_Active') }}">
                                                <option value="1">نشط</option>
                                                <option value="0">غير نشط</option>
                                            </select>
                                               @error('is_Active')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>
                                   
                                    
                                    <div class="form-group col-4">
                                        <label class="w-100" for="logo">صورة
                                            <input type="file" min='0' class="form-control" name="logo" placeholder="صورة" value="{{$Company->logo ?? old('logo')}}" />
                                            @error('logo')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="form-group col-4">
                                        <label class="w-100" for="name">{{__('dashboard.name')}}
                                            <input type="text" min='0' class="form-control" name="name" placeholder="{{__('dashboard.name')}}" value="{{ $Company->name ?? old('name')}}" />
                                            @error('name')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                      <div class="form-group col-4">
                                        <label class="w-100" for="email">{{__('dashboard.email')}}
                                            <input type="text" min='0' class="form-control" name="email" placeholder="{{__('dashboard.email')}}" value="{{ $Company->email ?? old('email')}}" />
                                            @error('email')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>



                                    <div class="form-group col-4">
                                        <label class="w-100" for="password">{{__('dashboard.password')}}
                                            <input type="text" min='0' class="form-control" name="password" placeholder="{{__('dashboard.password')}}" value="{{ $Company->password ??old('password')}}" />
                                            @error('password')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                      <div class="form-group col-4">
                                        <label class="w-100" for="slogo">الشعار
                                            <input type="text" min='0' class="form-control" name="slogo" placeholder="الشعار" value="{{ $Company->slogo ?? old('slogo')}}" />
                                            @error('slogo')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                      <div class="form-group col-4">
                                        <label class="w-100" for="website">الموقع الالكتروني
                                            <input type="text" min='0' class="form-control" name="website" placeholder="الموقع الالكتروني" value="{{ $Company->website ?? old('website')}}" />
                                            @error('website')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                      <div class="form-group col-4">
                                        <label class="w-100" for="address">العنوان
                                            <input type="text" min='0' class="form-control" name="address" placeholder="العنوان" value="{{ $Company->address ?? old('address')}}" />
                                            @error('address')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>


                                      <div class="form-group col-4">
                                        <label class="w-100" for="slogo">نص تعريفي(اختياري)
                                            <input type="text" min='0' class="form-control" name="bio" placeholder="نص تعريفي" value="{{ $Company->bio ?? old('bio')}}" />
                                            @error('bio')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                    
                                 
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">{{__('dashboard.update')}}</button>
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
