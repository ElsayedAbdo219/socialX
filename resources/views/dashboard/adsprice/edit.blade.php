@extends('components.dashboard.layouts.master')
@section('title')
    {{ __('dashboard.adsprice') }}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        {{-- <div class="header-navbar-shadow"></div> --}}
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{ __('dashboard.adsprice') }}">
                <li class="breadcrumb-item"><a href="{{ route('admin.Ads-price.index') }}">
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('dashboard.title edit') }} </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST"
                                action="{{ route('admin.Ads-price.update', $AdsPrice->id) }}">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="title">{{ __('dashboard.price') }}
                                            <input type="text" class="form-control" name="price"
                                                placeholder="{{ __('dashboard.title') }}"
                                                value="{{ $AdsPrice->price ?? old('price') }}" style="width: 500px;height:40px"/>
                                            @error('price')
                                                <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </label>
                                    </div>
                                    </div>

                                    <div class="row" >
                                        <div class="form-group col-12">
                                            <label for="title">{{ __('dashboard.currency') }}
                                                <select name="currency" class="form-control" id="currency" style="width: 500px;height:40px">
                                                    @foreach ($currencies ?? [] as $currency)
                                                        <option value="{{ $currency }}"
                                                            {{ $AdsPrice->currency == $currency ? 'selected' : '' }}>
                                                            {{ $currency }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('currency')
                                                    <span style="font-size: 12px;"
                                                        class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </label>
                                        </div>

                                    </div>
                                    <div class="row" >
                                    <div class="form-group col-12">
                                        <label for="type">{{ __('dashboard.type') }}
                                            <select name="type" class="form-control" id="type" style="width: 500px;height:40px">
                                                <option value="video" {{ $AdsPrice->type == 'video' ? 'selected' : '' }}>
                                                    {{ __('dashboard.video') }}</option>
                                                <option value="image" {{ $AdsPrice->type == 'image' ? 'selected' : '' }}>
                                                    {{ __('dashboard.image') }}</option>
                                            </select>
                                            @error('type')
                                                <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </label>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-12 mt-2">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1"
                                            class="edit">{{ __('dashboard.edit') }}</button>
                                    </div>
                                    </div>

                                     <div class="row">
                                    <div class="form-group col-12">
                                        <label for="title">{{ __('dashboard.appearence_count_for_time') }}
                                            <input type="text" class="form-control" name="appearence_count_for_time"
                                                placeholder="{{ __('dashboard.title') }}"
                                                value="{{ $AdsPrice->appearence_count_for_time ?? old('appearence_count_for_time') }}" style="width: 500px;height:40px"/>
                                            @error('appearence_count_for_time')
                                                <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </label>
                                    </div>
                                    </div>

                                    <div class="row" >
                                    <div class="form-group col-12" id="resolution-group">
                                        <label for="resolution">{{ __('dashboard.resolution') }}
                                            <select name="resolution" id="resolution" class="form-control" style="width: 500px;height:40px">
                                                <option value="">اختر الدقة</option>
                                                <option value="720" {{ $AdsPrice->resolution == '720' ? 'selected' : '' }}>
                                                    720p</option>
                                                <option value="1080" {{ $AdsPrice->resolution == '1080' ? 'selected' : '' }}>
                                                    1080p</option>
                                                <option value="1440" {{ $AdsPrice->resolution == '1440' ? 'selected' : '' }}>
                                                    1440p</option>
                                                <option value="2160" {{ $AdsPrice->resolution == '2160' ? 'selected' : '' }}>
                                                    2160p</option>
                                            @error('resolution')
                                                <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </label>
                                    </div>
                                 </div>

                                
                            {{-- </div>  --}}
                            {{-- </div>
                            </div> --}}
                            {{-- </div> --}}
                            
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
        $(document).ready(function() {
          // alert($('#resolution').val());
            // Hide resolution input by default
            //$('#resolution-group').hide();
            $('#type').change(function() {
              // alert('Type changed to: ' + $(this).val());
                if ($('select[name="type"]').val() == 'video') {
                    $('#resolution-group').show();
                    $('#resolution').attr('required', 'required');
                } else {
                    $('#resolution').removeAttr('required');
                    $('#resolution-group').hide();
                }
            });
        });
    </script>
@endsection
