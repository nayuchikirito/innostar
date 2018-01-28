@extends('client.includes.app')

@section('title')
    Innovation Star
@endsection
      @include('navigations.nav')
@section('content') 
 <header class="masthead text-center text-white d-flex">
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <h1 class="text-uppercase">
              <strong>Innovation Star</strong>
            </h1>
            <hr>
          </div>
          <div class="col-lg-8 mx-auto">
            <p class="white-text mb-5 ">Events Coordinating and Planning Team</p>
            <a class="btn btn-primary btn-xl js-scroll-trigger" href="#login">Log in</a>
          </div>
        </div>
      </div>
    </header>

    <section class="bg-dark text-white" id="login">
        <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box mt-5 mx-auto">
              <i class="fa fa-4x fa-user-o color-yellow mb-3 sr-icons"></i>
              <h3 class="mb-3">Admistrator</h3>
              <p class="text-muted mb-0 ">Our templates are updated regularly so they don't break.</p>
              <hr>
              <a class="btn btn-light btn-xl sr-button" href="/login">Login</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box mt-5 mx-auto">
              <i class="fa fa-4x fa-user-o color-yellow mb-3 sr-icons"></i>
              <h3 class="mb-3">Secretary</h3>
              <p class="text-muted mb-0 ">Our templates are updated regularly so they don't break.</p>
              <hr>
              <a class="btn btn-light btn-xl sr-button" href="/login">Login</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box mt-5 mx-auto">
              <i class="fa fa-4x fa-user color-yellow mb-3 sr-icons"></i>
              <h3 class="mb-3">Supplier</h3>
              <p class="text-muted mb-0 ">You can use this theme as is, or you can make changes!</p>
              <hr>
              <a class="btn btn-light btn-xl sr-button"  href="/login">Login</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box mt-5 mx-auto">
              <i class="fa fa-4x fa-users color-yellow mb-3 sr-icons"></i>
              <h3 class="mb-3">Client</h3>
              <p class="text-muted mb-0 ">We update dependencies to keep things fresh.</p>
              <hr>
              <a class="btn btn-light btn-xl sr-button"  href="/login">Login</a>
              <a class="btn btn-light btn-xl sr-button" href="/register">Register</a>
            </div>
          </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="loginmodal">
        <div class="modal-dialog modal-lg add-user-form">
          <div class="modal-content">
          </div>
        </div>
      </div>
    </section>

    @include('parts.about')

    @include('parts.services')

    @include('parts.portfolio')

    @include('parts.contact')


@endsection

@section('scripts')
<script type="text/javascript">
  $(function(){
    // $(".add-data-btn").click(function(x){  
    //         x.preventDefault();
    //         var that = this;
    //         $("#addmodal").html('');
    //         $("#addmodal").modal();
    //         $.ajax({
    //           url: '/client/register/create',         
    //           success: function(data) {
    //             $("#addmodal").html(data);
    //           }
    //         }); 
    //   });
    // $(document).off('click','add-data-btn').on('click','.add-data-btn', function(e){
    //   dd();
    //     e.preventDefault();
    //     var that = this;
    //     $("#addmodal").modal();
    //     $("#addmodal .modal-content").load('/client/register/create');
    //   });
  });
@endsection

    

    
