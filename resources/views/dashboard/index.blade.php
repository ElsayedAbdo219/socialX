@extends('components.dashboard.layouts.master')
@section('title')
        {{__('dashboard.dashboard')}}
@endsection
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section id="dashboard-analytics">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="card bg-analytics text-white">
                                <div class="card-content">
                                    <div class="card-body text-center">
                                        <img src="{{asset('dashboardAssets/app-assets/images/elements/decore-left.png')}}" class="img-left" alt="
                                            card-img-left">
                                        <img src="{{asset('dashboardAssets/app-assets/images/elements/decore-right.png')}}" class="img-right" alt="
                                            card-img-right">
                                        <div class="avatar avatar-xl bg-primary shadow mt-0">
                                            <div class="avatar-content">
                                                <i class="feather icon-award white font-large-1"></i>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <h1 class="mb-2 text-white">{{__('dashboard.hello')}} {{ auth()->user()->name }}</h1>
                                            <p class="m-auto w-75">{{__('dashboard.welcome_message')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                        <div class="col-lg-3 col-md-6 col-12">--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-header d-flex flex-column align-items-start pb-0">--}}
{{--                                    <div class="avatar bg-rgba-primary p-50 m-0">--}}
{{--                                        <div class="avatar-content">--}}
{{--                                            <i class="feather icon-users text-primary font-medium-5"></i>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <h2 class="text-bold-700 mt-1 mb-25">{{ '--'}}</h2>--}}
{{--                                    <p class="mb-0">--</p>--}}
{{--                                </div>--}}
{{--                                <div class="card-content">--}}
{{--                                    <div id="subscribe-gain-chart"></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
