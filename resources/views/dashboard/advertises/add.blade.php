@extends('components.dashboard.layouts.master')
@section('title')
    اضافة اعلان جديدة
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now=" اضافة اعلان جديدة">
                <li class="breadcrumb-item"><a href="{{route('admin.advertises.index')}}">
                      قائمة الاعلانات
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> اضافة اعلاان جديدة</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{route('admin.advertises.store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-4" id="video" style="display: none">
                                        <label class="w-100" for="logo">{{ __('dashboard.video') }}
                                            <input type="file" class="form-control" name="file_name" placeholder="الملف المرفوع" value="{{ old('file_name')}}" />
                                            @error('file_name')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="form-group col-4" id="video" style="display: none">
                                        <label class="w-100" for="logo">{{ __('dashboard.image') }}
                                            <input type="file"  class="form-control" name="image" placeholder="الصورة" value="{{ old('image')}}" />
                                            @error('image')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="name_en">{{ __('dashboard.company') }}</label>
                                        <select class="form-control" name="user_id" id="user_id">
                                            
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->full_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                      <div class="form-group col-4">
                                        <label class="w-100" for="email">{{__('dashboard.content')}}
                                            <textarea name="content" id="contentTextArea" cols="30" placeholder="{{__('dashboard.content')}}" class="form-control" rows="10" class="d-none"></textarea>
                                            @error('content')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="form-group col-4">
                                        <label class="w-100" for="period">{{__('dashboard.period')}} (دقيقة)
                                            <input type="number"  class="form-control" name="period" placeholder="{{__('dashboard.period')}}" value="{{old('period')}}" />
                                            @error('period')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                      <div class="form-group col-4">
                                        <label class="w-100" for="slogo">{{ __('dashboard.is_published') }}(بالايام)
                                            <input type="number"  class="form-control" name="is_published" placeholder="{{ __('dashboard.is_published') }}" value="{{old('is_published')}}" />
                                            @error('is_published')
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
