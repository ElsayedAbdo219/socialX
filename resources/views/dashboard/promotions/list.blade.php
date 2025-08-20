@extends('components.dashboard.layouts.master')
@section('styles')
    @stack('datatableStyles')
@endsection
@section('title')
    {{__('dashboard.promotions')}}
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
                    <x-dashboard.layouts.breadcrumb  now="{{__('dashboard.promotions')}}">
                    </x-dashboard.layouts.breadcrumb>
                    <!-- Column selectors with Export Options and print table -->
                    <section id="column-selectors">
                      
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{__('dashboard.promotions')}}</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body card-dashboard">
                                            <x-pages.datatable

                                                :title="__('dashboard.add')"
                                                route="admin.promotions"
                                                :datatable="$dataTable"
                                                :create='true'
                                            />
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



</script>


@endsection
