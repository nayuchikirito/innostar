@extends('client.includes.app')

@section('title')
    Innovation Star
@endsection

@include('navigations.supplier-nav')
@section('content') 

    <section class="bg-dark" id="about" style="height: 100vh;">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-left">
            <h2 class="section-heading text-white">Request </h2> 
            <table class="table table-hover table-bordered bg-white">
              <thead>
                <tr>
                  <th>Request Type</th>
                  <th>Reservation Date</th>
                  <th>Budget</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach(Auth::user()->supplier->notifications as $notif)
                <tr>
                  <td>{{ $notiff->reservation_detail->package_detail->package_description->name }}</td>
                  <td class="text-center">{{ date('F d,Y', strtotime($notiff->reservation_detail->reservation->date))}}</td>
                  <td class="text-center">{{ number_format($notiff->reservation_detail->price,2) }}</td>
                  <td> 
                    @if($notiff->status == 'accepted')
                      <span class="badge badge-pill badge-success">Accepted</span>
                    @endif
                    @if($notiff->status == 'pending')
                      <span class="badge badge-pill badge-warning">Pending</span>
                    @endif
                    @if($notiff->status == 'declined')
                      <span class="badge badge-pill badge-danger">Declined</span>
                    @endif
                    @if($notiff->status == 'closed')
                      <span class="badge badge-pill badge-info">Closed</span>
                    @endif
                    @if($notiff->status == 'ignored')
                      <span class="badge badge-pill badge-info">Seen</span>
                    @endif
                    
                    
                    
                    
                  </td>
                  <td class="text-center"> 
                    <a href="#" class="btn btn-success btn-xs accept-request-btn" data-id="{{ $notiff->id }}"><i class="fa fa-check"></i> Accept</a>

                    <a href="#" class="btn btn-danger btn-xs decline-request-btn" data-id="{{ $notiff->id }}"><i class="fa fa-times"></i> Decline</a>

                    <a href="#" class="btn btn-info btn-xs seen-request-btn" data-id="{{ $notiff->id }}"><i class="fa fa-eye"></i> Seen</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table> 
          </div>
        </div>
      </div>
    </section>


@endsection

@section('scripts')
  <script type="text/javascript">
    $(function(){

    $(document).off('click','.accept-request-btn').on('click','.accept-request-btn', function(e){
      e.preventDefault();
      var that = this; 
            bootbox.confirm({
              title: "Confirm Accept Request?",
              className: "del-bootbox",
              message: "Are you sure you want to accept request?",
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
                  url:'/supplier/accept_request/'+that.dataset.id,
                  type: 'POST',
                  data: {_token :token},
                  success:function(result){ 
                    if(result.success){
                      swal({
                          title: result.msg,
                          icon: "success"
                        });
                      window.location.reload();
                    }else{
                      swal({
                          title: result.msg,
                          icon: "success"
                        });
                    } 
                  }
                  }); 
                 }
              }
          });
    });

    $(document).off('click','.decline-request-btn').on('click','.decline-request-btn', function(e){
      e.preventDefault();
      var that = this; 
            bootbox.confirm({
              title: "Confirm Decline Request?",
              className: "del-bootbox",
              message: "Are you sure you want to decline request?",
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
                  url:'/supplier/decline_request/'+that.dataset.id,
                  type: 'POST',
                  data: {_token :token},
                  success:function(result){
                    if(result.success){
                      swal({
                          title: result.msg,
                          icon: "success"
                        });
                      window.location.reload();
                    }else{
                      swal({
                          title: result.msg,
                          icon: "success"
                        });
                    } 
                  }
                  }); 
                 }
              }
          });
    });

    $(document).off('click','.seen-request-btn').on('click','.seen-request-btn', function(e){
      e.preventDefault();
      var that = this; 
            bootbox.confirm({
              title: "Confirm Seen Request?",
              className: "del-bootbox",
              message: "Are you sure you want to seen request?",
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
                  url:'/supplier/seen_request/'+that.dataset.id,
                  type: 'POST',
                  data: {_token :token},
                  success:function(result){
                    if(result.success){
                      swal({
                          title: result.msg,
                          icon: "success"
                        });
                      window.location.reload();
                    }else{
                      swal({
                          title: result.msg,
                          icon: "success"
                        });
                    } 
                  }
                  }); 
                 }
              }
          });
    });
  });

  </script>
@endsection

    

    
