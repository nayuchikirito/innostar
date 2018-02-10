 <form action="{{ url('/admin/reservations') }}" method="POST" id="add-reservations-form">
    {{ csrf_field() }}
    <div class="modal-body">
      <h3 class="text-center">Package Reservation</h3>
      <div class="form-group">
          <label for="date">Date</label>
          <input type="date" name="date" class="form-control" id="date">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="time">Time</label>
          <input type="time" name="time" class="form-control" id="time">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="client_id" value="{{ $client->id }}" id="client_id">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="status" value="pending" id="status">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="assigned" value="0" id="assigned">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="service">Service</label>
          <select name="service_id" id="service_id" class="form-control">
            <option selected disabled>Select Service</option>
            @foreach($services as $service)
              <option value="{{$service->id}}">{{ $service->name }}</option>
            @endforeach
          </select> 
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group" id="package_label">
          <label for="package">Package</label>
          <select name="package_id" id="package_id" class="form-control">
          </select> 
          <span class="help-text text-danger"></span>
      </div>

      <div class="form-group">
          <label>Balance</label>
          <input type="text" name="balance" id="balance" readonly="true" class="form-control">
          <span class="help-text text-danger"></span>
      </div>

      <div class="form-group" id="description_label">
          <label for="description">Description</label>
          <textarea type="text" class="form-control" id="description" name="description" autocomplete="false" readonly="true" rows="4"></textarea>
          <span class="help-text text-danger"></span>
      </div>

      <div class="row">
        <div class="col-md-12" id="desc_detail">
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="submit" class="btn submit-btn btn-success btn-gradient pull-right">Submit</button>
    </div>
    </form>
