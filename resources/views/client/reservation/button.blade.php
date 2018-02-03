@extends('client.includes.app')

@section('title')
    Innovation Star
@endsection
      @include('navigations.client-nav')
@section('content')
<section class="bg-dark">
  <div class="row row-centered">
  <!-- <div class="row"> -->
    <div class="col-md-4 col-xs-6">
        <a class="reserve-data-btn">
          <button class="my-button">
            <h4 class="thicker">Package Reservation</h4>
            <div class="button-text">This kind of reservation has many packages to choose from. Just relax because the Innovation Star handles everything for you, from preparation to the event itself!</div>
          </button>
        </a>
    </div>

    <div class="col-md-4 col-xs-6">
        <a class="coord-data-btn">
          <button class="my-button">
            <h4 class="thicker">On-the-day Coordination</h4>
            <div class="button-text">Just reserve an event and the Innovation Star will manage the whole program for you. Just enjoy the event!</div>
          </button>
        </a>
      </div>

    <div class="col-md-4 col-xs-6">
        <a class="coord-data-btn2">
        <button class="my-button">
          <h4 class="thicker">Customize Package</h4>
          <div class="button-text">This kind of reservation allows you to make your own package that is not found in the packages given by Innovation Star.</div>
        </button>
      </div>

       
      <!-- </div> -->
      </div>
</section> 

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="addmodal">
    <div class="modal-dialog modal-lg add-user-form">
      <div class="modal-content" id="modal-content">
      </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="coordmodal">
    <div class="modal-dialog modal-lg add-user-form">
      <div class="modal-content" id="modal-content">
        
      
      

       </div>
    </div>
</div>

@endsection

@section('scripts')
  <script type="text/javascript">
  $(function(){ 
    $(document).off('click','.reserve-data-btn').on('click','.reserve-data-btn', function(e){
            e.preventDefault();
            var that = this;
            // $('#coordmodal').modal('hide');
          
            $("#addmodal").modal();
            $("#addmodal .modal-content").load('/client/reservations/create');
          });

    $(document).off('click','.coord-data-btn').on('click','.coord-data-btn', function(e){
            e.preventDefault();
            var that = this;
            // $('#addmodal').modal('hide');

            $("#coordmodal").modal();
            $("#coordmodal .modal-content").load('/client/reservations_coordination');
          });
  });
 </script> 

@endsection

    

    
