<div class="nav-area">
    <nav class="mainmenu">
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="@if(request()->routeIs('web.home')) active @endif"><a href="{{route('web.home')}}">@lang('main.home')</a></li>
                @foreach($menu as $menuLink)
                    @php $hasSubMenus = count($menuLink->subMenus) > 0;@endphp
                    <li class="@if(request()->fullUrlIs($menuLink->getUrl())) active @endif">
                        <a href="{{$menuLink->getUrl()}}">{{$menuLink->title}} @if($hasSubMenus) <i class="fa fa-angle-down"></i>@endif</a>
                        @if($hasSubMenus)
                        <ul class="drop-down">
                            @foreach($menuLink->subMenus as $subMenu)
                                <li class="@if(request()->fullUrlIs($subMenu->getUrl())) active @endif"><a href="{{$subMenu->getUrl()}}">{{$subMenu->title}}</a></li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
    <ul class="social">
        <li><a href="{{$settings->facebook ?? '#'}}"><i class="fa fa-facebook"></i></a></li>
        <li><a href="{{$settings->telegram ?? '#'}}"><i class="fa fa-telegram"></i></a></li>
        <li><a href="{{$settings->vk ?? '#'}}"><i class="fa fa-vk"></i></a></li>
        <li><a href="{{$settings->youtube ?? '#'}}"><i class="fa fa-youtube-square"></i></a></li>
    </ul>
</div>
