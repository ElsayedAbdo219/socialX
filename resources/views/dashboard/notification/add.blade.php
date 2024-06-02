@extends('components.dashboard.layouts.master')

@section('title')
    {{__('dashboard.add_notification')}}
@endsection
@section('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{__('dashboard.add_notification')}}">
                <li class="breadcrumb-item"><a href="{{route('admin.notification.index')}}">
                        {{__('dashboard.notification_list')}}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('dashboard.add_notification')}}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" id="formNotificationPage" action="{{route('admin.notification.store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-9    ">
                                        <label class="w-100" for="title">{{__('dashboard.title')}}
                                            <input type="text" class="form-control" name="title" placeholder="{{__('dashboard.title')}}" value="{{$notification->title ?? old('title')}}" />
                                            @error('title')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>
                                    {{-- Hidden Form --}}
                                    <div class="form-group col-4">
                                        <textarea name="body" id="contentTextArea" cols="30" rows="10" class="d-none"></textarea>
                                    </div>
                                    <!--  Formatted TextArea -->
                                    <label class="w-100 px-1" for="content">{{__('dashboard.content')}}
                                    </label>
                                    <div class="" style="width:100% !important; height:600px !important; over-flow:scroll; padding:1rem;" lang="ar" dir="rtl">
                                        <div id="editor" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row " style="margin:2rem 0"></div>
                                @error('body')
                                    <div style="font-size: 12px; margin:20px 1rem;" class="text-danger ">{{$message}}</div>
                                @enderror
                                <div class="col-12 row" style="">
                                    <button onclick="submitNotification()" class="btn btn-primary mb-1">{{__('dashboard.send')}}</button>
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
            <!-- Include the Quill library -->
            <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
            <script>
                var toolbarOptions = [
                    ['bold', 'italic', 'underline'],        // toggled buttons
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                    ['clean']                                         // remove formatting button
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
                //     $('#contentTextArea').val($('#editor .ql-editor').html());
                // });

                function submitNotification () {
                    $('#contentTextArea').val($('#editor .ql-editor').html());
                    $('#formNotificationPage').submit();
                }
            </script>
@endsection
