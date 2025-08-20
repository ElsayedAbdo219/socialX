@extends('components.dashboard.layouts.master')
@section('title')
    {{__('dashboard.edit_employee')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        {{-- <div class="header-navbar-shadow"></div> --}}
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{__('dashboard.edit_employee')}}">
                <li class="breadcrumb-item"><a href="{{route('admin.fqa.index')}}">
                        {{__('dashboard.employees_list')}}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('dashboard.edit_employee')}}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{route('admin.employees.update',$Employee->id)}}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="row">

                                    <div class="form-group col-4">
                                        <label class="w-100" for="slogo">الحالة
                                            <select class="form-control" name="is_Active" >
                                                <option value="1"  {{ $Employee->is_Active == 1 ?  'selected' : ''  }}>نشط</option>
                                                <option value="0"  {{ $Employee->is_Active == 0 ?  'selected' : ''  }}>غير نشط</option>
                                            </select>
                                               @error('is_Active')
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
