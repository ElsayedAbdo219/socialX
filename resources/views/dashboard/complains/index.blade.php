{{-- @extends('components.dashboard.layouts.master')
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
                    <select name="" id="SelectSolvedComplainPage" style="margin: 3rem auto;" onchange="SolvedComplainPageFn()">
                        <option value="unsolved" selected >{{__('dashboard.unsolved')}}</option>
                        <option value="solved" >{{__('dashboard.solved')}}</option>
                    </select>
                    <section id="column-selectors">
                        <div class="row text-center">
                            <div class="col-12">
                                <div id="SolvedComplainPage">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{__('dashboard.solved complains')}}</h4>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body card-dashboard">
                                                <div class="p-5 m-5 row cols-12">
                                                    @foreach ($solvedComplains as $complain)
                                                        <div class=" col-12 text-center m-5">
                                                            <p class="cols-12 m-5">{{ $complain->content ?? '---' }}</p>
                                                            <div class="cols-12 d-flex justify-content-around">
                                                                <a href="{{route('admin.merchant.show', $complain->user_id )}}">
                                                                    <button class="btn btn-primary mr-1 mb-1">{{__("dashboard.show_merchant")}}</button>
                                                                </a>
                                                                <form action="{{route('admin.complains.unsolved', $complain->id )}}" method="POST">
                                                                    @csrf
                                                                    <button class="btn btn-primary mr-1 mb-1">{{__("dashboard.unsolved")}}</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="UnsolvedComplainPage">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{__('dashboard.unsolved complains')}}</h4>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body card-dashboard">
                                                <div class="p-5 m-5 row cols-12">
                                                    @foreach ($unsolvedComplains as $complain)
                                                        <div class=" col-12 text-center m-5">
                                                            <p class="cols-12 m-5">{{ $complain->content ?? '---' }}</p>
                                                            <div class="cols-12 d-flex justify-content-around">
                                                                <a href="{{route('admin.merchant.show', $complain->user_id )}}">
                                                                    <button class="btn btn-primary mr-1 mb-1">{{__("dashboard.show_merchant")}}</button>
                                                                </a>
                                                                <form action="{{route('admin.complains.solved', $complain->id )}}" method="POST" >
                                                                    @csrf
                                                                    <button class="btn btn-primary mr-1 mb-1">{{__("dashboard.solved")}}</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endforeach
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
        function SolvedComplainPageFn() {
            if ($('#SelectSolvedComplainPage').val() == 'solved') {
                $('#SolvedComplainPage').show();
                $('#UnsolvedComplainPage').hide();
            } else {
                $('#SolvedComplainPage').hide();
                $('#UnsolvedComplainPage').show();
            }
        }
        SolvedComplainPageFn()
    </script>
@endsection --}}
