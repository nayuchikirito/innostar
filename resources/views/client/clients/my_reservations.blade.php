@extends('client.includes.app')

@section('title')
    Innovation Star
@endsection
      @include('navigations.client-nav')
@section('content') 
<section class="bg-dark" id="about" style="height: 100vh;">
      <div class="container font-mine">
        <div class="row">
          <div class="col-md-12 text-left">
            <h2 class="section-heading text-white">Package Reservations</h2> 
            <table class="table table-hover table-bordered bg-white">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Reservation Date</th>
                  <th class="text-left">Balance</th>
                  <th class="text-center">Service</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($reservations as $reservation)
                <tr>
                  <td class="text-left">{{ $reservation->client->user->lname.', '.$reservation->client->user->fname.' '.substr($reservation->client->user->midname, 0, 1).'.' }}</td>
                  <td class="text-left">{{ date('F d,Y', strtotime($reservation->date))}}</td>
                  <td class="text-left">{{ $reservation->balance }}</td>
                  <td class="text-center">{{ $reservation->package->service->name }}</td>
                  <td class="text-center"><a href="#" class="btn btn-danger btn-xs cancel-data-btn" data-id="{{ $reservation->id }}"><i class="fa fa-close"></i> Send Cancellation Request</a>
                  <td class="text-center"><a href="#" class="btn btn-warning btn-xs change-data-btn" data-id="{{ $reservation->id }}"><i class="fa fa-calendar"></i> Change Date Request</a>
                    <!-- <a href="#" class="btn btn-danger btn-xs decline-request-btn" data-id=" {{ $reservation->id }}"><i class="fa fa-times"></i> Decline</a>
                    <a href="#" class="btn btn-info btn-xs seen-request-btn" data-id="{{ $reservation->id }}"><i class="fa fa-eye"></i> Seen</a> --></td>
                </tr>
                @endforeach
              </tbody>
            </table> 
          </div>
        </div>
      </div>

      <section class="bg-dark" id="about" style="height: 100vh;">
      <div class="container font-mine">
        <div class="row">
          <div class="col-md-12 text-left">
            <h2 class="section-heading text-white">On-the-day Coordination Reservations</h2> 
            <table class="table table-hover table-bordered bg-white">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Reservation Date</th>
                  <th class="text-left">Balance</th>
                  <th class="text-center">Service</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($coordinations as $coordination)
                <tr>
                  <td class="text-left">{{ $coordination->client->user->lname.', '.$coordination->client->user->fname.' '.substr($coordination->client->user->midname, 0, 1).'.' }}</td>
                  <td class="text-left">{{ date('F d,Y', strtotime($coordination->date))}}</td>
                  <td class="text-left">{{ $coordination->balance }}</td>
                  <td class="text-center">{{ $coordination->service->name }}</td>
                  <td class="text-center"><a href="#" class="btn btn-danger btn-xs cancel2-data-btn" data-id="{{ $coordination->id }}"><i class="fa fa-close"></i> Send Cancellation Request</a>
                  <td class="text-center"><a href="#" class="btn btn-warning btn-xs change2-data-btn" data-id="{{ $coordination->id }}"><i class="fa fa-calendar"></i> Change Date Request</a>
                    <!-- <a href="#" class="btn btn-danger btn-xs decline-request-btn" data-id=" {{ $coordination->id }}"><i class="fa fa-times"></i> Decline</a>
                    <a href="#" class="btn btn-info btn-xs seen-request-btn" data-id="{{ $coordination->id }}"><i class="fa fa-eye"></i> Seen</a> --></td>
                </tr>
                @endforeach
              </tbody>
            </table> 
          </div>
        </div>
      </div>


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
    <!-- <section class="content-wrapper"> -->
<!-- naa ang include sa my_reservations.blade.php -->

<!--   </section> -->

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
      "columns": [ 
        {data: 'row',  name: 'row', className: ' text-left',   searchable: true, sortable: true},
        {data: 'date',  name: 'date', className: 'col-md-2  text-left',   searchable: true, sortable: true},
        {data: 'Balance',  name: 'Balance', className: 'col-md-2 text-left',  searchable: true, sortable: true}, 
        {data: 'balance',  name: 'balance', className: 'col-md-2 text-left',  searchable: true, sortable: true}, 
        {data: 'service',  name: 'service', className: 'col-md-2 text-left',  searchable: true, sortable: true}, 
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

    

    
