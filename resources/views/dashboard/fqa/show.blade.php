@extends('components.dashboard.layouts.master')
@section('styles')
    @stack('datatableStyles')
@endsection
@section('title')
    {{__('dashboard.show_fqa')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        {{-- <div class="header-navbar-shadow"></div> --}}
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- users list start -->
                <section class="users-list-wrapper">
                    <x-dashboard.layouts.breadcrumb now="{{__('dashboard.show_fqa')}}">
                    <li class="breadcrumb-item"><a href="{{route('admin.fqa.index')}}">
                        {{__('dashboard.fqas_list')}}
                    </a></li>
                    </x-dashboard.layouts.breadcrumb>
                    <!-- Column selectors with Export Options and print table -->
                    <section id="column-selectors">
                        <div class="row text-center">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{__('dashboard.show_fqa')}}</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body card-dashboard">
                                            <div class="p-2 m-2 row cols-12">
                                                <div class=" col-12 text-center m-2">
                                                    <h3 class="cols-12">{{__("dashboard.order")}}</h3>
                                                    <p class="cols-12">{{ $fqa->order ?? '---' }}</p>
                                                </div>
                                                <div class=" col-12 text-center m-2">
                                                    <h3 class="cols-12">{{__("dashboard.question_ar")}}</h3>
                                                    <p class="cols-12">{{ $fqa->question ?? '---' }}</p>
                                                </div>
                                                <div class=" col-12 text-center m-2">
                                                    <h3 class="cols-12">{{__("dashboard.answer_ar")}}</h3>
                                                    <p class="cols-12">{{ $fqa->answer ?? '---' }}</p>
                                                </div>
                                                
                                            </div>
                                            {{-- <form action="{{route('admin.fqa.destroy',$fqa->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-danger rounded">delete</button>
                                            </form> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Column selectors with Export Options and print table -->
                </section>
                <!-- users list ends -->

            </div>
        </div>
    </div>
@endsection
<!-- END: Content-->
@section('script')
    @stack('datatableScripts')
    <script>
    </script>

@endsection
