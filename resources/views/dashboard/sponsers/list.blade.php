@extends('components.dashboard.layouts.master')
@section('styles')
    @stack('datatableStyles')
    <style>
    #base-table tbody tr {
        cursor: move;
    }
</style>

@endsection
@section('title')
    {{__('dashboard.sponsers')}}
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
                    <x-dashboard.layouts.breadcrumb  now="{{__('dashboard.sponsers')}}">
                    </x-dashboard.layouts.breadcrumb>
                    <!-- Column selectors with Export Options and print table -->
                    <section id="column-selectors">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{__('dashboard.sponsers')}}</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body card-dashboard">
                                            <x-pages.datatable

                                                :title="__('dashboard.add')"
                                                route="admin.sponsers"
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
    {{-- @dd('test debuging'); --}}
@endsection
<!-- END: Content-->
@section('script')
    @stack('datatableScripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
$(document).ready(function () {
  enableRowSorting();
});

function enableRowSorting() {
    $('#base-table tbody').sortable({
        handle: 'td', // علشان تقدر تسحب من أي عمود
        update: function (event, ui) {
            let order = [];

            $('#base-table tbody tr').each(function (index) {
                const id = $(this).attr('id')?.replace('row-', '');
                if (id) {
                    order.push({ id: id, position: index + 1 });
                }
            });

            $.ajax({
                url: '/admin/sponsers/update-order', 
                method: 'POST',
                data: {
                    order: order,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    console.log('تم الحفظ بنجاح');
                },
                error: function (err) {
                    alert('حصل خطأ أثناء الحفظ');
                }
            });
        }
    });
}


</script>

@endsection
