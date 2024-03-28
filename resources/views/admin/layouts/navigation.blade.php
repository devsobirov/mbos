<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
            <div class="container-xl">
                <ul class="navbar-nav">

                    <li class="nav-item @if(request()->routeIs('home')) active @endif">
                        <a class="nav-link" href="{{ route('home') }}" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                            </span>
                            <span class="nav-link-title">
                                Bosh menu
                            </span>
                        </a>
                    </li>

                    <li class="nav-item @if(request()->routeIs('projects.*')) active @endif">
                        <a class="nav-link" href="{{ route('projects.index') }}" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block"><x-svg.app></x-svg.app></span>
                            <span class="nav-link-title">Loyihalar</span>
                        </a>
                    </li>

                    <li class="nav-item @if(request()->routeIs('customers.*')) active @endif">
                        <a class="nav-link" href="{{ route('customers.index') }}" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block"><x-svg.store></x-svg.store></span>
                            <span class="nav-link-title">Mijozlar</span>
                        </a>
                    </li>

                    <li class="nav-item @if(request()->routeIs('invoices.*')) active @endif">
                        <a class="nav-link" href="{{ route('invoices.index') }}" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block"><x-svg.invoice></x-svg.invoice></span>
                            <span class="nav-link-title">Shartnomalar</span>
                        </a>
                    </li>

                    <li class="nav-item @if(request()->routeIs('payments.*')) active @endif">
                        <a class="nav-link" href="#" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block"><x-svg.payment></x-svg.payment></span>
                            <span class="nav-link-title">To'lovlar</span>
                        </a>
                    </li>

                    @if(auth()->user()->isAdmin())
                    <li class="nav-item @if(request()->routeIs('logs.*')) active @endif">
                        <a class="nav-link" href="{{ route('logs.index') }}" >
                            <span class="nav-link-icon d-md-none d-lg-inline-block"><x-svg.history></x-svg.history></span>
                            <span class="nav-link-title">Log</span>
                        </a>
                    </li>
                        <li class="nav-item @if(request()->routeIs('users.*')) active @endif">
                            <a class="nav-link" href="{{ route('users.index') }}" >
                                <span class="nav-link-icon d-md-none d-lg-inline-block"><x-svg.users></x-svg.users></span>
                                <span class="nav-link-title">Users</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
