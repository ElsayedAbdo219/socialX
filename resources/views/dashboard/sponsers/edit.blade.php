@extends('components.dashboard.layouts.master')
@section('title')
    {{__('dashboard.advertises')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        {{-- <div class="header-navbar-shadow"></div> --}}
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{$Advertise?->user->full_name}}">
                <li class="breadcrumb-item"><a href="{{route('admin.advertises.index')}}">
                        {{__('dashboard.edit_advertise')}}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('dashboard.title edit')}} </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{route('admin.advertises.update',$Advertise->id)}}">
                                @csrf
                                @method('PATCH')
                                <div class="form-group col-4">
                                    <label class="w-100" for="slogo">الحالة
                                        <select class="form-control select2 status" name="status">
                                            @foreach( $adsStatus as $status)
                                                <option value="{{ $status }}" {{ $Advertise?->adsStatus?->status === $status ? 'selected' : '' }} >
                                                    {{ $status}}
                                                </option>
                                            @endforeach
                                            </select>
                                        @error('status')
                                        <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                        @enderror
                                    </label>
                                </div>

                                <div class="form-group col-4 reason" style="display: none">
                                    <label class="w-100" for="slogo">السبب
                                        <textarea type="text" class="form-control" name="reason_cancelled" placeholder="{{__('dashboard.reason_cancelled')}}">{{ old('reason_cancelled', $Advertise?->adsStatus?->reason_cancelled) }}</textarea>
                                        @error('reason_cancelled')
                                        <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                        @enderror
                                    </label>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">{{__('dashboard.edit')}}</button>
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
        $(document).ready(function () {
            if($('.status').val() === 'cancelled'){
                $('.reason').show();
            }else{
                $('.reason').hide();
            }
            $('.status').on('change',function(){
                if($(this).val() === 'cancelled'){
                    $('.reason').show();
                }else{
                    $('.reason').hide();
                }
            })
        });
    </script>
@endsection