@extends('client.includes.app')

@section('title')
    Innovation Star
@endsection
      @include('navigations.client-nav2')
@section('content') 
<section class="bg-dark" id="about" style="height: 100vh;">
      <div class="container font-mine">
        <h2 class="section-heading text-white">Package Reservations</h2>
        <div class="box-body">
              <table class="table table-hover bg-yellow" id="reservations-table">
                <thead>
                  <th>#</th>
                  <th>Reservation Date</th>
                  <th class="text-left">Balance</th>
                  <th class="text-center">Service</th>
                  <th class="text-center">Blocked</th>
                  <th class="text-center">Actions</th>
                </thead>
              </table>
            </div>
      </div>
    </section>

      <section class="bg-dark" id="about" style="height: 100vh;">
      <div class="container font-mine">
        <h2 class="section-heading text-white">On-the-day Coordinations</h2>
        <div class="box-body">
              <table class="table table-hover bg-yellow" id="coordinations-table">
                <thead>
                  <th>#</th>
                  <<th>Reservation Date</th>
                  <th class="text-left">Balance</th>
                  <th class="text-center">Service</th>
                  <th class="text-center">Blocked</th>
                  <th class="text-center">Actions</th>
                </thead>
              </table>
            </div>
      </div>
    </section>


    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="paymodal">
      <div class="modal-dialog modal-md add-user-form">
        <div class="modal-content">
        </div>
      </div>
    </div>
    <!-- <section class="content-wrapper"> -->
<!-- naa ang include sa my_reservations.blade.php -->

<!--   </section> -->
@include('parts.contact')

@endsection

@section('scripts')
  <script type="text/javascript">
    $(function(){
    var table = $('#reservations-table').DataTable({
      bProcessing: true,
      bServerSide: false,
      sServerMethod: "GET",
      'ajax': '/client/get-reservations-pay',
      searching: true, 
      paging: true, 
      filtering:false, 
      bInfo: true,
      responsive: true,
      language:{
        "paginate": {
          "next":       "<i class='fa fa-chevron-right'></i>",
          "previous":   "<i class='fa fa-chevron-left'></i>"
        }
      },
      "iDisplayLength": 5,
      "aLengthMenu": [[5, 10], [5, 10, "All"]],
      "columns": [ 
        {data: 'row',  name: 'row', className: ' text-left',   searchable: true, sortable: true},
        {data: 'date',  name: 'date', className: 'col-md-2  text-left',   searchable: true, sortable: true},
        {data: 'balance',  name: 'balance', className: 'col-md-2 text-left',  searchable: true, sortable: true}, 
        {data: 'service',  name: 'service', className: 'col-md-2 text-left',  searchable: true, sortable: true}, 
        {data: 'status',  name: 'status', className: 'col-md-2 text-left',  searchable: true, sortable: true}, 
        {data: 'actions',   name: 'actions', className: 'col-md-4 text-left',  searchable: false,  sortable: false},
      ], 
      'order': [[0, 'asc']]
    });

    var table = $('#coordinations-table').DataTable({
      bProcessing: true,
      bServerSide: false,
      sServerMethod: "GET",
      'ajax': '/client/get-coordinations-pay',
      searching: true, 
      paging: true, 
      filtering:false, 
      bInfo: true,
      responsive: true,
      language:{
        "paginate": {
          "next":       "<i class='fa fa-chevron-right'></i>",
          "previous":   "<i class='fa fa-chevron-left'></i>"
        }
      },
      "iDisplayLength": 5,
      "aLengthMenu": [[5, 10], [5, 10, "All"]],
      "columns": [ 
        {data: 'row',  name: 'row', className: ' text-left',   searchable: true, sortable: true},
        {data: 'date',  name: 'date', className: 'col-md-2  text-left',   searchable: true, sortable: true},
        {data: 'balance',  name: 'balance', className: 'col-md-2 text-left',  searchable: true, sortable: true}, 
        {data: 'service',  name: 'service', className: 'col-md-2 text-left',  searchable: true, sortable: true},  
        {data: 'status',  name: 'status', className: 'col-md-2 text-left',  searchable: true, sortable: true},
        {data: 'actions',   name: 'actions', className: 'col-md-4 text-left',  searchable: false,  sortable: false},
      ], 
      'order': [[0, 'asc']]
    });

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

    $(function(){
      $(document).off('click','pay-data-btn').on('click','.pay-data-btn', function(e){
        e.preventDefault();
        var that = this;
        $("#paymodal").modal();
        $("#paymodal .modal-content").load('/client/payments_bank/'+that.dataset.id);
      });
    });

    $(function(){
      $(document).off('click','pay2-data-btn').on('click','.pay2-data-btn', function(e){
        e.preventDefault();
        var that = this;
        $("#paymodal").modal();
        $("#paymodal .modal-content").load('/client/payments_bank_coord/'+that.dataset.id);
      });
    });

    // $(document).off('click','.pay-data-btn').on('click','.pay-data-btn', function(e){
    //   e.preventDefault();
    //   var that = this;
    //   $("#paymodal").html('');
    //   $("#paymodal").modal();
    //   $.ajax({
    //     url: '/client/payments_bank/'+that.dataset.id,
    //     success: function(data) {
    //       $("#paymodal").html(data);
    //     }
    //   });
    // });

  });

  </script>
@endsection

    

    
