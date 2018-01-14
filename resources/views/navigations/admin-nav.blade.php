
	<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
	      <div class="container">
	        <a class="navbar-brand js-scroll-trigger" href="#page-top">Home</a>
	        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	        <div class="collapse navbar-collapse" id="navbarResponsive">
	          <ul class="navbar-nav ml-auto">
	          	<!-- <li class="dropdown">
					  <button class="dropbtn">Manage</button>
						  <div class="dropdown-content">
						    <a href="#">Manage Services</a>
						    <a href="#">Manage Packages</a>
						    <a href="#">Manage Suppliers</a>
						    <a href="#">Manage Gallery</a>
						    <a href="#">Manage Reservation</a>
						  </div>
				</li> -->
	            <li class="nav-item">
	              <a class="nav-link js-scroll-trigger" href="#manage">Manage</a>
	            </li>
	            <li class="nav-item">
	              <a class="nav-link js-scroll-trigger" href="#services">Monitor Events</a>
	            </li>
	            <li class="nav-item">
	              <a class="nav-link js-scroll-trigger" href="#portfolio">View Payments</a>
	            </li>
	            <li class="nav-item">
	              <a class="nav-link js-scroll-trigger" href="#contact">Generate Reports</a>
	            </li>
	            <li class="nav-item">
                  <a class="nav-link js-scroll-trigger" href="{{ route('logout') }}" onclick="event.preventDefault(); 
                  	document.getElementById('logout-form').submit();">
                                            Logout
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                  </form>
               </li>
	          </ul>
	        </div>
	      </div>
	</nav>
