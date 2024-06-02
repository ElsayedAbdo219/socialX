<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav bookmark-icons">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon feather icon-maximize"></i></a></li>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">
                    @if(auth()->user())
                        <li class="dropdown dropdown-notification nav-item" id="notifications-icon"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon feather icon-bell"></i><span class="badge badge-pill badge-primary badge-up">{{auth()->user()->unreadNotifications()->count()}}</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <div class="dropdown-header m-0 p-2">
                                        <h3 class="white">{{auth()->user()->unreadNotifications()->count()}} {{__('dashboard.New')}}</h3><span class="notification-title">{{__('dashboard.App Notifications')}}</span>
                                    </div>
                                </li>
                                <li class="scrollable-container media-list">
                                    @foreach(auth()->user()->notifications as $notification)
                                        <a class="d-flex justify-content-between" href="javascript:void(0)">
                                            <div class="media d-flex align-items-start">
                                                <div class="media-left"><i class="feather icon-download-cloud font-medium-5 success"></i></div>
                                                <div class="media-body">
                                                    <h6 class="success media-heading red darken-1">{{$notification->data['title']}}</h6><small class="notification-text text-bold-700">{{$notification->data['body']}}</small>
                                                </div><small>
                                                    <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">{{$notification->created_at->diffForHumans()}}</time></small>
                                            </div>
                                        </a>
                                    @endforeach
                                </li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item p-1 text-center" href="{{ route('admin.notification.markAsRead') }}">@lang('dashboard.read_all')</a></li>
                            </ul>
                        </li>
                    @endif
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">{{ auth()->user()?->name }}</span><span class="user-status">{{ optional(auth()->user())?->name}}</span></div><span><img class="round" src="{{asset('dashboardAssets/app-assets/images/logo/logo.png')}}" alt="avatar" height="40" width="40"></span>
                        </a>
                        <div style="width: 200px;" class="dropdown-menu dropdown-menu-right">
                            @if(auth()->check())
                                <a class="dropdown-item" href="{{route('admin.profile.edit')}}"><i class="feather icon-user"></i> {{__('dashboard.Edit Profile')}}</a>
                                <div class="dropdown-divider"></div>
                            @endif
                            <a class="dropdown-item" href="{{route('admin.logout')}}"><i class="feather icon-power"></i> {{__('dashboard.Logout')}}</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
