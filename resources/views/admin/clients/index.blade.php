@extends('admin.includes.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Clients
        <small>Add/Edit/Delete/View Clients</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Clients</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">


        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Clients Table</h3>
              <button class="btn-sm btn btn-success add-data-btn pull-right">
                <i class="fa fa-plus"></i> Add
              </button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-hover" id="clients-table">
                <thead>
                  <th>#</th>
                  <th>Name</th>
                  <th>Action</th>
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
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="reservemodal">
    <div class="modal-dialog modal-lg add-user-form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Add Reservations</h4>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn submit-btn btn-success btn-gradient pull-right">Submit</button>
      </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="assign-modal">
    <div class="modal-dialog modal-lg assign-suppliers-form">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Assign Suppliers</h4>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn submit-btn btn-success btn-gradient pull-right">Submit</button>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="choosemodal"></div> -->
@endsection

@section('scripts')
<script type="text/javascript">
  $(function(){
    var table = $('#clients-table').DataTable({
      bProcessing: true,
      bServerSide: false,
      sServerMethod: "GET",
      'ajax': '/admin/get-clients',
      searching: true, 
      paging: true, 
      filtering:false, 
      bInfo: true,
      responsive: true,
      // dom: 'Bfrtip',
      // lengthChange: false,
      // buttons: [
      //       {
      //           extend: 'pdf', 
      //           exportOptions: {
      //               columns: ':visible'
      //           }
      //       },
            
      //       'excel', 'print', 'colvis',
      // ],
      language:{
        "paginate": {
          "next":       "<i class='fa fa-chevron-right'></i>",
          "previous":   "<i class='fa fa-chevron-left'></i>"
        }
      },
      "columns": [ 
        {data: 'row',  name: 'row', className: ' text-left',   searchable: true, sortable: true},
        {data: 'name',  name: 'name', className: 'col-md-6  text-left',   searchable: true, sortable: true},
        {data: 'actions',   name: 'actions', className: 'col-md-6 text-left',  searchable: false,  sortable: false},
      ], 
      'order': [[0, 'asc']]
    });

    //  $(document).off('click','.reserve-data-btn').on('click','.reserve-data-btn', function(e){
    //   e.preventDefault();
    //   var that = this;
    //   $("#reservemodal").modal();
    //   $("#reservemodal .modal-content").load('/admin/clients/'+that.dataset.id+'/reserve');
    // });

    $(document).off('click','.reserve-data-btn').on('click','.reserve-data-btn', function(e){
      e.preventDefault();
      var that = this; 
      $("#reservemodal").html('');
      $("#reservemodal").modal();
      $.ajax({
        url: '/admin/clients/'+that.dataset.id+'/reserve',         
        success: function(data) {
          $("#reservemodal").html(data);
          $('#add-coordinations-form').addClass('hidden');
        }
      }); 
    });

 

    $(document).off('click','.show-data-btn').on('click','.show-data-btn', function(e){
      e.preventDefault();
      var that = this; 
      $("#showmodal").html('');
      $("#showmodal").modal();
      $.ajax({
        url: '/admin/clients/'+that.dataset.id,         
        success: function(data) {
          $("#showmodal").html(data);
        }
      }); 
    });


    $(".add-data-btn").click(function(x){  
          x.preventDefault();
          var that = this;
          $("#addmodal").html('');
          $("#addmodal").modal();
          $.ajax({
            url: '/admin/clients/create',         
            success: function(data) {
              $("#addmodal").html(data);
            }
          }); 
    });

    $(document).off('click','.edit-data-btn').on('click','.edit-data-btn', function(e){
      e.preventDefault();
      var that = this; 
      $("#editmodal").html('');
      $("#editmodal").modal();
      $.ajax({
        url: '/admin/clients/'+that.dataset.id+'/edit',         
        success: function(data) {
          $("#editmodal").html(data);
        }
      }); 
    });

     $(document).off('click','.assign-data-btn').on('click','.assign-data-btn', function(e){
      e.preventDefault();
      var that = this; 
      $("#assign-modal").html('');
      $("#assign-modal").modal();
      $.ajax({
        url: '/admin/clients/'+that.dataset.id+'/assign-suppliers',         
        success: function(data) {
          console.log("data",data)
          $("#assign-modal").html(data);
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
                  url:'/admin/clients/'+that.dataset.id,
                  type: 'post',
                  data: {_method: 'delete', _token :token},
                  success:function(result){
                    $("#clients-table").DataTable().ajax.url( '/admin/get-clients' ).load();
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