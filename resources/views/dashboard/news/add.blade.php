@extends('components.dashboard.layouts.master')
@section('title')
    {{ __('dashboard.news_add') }}
@endsection

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
            <x-dashboard.layouts.breadcrumb now="{{ __('dashboard.news_add') }}">
                <li class="breadcrumb-item"><a href="{{ url('admin/news/') }}">
                        {{ __('dashboard.news') }}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>

            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('dashboard.news_add') }}</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{ route('admin.news.store') }}">
                                @csrf
                                <div class="row">
                                    <!-- Arabic -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">العنوان</label>
                                            <textarea class="form-control" name="title" placeholder="العنوان" style="height:100px;">{{ old('title') }}</textarea>
                                            @error('title')
                                                <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="contentNews">المحتوي</label>
                                            <textarea class="form-control" name="contentNews" placeholder="المحتوي" style="height:150px;">{{ old('contentNews') }}</textarea>
                                            @error('contentNews')
                                                <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- English -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title_en">العنوان - باللغة الإنجليزية</label>
                                            <textarea class="form-control" name="title_en" placeholder="العنوان بالإنجليزية" style="height:100px;">{{ old('title_en') }}</textarea>
                                            @error('title_en')
                                                <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="contentNews_en">المحتوي - باللغة الإنجليزية</label>
                                            <textarea class="form-control" name="contentNews_en" placeholder="المحتوي بالإنجليزية" style="height:150px;">{{ old('contentNews_en') }}</textarea>
                                            @error('contentNews_en')
                                                <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Is Poll -->
                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
                                            <label class="w-100">{{ __('dashboard.is_poll') }}</label><br>
                                            <label><input type="checkbox" name="is_poll" value="1"> @lang('dashboard.yes')</label><br>
                                            <label><input type="checkbox" name="is_poll" value="0"> @lang('dashboard.no')</label><br>
                                            @error('is_poll')
                                                <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">
                                            {{ __('dashboard.submit') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div> <!-- end card-content -->

                </div> <!-- end card -->
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
