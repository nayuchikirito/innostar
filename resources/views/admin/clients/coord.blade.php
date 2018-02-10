
    <!-- form for coordination -->
    <form action="{{ url('/admin/coordinations') }}" method="POST" id="add-coordinations-form" class="">
    {{ csrf_field() }}
    <div class="modal-body">
      <h3 class="text-center">On-the-day Coordination</h3>
      <!-- <div class="form-group">
          Date and Time
          <input type="datetime-local" name="datetime" class="form-control">
          <span class="help-text text-danger"></span>
      </div> -->
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
          <label for="service">Service</label>
          <select name="service_id" id="service_id" class="form-control" id="service_id">
            <option selected disabled>Select Service</option>
            @foreach($services as $service)
              <option value="{{$service->id}}">{{ $service->name }}</option>
            @endforeach
          </select> 
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="balance" id="balance" value="15000">
          <span class="help-text text-danger"></span>
      </div>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="submit" class="btn submit-btn btn-success btn-gradient pull-right">Submit</button>
    </div>
    </form>

