@extends('components.dashboard.layouts.master')
@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
  .setting-nav-active {
    background: #3232CD;
    color: white;
  }
</style>
@endsection
@section('title')
{{ __('dashboard.settings') }}
@endsection
<!-- BEGIN: Content-->
@section('content')
<div class="app-content content">
  <div class="content-overlay"></div>
  {{-- <div class="header-navbar-shadow"></div> --}}

  <div class="content-wrapper">
    <x-dashboard.layouts.breadcrumb now="{{ __('dashboard.app_settings') }}">
    </x-dashboard.layouts.breadcrumb>
    <div class="content-header row">
    </div>
    <div class="content-body">


      <div class="row">
        {{-- side nav --}}
        <div class="col-3 bg-white text-center p-2 m-1" style="height: fit-content">
          <div class="text-center ">
            <ul>

              <p class="p-1 m-1 {{ $page == 'contact' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'contact']) }}"
                  class="{{ $page == 'contact' ? 'setting-nav-active' : '' }}">
                  {{ __('dashboard.contact ways') }}
                </a>
              </p>

              <p class="p-1 m-1 {{ $page == 'about' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'about']) }}"
                  class="{{ $page == 'about' ? 'setting-nav-active' : '' }}">
                  {{ __('dashboard.app about') }}
                </a>
              </p>
              <p class="p-1 m-1 {{ $page == 'terms' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'terms']) }}"
                  class="{{ $page == 'terms' ? 'setting-nav-active' : '' }}">
                  {{ __('dashboard.Usage Terms') }}
                </a>
              </p>
              <p class="p-1 m-1 {{ $page == 'privacy' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'privacy']) }}"
                  class="{{ $page == 'points' ? 'setting-nav-active' : '' }}">
                  {{ __('dashboard.application privacy') }}
                </a>
              </p>
              {{-- new --}}
              <p class="p-1 m-1 {{ $page == 'our-vision' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'our-vision']) }}"
                  class="{{ $page == 'our-vision' ? 'setting-nav-active' : '' }}">
                  {{ __('dashboard.our-vision') }}
                </a>
              </p>
              <p class="p-1 m-1 {{ $page == 'why-choose-anceega-for-seekers' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index' , ['page' => 'why-choose-anceega-for-seekers']) }}"
                  class="{{ $page == 'why-choose-anceega-for-seekers' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.why-choose-anceega-for-seekers')}}
                </a>
              </p>
              <p
                class="p-1 m-1 {{ $page == 'why-choose-anceega-for-business-and-freelancers' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'why-choose-anceega-for-business-and-freelancers']) }}"
                  class="{{ $page == 'why-choose-anceega-for-business-and-freelancers' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.why-choose-anceega-for-business-and-freelancers')}}

                </a>
              </p>
              <p class="p-1 m-1 {{ $page == 'key-features' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'key-features']) }}"
                  class="{{ $page == 'key-features' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.key-features')}}

                </a>
              </p>
              <p class="p-1 m-1 {{ $page == 'user-responsibilities' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'user-responsibilities']) }}"
                  class="{{ $page == 'user-responsibilities' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.user-responsibilities')}}
                </a>
              </p>
              <p class="p-1 m-1 {{ $page == 'company-responsibilities' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'company-responsibilities']) }}"
                  class="{{ $page == 'company-responsibilities' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.company-responsibilities')}}
                </a>
              </p>
              <p class="p-1 m-1 {{ $page == 'platform-usage' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'platform-usage']) }}"
                  class="{{ $page == 'platform-usage' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.platform-usage')}}
                </a>
              </p>
              <p class="p-1 m-1 {{ $page == 'account-suspension-policy' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'account-suspension-policy']) }}"
                  class="{{ $page == 'account-suspension-policy' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.account-suspension-policy')}}
                </a>
              </p>
              <p class="p-1 m-1 {{ $page == 'Help-Shape-Anceega' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'Help-Shape-Anceega']) }}"
                  class="{{ $page == 'Help-Shape-Anceega' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.Help-Shape-Anceega')}}
                </a>

              </p>
              <p class="p-1 m-1 {{ $page == 'custom-suggestions' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'custom-suggestions']) }}"
                  class="{{ $page == 'points' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.custom-suggestions')}}
                </a>
              </p>

              <p class="p-1 m-1 {{ $page == 'your-rights' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'your-rights']) }}"
                  class="{{ $page == 'your-rights' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.your-rights')}}
                </a>
              </p>

              <p class="p-1 m-1 {{ $page == 'information-collect' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'information-collect']) }}"
                  class="{{ $page == 'information-collect' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.information-collect')}}
                </a>
              </p>
              <p class="p-1 m-1 {{ $page == 'how-use-data' ? 'setting-nav-active' : '' }}">

                <a href="{{ route('admin.settings.index', ['page' => 'how-use-data']) }}"
                  class="{{ $page == 'how-use-data' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.how-use-data')}}
                </a>
              </p>

              <p class="p-1 m-1 {{ $page == 'help-support' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'help-support']) }}"
                  class="{{ $page == 'help-support' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.help-support')}}
                </a>
              </p>

              <p class="p-1 m-1 {{ $page == 'advertise-Anceega' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'advertise-Anceega']) }}"
                  class="{{ $page == 'advertise-Anceega' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.advertise-Anceega')}}
                </a>
              </p>



              <p class="p-1 m-1 {{ $page == 'why-advertise-withAnceega' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'why-advertise-withAnceega']) }}"
                  class="{{ $page == 'why-advertise-withAnceega' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.why-advertise-withAnceega')}}

                </a>
              </p>

              <p class="p-1 m-1 {{ $page == 'how-advertise-work-for-companies' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'how-advertise-work-for-companies']) }}"
                  class="{{ $page == 'how-advertise-work-for-companies' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.how-advertise-work-for-companies')}}
                </a>
              </p>

              <p class="p-1 m-1 {{ $page == 'how-advertise-work-for-users' ? 'setting-nav-active' : '' }}">
                <a href="{{ route('admin.settings.index', ['page' => 'how-advertise-work-for-users']) }}"
                  class="{{ $page == 'how-advertise-work-for-users' ? 'setting-nav-active' : '' }}">
                  {{__('dashboard.how-advertise-work-for-users')}}
                </a>
              </p>






              {{-- end --}}
            </ul>
          </div>
        </div>























        {{-- setting content --}}
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
                  <input type="number" class="form-control" name="watsApp" value="{{ $setting->value['watsApp'] }}">
                  @error('watsApp')
                  <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="col-6">
                <div class="form-group">
                  <label>{{ __('dashboard.facebook') }}</label>
                  <input type="text" class="form-control" name="facebook" value="{{ $setting->value['facebook'] }}">
                  @error('facebook')
                  <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
              </div>


              <div class="col-6">
                <div class="form-group">
                  <label>{{ __('dashboard.snapchat') }}</label>
                  <input type="text" class="form-control" name="snapchat" value="{{ $setting->value['snapchat'] }}">
                  @error('snapchat')
                  <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
              </div>


              <div class="col-6">
                <div class="form-group">
                  <label>{{ __('dashboard.instagram') }}</label>
                  <input type="text" class="form-control" name="instagram" value="{{ $setting->value['instagram'] }}">
                  @error('instagram')
                  <span style="font-size: 12px;" class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">{{ trans('dashboard.update') }}</button>
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
                <form class="form form-vertical d-none" id="formAbout" method="POST"
                  action="{{ route('admin.settings.update', $setting->id) }}">
                  @csrf
                  @method('PATCH')
                  <div class="row">
                    <input type="hidden" name="language" value="{{ app()->getLocale() }}">
                    <div class="form-group col-4">
                      <textarea name="contentAbout" id="TextAreaAbout" cols="30" rows="10"></textarea>
                    </div>
                  </div>
                </form>
                <!--  Formatted TextArea -->
                <div class="" style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto"
                  lang="ar" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
                  <div id="editor">
                    {!! $setting->value[app()->getLocale()] ?? 'نص اختباري' !!}
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-center">
                <button onclick="submitFormAbout()" class="btn btn-primary mr-1 mb-1 m-3">{{ __('dashboard.save')
                  }}</button>
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
                  <input type="hidden" name="language" value="{{ app()->getLocale() }}">
                  <div class="row">
                    <div class="form-group col-4">
                      <textarea name="contentTerms" id="TextAreaUsageTerms" cols="30" rows="10"></textarea>
                    </div>
                  </div>
                </form>
                <!--  Formatted TextArea -->
                <div class="" style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto"
                  lang="ar" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
                  <div id="editor">
                    {!! $setting->value[app()->getLocale()] ?? 'نص اختباري' !!}
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-center">
                <button onclick="submitFormUsageTerm()" class="btn btn-primary mr-1 mb-1 m-3">{{ __('dashboard.save')
                  }}</button>
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
                  <input type="hidden" name="language" value="{{ app()->getLocale() }}">
                  <div class="row">
                    <div class="form-group col-4">
                      <textarea name="content" id="TextAreaPrivacy" cols="30" rows="10"></textarea>
                    </div>
                  </div>
                </form>
                <!--  Formatted TextArea -->
                <div class="" style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto"
                  lang="ar" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
                  <div id="editor">
                    {!! $setting->value[app()->getLocale()] ?? 'نص اختباري' !!}
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-center">
                <button onclick="submitformPrivacyPage()" class="btn btn-primary mr-1 mb-1 m-3">{{ __('dashboard.save')
                  }}</button>
              </div>
              @error('content')
              <div style="font-size: 12px; margin:20px 10px;" class="text-danger ">
                {{ $message }}</div>
              @enderror
            </div>
          </div>
          @endif


          @if ($page === 'our-vision' && $setting->key === 'our-vision')
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"> {{ app()->getLocale() == 'en' ? 'Our Vision - English' : ' اللغة العربية - رؤيتنا'
                }}</h4>
            </div>
            {{-- <a class="btn btn-primary" data-bs-toggle="collapse" href="#ourVision" role="button"
              aria-expanded="false" aria-controls="collapseExample">@lang('dashboard.show_data_in_arabic')</a> --}}
            <div class="card-content">
              <div class="card-body">
                {{-- Hidden Form --}}
                <form class="form form-vertical d-none" id="formOurVision" method="POST"
                  action="{{ route('admin.settings.update', $setting->id) }}">
                  @csrf
                  @method('PATCH')
                  <div class="row">
                    <input type="hidden" name="language" value="{{ app()->getLocale() }}">
                    <div class="form-group col-4">
                      <textarea name="content" id="TextOurVision" cols="30" rows="10"></textarea>
                    </div>
                  </div>
                </form>
                <!--  Formatted TextArea -->
                <div class="" style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto"
                  lang="ar" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
                  <div id="editor">
                    {!! $setting->value[app()->getLocale()] ?? 'نص اختباري' !!}
                  </div>
                </div>

              </div>

              <div class="d-flex justify-content-center">
                <button onclick="submitformOurVision()" class="btn btn-primary mr-1 mb-1 m-3">{{ __('dashboard.save')
                  }}</button>
              </div>

              @error('content')
              <div style="font-size: 12px; margin:20px 10px;" class="text-danger ">
                {{ $message }}</div>
              @enderror
            </div>
          </div>
          @endif


          @if ($page === 'why-choose-anceega-for-seekers' && $setting->key === 'why-choose-anceega-for-seekers')
          {{-- {{--@dd('this page for seekers')-- }} --}}

          <form class="form form-vertical  p-4 bg-light shadow rounded" method="POST"
            action="{{ route('admin.settings.update', $setting->id) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="language" value="{{ app()->getLocale() }}">
            <div id="repeater1">
              <div data-repeater-list="items1">
                @foreach($setting->value[app()->getLocale()] as $val)
                <div data-repeater-item class="d-flex align-items-center mb-3">
                  <input type="text" value="{{ $val }}" name="items[][contentSeekers]" class="form-control me-2"
                    placeholder="الوصف">
                  <button type="button" class="btn btn-danger btn-sm"
                    data-repeater-delete>@lang('dashboard.delete')</button>
                </div>
                @endforeach
              </div>
              <button type="button" class="btn btn-primary btn-sm mt-2"
                data-repeater-create>@lang('dashboard.add_new')</button>
            </div>

            <button type="submit" class="btn btn-success mt-3">@lang('dashboard.submit')</button>
          </form>

          @endif



          @if ($page === 'why-choose-anceega-for-business-and-freelancers' && $setting->key ===
          'why-choose-anceega-for-business-and-freelancers')
          {{-- {{--@dd('this page for seekers')-- }} --}}

          <form class="form form-vertical  p-4 bg-light shadow rounded" method="POST"
            action="{{ route('admin.settings.update', $setting->id) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="language" value="{{ app()->getLocale() }}">

            <div id="repeater2">
              <div data-repeater-list="items2">
                @foreach($setting->value[app()->getLocale()] as $val)
                <div data-repeater-item class="d-flex align-items-center mb-3">
                  <input type="text" value="{{ $val }}" name="items[][contentFreelanceAndBusiness]"
                    class="form-control me-2" placeholder="الوصف" required>
                  <button type="button" class="btn btn-danger btn-sm"
                    data-repeater-delete>@lang('dashboard.delete')</button>
                </div>
                @endforeach
              </div>
              <button type="button" class="btn btn-primary btn-sm mt-2"
                data-repeater-create>@lang('dashboard.add_new')</button>
            </div>

            <button type="submit" class="btn btn-success mt-3">@lang('dashboard.save')</button>
          </form>

          @endif


          @if ($page === 'key-features' && $setting->key === 'key-features')
          {{-- {{--@dd('this page for seekers')-- }} --}}

          <form class="form form-vertical  p-4 bg-light shadow rounded" method="POST"
            action="{{ route('admin.settings.update', $setting->id) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="language" value="{{ app()->getLocale() }}">

            <div id="repeater3">
              <div data-repeater-list="items3">
                @foreach($setting->value[app()->getLocale()] as $val)
                <div data-repeater-item class="d-flex align-items-center mb-3">
                  <input type="text" value="{{ $val }}" name="items[][contentKeyFeatures]" class="form-control me-2"
                    placeholder="الوصف" required>
                  <button type="button" class="btn btn-danger btn-sm"
                    data-repeater-delete>@lang('dashboard.delete')</button>
                </div>
                @endforeach
              </div>
              <button type="button" class="btn btn-primary btn-sm mt-2"
                data-repeater-create>@lang('dashboard.add_new')</button>
            </div>

            <button type="submit" class="btn btn-success mt-3">@lang('dashboard.save')</button>
          </form>

          @endif



          @if ($page === 'user-responsibilities' && $setting->key === 'user-responsibilities')
          {{-- {{--@dd('this page for seekers')-- }} --}}

          <form class="form form-vertical  p-4 bg-light shadow rounded" method="POST"
            action="{{ route('admin.settings.update', $setting->id) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="language" value="{{ app()->getLocale() }}">
            <div id="repeater4">
              <div data-repeater-list="items4">
                @foreach($setting->value[app()->getLocale()] as $val)
                <div data-repeater-item class="d-flex align-items-center mb-3">
                  <input type="text" value="{{ $val }}" name="items[][contentUserResponsibilities]"
                    class="form-control me-2" placeholder="الوصف" required>
                  <button type="button" class="btn btn-danger btn-sm"
                    data-repeater-delete>@lang('dashboard.delete')</button>
                </div>
                @endforeach
              </div>
              <button type="button" class="btn btn-primary btn-sm mt-2"
                data-repeater-create>@lang('dashboard.add_new')</button>
            </div>

            <button type="submit" class="btn btn-success mt-3">@lang('dashboard.save')</button>
          </form>

          @endif



          @if ($page === 'company-responsibilities' && $setting->key === 'company-responsibilities')
          {{-- {{--@dd('this page for seekers')-- }} --}}

          <form class="form form-vertical  p-4 bg-light shadow rounded" method="POST"
            action="{{ route('admin.settings.update', $setting->id) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="language" value="{{ app()->getLocale() }}">
            <div id="repeater5">
              <div data-repeater-list="items5">
                @foreach($setting->value[app()->getLocale()] as $val)
                <div data-repeater-item class="d-flex align-items-center mb-3">
                  <input type="text" value="{{ $val }}" name="items[][contentCompanyResponsibilities]"
                    class="form-control me-2" placeholder="الوصف" required>
                  <button type="button" class="btn btn-danger btn-sm"
                    data-repeater-delete>@lang('dashboard.delete')</button>
                </div>
                @endforeach
              </div>
              <button type="button" class="btn btn-primary btn-sm mt-2"
                data-repeater-create>@lang('dashboard.add_new')</button>
            </div>

            <button type="submit" class="btn btn-success mt-3">@lang('dashboard.save')</button>
          </form>

          @endif



          @if ($page === 'platform-usage' && $setting->key === 'platform-usage')
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">@lang('dashboard.platform-usage')</h4>
            </div>
            <div class="card-content">
              <div class="card-body">
                {{-- Hidden Form --}}
                <form class="form form-vertical d-none" id="formPlatformUsage" method="POST"
                  action="{{ route('admin.settings.update', $setting->id) }}">
                  @csrf
                  @method('PATCH')
                  <input type="hidden" name="language" value="{{ app()->getLocale() }}">
                  <div class="row">
                    <div class="form-group col-4">
                      <textarea name="contentPlatformUsage" id="TextPlatormUsage" cols="30" rows="10"></textarea>
                    </div>
                  </div>
                </form>
                <!--  Formatted TextArea -->
                <div class="" style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto"
                  lang="ar" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
                  <div id="editor">
                    {!! $setting->value[app()->getLocale()] ?? 'نص اختباري' !!}
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-center">
                <button onclick="submitformPlatformUsage()" class="btn btn-primary mr-1 mb-1 m-3">{{
                  __('dashboard.save') }}</button>
              </div>
              @error('content')
              <div style="font-size: 12px; margin:20px 10px;" class="text-danger ">
                {{ $message }}</div>
              @enderror
            </div>
          </div>
          @endif


          @if ($page === 'account-suspension-policy' && $setting->key === 'account-suspension-policy')
          <div class="card">
            <div class="card-header">
              <h4 class="card-title"> @lang('dashboard.account_suspension_policy') </h4>

            </div>
            <div class="card-body">
              {{-- Hidden Form --}}
              <form class="form form-vertical d-none" id="formAccountSuspensionPolicy" method="POST"
                action="{{ route('admin.settings.update', $setting->id) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="language" value="{{ app()->getLocale() }}">
                <div class="row">
                  <div class="form-group col-4">
                    <textarea name="contentAccountSuspensionPolicy" id="TextAccountSuspensionPolicy" cols="30"
                      rows="10"></textarea>
                  </div>
                </div>
              </form>
              <!--  Formatted TextArea -->
              <div class="" style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto"
                lang="ar" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
                <div id="editor">
                  {!! $setting->value[app()->getLocale()] ?? 'نص اختباري' !!}
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-center">
              <button onclick="submitAccountSuspensionPolicy()" class="btn btn-primary mr-1 mb-1 m-3">{{
                __('dashboard.save') }}</button>
            </div>
            @error('content')
            <div style="font-size: 12px; margin:20px 10px;" class="text-danger ">
              {{ $message }}</div>
            @enderror
          </div>
        </div>
        @endif




        @if ($page === 'Help-Shape-Anceega' && $setting->key === 'Help-Shape-Anceega')
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"> @lang('dashboard.help_shape_anceega') </h4>

          </div>
          <div class="card-body">
            {{-- Hidden Form --}}
            <form class="form form-vertical d-none" id="formHelpShapeAnceega" method="POST"
              action="{{ route('admin.settings.update', $setting->id) }}">
              @csrf
              @method('PATCH')
              <input type="hidden" name="language" value="{{ app()->getLocale() }}">
              <div class="row">
                <div class="form-group col-4">
                  <textarea name="contentHelpShapeAnceega" id="TextHelpShapeAnceega" cols="30" rows="10"></textarea>
                </div>
              </div>
            </form>
            <!--  Formatted TextArea -->
            <div class="" style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto"
              lang="ar" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
              <div id="editor">
                {!! $setting->value[app()->getLocale()] ?? 'نص اختباري' !!}
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-center">
            <button onclick="submitHelpShapeAnceega()" class="btn btn-primary mr-1 mb-1 m-3">{{ __('dashboard.save')
              }}</button>
          </div>
          @error('content')
          <div style="font-size: 12px; margin:20px 10px;" class="text-danger ">
            {{ $message }}</div>
          @enderror
        </div>
      </div>
      @endif




      @if ($page === 'custom-suggestions' && $setting->key === 'custom-suggestions')
      {{-- {{--@dd('this page for seekers')-- }} --}}

      <form class="form form-vertical  p-4 bg-light shadow rounded" method="POST"
        action="{{ route('admin.settings.update', $setting->id) }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="language" value="{{ app()->getLocale() }}">
        <div id="repeater6">
          <div data-repeater-list="items6">
            {{-- @dd($setting) --}}
            @foreach($setting->value[app()->getLocale()] as $val)
            <div data-repeater-item class="d-flex align-items-center mb-3">
              <input type="text" value="{{ $val }}" name="items[][contentCustomSuggestions]" class="form-control me-2"
                placeholder="الوصف" required>
              <button type="button" class="btn btn-danger btn-sm"
                data-repeater-delete>@lang('dashboard.delete')</button>
            </div>
            @endforeach
          </div>
          <button type="button" class="btn btn-primary btn-sm mt-2"
            data-repeater-create>@lang('dashboard.add_new')</button>
        </div>

        <button type="submit" class="btn btn-success mt-3">@lang('dashboard.save')</button>
      </form>

      @endif



      @if ($page === 'your-rights' && $setting->key === 'your-rights')
      {{-- {{--@dd('this page for seekers')-- }} --}}

      <form class="form form-vertical  p-4 bg-light shadow rounded" method="POST"
        action="{{ route('admin.settings.update', $setting->id) }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="language" value="{{ app()->getLocale() }}">
        <div id="repeater7">
          <div data-repeater-list="items7">
            {{-- @dd($setting) --}}
            @foreach($setting->value[app()->getLocale()] as $val)
            <div data-repeater-item class="d-flex align-items-center mb-3">
              <input type="text" value="{{ $val }}" name="items[][contentYourRights]" class="form-control me-2"
                placeholder="الوصف" required>
              <button type="button" class="btn btn-danger btn-sm"
                data-repeater-delete>@lang('dashboard.delete')</button>
            </div>
            @endforeach
          </div>
          <button type="button" class="btn btn-primary btn-sm mt-2"
            data-repeater-create>@lang('dashboard.add_new')</button>
        </div>

        <button type="submit" class="btn btn-success mt-3">@lang('dashboard.save')</button>
      </form>

      @endif



      @if ($page === 'information-collect' && $setting->key === 'information-collect')
      {{-- {{--@dd('this page for seekers')-- }} --}}

      <form class="form form-vertical  p-4 bg-light shadow rounded" method="POST"
        action="{{ route('admin.settings.update', $setting->id) }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="language" value="{{ app()->getLocale() }}">
        <div id="repeater8">
          <div data-repeater-list="items8">
            {{-- @dd($setting) --}}
            @foreach($setting->value[app()->getLocale()] as $val)
            <div data-repeater-item class="d-flex align-items-center mb-3">
              <input type="text" value="{{ $val }}" name="items[][contentInformationCollect]" class="form-control me-2"
                placeholder="الوصف" required>
              <button type="button" class="btn btn-danger btn-sm"
                data-repeater-delete>@lang('dashboard.delete')</button>
            </div>
            @endforeach
          </div>
          <button type="button" class="btn btn-primary btn-sm mt-2"
            data-repeater-create>@lang('dashboard.add_new')</button>
        </div>

        <button type="submit" class="btn btn-success mt-3">@lang('dashboard.submit')</button>
      </form>

      @endif




      @if ($page === 'how-use-data' && $setting->key === 'how-use-data')
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"> @lang('dashboard.how_use_data') </h4>

        </div>
        <div class="card-body">
          {{-- Hidden Form --}}
          <form class="form form-vertical d-none" id="formHowUseData" method="POST"
            action="{{ route('admin.settings.update', $setting->id) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="language" value="{{ app()->getLocale() }}">
            <div class="row">
              <div class="form-group col-4">
                <textarea name="contentHowUseData" id="TextHowUseData" cols="30" rows="10"></textarea>
              </div>
            </div>
          </form>
          <!--  Formatted TextArea -->
          <div class="" style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto" lang="ar"
            dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
            <div id="editor">
              {!! $setting->value[app()->getLocale()] ?? 'نص اختباري' !!}
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <button onclick="submitHowUseData()" class="btn btn-primary mr-1 mb-1 m-3">{{ __('dashboard.save') }}</button>
        </div>
        @error('content')
        <div style="font-size: 12px; margin:20px 10px;" class="text-danger ">
          {{ $message }}</div>
        @enderror
      </div>
    </div>
    @endif

    @if ($page === 'help-support' && $setting->key === 'help-support')
    <div class="card">
      <div class="card-header">
        <h4 class="card-title"> @lang('dashboard.help_support') </h4>

      </div>
      <div class="card-body">
        {{-- Hidden Form --}}
        <form class="form form-vertical d-none" id="formHelpAndSupport" method="POST"
          action="{{ route('admin.settings.update', $setting->id) }}">
          @csrf
          @method('PATCH')
          <input type="hidden" name="language" value="{{ app()->getLocale() }}">
          <div class="row">
            <div class="form-group col-4">
              <textarea name="contentHelpAndSupport" id="TextHelpAndSupport" cols="30" rows="10"></textarea>
            </div>
          </div>
        </form>
        <!--  Formatted TextArea -->
        <div class="" style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto" lang="ar"
          dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
          <div id="editor">
            {!! $setting->value[app()->getLocale()] ?? 'نص اختباري' !!}
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-center">
        <button onclick="submitHelpAndSupport()" class="btn btn-primary mr-1 mb-1 m-3">{{ __('dashboard.save')
          }}</button>
      </div>
      @error('content')
      <div style="font-size: 12px; margin:20px 10px;" class="text-danger ">
        {{ $message }}</div>
      @enderror
    </div>
  </div>
  @endif

  @if ($page === 'advertise-Anceega' && $setting->key === 'advertise-Anceega')
  <div class="card">
    <div class="card-header">
      <h4 class="card-title"> @lang('dashboard.advertise_Anceega') </h4>

    </div>
    <div class="card-body">
      {{-- Hidden Form --}}
      <form class="form form-vertical d-none" id="formAdvertiseAnceega" method="POST"
        action="{{ route('admin.settings.update', $setting->id) }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="language" value="{{ app()->getLocale() }}">
        <div class="row">
          <div class="form-group col-4">
            <textarea name="contentAdvertiseAnceega" id="TextAdvertiseAnceega" cols="30" rows="10"></textarea>
          </div>
        </div>
      </form>
      <!--  Formatted TextArea -->
      <div class="" style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto" lang="ar"
        dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
        <div id="editor">
          {!! $setting->value[app()->getLocale()] ?? 'نص اختباري' !!}
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center">
      <button onclick="submitAdvertiseAnceega()" class="btn btn-primary mr-1 mb-1 m-3">{{ __('dashboard.save')
        }}</button>
    </div>
    @error('contentAdvertiseAnceega')
    <div style="font-size: 12px; margin:20px 10px;" class="text-danger ">
      {{ $message }}</div>
    @enderror
  </div>
</div>
@endif


@if ($page === 'why-advertise-withAnceega' && $setting->key === 'why-advertise-withAnceega')
{{-- {{--@dd('this page for seekers')-- }} --}}

<form class="form form-vertical  p-4 bg-light shadow rounded" method="POST"
  action="{{ route('admin.settings.update', $setting->id) }}" enctype="multipart/form-data">
  @csrf
  @method('PATCH')
  <input type="hidden" name="language" value="{{ app()->getLocale() }}">
  <div class="image-container d-flex flex-wrap" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
    <label for="">@lang('dashboard.current_images') </label>
    <div class="d-flex gap-2" style="display: flex; gap: 10px;">
      @if(is_array($setting?->value['imagePath']))
      @foreach($setting?->value['imagePath'] as $img)
      <img class="preview-img" src="{{ asset('storage/whyAdvertise-Anceega/'.$img) }}"
        alt="imagePathForwhyAdvertise-Anceega"
        style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px; border: 2px solid #ddd; padding: 5px; background: #fff;">
      @endforeach
      @endif
    </div>
  </div>


  <input type="file" name="imageWhyAdvertise[]" class="form-control me-2" placeholder="حمل الصورة .." multiple> <br>
  <div id="repeater9">
    <div data-repeater-list="items9">
      {{-- @dd($setting) --}}
      @foreach($setting->value[app()->getLocale()] ?? [] as $val)
      <div data-repeater-item class="d-flex align-items-center mb-3">
        <input type="text" value="{{ $val }}" name="items[][contentWhyAdvertiseWithUs]" class="form-control me-2"
          placeholder="الوصف" required>
        <button type="button" class="btn btn-danger btn-sm" data-repeater-delete>@lang('dashboard.delete')</button>
      </div>
      @endforeach
    </div>
    <button type="button" class="btn btn-primary btn-sm mt-2" data-repeater-create>@lang('dashboard.add_new')</button>
  </div>

  <button type="submit" class="btn btn-success mt-3">@lang('dashboard.submit')</button>
</form>

@endif




@if ($page === 'how-advertise-work-for-companies' && $setting->key === 'how-advertise-work-for-companies')
<div class="card">
  <div class="card-header">
    <h4 class="card-title"> @lang('dashboard.how_advertise_work_for_companies') </h4>

  </div>
  <div class="card-body">
    {{-- Hidden Form --}}
    <form class="form form-vertical" id="formAdvertiseForCompanies" method="POST"
      action="{{ route('admin.settings.update', $setting->id) }}" enctype="multipart/form-data">
      @csrf
      @method('PATCH')
      <input type="hidden" name="language" value="{{ app()->getLocale() }}">
      <div class="video-container d-flex flex-wrap"
        style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
        <label for="">الفيديوهات الحالية</label>
        <div class="d-flex gap-2" style="display: flex; gap: 10px;">
          @if(is_array($setting?->value['videoPath']))
          @foreach($setting?->value['videoPath'] ?? [] as $video)
          <video
            style="width: 200px; height: 150px; border-radius: 8px; border: 2px solid #ddd; padding: 5px; background: #fff;"
            controls>
            <source src="{{ asset('storage/AdvertiseForCompaniesAnceega/'.$video) }}" type="video/mp4">
            متصفحك لا يدعم تشغيل الفيديو.
          </video>
          @endforeach
          @endif
        </div>
      </div>
      <input type="file" name="videoAdvertiseForCompanies[]" id="videoAdvertiseForCompanies" class="form-control me-2"
        placeholder="حمل الفيديو .." multiple>
      <br>
      <div class="row">
        <div class="form-group col-4 d-none">
          <textarea name="contentAdvertiseForCompanies" id="TextAdvertiseForCompanies" cols="30" rows="10"></textarea>
        </div>
      </div>
    </form>
    <!--  Formatted TextArea -->
    <div class="" style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto" lang="ar"
      dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
      <div id="editor">
        {!! $setting->value[app()->getLocale()] ?? 'نص اختباري' !!}
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-center">
    <button onclick="submitAdvertiseForCompanies()" class="btn btn-primary mr-1 mb-1 m-3">{{ __('dashboard.save')
      }}</button>
  </div>
  @error('content')
  <div style="font-size: 12px; margin:20px 10px;" class="text-danger ">
    {{ $message }}</div>
  @enderror
</div>
</div>
@endif


@if ($page === 'how-advertise-work-for-users' && $setting->key === 'how-advertise-work-for-users')
<div class="card">
  <div class="card-header">
    <h4 class="card-title"> @lang('dashboard.how_advertise_work_for_users') </h4>

  </div>
  <div class="card-body">
    {{-- Hidden Form --}}
    <form class="form form-vertical" id="formAdvertiseForUsers" method="POST"
      action="{{ route('admin.settings.update', $setting->id) }}" enctype="multipart/form-data">
      @csrf
      @method('PATCH')
      <input type="hidden" name="language" value="{{ app()->getLocale() }}">
      <div class="video-container d-flex flex-wrap"
        style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
        <label for=""> @lang('dashboard.current_videos')</label>
        <div class="d-flex gap-2" style="display: flex; gap: 10px;">
          @if(is_array($setting?->value['videoPath']))
          @foreach($setting?->value['videoPath'] ?? [] as $video)
          <video
            style="width: 200px; height: 150px; border-radius: 8px; border: 2px solid #ddd; padding: 5px; background: #fff;"
            controls>
            <source src="{{ asset('storage/AdvertiseForUsers-Anceega/'.$video) }}" type="video/mp4">
            متصفحك لا يدعم تشغيل الفيديو.
          </video>
          @endforeach
          @endif
        </div>
      </div>
      <input type="file" name="videoAdvertiseForUsers[]" id="videoAdvertiseForUsers" class="form-control me-2"
        placeholder="حمل الفيديو .." multiple>
      <br>
      {{-- @dd(app()->getLocale()) --}}
      <div class="row">
        <div class="form-group col-4 d-none">
          <textarea name="contentAdvertiseForUsers" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
            id="TextAdvertiseForUsers" cols="30" rows="10"></textarea>
        </div>
      </div>
    </form>
    <!--  Formatted TextArea -->
    <div class="" style="width:100% !important; height:600px !important; over-flow:scroll; margin:auto" lang="ar"
      dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
      <div id="editor">
        {!! $setting->value[app()->getLocale()] ?? 'نص اختباري' !!}
      </div>
    </div>
  </div>
  <div class="d-flex justify-content-center">
    <button onclick="submitAdvertiseForUsers()" class="btn btn-primary mr-1 mb-1 m-3">{{ __('dashboard.save')
      }}</button>
  </div>
  @error('contentAdvertiseForUsers')
  <div style="font-size: 12px; margin:20px 10px;" class="text-danger ">
    {{ $message }}</div>
  @enderror
</div>
</div>
@endif


@endforeach

</div>
</div>

</div>
@endsection
<!-- END: Content-->
@section('script')
<!-- Include the Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.repeater/jquery.repeater.min.js"></script>
<script src="{{ asset('js/settings.js') }}"></script>
<script>
  // $(input['textarea']).keyup(function(){

  //   })

</script>
@endsection