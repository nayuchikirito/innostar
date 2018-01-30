@extends('client.includes.app')

@section('title')
    Innovation Star
@endsection
      @include('navigations.supplier-nav')
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
            <a class="btn btn-primary btn-xl" href="{{ route('clients.reservations') }}">View Reservations</a>
          </div>
        </div>
      </div>
    </header>

    @include('parts.about')

    @include('parts.services')

    @include('parts.portfolio')

    @include('parts.contact')
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="addmodal">
        <div class="modal-dialog modal-lg add-user-form">
          <div class="modal-content" id="modal-content">
            
          
          

           </div>
        </div>
    </div>

@endsection

@section('scripts')
  <script type="text/javascript">
    $(function(){
      $(document).off('click','reserve-data-btn').on('click','.reserve-data-btn', function(e){
        e.preventDefault();
        var that = this;
        $("#addmodal").modal();
        $("#addmodal .modal-content").load('/client/reservations/create');
      });

      

      // $(document).off('click','request-data-btn').on('click','.request-data-btn', function(e){
      //   e.preventDefault();
      //   var that = this;
      //   Auth::user()->notify(new UserRequests());
      // });
  });

  </script>
@endsection

    

    
