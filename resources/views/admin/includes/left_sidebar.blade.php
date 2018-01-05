<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('admin/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li> 

        <li><a href="{{url('admin')}}"><i class="fa fa-dashboard"></i> <span>Home</span></a></li>
        <li><a href="{{url('admin/suppliers')}}"><i class="fa fa-truck"></i> <span>Suppliers</span></a></li>
        <li><a href="{{url('admin/users')}}"><i class="fa fa-users"></i> <span>Users</span></a></li>


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
