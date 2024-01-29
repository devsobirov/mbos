<footer id="footer" class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="single-widget address">
{{--                        <img src="{{asset($settings->footer_logo)}}" alt="{{$settings->meta_title}}"--}}
{{--                             style="display: block; max-height: 85px;">--}}
                        <h2>@lang('main.footer_header')</h2>
                        <p>@lang('main.footer_info')</p>
                        <ul class="list">
                            <li><i class="fa fa-phone"></i>@lang('main.header_phone'): <a href="tel:{{$settings->phone}}">{{$settings->phone}} </li>
                            <li><i class="fa fa-envelope"></i>@lang('main.header_email'): <a href="mailto:{{$settings->email}}">{{$settings->email}}</a></li>
                            <li><i class="fa fa-map-o"></i>@lang('main.footer_address'): {{$settings->address}}</li>
                            <li><i class="fa fa-clock-o"></i>@lang('main.header_hours'): {{$settings->working_hours}}</li>
                        </ul>
                        <ul class="social">
                            <li><a href="{{$settings->facebook ?? '#'}}"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="{{$settings->twitter ?? '#'}}"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="{{$settings->vk ?? '#'}}"><i class="fa fa-vk"></i></a></li>
                            <li><a href="{{$settings->ok ?? '#'}}"><i class="fa fa-odnoklassniki"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="single-widget links">
                        <h2>@lang('main.footer_navigation')</h2>
                        <ul class="list">
                        @foreach($menu->where('show_in_footer') as $footerLink)
                            <li><a href="{{$footerLink->getUrl()}}"><i class="fa fa-angle-right"></i>{{$footerLink->title}}</a></li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="copyright">
                        <p>© Copyright © {{date('Y')}}. @lang('main.footer_copyright')</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
