<ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li> 

        <li class="{{ Request::segment(2) == 'admin' ? 'active':'' }}"><a href="{{url('admin/home')}}"><i class="fa fa-dashboard"></i> <span>Home</span></a></li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-bar-chart-o"></i>
            <span>Users</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
            <ul class="treeview-menu">
              <li class=" {{ Request::segment(2) == 'administrators' ? 'active':'' }}"><a href="{{url('admin/users')}}"><i class="fa fa-users"></i> <span>Aministrators</span></a></li>

              <li class=" {{ Request::segment(2) == 'suppliers' ? 'active':'' }}"><a href="{{url('admin/suppliers')}}"><i class="fa fa-truck"></i> <span>Suppliers</span></a></li>

              <li class=" {{ Request::segment(2) == 'clients' ? 'active':'' }}"><a href="{{url('admin/clients')}}"><i class="fa fa-truck"></i> <span>Clients</span></a></li>
            </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-bar-chart-o"></i>
            <span>Services and Packages</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::segment(2) == 'services' ? 'active':'' }}"><a href="{{url('admin/services')}}"><i class="fa fa-users"></i> <span>Services</span></a></li>

            <li class="{{ Request::segment(2) == 'packages' ? 'active':'' }}"><a href="{{url('admin/packages')}}"><i class="fa fa-users"></i> <span>Packages</span></a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-bar-chart-o"></i>
            <span>Reservations</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::segment(2) == 'package' ? 'active':'' }}"><a href="{{url('admin/reservations')}}"><i class="fa fa-users"></i> <span>Package Reservations</span></a></li>

            <li class="{{ Request::segment(2) == 'coordinations' ? 'active':'' }}"><a href="{{url('admin/coordinations')}}"><i class="fa fa-users"></i> <span>Coordinations</span></a></li>
          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-bar-chart-o"></i>
            <span>Reports</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">

            <li class="{{ Request::segment(2) == 'user registration' ? 'active':'' }}"><a href="{{url('admin/report/user')}}"><i class="fa fa-users"></i> <span>User Registration</span></a></li>


              <li class="treeview">
                <a href="#">
                  <i class="fa fa-bar-chart-o"></i>
                  <span>Services</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li class="{{ Request::segment(2) == 'yearly report' ? 'active':'' }}"><a href="{{url('admin/report/service/yearly')}}"><i class="fa fa-users"></i> <span>Yearly Report</span></a></li>

                  <li class="{{ Request::segment(2) == 'monthly report' ? 'active':'' }}"><a href="{{url('admin/report/service/monthly')}}"><i class="fa fa-users"></i> <span>Monthly Report</span></a></li>

                  <li class="{{ Request::segment(2) == 'overall' ? 'active':'' }}"><a href="{{url('admin/report/service/overall')}}"><i class="fa fa-users"></i> <span>Overall</span></a></li>
                </ul>
              </li>


              <li class="treeview">
                <a href="#">
                  <i class="fa fa-bar-chart-o"></i>
                  <span>Packages</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li class="{{ Request::segment(2) == 'yearly report' ? 'active':'' }}"><a href="{{url('admin/report/package/yearly')}}"><i class="fa fa-users"></i> <span>Yearly Report</span></a></li>

                  <li class="{{ Request::segment(2) == 'monthly report' ? 'active':'' }}"><a href="{{url('admin/report/package/monthly')}}"><i class="fa fa-users"></i> <span>Monthly Report</span></a></li>

                  <li class="{{ Request::segment(2) == 'overall' ? 'active':'' }}"><a href="{{url('admin/report/package/overall')}}"><i class="fa fa-users"></i> <span>Overall</span></a></li>

                </ul>
              </li>


              <li class="treeview">
                <a href="#">
                  <i class="fa fa-bar-chart-o"></i>
                  <span>Reservations</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li class="{{ Request::segment(2) == 'yearly' ? 'active':'' }}"><a href="{{url('admin/report/reservation/yearly')}}"><i class="fa fa-users"></i> <span>Yearly Report</span></a></li>

                  <li class="{{ Request::segment(2) == 'yearly report' ? 'active':'' }}"><a href="{{url('admin/report/reservation/monthly')}}"><i class="fa fa-users"></i> <span>Monthly Report</span></a></li>

                  <li class="{{ Request::segment(2) == 'overall' ? 'active':'' }}"><a href="{{url('admin/report/reservation/overall')}}"><i class="fa fa-users"></i> <span>Overall</span></a></li>

                </ul>
              </li>
            
          </ul>
        </li>

        <li class="treeview">
                <a href="#">
                  <i class="fa fa-bar-chart-o"></i>
                  <span>Payments</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li class="{{ Request::segment(2) == 'payments' ? 'active':'' }}"><a href="{{url('admin/payments')}}"><i class="fa fa-users"></i> <span>Package Reservation</span></a></li>

                  <li class="{{ Request::segment(2) == 'payments' ? 'active':'' }}"><a href="{{url('admin/payments')}}"><i class="fa fa-users"></i> <span>On-the-day Coordination</span></a></li>

                </ul>
              </li>


      </ul>