@extends('components.dashboard.layouts.master')
@section('title')
    {{__('dashboard.add_fqa')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{__('dashboard.add_fqa')}}">
                <li class="breadcrumb-item"><a href="{{route('admin.fqa.index')}}">
                        {{__('dashboard.fqas_list')}}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('dashboard.add_fqa')}}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{route('admin.fqa.store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label class="w-100" for="order">{{__('dashboard.order')}}
                                            <input type="number" min='0' class="form-control" name="order" placeholder="{{__('dashboard.order')}}" value="{{$fqa->order ?? old('order')}}" />
                                            @error('order')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>
                                    {{-- <div class="form-group col-12">
                                        <label class="w-100" for="question_en">{{__('dashboard.question_en')}}
                                            <input type="text" min='0' class="form-control" name="question_en" placeholder="{{__('dashboard.question_en')}}" value="{{$fqa->question_en ?? old('question_en')}}" />
                                            @error('question_en')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>
                                    <div class="form-group col-12">
                                        <label class="w-100" for="answer_en">{{__('dashboard.answer_en')}}
                                            <input type="text" min='0' class="form-control" name="answer_en" placeholder="{{__('dashboard.answer_en')}}" value="{{$fqa->answer_en ?? old('answer_en')}}" />
                                            @error('answer_en')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div> --}}
                                    <div class="form-group col-12">
                                        <label class="w-100" for="question_ar">{{__('dashboard.question_ar')}}
                                            <input type="text" min='0' class="form-control" name="question" placeholder="{{__('dashboard.question_ar')}}" value="{{$fqa->question?? old('question_ar')}}" />
                                            @error('question')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>
                                    <div class="form-group col-12">
                                        <label class="w-100" for="answer_ar">{{__('dashboard.answer_ar')}}
                                            <input type="text" min='0' class="form-control" name="answer" placeholder="{{__('dashboard.answer_ar')}}" value="{{$fqa->answer ?? old('answer_ar')}}" />
                                            @error('answer')
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
