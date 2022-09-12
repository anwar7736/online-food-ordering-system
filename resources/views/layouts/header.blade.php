<header class="header black_nav clearfix element_to_stick">
                    <div class="container">
                        <div id="logo">
                            <a href="{{url('/')}}">
                                <img src="{{asset('frontend/img/logo_sticky.svg')}}" width="162" height="35" alt="">
                            </a>
                        </div>
                        <div class="layer"></div><!-- Opacity Mask Menu Mobile -->
                        <ul id="top_menu">
                            <li><a href="{{route('login')}}" class="login">Sign In</a></li>
                            <li><a href="{{URL::to('/')}}" class="wishlist_bt_top" title="Your wishlist">Your wishlist</a></li>
                        </ul>
                        <!-- /top_menu -->
                        <a href="#" class="open_close">
                            <i class="icon_menu"></i><span>Menu</span>
                        </a>
                       <nav class="main-menu">
                            <ul>
                                <li class="submenu">
                                    <a href="{{url('/')}}" class="show-submenu">Home</a>
                                    
                                </li>
                                <li class="submenu">
                                    <a href="{{url('/')}}" class="show-submenu">Listing</a>
                                    
                                </li>
                                <li class="submenu">
                                    <a href="{{url('/')}}" class="show-submenu">Other Pages</a>
                                   
                                </li>
                            </ul>
                        </nav>
                    </div>
                </header>
                <!-- /header -->
            