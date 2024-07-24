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
                                                    <h6 class="success media-heading red darken-1">{{$notification?->data['title']}}</h6><small class="notification-text text-bold-700">{{$notification?->data['body']}}</small>
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
                            {{-- <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">{{ auth()->user()?->name }}</span><span class="user-status">
                                {{ optional(auth()->user())?->name}}</span></div><span> --}}
                                    <svg style="width: 65px"  width="112" height="32" viewBox="0 0 112 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M42.64 13.22V18.58C42.64 18.9533 42.7267 19.2267 42.9 19.4C43.0867 19.56 43.3933 19.64 43.82 19.64H45.12V22H43.36C41 22 39.82 20.8533 39.82 18.56V13.22H38.5V10.92H39.82V8.18H42.64V10.92H45.12V13.22H42.64ZM53.3739 10.76C54.2139 10.76 54.9606 10.9467 55.6139 11.32C56.2672 11.68 56.7739 12.22 57.1339 12.94C57.5072 13.6467 57.6939 14.5 57.6939 15.5V22H54.8939V15.88C54.8939 15 54.6739 14.3267 54.2339 13.86C53.7939 13.38 53.1939 13.14 52.4339 13.14C51.6606 13.14 51.0472 13.38 50.5939 13.86C50.1539 14.3267 49.9339 15 49.9339 15.88V22H47.1339V7.2H49.9339V12.3C50.2939 11.82 50.7739 11.4467 51.3739 11.18C51.9739 10.9 52.6406 10.76 53.3739 10.76ZM61.7766 9.6C61.2832 9.6 60.8699 9.44667 60.5366 9.14C60.2166 8.82 60.0566 8.42667 60.0566 7.96C60.0566 7.49333 60.2166 7.10667 60.5366 6.8C60.8699 6.48 61.2832 6.32 61.7766 6.32C62.2699 6.32 62.6766 6.48 62.9966 6.8C63.3299 7.10667 63.4966 7.49333 63.4966 7.96C63.4966 8.42667 63.3299 8.82 62.9966 9.14C62.6766 9.44667 62.2699 9.6 61.7766 9.6ZM63.1566 10.92V22H60.3566V10.92H63.1566ZM65.203 16.44C65.203 15.3333 65.4296 14.3533 65.883 13.5C66.3496 12.6333 66.9763 11.96 67.763 11.48C68.5496 11 69.4163 10.76 70.363 10.76C71.1496 10.76 71.843 10.9133 72.443 11.22C73.0563 11.5133 73.5496 11.8933 73.923 12.36V10.92H76.743V27.28H73.923V20.48C73.5496 20.96 73.0496 21.36 72.423 21.68C71.7963 22 71.0896 22.16 70.303 22.16C69.3696 22.16 68.5096 21.92 67.723 21.44C66.9496 20.9467 66.3363 20.2667 65.883 19.4C65.4296 18.5333 65.203 17.5467 65.203 16.44ZM73.923 16.46C73.923 15.78 73.783 15.1933 73.503 14.7C73.223 14.2067 72.8563 13.8333 72.403 13.58C71.963 13.3267 71.4896 13.2 70.983 13.2C70.4896 13.2 70.0163 13.3267 69.563 13.58C69.123 13.8333 68.763 14.2067 68.483 14.7C68.203 15.18 68.063 15.76 68.063 16.44C68.063 17.12 68.203 17.7133 68.483 18.22C68.763 18.7133 69.123 19.0867 69.563 19.34C70.0163 19.5933 70.4896 19.72 70.983 19.72C71.4896 19.72 71.963 19.5933 72.403 19.34C72.8563 19.0867 73.223 18.7133 73.503 18.22C73.783 17.7267 73.923 17.14 73.923 16.46ZM78.7577 16.42C78.7577 15.3 78.9777 14.3067 79.4177 13.44C79.871 12.5733 80.4777 11.9067 81.2377 11.44C82.011 10.9733 82.871 10.74 83.8177 10.74C84.6443 10.74 85.3643 10.9067 85.9777 11.24C86.6043 11.5733 87.1043 11.9933 87.4777 12.5V10.92H90.2977V22H87.4777V20.38C87.1177 20.9 86.6177 21.3333 85.9777 21.68C85.351 22.0133 84.6243 22.18 83.7977 22.18C82.8643 22.18 82.011 21.94 81.2377 21.46C80.4777 20.98 79.871 20.3067 79.4177 19.44C78.9777 18.56 78.7577 17.5533 78.7577 16.42ZM87.4777 16.46C87.4777 15.78 87.3443 15.2 87.0777 14.72C86.811 14.2267 86.451 13.8533 85.9977 13.6C85.5443 13.3333 85.0577 13.2 84.5377 13.2C84.0177 13.2 83.5377 13.3267 83.0977 13.58C82.6577 13.8333 82.2977 14.2067 82.0177 14.7C81.751 15.18 81.6177 15.7533 81.6177 16.42C81.6177 17.0867 81.751 17.6733 82.0177 18.18C82.2977 18.6733 82.6577 19.0533 83.0977 19.32C83.551 19.5867 84.031 19.72 84.5377 19.72C85.0577 19.72 85.5443 19.5933 85.9977 19.34C86.451 19.0733 86.811 18.7 87.0777 18.22C87.3443 17.7267 87.4777 17.14 87.4777 16.46Z" fill="#44444F"></path>
                                        <rect x="2" y="3" width="24" height="24" rx="8" stroke="#0073FF" stroke-width="4"></rect>
                                        <rect x="13" y="4" width="12" height="12" rx="6" stroke="#0073FF" stroke-width="4"></rect>
                                    </svg>
                        
                        </span>
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
