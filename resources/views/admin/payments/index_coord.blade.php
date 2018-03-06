@extends('admin.includes.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Payments
        <small>Add/Edit/Delete/View Coordination Payments</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Coordination Payments</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">


        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Coordination Payments Table</h3>
            </div>
            <!-- /.box-header -->
            <!-- Status is blocked date or not -->
            <div class="box-body">
              <table class="table table-hover" id="payments-table">
                <thead>
                  <th>#</th>
                  <th>Client Name</th>
                  <th>OR / Transaction Number</th>
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

  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="addmodal"></div>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="editmodal"></div>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="showmodal"></div>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="paymodal"></div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(function(){
    var table = $('#payments-table').DataTable({
      bProcessing: true,
      bServerSide: false,
      sServerMethod: "GET",
      'ajax': '/admin/get-payments-coord',
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
        {data: 'name',  name: 'name', className: 'col-md-2 text-left',  searchable: true, sortable: true}, 
        {data: 'details',  name: 'details', className: 'col-md-3 text-left',  searchable: true, sortable: true}, 
        {data: 'amount',  name: 'amount', className: 'col-md-2 text-left',  searchable: true, sortable: true}, 
        {data: 'type',  name: 'type', className: 'col-md-2  text-left',   searchable: true, sortable: true},
        {data: 'actions',   name: 'actions', className: 'col-md-4 text-left',  searchable: false,  sortable: false},
      ], 
      'order': [[0, 'desc']]
    });

    // $(".add_data-btn").click(function(x){  
    //       x.preventDefault();
    //       var that = this;
    //       $("#addmodal").html('');
    //       $("#addmodal").modal();
    //       $.ajax({
    //         url: '/admin/payments/create',         
    //         success: function(data) {
    //           $("#addmodal").html(data);
    //         }
    //       }); 
    // });

    $(document).off('click','.show-data-btn').on('click','.show-data-btn', function(e){
      e.preventDefault();
      var that = this; 
      $("#showmodal").html('');
      $("#showmodal").modal();
      $.ajax({
        url: '/admin/payments/'+that.dataset.id,         
        success: function(data) {
          $("#showmodal").html(data);
        }
      }); 
    });
    $(document).off('click','.edit-data-btn').on('click','.edit-data-btn', function(e){
      e.preventDefault();
      var that = this; 
      $("#editmodal").html('');
      $("#editmodal").modal();
      $.ajax({
        url: '/admin/payments/'+that.dataset.id+'/edit',         
        success: function(data) {
          $("#editmodal").html(data);
        }
      }); 
    });
    $(document).off('click','.delete-data-btn').on('click','.delete-data-btn', function(e){
      e.preventDefault();
      var that = this; 
            bootbox.confirm({
              title: "Confirm Delete Data?",
              className: "del-bootbox",
              message: "Are you sure you want to delete record?",
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
                  url:'/admin/payments/'+that.dataset.id,
                  type: 'post',
                  data: {_method: 'delete', _token :token},
                  success:function(result){
                    $("#payments-table").DataTable().ajax.url( '/admin/get-payments' ).load();
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