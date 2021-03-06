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
        @if(Auth::user()->user_type == 'Admin' )
        <li class="{{ Request::segment(2) == 'admin' ? 'active':'' }}"><a href="{{url('admin/home')}}"><i class="fa fa-home"></i> <span>Home</span></a></li>
        @endif

        @if(Auth::user()->user_type == 'Secretary' )
        <li class="{{ Request::segment(2) == 'secretary' ? 'active':'' }}"><a href="{{url('secretary/home')}}"><i class="fa fa-home"></i> <span>Home</span></a></li>
        @endif
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user-circle-o"></i>
            <span>Users</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
            <ul class="treeview-menu">
              @if(Auth::user()->user_type == 'Admin' )
              <li class=" {{ Request::segment(2) == 'administrators' ? 'active':'' }}"><a href="{{url('admin/users')}}"><i class="fa fa-user-circle-o"></i> <span>Aministrators</span></a></li>

              <li class=" {{ Request::segment(2) == 'suppliers' ? 'active':'' }}"><a href="{{url('admin/suppliers')}}"><i class="fa fa-user-o"></i> <span>Suppliers</span></a></li>
              @endif
              <li class=" {{ Request::segment(2) == 'clients' ? 'active':'' }}"><a href="{{url('admin/clients')}}"><i class="fa fa-users"></i> <span>Clients</span></a></li>
            </ul>
        </li>

              @if(Auth::user()->user_type == 'Admin' )
        <li class="treeview">
          <a href="#">
            <i class="fa fa-briefcase"></i>
            <span>Services and Packages</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::segment(2) == 'services' ? 'active':'' }}"><a href="{{url('admin/services')}}"><i class="fa fa-briefcase"></i> <span>Services</span></a></li>

            <li class="{{ Request::segment(2) == 'packages' ? 'active':'' }}"><a href="{{url('admin/packages')}}"><i class="fa fa-briefcase"></i> <span>Packages</span></a></li>
          </ul>
        </li>
        @endif
        <li class="treeview">
          <a href="#">
            <i class="fa fa-calendar"></i>
            <span>Reservations</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::segment(2) == 'package' ? 'active':'' }}"><a href="{{url('admin/reservations')}}"><i class="fa fa-calendar"></i> <span>Package Reservations</span></a></li>

            <li class="{{ Request::segment(2) == 'coordinations' ? 'active':'' }}"><a href="{{url('admin/coordinations')}}"><i class="fa fa-calendar"></i> <span>On-the-day Coordinations</span></a></li>
          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-area-chart"></i>
            <span>Reports</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">

            <li class="{{ Request::segment(2) == 'user registration' ? 'active':'' }}"><a href="{{url('admin/report/user')}}"><i class="fa fa-area-chart"></i> <span>User Registration</span></a></li>


              <li class="treeview">
                <a href="#">
                  <i class="fa fa-bar-chart-o"></i>
                  <span>Services Purchased</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li class="{{ Request::segment(2) == 'between years' ? 'active':'' }}"><a href="{{url('admin/report/service/yearly')}}"><i class="fa fa-area-chart"></i> <span>Between Years</span></a></li>

           
                  <li class="{{ Request::segment(2) == 'yearly report' ? 'active':'' }}"><a href="{{url('admin/report/service/monthly')}}/{{\Carbon\Carbon::now()->year}}"><i class="fa fa-area-chart"></i> <span>Yearly Report</span></a></li>

                  <li class="{{ Request::segment(2) == 'monthly report' ? 'active':'' }}"><a href="{{url('admin/report/service/weekly')}}/{{\Carbon\Carbon::now()->month}}/{{\Carbon\Carbon::now()->year}}"><i class="fa fa-area-chart"></i> <span>Monthly Report</span></a></li>

                  <li class="{{ Request::segment(2) == 'overall' ? 'active':'' }}"><a href="{{url('admin/report/service/overall')}}"><i class="fa fa-area-chart"></i> <span>Overall</span></a></li>
                </ul>
              </li>


              <li class="treeview">
                <a href="#">
                  <i class="fa fa-bar-chart-o"></i>
                  <span>Packages Purchased</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li class="{{ Request::segment(2) == 'between years' ? 'active':'' }}"><a href="{{url('admin/report/package/yearly')}}"><i class="fa fa-area-chart"></i> <span>Between Years</span></a></li>

                  <li class="{{ Request::segment(2) == 'yearly report' ? 'active':'' }}"><a href="{{url('admin/report/package/monthly')}}/{{\Carbon\Carbon::now()->year}}"><i class="fa fa-area-chart"></i> <span>Yearly Report</span></a></li>

                  <li class="{{ Request::segment(2) == 'monthly report' ? 'active':'' }}"><a href="{{url('admin/report/package/weekly')}}/{{\Carbon\Carbon::now()->month}}/{{\Carbon\Carbon::now()->year}}"><i class="fa fa-area-chart"></i> <span>Monthly Report</span></a></li>

                  <li class="{{ Request::segment(2) == 'overall' ? 'active':'' }}"><a href="{{url('admin/report/package/overall')}}"><i class="fa fa-area-chart"></i> <span>Overall</span></a></li>

                </ul>
              </li>

               <li class="treeview">
                <a href="#">
                  <i class="fa fa-bar-chart-o"></i>
                  <span>Reservations</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                
                <ul class="treeview-menu">
                  <li class="{{ Request::segment(2) == 'yearly' ? 'active':'' }}"><a href="{{url('admin/report/reservation/yearly')}}"><i class="fa fa-area-chart"></i> <span>Between Years</span></a></li>

                  <li class="{{ Request::segment(2) == 'yearly report' ? 'active':'' }}"><a href="{{url('admin/report/reservation/monthly')}}/{{\Carbon\Carbon::now()->year}}"><i class="fa fa-area-chart"></i> <span>Yearly Report</span></a></li>

                  <li class="{{ Request::segment(2) == 'overall' ? 'active':'' }}"><a href="{{url('admin/report/reservation/overall')}}"><i class="fa fa-area-chart"></i> <span>Overall</span></a></li>

                </ul>
              </li>
            
          </ul>
        </li>

              <li class="treeview">
                <a href="#">
                  <i class="fa fa-money"></i>
                  <span>Payments</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li class="{{ Request::segment(2) == 'package reservation' ? 'active':'' }}"><a href="{{url('admin/payments')}}"><i class="fa fa-money"></i> <span>Package Reservation</span></a></li>

                  <li class="{{ Request::segment(2) == 'on-the-day coordination' ? 'active':'' }}"><a href="{{url('admin/payments_coord')}}"><i class="fa fa-money"></i> <span>On-the-day Coordination</span></a></li>

                </ul>
              </li>

              @if(Auth::user()->user_type == 'Admin' )
            <li class="treeview">
                <a href="#">
                  <i class="fa fa-credit-card-alt"></i>
                  <span>Payment Requests</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li class="{{ Request::segment(2) == 'package reservations' ? 'active':'' }}"><a href="{{url('admin/payment_requests')}}"><i class="fa fa-credit-card-alt"></i> <span>Package Reservations</span><span class="badge badge-pill badge-danger display-5"> {{ \App\Payment::where('status', 'pending')->count() }}</span></a></li>
                  <li class="{{ Request::segment(2) == 'On-the-day Coordinations' ? 'active':'' }}"><a href="{{url('admin/payment_requests_coord')}}"><i class="fa fa-credit-card-alt"></i> <span>On-the-day Coordinations</span><span class="badge badge-pill badge-danger display-5"> {{ \App\PaymentCoordination::where('status', 'pending')->count() }}</span></a></li>
                </ul>
              </li>

              <li class="treeview">
                <a href="#">
                  <i class="fa fa-edit"></i>
                  <span>Client Requests</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li class="{{ Request::segment(2) == 'package reservations' ? 'active':'' }}"><a href="{{url('admin/client_requests')}}"><i class="fa fa-edit"></i> <span>Package Reservations</span><span class="badge badge-pill badge-danger display-5"> {{ \App\ClientNotification::where('status', 'pending')->count() }}</span></a></li>
                  <li class="{{ Request::segment(2) == 'On-the-day Coordinations' ? 'active':'' }}"><a href="{{url('admin/client_requests_coord')}}"><i class="fa fa-edit"></i> <span>On-the-day Coordinations</span><span class="badge badge-pill badge-danger display-5"> {{ \App\ClientNotificationCoord::where('status', 'pending')->count() }}</span></a></li>
                </ul>
              </li>
              @endif

<!--             <li class="{{ Request::segment(2) == 'messenger' ? 'active':'' }}"><a href="{{url('/chat/')}}"><i class="fa fa-dashboard"></i> <span>Messenger</span></a></li> -->

              

              
              
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
