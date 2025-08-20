@extends('components.dashboard.layouts.master')
@section('title')
    {{ __('dashboard.promotions') }}
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-overlay"></div>
        {{-- <div class="header-navbar-shadow"></div> --}}
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{ $promotion->name }}">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.promotions.addUser', $promotion?->id) }}">
                        {{ __('dashboard.add_users_to_this_promotion') }}
                    </a>
                </li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('dashboard.add_users_to_this_promotion') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST"
                                action="{{ url('admin/promotions/addUser') }}">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="promotionId"   value="{{ $promotion?->id }}">
                                <div class="form-group col-sm-3">
                                    <label for="users">{{ __('dashboard.users') }}</label>
                                    <select name="user_ids[]" id="status" class="form-control select2" multiple style="width: 1000px;height:200px">
                                        @foreach ($users ?? [] as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->full_name ?? $user->first_name . ' ' . $user->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_ids')
                                        <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">
                                        {{ __('dashboard.add') }}
                                    </button>
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
            $('.select2').select2({
                placeholder: "{{ __('dashboard.select_users') }}",
                allowClear: true
            });
        });
    </script>
@endsection
