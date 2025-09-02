<header class="shadow header_area">
    <div class="top_menu row m0">
        <div class="container">
            <div class="float-left">
                <ul class="list header_social">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
            <div class="float-right">
                <a class="dn_btn" href="tel:+237671128616">+237 671 128 616</a>
                <a class="dn_btn" href="mailto:support@mtmkay.com">support@mtmkay.com</a>
            </div>
        </div>
    </div>
    <div class="main_menu" id="navigation">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h logo_navbar" href="{{route('home')}}"><img src="img/company/mtmkay_logo.png" alt="" width="20%" height="20%"></a>

                <button class="navbar-toggler menu_nav_bar" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset nav_menu_item_list" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item {{ request()->routeIs('home') ? 'active' : ''}}">
                            <a class="nav-link " href="{{route('home')}}">Home</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('about') ? 'active' : ''}}">
                            <a class="nav-link" href="{{route('about')}}">About</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('services') ? 'active' : ''}}">
                            <a href="{{route('services')}}" class="nav-link">Services</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('training') || request()->routeIs('show-training') ? 'active' : ''}}">
                            <a href="{{route('training')}}" class="nav-link">Training</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('blog') || request()->routeIs('show-blog') ? 'active' : ''}}">
                            <a href="{{route('blog')}}" class="nav-link">Blog</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('contact') ? 'active' : ''}}">
                            <a class="nav-link" href="{{route('contact')}}">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
