
	<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
	      <div class="container">
	        <a class="navbar-brand js-scroll-trigger" href="{{ route('clients.home') }}">Home</a>
	        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	          <span class="navbar-toggler-icon"></span>
	        </button>
	        <div class="collapse navbar-collapse" id="navbarResponsive">
	          <ul class="navbar-nav ml-auto">
	          	<li class="nav-item">
	              <a class="nav-link js-scroll-trigger" href="{{ url('/client/button') }}">Reserve Event
	              </a>
	            </li>
	            <li class="nav-item">
	              <a class="nav-link js-scroll-trigger" href="{{ route('clients.my_reservations') }}">Monitor Reservations </a>
	            </li>
	            <li class="nav-item">
	              <a class="nav-link js-scroll-trigger" href="{{ route('clients.reservations') }}">Send Payment Details </a>
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
