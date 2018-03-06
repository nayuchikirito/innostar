
    <div class="modal-header">
      <h4 class="modal-title">View Reservation </h4>
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      
    </div>
 
    <form action="{{ url('/admin/coordinations/'.$coordination->id) }}" method="GET" id="show-clients-form">
    {{ csrf_field() }}
    <div class="modal-body">
      <div class="form-group">
          <label for="client">Client Name: </label>
          <span id="client">{{ $coordination->client->user->lname.', '.$coordination->client->user->fname.' '.ucfirst(substr($coordination->client->user->midname,0 ,1).'.') }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="service">Service Reserved: </label>
          <span id="service">{{ $coordination->service->name }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="date">Date Reserved: </label>
          <span id="date">{{ date('M d, Y | h:i A', strtotime($coordination->date)) }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="balance">Balance: </label>
          <span id="balance">{{ $coordination->balance }}</span>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="status">Status: </label>
          <span id="status">{{ ucfirst($coordination->status) }}</span>
          <span class="help-text text-danger"></span>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
    </form> 