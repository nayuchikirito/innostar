@extends('admin.includes.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Payment Details
        <small>Confirm or Decline Payments</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Payment Requests</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">


        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Payments Table</h3>
            </div>
            <!-- /.box-header -->
            <!-- Status is blocked date or not -->
            <div class="box-body">
              <table class="table table-hover" id="payments-table">
                <thead>
                  <th>#</th>
                  <th>Name</th>
                  <th>Date of Payment</th>
                  <th>Transaction Number</th>
                  <th>Amount</th>
                  <th>Type</th>
                  <th>Actions</th>
                </thead>
              </table>
            </div>
          </div>
      </div>
      <!-- /.row --> 

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  $(function(){
    var table = $('#payments-table').DataTable({
      bProcessing: true,
      bServerSide: false,
      sServerMethod: "GET",
      'ajax': '/admin/get-requests-coord',
      searching: true, 
      paging: true, 
      filtering:false, 
      bInfo: true,
      responsive: true,
      dom: 'Bfrtip',
      lengthChange: false,
      buttons: [
            {
                extend: 'pdf', 
                exportOptions: {
                    columns: ':visible'
                }
            },
            
            'excel', 'print', 'colvis',
      ],
      language:{
        "paginate": {
          "next":       "<i class='fa fa-chevron-right'></i>",
          "previous":   "<i class='fa fa-chevron-left'></i>"
        }
      },
      "columns": [ 
        {data: 'row',  name: 'row', className: ' text-left',   searchable: true, sortable: true},
        {data: 'name',  name: 'name', className: 'col-md-3   text-left',  searchable: true, sortable: true}, 
        {data: 'date_of_payment',  name: 'date_of_payment', className: 'col-md-2 text-left',  searchable: true, sortable: true}, 
        {data: 'details',  name: 'details', className: 'col-md-2 text-left',  searchable: true, sortable: true}, 
        {data: 'amount',  name: 'amount', className: 'col-md-1 text-left',  searchable: true, sortable: true}, 
        {data: 'type',  name: 'type', className: 'col-md-1  text-left',   searchable: true, sortable: true},
        {data: 'actions',   name: 'actions', className: 'col-md-2 text-left',  searchable: false,  sortable: false},
      ], 
      'order': [[0, 'asc']]
    });

    $(document).off('click','.confirm-data-btn').on('click','.confirm-data-btn', function(e){
      e.preventDefault();
      var that = this; 
            bootbox.confirm({
              title: "Confirm Payment?",
              className: "del-bootbox",
              message: "Are you sure you want to confirm payment?",
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
                  url:'/admin/payment_requests_coord/'+that.dataset.id,
                  type: 'post',
                  data: {_method: 'post', _token :token},
                  success:function(result){
                    $("#payments-table").DataTable().ajax.url( '/admin/get-requests-coord' ).load();
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

    $(document).off('click','.decline-data-btn').on('click','.decline-data-btn', function(e){
      e.preventDefault();
      var that = this; 
            bootbox.confirm({
              title: "Decline Payment?",
              className: "del-bootbox",
              message: "Are you sure you want to decline payment?",
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
                  url:'/admin/payment_requests_decline_coord/'+that.dataset.id,
                  type: 'post',
                  data: {_method: 'post', _token :token},
                  success:function(result){
                    $("#payments-table").DataTable().ajax.url( '/admin/get-requests-coord' ).load();
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
  });
</script>
@endsection