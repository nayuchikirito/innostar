@extends('client.includes.app')

@section('title')
    Innovation Star
@endsection
      @include('navigations.client-nav')
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
            <p class="text-white mb-5">Events Coordinating and Planning Team</p>
            <button class="btn btn-primary add-data-btn">Reserve</button>
          </div>
        </div>
      </div>
    </header>



    @include('parts.about')

    @include('parts.services')

    @include('parts.portfolio')

    @include('parts.contact')
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="addmodal"></div>

@endsection

@section('scripts')
  <script type="text/javascript">
    $(".add-data-btn").click(function(x){  
          x.preventDefault();
          var that = this;
          $("#addmodal").html('');
          $("#addmodal").modal();
          $.ajax({
            url: '/admin/reservations/create',         
            success: function(data) {
              $("#addmodal").html(data);
            }
          }); 
    });
  </script>
@endsection

    

    
