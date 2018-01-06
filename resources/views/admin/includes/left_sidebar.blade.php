<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('admin/dist/img/avatar5.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p style="padding-top: 10px; ">Alexander Pierce</p>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li> 

        <li class="{{ Request::segment(2) == 'admin' ? 'active':'' }}"><a href="{{url('admin/home')}}"><i class="fa fa-dashboard"></i> <span>Home</span></a></li>
        <li class="{{ Request::segment(2) == 'suppliers' ? 'active':'' }}"><a href="{{url('admin/suppliers')}}"><i class="fa fa-truck"></i> <span>Suppliers</span></a></li>
        <li class="{{ Request::segment(2) == 'users' ? 'active':'' }}"><a href="{{url('admin/users')}}"><i class="fa fa-users"></i> <span>Users</span></a></li>


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
