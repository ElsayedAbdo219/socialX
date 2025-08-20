@extends('components.dashboard.layouts.master')
@section('title')
    {{__('dashboard.categories')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        {{-- <div class="header-navbar-shadow"></div> --}}
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{$category->name}}">
                <li class="breadcrumb-item"><a href="{{route('admin.categories.index')}}">
                        {{__('dashboard.categories_list')}}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('dashboard.title edit')}} </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{route('admin.categories.update',$category->id)}}" >
                                @csrf
                                @method('PATCH')
                               <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label for="title">{{__('dashboard.name')}}
                                            <input type="text"  class="form-control" name="name" placeholder="{{__('dashboard.name')}}" value="{{$category->name ?? old('name')}}" />
                                            @error('name')
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
@section('script')
    <script>
        $(document).ready(function () {
            $('.statusArray').select2(
                {
                    placeholder: "{{__('dashboard.choose_status')}}",
                }
            )
             

            // show comment input when value status equal rejected


            $status=$('.statusArray').val();
            $status_option=$('.status_option').val();

            
             if($status==='accepted'){
                $('.comment_class').hide();
            }
           else if($status==='rejected'){
                $('.comment_class').show();
            }
           


           $('.statusArray').on('change',function(){
            if($(this).val()==='rejected'){
                $('.comment_class').show();
              
            }else{
           $('.comment_class').hide();

            }

            $(".edit").click(function(){
                if( $status==='rejected'){
                    $('.status_option').val('rejected');


                }
});

            
    });

   
        })
    </script>
@endsection