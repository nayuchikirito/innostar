<div class="modal-dialog modal-lg add-user-form" style="max-width: 500px">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title">View Payment</h4>
    </div>
 
    <form action="{{ url('/admin/payments_coord/'.$payment->id) }}" method="GET" id="show-payments-form">
    {{ csrf_field() }}
    <div class="modal-body">
      <div class="form-group">
          <label for="details">Official Receipt: </label>
          <span id="details">{{ $payment->details }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="amount">Amount: </label>
          <span id="amount">{{ $payment->amount }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="type">Type of Payment: </label>
          <span id="type">{{ ucwords($payment->type) }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="reservation_id">Reservation: </label>
          <span id="location">{{ 'ID: '.$payment->reservation->id.' | '.$payment->reservation->client->user->lname.', '.$payment->reservation->client->user->fname.' '.substr($payment->reservation->client->user->midname, 0, 1).'.' }}</span>          
          <span class="help-text text-danger"></span>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
    </form>
  </div>
</div>