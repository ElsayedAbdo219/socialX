@extends('components.dashboard.layouts.master')
@section('title')
    {{__('dashboard.news')}}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{$News->name}}">
                <li class="breadcrumb-item"><a href="{{route('admin.news.index')}}">
                        {{__('dashboard.news_list')}}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('dashboard.title edit')}} </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{route('admin.news.update',$News->id)}}" >
                                @csrf
                                @method('PATCH')
                               <div class="row">
                                    <div class="form-group col-sm-3">
                                        <label for="title">{{__('dashboard.title')}}
                                            <input type="text"  class="form-control" name="title" placeholder="{{__('dashboard.title')}}" value="{{$News->title ?? old('title')}}" />
                                            @error('title')
                                            <span style="font-size: 12px;" class="text-danger">{{$message}}</span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="contentNews">{{__('dashboard.contentNews')}}
                                            <input type="text"  class="form-control" name="contentNews" placeholder="{{__('dashboard.contentNews')}}" value="{{$News->contentNews ?? old('contentNews')}}" />
                                            @error('contentNews')
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