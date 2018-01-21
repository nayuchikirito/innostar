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
            <button class="btn btn-primary reserve-data-btn">Reserve</button>
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
    // var table = $('#reservations-table').DataTable({
    //   bProcessing: true,
    //   bServerSide: false,
    //   sServerMethod: "GET",
    //   'ajax': '/client/get-reservations',
    //   searching: true, 
    //   paging: true, 
    //   filtering:false, 
    //   bInfo: true,
    //   responsive: true,
    //   language:{
    //     "paginate": {
    //       "next":       "<i class='fa fa-chevron-right'></i>",
    //       "previous":   "<i class='fa fa-chevron-left'></i>"
    //     }
    //   },
    //   "columns": [ 
    //     {data: 'row',  name: 'row', className: ' text-left',   searchable: true, sortable: true},
    //     {data: 'date',  name: 'date', className: 'col-md-2  text-left',   searchable: true, sortable: true},
    //     {data: 'status',  name: 'status', className: 'col-md-2 text-left',  searchable: true, sortable: true}, 
    //     {data: 'balance',  name: 'balance', className: 'col-md-2 text-left',  searchable: true, sortable: true}, 
    //     {data: 'service',  name: 'service', className: 'col-md-2 text-left',  searchable: true, sortable: true}, 
    //     {data: 'actions',   name: 'actions', className: 'col-md-3 text-left',  searchable: false,  sortable: false},
    //   ], 
    //   'order': [[0, 'asc']]
    // });

    // $(".reserve-data-btn").click(function(x){  
    //       x.preventDefault();
    //       var that = this;
    //       $("#addmodal").html('');
    //       $("#addmodal").modal();
    //       $.ajax({
    //         url: '/client/reservations/create',         
    //         success: function(data) {
    //           $("#addmodal").html(data);
    //         }
    //       }); 
    //   });
      $(document).off('click','reserve-data-btn').on('click','.reserve-data-btn', function(e){
        e.preventDefault();
        var that = this;
        $("#addmodal").modal();
        $("#addmodal .modal-content").load('/client/reservations/create');
      });
  });

  </script>
@endsection

    

    
