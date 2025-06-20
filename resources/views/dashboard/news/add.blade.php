@extends('components.dashboard.layouts.master')
@section('title')
    {{__('dashboard.news_add')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
@if (session('success'))
<script>
    toastr.success('{{(session("success")) }}');
</script>
@endif
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{__('dashboard.news_add')}}">
                <li class="breadcrumb-item"><a href="{{url('admin/news/')}}">
                        {{__('dashboard.news')}}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('dashboard.news_add')}}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{route('admin.news.store')}}" >
                                @csrf
                              <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label for="name_en">العنوان
                                            <textarea type="text"  class="form-control" name="title" placeholder="العنوان" value="{{ old('title')}}" style="width:400px; height:100px;" ></textarea>
                                            @error('title')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label> 
                                    </div>
                              </div>
                                      <div class="row">
                                    <div class="form-group col-sm-12">
                                        <label for="name_en">المحتوي
                                            <textarea type="text"  class="form-control" name="contentNews" placeholder="العنوان" value="{{ old('contentNews')}}" style="width:500px; height:150px;" ></textarea>
                                            @error('contentNews')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label> 
                                    </div>
                                      </div>


                                      <div class="form-group col-4">
                                    <label class="w-100" for="is_poll">{{ __('dashboard.is_poll') }}
                                        <br>
                                        <label><input type="checkbox" name="is_poll" value="1">
                                                                                        @lang('dashboard.yes')</label><br>
                                        <label><input type="checkbox" name="is_poll" value="0"> @lang('dashboard.no') </label><br>
                                        @error('is_poll')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>

                                  
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1" class="store">{{__('dashboard.submit')}}</button>
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