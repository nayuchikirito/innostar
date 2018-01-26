@extends('client.includes.app')

@section('title')
    Innovation Star
@endsection
      @include('navigations.client-nav')
@section('content') 
    <section class="content-wrapper">
    @include('parts.my-reservations')
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="paymodal">
      <div class="modal-dialog modal-lg add-user-form">
        <div class="modal-content">
        </div>
      </div>
    </div>
  </section>

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
        {data: 'status',  name: 'status', className: 'col-md-2 text-left',  searchable: true, sortable: true}, 
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

    

    
