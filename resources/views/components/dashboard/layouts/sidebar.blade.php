<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ route('admin.home') }}">
                    <div class="brand-logo">
                        <img style="width: 40px" src="{{ asset('dashboardAssets/app-assets/images/logo/logo.png') }}">
                    </div>
                    <h2 class="brand-text mb-0">ثقه</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                        class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i
                        class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
                        data-ticon="icon-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item {{ Route::is('admin.home') ? 'active' : '' }}"><a href="{{ route('admin.home') }}"><i
                        class="feather icon-home"></i><span class="menu-title"
                        data-i18n="Dashboard">{{ __('dashboard.dashboard') }}</span></a>
            </li>

            

          
            <li class=" nav-item"><a href="#"><i class="feather icon-users"></i>
                <span class="menu-title" data-i18n="Data List">{{ __('dashboard.companies') }}</span>
            </a>
            <ul class="menu-content">

                <li class="{{ Route::is('admin.companies.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.companies.index') }}">
                        <i class="feather icon-eye"></i>
                        <span class="menu-item"
                            data-i18n="List View">{{ __('dashboard.show_companies') }}</span>
                    </a>
                </li>
     
            </ul>
        </li> 


           <li class=" nav-item"><a href="#"><i class="feather icon-users"></i>
                <span class="menu-title" data-i18n="Data List">{{ __('dashboard.employees') }}</span>
            </a>
            <ul class="menu-content">

                <li class="{{ Route::is('admin.employees.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.employees.index') }}">
                        <i class="feather icon-eye"></i>
                        <span class="menu-item"
                            data-i18n="List View">{{ __('dashboard.show_employees') }}</span>
                    </a>
                </li>
     
            </ul>
        </li> 



        <li class=" nav-item"><a href="#"><i class="feather icon-layers"></i>
            <span class="menu-title" data-i18n="Data List">{{ __('dashboard.posts') }}</span>
        </a>
        <ul class="menu-content">

            <li class="{{ Route::is('admin.posts.index') ? 'active' : '' }}">
                <a href="{{ route('admin.posts.index') }}">
                    <i class="feather icon-eye"></i>
                    <span class="menu-item"
                        data-i18n="List View">{{ __('dashboard.show_posts') }}</span>
                </a>
            </li>
 
        </ul>
    </li> 


    <li class=" nav-item"><a href="#"><i class="feather icon-activity"></i>
        <span class="menu-title" data-i18n="Data List">{{ __('dashboard.news') }}</span>
    </a>
    <ul class="menu-content">

        <li class="{{ Route::is('admin.news.index') ? 'active' : '' }}">
            <a href="{{ route('admin.news.index') }}">
                <i class="feather icon-eye"></i>
                <span class="menu-item"
                    data-i18n="List View">{{ __('dashboard.show_news') }}</span>
            </a>
        </li>

    </ul>
</li> 

        

            

          <li class=" nav-item">
            <a href="#"><i class="feather icon-user-x"></i>
                <span class="menu-title" data-i18n="Data List">{{__('dashboard.Complains')}}</span>
            </a>
            <ul class="menu-content">
                <li class="{{Route::is('admin.complain.index')? 'active':''}}">
                    <a href="{{route('admin.complain.index')}}">
                        <i class="feather icon-eye"></i>
                        <span class="menu-item" data-i18n="List View">{{__('dashboard.complains_list')}}</span>
                    </a>
                </li>
            </ul>
        </li> 

        {{-- FQA --}}
        {{--            @can('patients')--}}
         <li class=" nav-item"><a href="#"><i class="feather icon-help-circle"></i>
                <span class="menu-title" data-i18n="Data List">{{__('dashboard.fqas')}}</span>
            </a>
            <ul class="menu-content">
                <li class="{{Route::is('admin.fqa.index')? 'active':''}}">
                    <a href="{{route('admin.fqa.index')}}">
                        <i class="feather icon-eye"></i>
                        <span class="menu-item" data-i18n="List View">{{__('dashboard.fqa_list')}}</span>
                    </a>
                </li>
            </ul>
        </li> 



           {{-- settings --}}
              <li class=" nav-item"><a href="{{ route('admin.settings.index') }}"><i
                        class="feather icon-settings"></i><span class="menu-title"
                        data-i18n="Data List">{{ __('dashboard.app_settings') }}</span></a></li> 





        </ul>
    </div>
</div>
