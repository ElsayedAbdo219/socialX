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
                                    <label class="w-100" for="email">{{ __('dashboard.name') }} - <span
                                            class="text-warning">@lang('dashboard.en_lang_only')</span>
                                        <input name="name" id="nameTextArea" placeholder="{{ __('dashboard.name') }}"
                                            class="form-control"></input>
                                        @error('name')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>
                                <div class="form-group col-4">
                                    <label class="w-100" for="discount">{{ __('dashboard.discount') }} %
                                        <input type="number" class="form-control" name="discount"
                                            placeholder="{{ __('dashboard.discount') }}" value="{{ old('discount') }}" max="100" />
                                        @error('discount')
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
        $(document).ready(function() {
            document.getElementById('nameTextArea').addEventListener('input', function(e) {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
            });
        });
    </script>
@endsection
