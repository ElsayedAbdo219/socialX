@extends('components.dashboard.layouts.master')
@section('title')
    {{__('dashboard.job')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        {{-- <div class="header-navbar-shadow"></div> --}}
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{$job->job_name}}">
                <li class="breadcrumb-item"><a href="{{route('admin.jobs.index')}}">
                        {{__('dashboard.edit_job')}}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('dashboard.title edit')}} </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{route('admin.jobs.update',$job->id)}}" >
                                @csrf
                                @method('PATCH')
                               <div class="row">
                                <div class="form-group col-4">
                                    <label class="w-100" for="slogo">الحالة
                                        <select class="form-control" name="is_Active">
                                            <option value="1" {{ $job->is_Active == 1 ?  'selected' : ''  }}>نشط</option>
                                            <option value="0" {{ $job->is_Active == 0 ?  'selected' : ''  }}>غير نشط</option>
                                        </select>
                                           @error('is_Active')
                                        <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                        @enderror
                                    </label>
                                </div>
                               
                           
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1" class="edit">{{__('dashboard.edit')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
