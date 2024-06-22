<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
<div class="sticky">
    <aside class="app-sidebar sidebar-scroll">
        <div class="main-sidebar-header active">
            <a class="desktop-logo logo-light active" href="{{url('/')}}"><img
                    src="{{ asset('dashboard/img/brand/logo-light.png') }}" class="main-logo" alt="logo"></a>
            <a class="desktop-logo logo-dark active" href="{{url('/')}}"><img
                    src="{{ asset('dashboard/img/brand/logo-light.png') }}" class="main-logo" alt="logo"></a>
            <a class="logo-icon mobile-logo icon-light active" href="{{url('/')}}"><img
                    src="{{ asset('dashboard/img/brand/logo2.png') }}" alt="logo"></a>
            <a class="logo-icon mobile-logo icon-dark active" href="{{url('/')}}"><img
                    src="{{ asset('dashboard/img/brand/logo2.png') }}" alt="logo"></a>
        </div>
        <div class="main-sidemenu">
            <div class="app-sidebar__user clearfix">
                <div class="dropdown user-pro-body">
                    <div class="main-img-user avatar-xl">
                        <img alt="user-img" src="{{ asset('icon/logo2.png') }}" width="10" height="10"><span
                            class="avatar-status profile-status bg-green"></span>
                    </div>
                    <div class="user-info">
                        <h4 class="fw-semibold mt-3 mb-0">{{ auth()->user()->name }}</h4>
                        <span class="mb-0 text-muted">{{ auth()->user()->email }}</span>
                    </div>
                </div>
            </div>
            <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg></div>
            <ul class="side-menu">
                <li class="side-item side-item-category">{{ __('Main') }}</li>
                @can('display dashboard')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('home') }}">
                        <img class="side-menu__icon mCS_img_loaded" src="{{asset('icon-new/2.png')}}" style=" width: 30px; height: 30px;">

                        <span class="side-menu__label">{{ __('Dashboard ') }}</span>
                    </a>
                </li>
                @endcan


                <li class="side-item side-item-category">{{ __('General') }}</li>
                @can('display admins')
                    <li class="slide">
                        <a class="side-menu__item" href="{{ route('admins.index') }}">
                            <img class="side-menu__icon mCS_img_loaded" src="{{asset('icon-new/3.png')}}" style=" width: 30px; height: 30px;">
                            <span class="side-menu__label">{{ __('Members') }}</span>
                        </a>
                    </li>
                @endcan

                @can('display roles')
                    <li class="slide">
                        <a class="side-menu__item" href="{{ route('roles.index') }}">
                            <img class="side-menu__icon mCS_img_loaded" src="{{asset('icon-new/4.png')}}" style=" width: 30px; height: 30px;">
                            <span class="side-menu__label">{{ __('Permissions') }}</span></a>
                    </li>
                @endcan

                @can('display users')
                    <li class="slide">
                        <a class="side-menu__item" href="{{ route('users.index') }}">
                            <img class="side-menu__icon mCS_img_loaded" src="{{asset('icon-new/5.png')}}" style=" width: 30px; height: 30px;">
                            <span class="side-menu__label">{{ __('Users') }}</span>
                        </a>
                    </li>

                @endcan


                @can('display courses')
                    <li class="slide">
                        <a class="side-menu__item" href="{{ route('courses.index') }}">
                            <img class="side-menu__icon mCS_img_loaded" src="{{asset('icon-new/6.png')}}" style=" width: 30px; height: 30px;">
                            <span class="side-menu__label">{{ __('Courses') }}</span></a>
                    </li>
                @endcan

{{--                @can('display videos')--}}
{{--                    <li class="slide">--}}
{{--                        <a class="side-menu__item" href="{{ route('videos.index') }}">--}}
{{--                            <img class="side-menu__icon mCS_img_loaded" src="{{asset('icon/3.png')}}" style=" width: 30px; height: 30px;">--}}
{{--                            <span class="side-menu__label">{{ __('Videos') }}</span></a>--}}
{{--                    </li>--}}
{{--                @endcan--}}


                @can('display settings')
                    <li class="slide">
                        <a class="side-menu__item" href="{{ route('settings.index') }}">
                            <img class="side-menu__icon mCS_img_loaded" src="{{asset('icon-new/7.png')}}" style=" width: 30px; height: 30px;">
                            <span class="side-menu__label">{{ __('Settings') }}</span></a>
                    </li>
                @endcan


            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg></div>
        </div>
    </aside>
</div>
