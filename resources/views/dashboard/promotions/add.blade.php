@extends('components.dashboard.layouts.master')
@section('title')
    @lang('dashboard.add_promotion')
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{ __('dashboard.add_promotion') }}">
                <li class="breadcrumb-item"><a href="{{ route('admin.promotions.index') }}">
                        @lang('dashboard.promotions')
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> @lang('dashboard.add_promotion')</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{ route('admin.promotions.store') }}">
                                @csrf
                                <div class="form-group col-4">
                                    <label class="w-100" for="email">{{ __('dashboard.promotion_name') }} - <span
                                            class="text-warning">@lang('dashboard.en_lang_only')</span>
                                        <input name="name" id="promotion" placeholder="{{ __('dashboard.name') }}"
                                            class="form-control">
                                        @error('name')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="validity">{{ __('dashboard.validity') }}</label>
                                    <select name="validity" id="validity" class="form-control validity select2">
                                        <option value="option_default" class="option_default" selected>@lang('dashboard.choose_the_promotion_validity')
                                        </option>
                                        <option value="period">@lang('dashboard.with_period')</option>
                                        <option value="days">@lang('dashboard.with_days_number')</option>
                                    </select>

                                    @error('validity')
                                        <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-4 start_date" style="display: none" id="start_date">
                                    <label class="w-100" for="start_date">{{ __('dashboard.start_date') }}
                                        <input type="date" class="form-control" name="start_date"
                                            placeholder="{{ __('dashboard.start_date') }}" />
                                        @error('start_date')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>

                                <div class="form-group col-4 end_date" style="display: none" id="end_date">
                                    <label class="w-100" for="end_date">{{ __('dashboard.end_date') }}
                                        <input type="date" class="form-control" name="end_date"
                                            placeholder="{{ __('dashboard.end_date') }}" />
                                        @error('end_date')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>

                                <div class="form-group col-4 days_count" style="display: none" id="days_count">
                                    <label class="w-100" for="days_count">{{ __('dashboard.days_count') }}
                                        <input type="number" class="form-control" name="days_count"
                                            placeholder="{{ __('dashboard.days_count') }}" />
                                        @error('days_count')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>


                                <div class="form-group col-4">
                                    <label class="w-100" for="discount">{{ __('dashboard.discount') }} %
                                        <input type="number" class="form-control" name="discount"
                                            placeholder="{{ __('dashboard.discount') }}" value="{{ old('discount') }}"
                                            min="0" max="100" />
                                        @error('discount')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>

                                <div class="form-group col-4">
                                    <label class="w-100" for="resolution_number">{{ __('dashboard.resolution_number') }} <br>
                                        <label><input type="checkbox" name="resolution_number[]" value="720" style="border-radius: 50%"> 720p</label><br>
                                        <label><input type="checkbox" name="resolution_number[]" value="1080"> 1080p</label><br>
                                        <label><input type="checkbox" name="resolution_number[]" value="1440"> 1440p</label><br>
                                        <label><input type="checkbox" name="resolution_number[]" value="2160"> 2160p
                                            (4K)</label><br>
                                        @error('resolution_number')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>


                                <div class="form-group col-sm-3">
                                    <label for="status">{{ __('dashboard.status') }}</label>
                                    <select name="is_active" id="status" class="form-control">
                                        <option value="1"
                                            {{ old('is_active', $model->is_active ?? '') == 1 ? 'selected' : '' }}>
                                            {{ __('dashboard.active') }}
                                        </option>
                                        <option value="0"
                                            {{ old('is_active', $model->is_active ?? '') == 0 ? 'selected' : '' }}>
                                            {{ __('dashboard.inactive') }}
                                        </option>
                                    </select>

                                    @error('is_active')
                                        <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button type="submit"
                                        class="btn btn-primary mr-1 mb-1">{{ __('dashboard.add') }}</button>
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
        document.getElementById('promotion').addEventListener('input', function() {
            this.value = this.value.replace(/[\u0600-\u06FF]/g, '');
        });


        // when change on value of validity
        $('#validity').on('change', function() {
            var validity = $(this).val();
            if (validity === 'period') {
                $('#start_date').show();
                $('#end_date').show();
                $('#days_count').hide();
            } else if (validity === 'days') {
                $('#start_date').hide();
                $('#end_date').hide();
                $('#days_count').show();
            } else {
                $('#start_date').hide();
                $('#end_date').hide();
                $('#days_count').hide();
            }
        });
    </script>
@endsection
