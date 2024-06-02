@extends('components.dashboard.layouts.master')
@section('title')
    {{ __('dashboard.sectoral_selling') }}
@endsection
<!-- BEGIN: Content-->
@section('content')
    @if (session('success'))
        <script>
            toastr.success('{{ session('success') }}');
        </script>
    @endif
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <x-dashboard.layouts.breadcrumb now="{{ __('dashboard.sectoral_selling') }}">
                <li class="breadcrumb-item"><a href="{{ route('admin.sectoral-selling.index') }}">
                        {{ __('dashboard.sectoral_selling') }}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('dashboard.add_sectoral_selling') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{ route('admin.sectoral-selling.store') }}">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-sm-3">
                                        <label for="name_en">{{ __('dashboard.payment_type') }}</label>
                                        <select class="form-control" name="payment_type" id="payment_type"
                                            onchange="toggleInputPaymentSectoral()">
                                            <option value="cash" selected>@lang('dashboard.cash')</option>
                                            <option value="checking_account">@lang('dashboard.checking_account')</option>
                                        </select>
                                        @error('payment_type')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3" style="display: none" id="trader">
                                        <label for="name_en">{{ __('dashboard.trader') }}</label>
                                        <select class="form-control" name="trader_id" id="trader_id">

                                            @foreach ($traders as $trader)
                                                <option value="{{ $trader->id }}" >{{ $trader->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('trader_id')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3" style="display: none" id="phone">
                                        <label for="name_en">{{ __('dashboard.phone') }}</label>
                                        <select class="form-control" name="phone" id="phone">
                                            @foreach ($traders as $trader)
                                                <option value="{{ $trader->id }}">{{ $trader->phone }}</option>
                                            @endforeach
                                        </select>
                                        @error('phone')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3"  style="display: none" id="payment_amout" >
                                        <label for="name_en">{{ __('dashboard.payment_amout') }}
                                            <input type="number" class="form-control" name="payment_amout"
                                                placeholder="{{ __('dashboard.payment_amout') }}" />
                                            @error('payment_amout')
                                                <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="name_en">{{ __('dashboard.good_type') }}</label>
                                        <select class="form-control" name="goods_type_id" id="goods_type_id">
                                            @foreach ($goodsTypes as $goodsType)
                                                <option value="{{ $goodsType->id }}">{{ $goodsType->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('goods_type_id')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="name_en">{{ __('dashboard.define_unit') }}</label>
                                        <select class="form-control" name="unit" id="unit">
                                                <option value="ton">@lang('dashboard.ton')</option>
                                                <option value="shekara">@lang('dashboard.shekara')</option>
                                        </select>
                                        @error('unit')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="name_en">{{ __('dashboard.quantity') }}
                                            <input type="number" class="form-control" name="quantity"
                                                placeholder="{{ __('dashboard.quantity') }}" />
                                            @error('quantity')
                                                <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="name_en">{{ __('dashboard.unit_price') }}
                                            <input type="number" class="form-control" name="unit_price"
                                                placeholder="{{ __('dashboard.unit_price') }}" />
                                            @error('unit_price')
                                                <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </label>
                                    </div>







                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1"
                                        class="store">{{ __('dashboard.submit') }}</button>
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
        function toggleInputPayment() {
            var paymentTypeSelect = document.getElementById("payment_type");
            var firstAmountInput = document.getElementById("first_amount");
            var firstDurationInput = document.getElementById("duration");
            // console.log(paymentTypeSelect.value);
            if (paymentTypeSelect.value === "installment") {
                firstAmountInput.style.display = "block";
                firstDurationInput.style.display = "block";
            } else {
                firstAmountInput.style.display = "none";
                firstDurationInput.style.display = "none";
            }
        }

        function toggleInputDelivery() {
            var deliveryTypeSelect = document.getElementById("delivery_way");
            var nolonAmountInput = document.getElementById("ton_nolon_price");
             console.log(deliveryTypeSelect.value);
            if (deliveryTypeSelect.value === "wassal") {

                nolonAmountInput.style.display = "block";
            } else {
                nolonAmountInput.style.display = "none";
            }
        }






    </script>
@endsection
