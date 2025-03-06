<div class="col-8 bg-white p-5 m-1">

    @foreach ($settings as $setting)
        @if ($page === 'contact' && $setting->key === 'app-contacts')
            <form action="{{ route('admin.settings.update', $setting->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="row">
                    @foreach ($setting->value['phones'] ?? [] as $key => $phone)
                        <div class="col-6">
                            <div class="form-group">
                                <label>{{ __('dashboard.phone Number') }} ({{$key + 1}})</label>
                                <input type="number" class="form-control" name="number[]" value="{{ $phone }}">
                            </div>
                        </div>
                    @endforeach
                    @error('number')
                        <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                    @enderror

                    <div class="col-6">
                        <div class="form-group">
                            <label>{{ __('dashboard.watsApp') }}</label>
                            <input type="number" class="form-control" name="watsApp"
                                   value="{{ $setting->value['watsApp'] }}">
                            @error('watsApp')
                            <span style="font-size: 12px;"
                                  class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label>{{ __('dashboard.facebook') }}</label>
                            <input type="text" class="form-control" name="facebook"
                                   value="{{ $setting->value['facebook'] }}">
                            @error('facebook')
                            <span style="font-size: 12px;"
                                  class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-6">
                        <div class="form-group">
                            <label>{{ __('dashboard.snapchat') }}</label>
                            <input type="text" class="form-control" name="snapchat"
                                   value="{{ $setting->value['snapchat'] }}">
                            @error('snapchat')
                            <span style="font-size: 12px;"
                                  class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-6">
                        <div class="form-group">
                            <label>{{ __('dashboard.instagram') }}</label>
                            <input type="text" class="form-control" name="instagram"
                                   value="{{ $setting->value['instagram'] }}">
                            @error('instagram')
                            <span style="font-size: 12px;"
                                  class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit"
                        class="btn btn-primary">{{ trans('dashboard.update') }}</button>
            </form>
        @endif
        @if ($page === 'about' && $setting->key === 'about-app')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.app about') }}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        {{-- Hidden Form --}}
                        <form class="form form-vertical d-none"  id="formAbout" method="POST"
                              action="{{ route('admin.settings.update', $setting->id) }}">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="form-group col-4">
                                    <textarea name="contentAbout" id="TextAreaAbout" cols="30"
                                              rows="10"></textarea>
                                </div>
                            </div>
                        </form>
                        <!--  Formatted TextArea -->
                        <div class=""
                             style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto"
                             lang="ar" dir="rtl">
                            <div id="editor">
                                {!! $setting->value['ar'] ?? 'نص اختباري' !!}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button onclick="submitFormAbout()"
                                class="btn btn-primary mr-1 mb-1 m-3">{{ __('dashboard.edit') }}</button>
                    </div>
                    @error('content')
                    <div style="font-size: 12px; margin:20px 10px;" class="text-danger ">
                        {{ $message }}</div>
                    @enderror
                </div>
            </div>
        @endif

        @if ($page === 'terms' && $setting->key === 'terms-and-conditions')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.Usage Terms') }}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        {{-- Hidden Form --}}
                        <form class="form form-vertical d-none" id="formUsageTermPage" method="POST"
                              action="{{ route('admin.settings.update', $setting->id) }}">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="form-group col-4">
                                    <textarea name="contentTerms" id="TextAreaUsageTerms" cols="30"
                                              rows="10"></textarea>
                                </div>
                            </div>
                        </form>
                        <!--  Formatted TextArea -->
                        <div class=""
                             style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto"
                             lang="ar" dir="rtl">
                            <div id="editor">
                                {!! $setting->value['ar'] ?? 'نص اختباري' !!}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button onclick="submitFormUsageTerm()"
                                class="btn btn-primary mr-1 mb-1 m-3">{{ __('dashboard.edit') }}</button>
                    </div>
                    @error('content')
                    <div style="font-size: 12px; margin:20px 10px;" class="text-danger ">
                        {{ $message }}</div>
                    @enderror
                </div>
            </div>
        @endif


        @if ($page === 'privacy' && $setting->key === 'app-privacy')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('dashboard.application privacy') }}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        {{-- Hidden Form --}}
                        <form class="form form-vertical d-none" id="formPrivacyPage" method="POST"
                              action="{{ route('admin.settings.update', $setting->id) }}">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="form-group col-4">
                                    <textarea name="content" id="TextAreaPrivacy" cols="30"
                                              rows="10"></textarea>
                                </div>
                            </div>
                        </form>
                        <!--  Formatted TextArea -->
                        <div class=""
                             style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto"
                             lang="ar" dir="rtl">
                            <div id="editor">
                                {!! $setting->value['ar'] ?? 'نص اختباري' !!}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button onclick="submitformPrivacyPage()"
                                class="btn btn-primary mr-1 mb-1 m-3">{{ __('dashboard.edit') }}</button>
                    </div>
                    @error('content')
                    <div style="font-size: 12px; margin:20px 10px;" class="text-danger ">
                        {{ $message }}</div>
                    @enderror
                </div>
            </div>
        @endif
    @endforeach
</div>