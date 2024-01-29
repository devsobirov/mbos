<div class="row">
    <div class="col-md-3 col-sm-3 col-xs-12">
        <div class="logo">
            <a href="{{route('web.home')}}"><img src="{{asset($settings->logo ?? 'assets/images/logo.png')}}" alt="logo" style="max-height: 85px; display: inline-block"></a>
        </div>
        <div class="mobile-nav"></div>
    </div>
    <div class="col-md-9 col-sm-9 col-xs-12">
        <div class="header-widget">
            <div class="single-widget">
                <i class="fa fa-clock-o"></i>
                <h4>@lang('main.header_hours')</h4>
                <p>{{$settings->working_hours}}</p>
            </div>
            <div class="single-widget">
                <i class="fa fa-envelope"></i>
                <h4>@lang('main.header_email')</h4>
                <p><a href="mailto:{{$settings->email}}">{{$settings->email}}</a></p>
            </div>
            <div class="single-widget">
                <i class="fa fa-phone"></i>
                <h4>@lang('main.header_phone')</h4>
                <p><a href="tel:{{$settings->phone}}">{{$settings->phone}}</a></p>
            </div>

            <ul class="single-widget">
                <li class="" style="margin-left: auto">
                @foreach(LaravelLocalization::getLocalesOrder() as $localeCode => $properties)
                    @if($localeCode == app()->getLocale())
                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                        <img src="{{asset('img/'.$localeCode.'.png')}}" style="margin-right: 8px; display: inline-block" alt="">{{ ucfirst($properties['native']) }} <i class="fa fa-angle-down"></i>
                    </a>
                    @else
                    <ul class="drop-down">
                        <li class=""><a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                <img src="{{asset('img/'.$localeCode.'.png')}}" style="margin-right: 8px; display: inline-block" alt="">{{ ucfirst($properties['native']) }}</a>
                        </li>
                    </ul>
                    @endif
                @endforeach
                </li>
            </ul>
        </div>
    </div>
</div>
