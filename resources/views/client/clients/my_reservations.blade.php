@extends('client.includes.app')

@section('title')
    Innovation Star
@endsection
      @include('navigations.client-nav2')
@section('content') 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
<style type="text/css">
  .dataTables_length{
    float: left;
    color: #fff;
  } 
  .dataTables_filter{
    float: right;
    color: #fff;
  }
  .dataTables_info{
    float: left;
    color: #fff;
  }
</style>
<section class="bg-dark" id="about" style="height: 150vh;">

      <div class="container font-mine">
        <h2 class="section-heading text-white">Package Reservations</h2>
        <div class="box-body">
              <table class="table table-horver bg-yellow" id="reservations-table">
                <thead>
                  <th>#</th>
                  <th>Date</th>
                  <th>Balance</th>
                  <th>Service</th>
                  <th>Assigned</th>
                  <th>Blocked</th>
                  <th>Request</th>
                </thead>
              </table>
            </div>
          
      </div>
    </section>

      <section class="bg-dark" id="about" style="height: 150vh;">
      <div class="container font-mine">
        <h2 class="section-heading text-white">On-the-day Coordinations</h2>
        <div class="box-body">
              <table class="table table-hover bg-yellow" id="coordinations-table">
                <thead>
                  <th>#</th>
                  <th>Date</th>
                  <th>Balance</th>
                  <th>Service</th>  
                  <th>Blocked</th>
                  <th>Request</th>
                </thead>
              </table>
            </div>
      </div>
    </section>


    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="changemodal">
      <div class="modal-dialog modal-md add-user-form">
        <div class="modal-content">
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="changemodal2">
      <div class="modal-dialog modal-md add-user-form">
        <div class="modal-content">
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="showmodal">
      <div class="modal-dialog modal-md add-user-form">
        <div class="modal-content">
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="showmodal_coord">
      <div class="modal-dialog modal-md add-user-form">
        <div class="modal-content">
        </div>
      </div>
    </div>
    <!-- <section class="content-wrapper"> -->
<!-- naa ang include sa my_reservations.blade.php -->
@include('parts.contact')
@endsection

@section('scripts')
  <script type="text/javascript">
    $(function(){
    var table = $('#reservations-table').DataTable({
      bProcessing: true,
      bServerSide: false,
      sServerMethod: "GET",
      'ajax': '/client/get-reservations',
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
        {data: 'assigned',  name: 'assigned', className: 'col-md-2 text-left',  searchable: true, sortable: true}, 
        {data: 'status',  name: 'status', className: 'col-md-2 text-left',  searchable: true, sortable: true},
        {data: 'actions',   name: 'actions', className: 'col-md-4 text-left',  searchable: false,  sortable: false},
      ], 
      'order': [[0, 'asc']]
    });

    var table = $('#coordinations-table').DataTable({
      bProcessing: true,
      bServerSide: false,
      sServerMethod: "GET",
      'ajax': '/client/get-coordinations',
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

    $(document).off('click','.cancel-data-btn').on('click','.cancel-data-btn', function(e){
      e.preventDefault();
      var that = this; 
            bootbox.confirm({
              title: "Cancel Reservation?",
              className: "del-bootbox",
              message: "Are you sure you want to request cancellation of reservation?",
              buttons: {
                  confirm: {
                      label: 'Yes',
                      className: 'btn-success'
                  },
                  cancel: {
                      label: 'No',
                      className: 'btn-danger'
                  }
              },
              callback: function (result) {
                 if(result){
                  var token = '{{csrf_token()}}'; 
                  $.ajax({
                  url:'/client/request_cancel/'+that.dataset.id,
                  type: 'post',
                  data: {_method: 'post', _token :token},
                  success:function(result){
                    // $("#payments-table").DataTable().ajax.url( '/admin/get-requests-coord' ).load();
                    swal({
                        title: result.msg,
                        icon: "success"
                      });
                  }
                  }); 
                 }
              }
          });
    });

    $(function(){
      $(document).off('click','change-data-btn').on('click','.change-data-btn', function(e){
        e.preventDefault();
        var that = this;
        $("#changemodal").modal();
        $("#changemodal .modal-content").load('/client/change_request/'+that.dataset.id);
      });
    });

    $(document).off('click','.show-data-btn').on('click','.show-data-btn', function(e){
      e.preventDefault();
      var that = this;
      $("#showmodal").modal();
      $("#showmodal .modal-content").load('/client/reservations/'+that.dataset.id);
    });

    $(document).off('click','.show-coord-data-btn').on('click','.show-coord-data-btn', function(e){
      e.preventDefault();
      var that = this;
      $("#showmodal_coord").modal();
      $("#showmodal_coord .modal-content").load('/client/coordinations/'+that.dataset.id);
    });


    $(document).off('click','.cancel2-data-btn').on('click','.cancel2-data-btn', function(e){
      e.preventDefault();
      var that = this; 
            bootbox.confirm({
              title: "Cancel Reservation?",
              className: "del-bootbox",
              message: "Are you sure you want to request cancellation of reservation?",
              buttons: {
                  confirm: {
                      label: 'Yes',
                      className: 'btn-success'
                  },
                  cancel: {
                      label: 'No',
                      className: 'btn-danger'
                  }
              },
              callback: function (result) {
                 if(result){
                  var token = '{{csrf_token()}}'; 
                  $.ajax({
                  url:'/client/request_cancel_coord/'+that.dataset.id,
                  type: 'post',
                  data: {_method: 'post', _token :token},
                  success:function(result){
                    // $("#payments-table").DataTable().ajax.url( '/admin/get-requests-coord' ).load();
                    swal({
                        title: result.msg,
                        icon: "success"
                      });
                  }
                  }); 
                 }
              }
          });
    });

    $(function(){
      $(document).off('click','change2-data-btn').on('click','.change2-data-btn', function(e){
        e.preventDefault();
        var that = this;
        $("#changemodal2").modal();
        $("#changemodal2 .modal-content").load('/client/change_request_coord/'+that.dataset.id);
      });
    });



  });

  </script>
@endsection

    

    
