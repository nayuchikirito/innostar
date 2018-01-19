@extends('admin.includes.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reservations
        <small>Add/Edit/Delete/View Reservations</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Reservations</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">


        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Reservations Table</h3>
            </div>
            <!-- /.box-header -->
            <!-- Status is blocked date or not -->
            <div class="box-body">
              <table class="table table-hover" id="reservations-table">
                <thead>
                  <th>#</th>
                  <th>Client</th>
                  <th>Service</th>
                  <th>Date</th>
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
@endsection

@section('scripts')
<script type="text/javascript">
  $(function(){
    var table = $('#reservations-table').DataTable({
      bProcessing: true,
      bServerSide: false,
      sServerMethod: "GET",
      'ajax': '/admin/get-reservations',
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
        {data: 'client',  name: 'client', className: 'col-md-3 text-left',  searchable: true, sortable: true}, 
        {data: 'service',  name: 'service', className: 'col-md-3 text-left',  searchable: true, sortable: true}, 
        {data: 'date',  name: 'date', className: 'col-md-3  text-left',   searchable: true, sortable: true},
        {data: 'actions',   name: 'actions', className: 'col-md-3 text-left',  searchable: false,  sortable: false},
      ], 
      'order': [[0, 'asc']]
    });

    // $(".add_data-btn").click(function(x){  
    //       x.preventDefault();
    //       var that = this;
    //       $("#addmodal").html('');
    //       $("#addmodal").modal();
    //       $.ajax({
    //         url: '/admin/reservations/create',         
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
        url: '/admin/reservations/'+that.dataset.id,         
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
        url: '/admin/reservations/'+that.dataset.id+'/edit',         
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
                  url:'/admin/reservations/'+that.dataset.id,
                  type: 'post',
                  data: {_method: 'delete', _token :token},
                  success:function(result){
                    $("#reservations-table").DataTable().ajax.url( '/admin/get-reservations' ).load();
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