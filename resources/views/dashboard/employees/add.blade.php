@extends('components.dashboard.layouts.master')
@section('title')
    {{__('dashboard.add_employee')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{__('dashboard.add_employee')}}">
                <li class="breadcrumb-item"><a href="{{route('admin.fqa.index')}}">
                        {{__('dashboard.fqas_list')}}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('dashboard.add_employee')}}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{route('admin.employees.store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label class="w-100" for="personal_photo">الصورة الشخصية (اختياري)
                                            <input type="file" min='0' class="form-control" name="personal_photo" placeholder="الصورة الشخصية" value="{{ old('personal_photo')}}" />
                                            @error('personal_photo')
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
                                        <label class="w-100" for="job">الوظيفة
                                            <input type="text" min='0' class="form-control" name="job" placeholder="الشعار" value="{{old('job')}}" />
                                            @error('job')
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
                                        <label class="w-100" for="personal_info">نص تعريفي(اختياري)
                                            <input type="text" min='0' class="form-control" name="personal_info" placeholder="نص تعريفي" value="{{old('personal_info')}}" />
                                            @error('personal_info')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="form-group col-4">
                                        <label class="w-100" for="experience"> الخبرة
                                            <input type="text" min='0' class="form-control" name="experience" placeholder=" الخبرة" value="{{old('experience')}}" />
                                            @error('experience')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="form-group col-4">
                                        <label class="w-100" for="coverletter">صورة الغلاف  (اختياري)
                                            <input type="file" min='0' class="form-control" name="coverletter" placeholder="الصورة الشخصية" value="{{ old('coverletter')}}" />
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
