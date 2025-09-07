@extends('components.dashboard.layouts.master')
@section('title')
{{ __('dashboard.news') }}
@endsection
<!-- BEGIN: Content-->
@section('content')
<div class="app-content content">
  <div class="content-overlay"></div>
  {{-- <div class="header-navbar-shadow"></div> --}}
  <div class="content-wrapper">
    <x-dashboard.layouts.breadcrumb now="{{ $News->name }}">
      <li class="breadcrumb-item"><a href="{{ route('admin.news.index') }}">
          {{ __('dashboard.news_list') }}
        </a></li>
    </x-dashboard.layouts.breadcrumb>
    <div class="col-12 mt-3">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{ __('dashboard.title edit') }} </h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form class="form form-vertical" method="POST" action="{{ route('admin.news.update', $News->id) }}">
              @csrf
              @method('PATCH')
              <div class="row">
                <!-- العربية -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="title">{{ __('dashboard.title') }}</label>
                    <textarea class="form-control" name="title"
                      style="height:100px;">{{ $News->title ?? old('title') }}</textarea>
                    @error('title')
                    <span class="text-danger" style="font-size:12px;">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="contentNews">{{ __('dashboard.contentNews') }}</label>
                    <textarea class="form-control" name="contentNews"
                      style="height:150px;">{{ $News->contentNews ?? old('contentNews') }}</textarea>
                    @error('contentNews')
                    <span class="text-danger" style="font-size:12px;">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <!-- الإنجليزية -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="title_en">{{ __('dashboard.title_en') }}</label>
                    <textarea class="form-control" name="title_en" dir="ltr"
                      style="height:100px;">{{ $News->title_en ?? old('title_en') }}</textarea>
                    @error('title_en')
                    <span class="text-danger" style="font-size:12px;">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="contentNews_en">{{ __('dashboard.contentNews_en') }}</label>
                    <textarea class="form-control" dir="ltr" name="contentNews_en"
                      style="height:150px;">{{ $News->contentNews_en ?? old('contentNews_en') }}</textarea>
                    @error('contentNews_en')
                    <span class="text-danger" style="font-size:12px;">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <!-- is_poll -->
                <div class="form-group col-12 mt-2">
                  <label class="w-100">{{ __('dashboard.is_poll') }}</label><br>
                  <label><input type="radio" name="is_poll" value="1" {{ $News->is_poll == 1 ? 'checked' : '' }}>
                    @lang('dashboard.yes')</label><br>
                  <label><input type="radio" name="is_poll" value="0" {{ $News->is_poll == 0 ? 'checked' : '' }}>
                    @lang('dashboard.no')</label>
                  @error('is_poll')
                  <span class="text-danger" style="font-size:12px;">{{ $message }}</span>
                  @enderror
                </div>


                <div class="row" style="width: 100%; margin: 0; padding: 0;">
                  <div class="col-6">
                    <div class="form-group">
                      <select class="form-select countries_status" id="countries_status" name="countries_status"
                        aria-label="Define Countries Status">
                        <option value="all">@lang('dashboard.all')</option>
                        <option value="certain_countries">@lang('dashboard.certain_countries')</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-6 ">
                    <div class="form-group">
                      <select class="form-select countries" style="display: none; padding:15px" id="countries"
                        name="countries[]" aria-label="select Countries" multiple>
                        @if (is_array($arabicCountries))
                        @foreach($arabicCountries ?? [] as $country)
                        <option value="{{ $country }}"
                          {{ isset($countriesThisNews) && is_array($countriesThisNews) ? (in_array($country, $countriesThisNews) ? 'selected' : '') : '' }} multiple>
                          {{ $country }}</option>
                        @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                </div>
                <br><br>

                <!-- زر التعديل -->
                <div class="col-12">
                  <button type="submit" class="btn btn-primary mr-1 mb-1 edit">
                    {{ __('dashboard.edit') }}
                  </button>
                </div>
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
    // alert($('#countries').val());
      $('#countries_status').select2();
      // $('#countries').select2();
      if($('#countries').val()){
         $('#countries_status').val('certain_countries').change();
        //  $('#countries_status').html('certain_countries');
          $('#countries').show();
      }

      $('#countries_status').on('change',function(){
        console.log($(this).val());
    if($(this).val() == 'certain_countries'){
        $('#countries').show();
        
    }else{
        $('#countries').hide();
    }
});
});
</script>
@endsection