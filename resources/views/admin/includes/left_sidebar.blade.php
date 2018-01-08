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
          <p style="padding-top: 10px; ">{{ Auth::user()->fname." ".Auth::user()->lname }}</p>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li> 

        <li class="{{ Request::segment(2) == 'admin' ? 'active':'' }}"><a href="{{url('admin/home')}}"><i class="fa fa-dashboard"></i> <span>Home</span></a></li>

        <li class="{{ Request::segment(2) == 'users' ? 'active':'' }}"><a href="{{url('admin/users')}}"><i class="fa fa-users"></i> <span>Users</span></a></li>

        <li class="{{ Request::segment(2) == 'suppliers' ? 'active':'' }}"><a href="{{url('admin/suppliers')}}"><i class="fa fa-truck"></i> <span>Suppliers</span></a></li>

        <li class="{{ Request::segment(2) == 'clients' ? 'active':'' }}"><a href="{{url('admin/clients')}}"><i class="fa fa-truck"></i> <span>Clients</span></a></li>

        <li class="{{ Request::segment(2) == 'services' ? 'active':'' }}"><a href="{{url('admin/services')}}"><i class="fa fa-users"></i> <span>Services</span></a></li>

        <li class="{{ Request::segment(2) == 'packages' ? 'active':'' }}"><a href="{{url('admin/packages')}}"><i class="fa fa-users"></i> <span>Packages</span></a></li>

        <li class="{{ Request::segment(2) == 'reservations' ? 'active':'' }}"><a href="{{url('admin/reservations')}}"><i class="fa fa-users"></i> <span>Reservations</span></a></li>


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
