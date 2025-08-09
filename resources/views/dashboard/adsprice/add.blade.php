@extends('components.dashboard.layouts.master')
@section('title')
    {{ __('dashboard.news_add') }}
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
            <x-dashboard.layouts.breadcrumb now="{{ __('dashboard.skill_add') }}">
                <li class="breadcrumb-item"><a href="{{ url('admin/skills/') }}">
                        {{ __('dashboard.skills') }}
                    </a></li>
            </x-dashboard.layouts.breadcrumb>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('dashboard.ads_price_add') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical" method="POST" action="{{ route('admin.Ads-price.store') }}">
                                @csrf
                                <div class="row">
                                    <!-- السعر -->
                                    <div class="form-group col-sm-3">
                                        <label for="price">{{ __('dashboard.price') }}</label>
                                        <input type="text" class="form-control" name="price"
                                            placeholder="{{ __('dashboard.price') }}" />
                                        @error('price')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- العملة -->
                                    <div class="form-group col-sm-3">
                                        <label for="currency">اختر العملة</label>
                                        <select name="currency" class="form-control" id="currency">
                                            <option value="">اختر العملة</option>
                                            <option value="EGP">🇪🇬 الجنيه المصري (EGP)</option>
                                            <option value="SAR">🇸🇦 الريال السعودي (SAR)</option>
                                            <option value="AED">🇦🇪 الدرهم الإماراتي (AED)</option>
                                            <option value="KWD">🇰🇼 الدينار الكويتي (KWD)</option>
                                            <option value="QAR">🇶🇦 الريال القطري (QAR)</option>
                                            <option value="BHD">🇧🇭 الدينار البحريني (BHD)</option>
                                            <option value="OMR">🇴🇲 الريال العماني (OMR)</option>
                                            <option value="JOD">🇯🇴 الدينار الأردني (JOD)</option>
                                            <option value="IQD">🇮🇶 الدينار العراقي (IQD)</option>
                                            <option value="LYD">🇱🇾 الدينار الليبي (LYD)</option>
                                            <option value="DZD">🇩🇿 الدينار الجزائري (DZD)</option>
                                            <option value="MAD">🇲🇦 الدرهم المغربي (MAD)</option>
                                            <option value="TND">🇹🇳 الدينار التونسي (TND)</option>
                                            <option value="SYP">🇸🇾 الليرة السورية (SYP)</option>
                                            <option value="SDG">🇸🇩 الجنيه السوداني (SDG)</option>
                                            <option value="YER">🇾🇪 الريال اليمني (YER)</option>
                                            <option value="MRU">🇲🇷 الأوقية الموريتانية (MRU)</option>
                                            <option value="DJF">🇩🇯 الفرنك الجيبوتي (DJF)</option>
                                            <option value="SOS">🇸🇴 الشلن الصومالي (SOS)</option>
                                            <option value="PSE">🇵🇸 الشيكل الإسرائيلي (PSE)*</option>
                                        </select>
                                        @error('currency')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- النوع -->
                                    <div class="form-group col-sm-3">
                                        <label for="type">{{ __('dashboard.type') }}</label>
                                        <select name="type" class="form-control" id="type">
                                            <option value="">اختر النوع</option>
                                            <option value="video">فيديو</option>
                                            <option value="image">صورة</option>
                                        </select>
                                        @error('type')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- الدقة -->
                                    <div class="form-group col-sm-3" id="resolution-group">
                                        <label for="resolution">{{ __('dashboard.resolution') }}</label>
                                        <select name="resolution" id="resolution" class="form-control">
                                            <option value="">اختر الدقة</option>
                                            <option value="720">720p</option>
                                            <option value="1080">1080p</option>
                                            <option value="1440">1440p</option>
                                            <option value="2160">2160p</option>
                                        </select>
                                        @error('resolution')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- زر الحفظ -->
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-primary">{{ __('dashboard.submit') }}</button>
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
          // alert($('#resolution').val());
            // Hide resolution input by default
            $('#resolution-group').hide();
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
