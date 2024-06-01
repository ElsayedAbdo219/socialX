@extends('components.dashboard.layouts.master')
@section('title')
    {{ __('dashboard.add_purshasing_from_company') }}
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
            <x-dashboard.layouts.breadcrumb now="{{ __('dashboard.add_purshasing_from_company') }}">
                <li class="breadcrumb-item"><a href="{{ route('admin.purshasefromcompanies.index') }}">
                        {{ __('dashboard.add_purshasing_from_company') }}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('dashboard.add_purshasing_from_company') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{ route('admin.purshasefromcompanies.store') }}">
                                @csrf
                                <div class="row">

                                    <div class="form-group col-sm-3">
                                        <label for="name_en">{{ __('dashboard.trader') }}</label>
                                        <select class="form-control" name="trader_id" id="trader_id">
                                            @foreach ($traders as $trader)
                                                <option value="{{ $trader->id }}">{{ $trader->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('trader_id')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
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
                                        <label for="name_en">{{ __('dashboard.ton_quantity') }}
                                            <input type="number" class="form-control" name="ton_quantity"
                                                placeholder="{{ __('dashboard.ton_quantity') }}" />
                                            @error('ton_quantity')
                                                <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </label>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label for="name_en">{{ __('dashboard.ton_quantity_price') }}
                                            <input type="number" class="form-control" name="ton_quantity_price"
                                                placeholder="{{ __('dashboard.ton_quantity_price') }}" />
                                            @error('ton_quantity_price')
                                                <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </label>
                                    </div>
                                    <div class="form-group col-sm-3" >
                                        <label for="name_en">{{ __('dashboard.delivery_way') }}</label>
                                        <select class="form-control" name="delivery_way"  onchange="toggleInputDelivery()" id="delivery_way"  >
                                            <option value="on_site" selected>@lang('dashboard.on_site')</option>
                                            <option value="wassal">@lang('dashboard.wassal')</option>
                                        </select>
                                        @error('delivery_way')
                                            <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3" style="display: none;"  id="ton_nolon_price" >
                                        <label for="name_en">{{ __('dashboard.ton_nolon_price') }}
                                            <input type="number" class="form-control" name="ton_colon_price"
                                                placeholder="{{ __('dashboard.ton_nolon_price') }}"/>
                                            @error('ton_colon_price')
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
