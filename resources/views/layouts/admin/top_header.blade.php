<?php
$image=asset('img/avatar.png');
if(Auth::user()->avatar!='')
$image=Auth::user()->avatar;
?>
<header class="main-header">
    <!-- Logo -->
  <a href="{{ route('admin.dashboard')}}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">{{ config('params.short_appTitle') }}</span>
    <!-- logo for regular state and mobile devices -->
     <span class="logo-lg">{{ config('params.appTitle') }}</span> 
    
  </a>

    <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" data-pjax=false class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{$image}}" class="user-image" alt="User Image">
            <span class="hidden-xs">{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
             <img src="{{$image}}" class="img-circle" alt="User Image">
             
              <p>
                {{ Auth::user()->name }}
              </p>
              <a href="{{ route('admin.editprofile')}}" class="btn btn-default btn-flat">Edit Profile
             </a>
            </li>

            
            <li class="user-footer new-user-footer">
                
                <div class="pull-left">
                  <a href="{{ route('admin.showchangepassword')}}" class="btn btn-default btn-flat">Change Password</a>
                </div>
                <div class="pull-right">
                    <a href="{{route('admin.logout')}}" class="btn btn-default btn-flat" title="Logout">Logout</a>
                </div>
            </li>
          </ul>
        </li>

      </ul>
    </div>
  </nav>          
</header>
