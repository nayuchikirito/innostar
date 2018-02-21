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

  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="reservemodal">

</div>

@endsection

@section('scripts')
<script type="text/javascript">
  $(function(){
    var table = $('#clients-table').DataTable({
      bProcessing: true,
      bServerSide: false,
      sServerMethod: "GET",
      'ajax': '/admin/get-clients-display',
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

 


  });
</script>
@endsection