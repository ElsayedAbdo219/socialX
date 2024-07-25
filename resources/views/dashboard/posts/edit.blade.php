@extends('components.dashboard.layouts.master')
@section('title')
    {{__('dashboard.posts')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{$post->company?->name}}">
                <li class="breadcrumb-item"><a href="{{route('admin.posts.index')}}">
                        {{__('dashboard.edit_post')}}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('dashboard.title edit')}} </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{route('admin.posts.update',$post->id)}}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <div class="form-group col-4">
                                    <label class="w-100" for="slogo">الحالة
                                        <select class="form-control" name="is_Active">
                                            <option value="1" {{ $post->is_Active == 1 ?  'selected' : ''  }}>نشط</option>
                                            <option value="0" {{ $post->is_Active == 0 ?  'selected' : ''  }}>غير نشط</option>
                                        </select>
                                           @error('is_Active')
                                        <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                        @enderror
                                    </label>
                                </div>

                                {{-- <div class="row">
                                    <div class="form-group col-4">
                                        <label class="w-100" for="logo">الملف
                                            <input type="file"  class="form-control" value="{{ $post->file_name }}" name="file_name" placeholder="الملف المرفوع" value="{{ old('file_name')}}" />
                                            @error('file_name')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div> --}}

                                    {{-- <div class="form-group col-sm-3">
                                        <label for="name_en">{{ __('dashboard.good_type') }}</label>
                                        <select class="form-control" name="company_id" id="company_id">
                                            
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}"  >{{ $company->full_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('company_id')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> --}}


                                      {{-- <div class="form-group col-4">
                                        <label class="w-100" for="email">{{__('dashboard.content')}}
                                            <textarea name="content" id="contentTextArea" cols="30" placeholder="{{__('dashboard.content')}}" class="form-control" rows="10" class="d-none" readonly>{{ $post->content }}</textarea>
                                            @error('content')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div> --}}



                                    {{-- <div class="form-group col-4">
                                        <label class="w-100" for="period">{{__('dashboard.period')}} (دقيقة)
                                            <input type="string"  class="form-control" name="period" placeholder="{{__('dashboard.period')}}" value="{{ $post->period ??  old('period')}}" />
                                            @error('period')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                      <div class="form-group col-4">
                                        <label class="w-100" for="slogo">{{ __('dashboard.is_published') }}(بالايام)
                                            <input type="string"  class="form-control" name="is_published" placeholder="{{ __('dashboard.is_published') }}" value="{{$post->is_published ?? old('is_published')}}" />
                                            @error('is_published')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div> --}}



                                   
                                    
                                   
                                 
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
