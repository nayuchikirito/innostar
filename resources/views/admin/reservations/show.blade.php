<div class="modal-dialog modal-lg add-user-form" style="max-width: 500px">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title">View Reservation</h4>
    </div>
 
    <form action="{{ url('/admin/reservations/'.$reservation->id) }}" method="GET" id="show-clients-form">
    {{ csrf_field() }}
    <div class="modal-body">
      <div class="form-group">
          <label for="client">Client Name: </label>
          <span id="client">{{ $reservation->client->user->lname.', '.$reservation->client->user->fname.' '.substr($reservation->client->user->midname,0 ,1).'.' }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="service">Service Reserved: </label>
          <span id="service">{{ $reservation->package->service->name }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="package">Package Reserved: </label>
          <span id="package">{{ $reservation->package->name }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="description">Description of Package: </label>
          <span id="description">{{ $reservation->package->description }}</span>          
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="date">Date Reserved: </label>
          <span id="date">{{ date('M d, Y | h:i A', strtotime($reservation->date)) }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="balance">Balance: </label>
          <span id="balance">{{ $reservation->balance }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="status">Status: </label>
          <span id="status">{{ ucfirst($reservation->status) }}</span>
          <span class="help-text text-danger"></span>
      </div>
      @if($reservation->reservation_type)
      <div class="form-group">
          <label for="status">RESERVATION TYPE: </label>
          <span id="status">{{ ucfirst($reservation->reservation_type) }}</span>
          <span class="help-text text-danger"></span>
          <h6>Description Detail</h6> 

            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Service Detail Name</th>
                  <th>Cost</th>
                  <th>Supplier</th>
                </tr>
              </thead>
              <tbody>
                @foreach($reservation->details as $detail)
                <tr>
                  <td>{{ $detail->package_detail->package_description->name }}</td>
                  <td class="text-right">{{ number_format($detail->price,2) }}</td>
                  <th>PENDING</th>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th class="text-right">TOTAL:</th>
                  <th class="text-right"><b id="total">{{ number_format($reservation->details->sum('price'),2) }}</b></th>
                </tr>
              </tfoot>
            </table>
      </div>
      @endif
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
    </form>

  </div>
</div>