@extends('components.dashboard.layouts.master')
@section('styles')

@endsection
@section('title')
    {{__('dashboard.Complains')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- users list start -->
                <section class="users-list-wrapper">
                    <x-dashboard.layouts.breadcrumb now="{{__('dashboard.Complains')}}">
                    </x-dashboard.layouts.breadcrumb>
                    <!-- Column selectors with Export Options and print table -->
                    <section id="column-selectors">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{__('dashboard.Complains')}}</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body card-dashboard">
                                            <div class="p-2 row cols-12">
                                                <div class=" col-12 ">
                                                    <div class="border border-warning">
                                                        <h5 class="cols-12 m-3">{{__('dashboard.content')}}</h5>
                                                        <p class="cols-12 m-3 ">{{ $complain->message ?? '---' }}</p>
                                                    </div>
                                                    <div class="cols-12">
                                                        {{-- <h5 class="cols-12 m-3">{{__('dashboard.change_status')}}</h5> --}}
                                                        <div class="">
                                                            <form action="{{route('admin.complain.update',$complain->id)}}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="form-group col-sm-3 mt-2">
                                                                    <label style="width: 100%" for="statusArray">{{__('dashboard.status')}}
                                                                        <select class="form-control select2 statusArray" name="status">
                                                                            {{-- <option selected disabled readonly>{{__('dashboard.choose_status')}}</option> --}}
                                                                            @foreach ([
                                                                                'unsolved' => __('dashboard.unsolved') , 
                                                                                'processing' => __('dashboard.processing') , 
                                                                                'solved' => __('dashboard.solved') , 
                                                                            ] as $key => $value)
                                                                                <option value="{{$key}}" {{ $complain->status === $key ? 'selected' : '' }} >{{$value}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('status')
                                                                        <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                                                        @enderror
                                                                    </label>
                                                                    <button type="submit"class="btn btn-primary mt-2">{{__("dashboard.edit")}}</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    <script>
    </script>
@endsection
