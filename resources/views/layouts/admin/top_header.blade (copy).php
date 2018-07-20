<header class="main-header">
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('img/user8-128x128.jpg') }}" class="user-image" alt="User Image">
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <div class="log-arrow-up"></div>
                                    <li class="user-header">
                                       <img src="{{ asset('img/user8-128x128.jpg') }}" class="img-circle" alt="User Image">
                                    </li>
                                    <span class="user-body">
                                      <p class="username">
                                      {{ Auth::user()->name }}
                                      </p>
                                      <!--<li><a href="#">My Profile</a></li>-->
                                      <li><a href="{{ route('admin.showchangepassword')}}">Change Password</a></li>
                                      <li><a href="{{route('admin.logout')}}">Sign out</a></li>
                                    </span>
                                 </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{ route('admin.dashboard')}}">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo" width="30px" />
                            <span>{{ config('params.appTitle') }}</span>
                        </a>
                    </div>

                    <!-- Sidebar toggle button-->
                    <!--<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">-->
                    <!--    <span class="sr-only">Toggle navigation</span>-->
                    <!--    <span class="icon-bar"></span>-->
                    <!--    <span class="icon-bar"></span>-->
                    <!--    <span class="icon-bar"></span>-->
                    <!--</a>-->
                    <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('admin.dashboard')}}"><span>Dashboard</span></a></li>
                        <li><a href="{{ URL::to('admin/user') }}"><span>Users</span></a></li>
                        <!--<li><a href="{{ URL::to('masjid') }}"><span>Masjid</span></a></li>-->
                        <!--<li><a href="{{ URL::to('person') }}"><span>Person</span></a></li>-->
                        <!--<li><a href="{{ route('home')}}"><span>Safer</span></a></li>-->
                        <!--<li>-->
                        <!--    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">Reports <span class="caret"></span></a>-->
                        <!--    <ul class="dropdown-menu">-->
                        <!--        <li><a href="{{ route('home')}}">Person Report</a></li>-->
                        <!--        <li><a href="{{ route('home')}}">Summary Halkawise</a></li>-->
                        <!--        <li><a href="{{ route('home')}}">Summary Typewise</a></li>-->
                        <!--    </ul>-->
                        <!--</li>-->
                        <!--<li><a href="{{ route('home')}}"><span>Transferred Person</span></a></li>-->
                    </ul>
                    </div>

                </nav>
            </header>
