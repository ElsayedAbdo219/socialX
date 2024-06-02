@extends('components.dashboard.layouts.master')
@section('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .setting-nav-active {
            background: #F57141;
            color: white;
        }
    </style>
@endsection
@section('title')
    {{ __('dashboard.settings') }}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{ __('dashboard.app_settings') }}">
            </x-dashboard.layouts.breadcrumb>
            <div class="content-header row">
            </div>
            <div class="content-body">


                <div class="row">
                    {{-- side nav --}}
                    <div class="col-3 bg-white text-center p-2 m-1" style="height: fit-content">
                        <div class="text-center ">
                            <ul>

                                <p class="p-1 m-1 {{ $page == 'contact' ? 'setting-nav-active' : '' }}">
                                    <a href="{{ route('admin.settings.index', ['page' => 'contact']) }}"
                                       class="{{ $page == 'contact' ? 'setting-nav-active' : '' }}">
                                        {{ __('dashboard.contact ways') }}
                                    </a>
                                </p>

                                <p class="p-1 m-1 {{ $page == 'about' ? 'setting-nav-active' : '' }}">
                                    <a href="{{ route('admin.settings.index', ['page' => 'about']) }}"
                                       class="{{ $page == 'about' ? 'setting-nav-active' : '' }}">
                                        {{ __('dashboard.app about') }}
                                    </a>
                                </p>
                                <p class="p-1 m-1 {{ $page == 'terms' ? 'setting-nav-active' : '' }}">
                                    <a href="{{ route('admin.settings.index', ['page' => 'terms']) }}"
                                       class="{{ $page == 'terms' ? 'setting-nav-active' : '' }}">
                                        {{ __('dashboard.Usage Terms') }}
                                    </a>
                                </p>
                                <p class="p-1 m-1 {{ $page == 'privacy' ? 'setting-nav-active' : '' }}">
                                    <a href="{{ route('admin.settings.index', ['page' => 'privacy']) }}"
                                       class="{{ $page == 'points' ? 'setting-nav-active' : '' }}">
                                        {{ __('dashboard.application privacy') }}
                                    </a>
                                </p>
                            </ul>
                        </div>
                    </div>
                    {{-- setting content --}}
                    <div class="col-8 bg-white p-5 m-1">

                        @foreach ($settings as $setting)
                            @if ($page === 'contact' && $setting->key === 'app-contacts')
                                <form action="{{ route('admin.settings.update', $setting->id) }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row">
                                        @foreach ($setting->value['phones'] ?? [] as $key => $phone)
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>{{ __('dashboard.phone Number') }} ({{$key + 1}})</label>
                                                    <input type="number" class="form-control" name="number[]" value="{{ $phone }}">
                                                </div>
                                            </div>
                                        @endforeach
                                        @error('number')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{ __('dashboard.watsApp') }}</label>
                                                <input type="number" class="form-control" name="watsApp"
                                                       value="{{ $setting->value['watsApp'] }}">
                                                @error('watsApp')
                                                <span style="font-size: 12px;"
                                                      class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{ __('dashboard.facebook') }}</label>
                                                <input type="text" class="form-control" name="facebook"
                                                       value="{{ $setting->value['facebook'] }}">
                                                @error('facebook')
                                                <span style="font-size: 12px;"
                                                      class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{ __('dashboard.snapchat') }}</label>
                                                <input type="text" class="form-control" name="snapchat"
                                                       value="{{ $setting->value['snapchat'] }}">
                                                @error('snapchat')
                                                <span style="font-size: 12px;"
                                                      class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>{{ __('dashboard.instagram') }}</label>
                                                <input type="text" class="form-control" name="instagram"
                                                       value="{{ $setting->value['instagram'] }}">
                                                @error('instagram')
                                                <span style="font-size: 12px;"
                                                      class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit"
                                            class="btn btn-primary">{{ trans('dashboard.update') }}</button>
                                </form>
                            @endif
                            @if ($page === 'about' && $setting->key === 'about-app')
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ __('dashboard.app about') }}</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            {{-- Hidden Form --}}
                                            <form class="form form-vertical d-none"  id="formAbout" method="POST"
                                                  action="{{ route('admin.settings.update', $setting->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="row">
                                                    <div class="form-group col-4">
                                                        <textarea name="contentAbout" id="TextAreaAbout" cols="30"
                                                                  rows="10"></textarea>
                                                    </div>
                                                </div>
                                            </form>
                                            <!--  Formatted TextArea -->
                                            <div class=""
                                                 style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto"
                                                 lang="ar" dir="rtl">
                                                <div id="editor">
                                                    {!! $setting->value['ar'] ?? 'نص اختباري' !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button onclick="submitFormAbout()"
                                                    class="btn btn-primary mr-1 mb-1 m-3">{{ __('dashboard.edit') }}</button>
                                        </div>
                                        @error('content')
                                        <div style="font-size: 12px; margin:20px 10px;" class="text-danger ">
                                            {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            @if ($page === 'terms' && $setting->key === 'terms-and-conditions')
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ __('dashboard.Usage Terms') }}</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            {{-- Hidden Form --}}
                                            <form class="form form-vertical d-none" id="formUsageTermPage" method="POST"
                                                  action="{{ route('admin.settings.update', $setting->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="row">
                                                    <div class="form-group col-4">
                                                        <textarea name="contentTerms" id="TextAreaUsageTerms" cols="30"
                                                                  rows="10"></textarea>
                                                    </div>
                                                </div>
                                            </form>
                                            <!--  Formatted TextArea -->
                                            <div class=""
                                                 style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto"
                                                 lang="ar" dir="rtl">
                                                <div id="editor">
                                                    {!! $setting->value['ar'] ?? 'نص اختباري' !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button onclick="submitFormUsageTerm()"
                                                    class="btn btn-primary mr-1 mb-1 m-3">{{ __('dashboard.edit') }}</button>
                                        </div>
                                        @error('content')
                                        <div style="font-size: 12px; margin:20px 10px;" class="text-danger ">
                                            {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif


                            @if ($page === 'privacy' && $setting->key === 'app-privacy')
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ __('dashboard.application privacy') }}</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            {{-- Hidden Form --}}
                                            <form class="form form-vertical d-none" id="formPrivacyPage" method="POST"
                                                  action="{{ route('admin.settings.update', $setting->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="row">
                                                    <div class="form-group col-4">
                                                        <textarea name="content" id="TextAreaPrivacy" cols="30"
                                                                  rows="10"></textarea>
                                                    </div>
                                                </div>
                                            </form>
                                            <!--  Formatted TextArea -->
                                            <div class=""
                                                 style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto"
                                                 lang="ar" dir="rtl">
                                                <div id="editor">
                                                    {!! $setting->value['ar'] ?? 'نص اختباري' !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button onclick="submitformPrivacyPage()"
                                                    class="btn btn-primary mr-1 mb-1 m-3">{{ __('dashboard.edit') }}</button>
                                        </div>
                                        @error('content')
                                        <div style="font-size: 12px; margin:20px 10px;" class="text-danger ">
                                            {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
            @endsection
            <!-- END: Content-->
            @section('script')
                <!-- Include the Quill library -->
                <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
                <script>
                    var toolbarOptions = [
                        ['bold', 'italic', 'underline'], // toggled buttons
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        [{
                            'header': [1, 2, 3, 4, 5, 6, false]
                        }],
                        [{
                            'color': []
                        }, {
                            'background': []
                        }], // dropdown with defaults from theme
                        ['clean'] // remove formatting button
                    ];
                    var quill = new Quill('#editor', {
                        modules: {
                            toolbar: toolbarOptions
                        },
                        theme: 'snow'
                    });
                    quill.format('align', 'right');
                    quill.format('direction', 'rtl');
                    // quill.on('text-change', function() {
                    //     $('#TextAreaUsageTerms').val($('#editor .ql-editor').html());
                    // });

                    function submitFormUsageTerm() {
                        $('#TextAreaUsageTerms').val($('#editor .ql-editor').html());
                        $('#formUsageTermPage').submit();
                    }

                    function submitformPrivacyPage() {
                        $('#TextAreaPrivacy').val($('#editor .ql-editor').html());
                        $('#formPrivacyPage').submit();
                    }

                    function submitFormAbout() {
                        $('#TextAreaAbout').val($('#editor .ql-editor').html());
                        $('#formAbout').submit();
                    }

                </script>
@endsection
