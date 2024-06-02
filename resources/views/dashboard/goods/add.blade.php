@extends('components.dashboard.layouts.master')
@section('title')
    {{__('dashboard.goods_add')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
@if (session('success'))
<script>
    toastr.success('{{(session("success")) }}');
</script>
@endif
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{__('dashboard.goods_add')}}">
                <li class="breadcrumb-item"><a href="{{url('admin/goods-types/')}}">
                        {{__('dashboard.goods')}}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('dashboard.goods_add')}}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{route('admin.goods-types.store')}}" >
                                @csrf
                              <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label for="name_en">{{__('dashboard.name')}}
                                            <input type="text"  class="form-control" name="name" placeholder="{{__('dashboard.name')}}" value="{{$MerchantCodingRequest->name ?? old('name')}}" />
                                            @error('name')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label> 
                                    </div>
                                  
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1" class="store">{{__('dashboard.submit')}}</button>
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

@endsection