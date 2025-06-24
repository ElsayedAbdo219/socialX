@extends('components.dashboard.layouts.master')
@section('title')
    {{ __('dashboard.promotions') }}
@endsection
<!-- BEGIN: Content-->
@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{ $promotion->name }}">
                <li class="breadcrumb-item"><a href="{{ route('admin.promotions.index') }}">
                        {{ __('dashboard.edit_promotion') }}
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
                                action="{{ route('admin.promotions.update', $promotion->id) }}">
                                @csrf
                                @method('PATCH')
                                <div class="form-group col-4">
                                    <label class="w-100" for="email">{{ __('dashboard.name') }} - <span
                                            class="text-warning">@lang('dashboard.en_lang_only')</span>
                                        <input name="name" id="promotion" value="{{ $promotion->name }}"
                                            placeholder="{{ __('dashboard.name') }}" class="form-control"></input>
                                        @error('name')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>

                                <div class="form-group col-4">
                                    <label class="w-100" for="discount">{{ __('dashboard.discount') }} %
                                        <input type="number" class="form-control" name="discount"
                                            placeholder="{{ __('dashboard.discount') }}"
                                            value="{{ old('discount', $promotion->discount) }}" max="100" />
                                        @error('discount')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label for="validity">{{ __('dashboard.validity') }}</label>
                                    <select name="validity" id="validity" class="form-control validity select2">
                                        <option value="period" {{ empty($promotion->days_count) ? 'selected' : '' }}>
                                            @lang('dashboard.with_period')</option>
                                        <option value="days" {{ !empty($promotion->days_count) ? 'selected' : '' }}>
                                            @lang('dashboard.with_days_number')</option>
                                    </select>
                                    @error('validity')
                                        <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-4 start_date" id="start_date">
                                    <label class="w-100" for="start_date">{{ __('dashboard.start_date') }}
                                        <input type="date" class="form-control" name="start_date"
                                            value="{{ $promotion?->start_date }}"
                                            placeholder="{{ __('dashboard.start_date') }}" />
                                        @error('start_date')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>

                                <div class="form-group col-4 end_date" id="end_date">
                                    <label class="w-100" for="end_date">{{ __('dashboard.end_date') }}
                                        <input type="date" class="form-control" name="end_date"
                                            value="{{ $promotion?->end_date}}"
                                            placeholder="{{ __('dashboard.end_date') }}" />
                                        @error('end_date')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>

                                <div class="form-group col-4 days_count" id="days_count">
                                    <label class="w-100" for="days_count">{{ __('dashboard.days_count') }}
                                        <input type="number" class="form-control" name="days_count"
                                            value="{{ $promotion?->days_count }}"
                                            placeholder="{{ __('dashboard.days_count') }}" />
                                        @error('days_count')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>
{{-- @dd($promotion->resolutions) --}}

                                @php
                                 
                                    $array = $promotion->resolutions?->resolution_number ?? '[]';
                                    $resolutions = $array;
                                    if (!is_array($resolutions)) {
                                        $resolutions = [];
                                    }
                                @endphp
                                  {{-- @dd($resolutions) --}}
                                <div class="form-group col-4">
                                    <label class="w-100" for="resolution_number">{{ __('dashboard.resolution_number') }}
                                        <br>

                                        <label>
                                            <input type="checkbox" name="resolution_number[]" value="720"
                                                {{ in_array('720', $resolutions) ? 'checked' : '' }}
                                                style="border-radius: 50%"> 720p
                                        </label><br>

                                        <label>
                                            <input type="checkbox" name="resolution_number[]" value="1080"
                                                {{ in_array('1080', $resolutions) ? 'checked' : '' }}>
                                            1080p
                                        </label><br>

                                        <label>
                                            <input type="checkbox" name="resolution_number[]" value="1440"
                                                {{ in_array('1440', $resolutions) ? 'checked' : '' }}>
                                            1440p
                                        </label><br>

                                        <label>
                                            <input type="checkbox" name="resolution_number[]" value="2160"
                                                {{ in_array('2160', $resolutions) ? 'checked' : '' }}>
                                            2160p (4K)
                                        </label><br>

                                        @error('resolution_number')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </label>
                                </div>



                                <div class="form-group col-sm-3">
                                    <label for="status">{{ __('dashboard.status') }}</label>
                                    <select name="is_active" id="status" class="form-control">
                                        <option value="1"
                                            {{ old('is_active', $promotion->is_active ?? '') == 1 ? 'selected' : '' }}>
                                            {{ __('dashboard.active') }}
                                        </option>
                                        <option value="0"
                                            {{ old('is_active', $promotion->is_active ?? '') == 0 ? 'selected' : '' }}>
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
    <!-- jquery js -->
    <script>
        $(document).ready(function() {
            document.getElementById('promotion').addEventListener('input', function(e) {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
            });

            var validity = $('#validity').val();
            // console.log(validity);

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
            $('#validity').on('change', function() {
                var validity = $(this).val();
                //  alert(validity);
                if (validity === 'period') {
                    $('#start_date').show();
                    $('#end_date').show();
                    $('#days_count').hide();
                    $('input[name="days_count"]').val('');
                } else if (validity === 'days') {
                    $('#start_date').hide();
                    $('#end_date').hide();
                    $('input[name="start_date"]').val('');
                    $('input[name="end_date"]').val('');
                    $('#days_count').show();
                } else {
                    $('#start_date').hide();
                    $('#end_date').hide();
                    $('#days_count').hide();
                    $('input[name="days_count"]').val('');
                    $('input[name="start_date"]').val('');
                    $('input[name="end_date"]').val('');
                }
            });
        });
    </script>
@endsection
