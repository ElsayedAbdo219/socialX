@extends('components.dashboard.layouts.master')
@section('title')
    اضافة شركة جديدة
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now=" اضافة شركة جديدة">
                <li class="breadcrumb-item"><a href="{{route('admin.fqa.index')}}">
                      قائمة الشركات
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> اضافة شركة جديدة</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{route('admin.companies.store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label class="w-100" for="logo">صورة
                                            <input type="file" min='0' class="form-control" name="logo" placeholder="صورة" value="{{ old('logo')}}" />
                                            @error('logo')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="form-group col-4">
                                        <label class="w-100" for="name">{{__('dashboard.name')}}
                                            <input type="text" min='0' class="form-control" name="name" placeholder="{{__('dashboard.name')}}" value="{{ old('name')}}" />
                                            @error('name')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                      <div class="form-group col-4">
                                        <label class="w-100" for="email">{{__('dashboard.email')}}
                                            <input type="text" min='0' class="form-control" name="email" placeholder="{{__('dashboard.email')}}" value="{{ old('email')}}" />
                                            @error('email')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>



                                    <div class="form-group col-4">
                                        <label class="w-100" for="password">{{__('dashboard.password')}}
                                            <input type="text" min='0' class="form-control" name="password" placeholder="{{__('dashboard.password')}}" value="{{old('password')}}" />
                                            @error('password')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                      <div class="form-group col-4">
                                        <label class="w-100" for="slogo">الشعار
                                            <input type="text" min='0' class="form-control" name="slogo" placeholder="الشعار" value="{{old('slogo')}}" />
                                            @error('slogo')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                      <div class="form-group col-4">
                                        <label class="w-100" for="website">الموقع الالكتروني
                                            <input type="text" min='0' class="form-control" name="website" placeholder="الموقع الالكتروني" value="{{ old('website')}}" />
                                            @error('website')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                      <div class="form-group col-4">
                                        <label class="w-100" for="address">العنوان
                                            <input type="text" min='0' class="form-control" name="address" placeholder="العنوان" value="{{ old('address')}}" />
                                            @error('address')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>


                                      <div class="form-group col-4">
                                        <label class="w-100" for="slogo">نص  تعريفي(اختياري)
                                            <input type="text" min='0' class="form-control" name="bio" placeholder="نص تعريفي" value="{{old('bio')}}" />
                                            @error('bio')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="form-group col-4">
                                        <label class="w-100" for="coverletter">صورة الغلاف  (اختياري)
                                            <input type="file" min='0' class="form-control" name="coverletter" placeholder="الصورة الشخصية" value="{{ $Employee->coverletter ?? old('coverletter')}}" />
                                            @error('coverletter')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
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
