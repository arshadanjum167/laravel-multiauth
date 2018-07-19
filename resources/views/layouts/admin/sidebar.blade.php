<?php
use yii\helpers\Html;
use app\models\Authitem;
use app\models\Role;
use app\models\Users;
use yii\helpers\ArrayHelper;

?>
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    
    <!-- Sidebar user panel -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <!-- <li class="header"></li> -->


    <li class="treeview ">
      <a href="{{ route('admin.dashboard')}}"><i class="fa fa-home"></i><span>Dashboard</span></a>
    </li>
    <li class="treeview ">
      <a href="{{ URL::to('admin/user') }}"><i class="fa fa-users"></i><span>Users</span></a>
    </li>
     
    
    </ul>
    
    
  </section>
  <!-- /.sidebar -->
</aside>
<script>
 $(function () {
    if(localStorage.expandedMenu==0) {
        $("body").addClass('sidebar-collapse');
    }

    $('body').bind('expanded.pushMenu', function() {
      localStorage.expandedMenu = 1;
    });

    $('body').bind('collapsed.pushMenu', function() {
      localStorage.expandedMenu = 0;
    });
  });
</script>
