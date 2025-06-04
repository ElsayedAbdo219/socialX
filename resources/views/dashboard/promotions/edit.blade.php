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
                                        <input name="name" value="{{ $promotion->name }}" placeholder="{{ __('dashboard.name') }}"
                                            class="form-control"></input>
                                        @error('name')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>
                                <div class="form-group col-4">
                                    <label class="w-100" for="discount">{{ __('dashboard.discount') }} %
                                        <input type="number" class="form-control" name="discount"
                                            placeholder="{{ __('dashboard.discount') }}" value="{{ old('discount', $promotion->discount) }}" max="100" />
                                        @error('discount')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>

                                <div class="form-group col-4">
                                    <label class="w-100" for="slogo">{{ __('dashboard.start_date') }}
                                        <input type="date" class="form-control" name="start_date"
                                            placeholder="{{ __('dashboard.start_date') }}"
                                            value="{{ old('start_date', $promotion->start_date->format('Y-m-d')) }}" />
                                        @error('start_date')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>

                                <div class="form-group col-4">
                                    <label class="w-100" for="slogo">{{ __('dashboard.end_date') }}
                                        <input type="date" class="form-control" name="end_date"
                                            placeholder="{{ __('dashboard.end_date') }}" value="{{ old('end_date', $promotion->end_date->format('Y-m-d')) }}" />
                                        @error('end_date')
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
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
