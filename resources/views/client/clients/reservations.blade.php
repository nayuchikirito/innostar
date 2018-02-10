@extends('client.includes.app')

@section('title')
    Innovation Star
@endsection
      @include('navigations.client-nav2')
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
                  <td class="text-center"><a href="#" class="btn btn-success btn-xs pay-data-btn" data-id="{{ $reservation->id }}"><i class="fa fa-check"></i> Send Payment Details</a>
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
                  <td class="text-center"><a href="#" class="btn btn-success btn-xs pay2-data-btn" data-id="{{ $coordination->id }}"><i class="fa fa-check"></i> Send Payment Details</a>
                    <!-- <a href="#" class="btn btn-danger btn-xs decline-request-btn" data-id=" {{ $coordination->id }}"><i class="fa fa-times"></i> Decline</a>
                    <a href="#" class="btn btn-info btn-xs seen-request-btn" data-id="{{ $coordination->id }}"><i class="fa fa-eye"></i> Seen</a> --></td>
                </tr>
                @endforeach
              </tbody>
            </table> 
          </div>
        </div>
      </div>


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

    

    
