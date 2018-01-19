<div class="modal-dialog modal-lg add-user-form">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title">Edit Coordination Reservations</h4>
    </div>
    <form action="{{ url('/admin/coordinations/'.$coordination->id) }}" method="PATCH" id="edit-coordinations-form">
    {{ csrf_field() }}
    <div class="modal-body">
      <h3 class="text-center">On-the-day Coordination</h3>
      <!-- <div class="form-group">
          Date and Time
          <input type="datetime-local" name="datetime" class="form-control">
          <span class="help-text text-danger"></span>
      </div> -->
      <div class="form-group">
          Date
          <input type="date" name="date" class="form-control" value="{{ $coordination->date->format('Y-m-d') }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          Time
          <input type="time" name="time" class="form-control" value="{{ $coordination->date->format('H:i:s') }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="client_id" value="{{ $coordination->client->id }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="status" value="pending">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="service">Service</label>
          <select name="service_id" id="service_id" class="form-control">
            <option selected disabled>Select Service</option>
            @foreach($services as $service)
              <option value="{{$service->id}}" {{ $service->service_id == $coordination->service_id ? ' selected':'' }}>{{ $service->name }}</option>
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
  </div>
</div>

<script type="text/javascript">
  $(function(){ 

        $("#edit-coordinations-form").on('submit', function(e){
        e.preventDefault(); //keeps the form from behaving like a normal (non-ajax) html form
        var $form = $(this);
        var $url = $form.attr('action');
        var formData = {};
        //submit a POST request with the form data
        $form.find('input', 'select').each(function()
        {
            formData[ $(this).attr('name') ] = $(this).val();
        });
        //submits an array of key-value pairs to the form's action URL
     /*   $.post(url, formData, function(response)
        {
            //handle successful validation
            alert(1);
        }).fail(function(response)
        {
            //handle failed validation
            alert(1);
            associate_errors(response['errors'], $form);
        });*/

        $.ajax({
          type: 'PATCH',
          url: $url,
          data: $("#edit-coordinations-form").serialize(), 
          success: function(result){
            if(result.success){
              swal({
                  title: result.msg,
                  icon: "success"
                });
            }else{
              swal({
                  title: result.msg,
                  icon: "error"
                });
            }
            $("#coordinations-table").DataTable().ajax.url( '/admin/get-coordinations' ).load();
            $('.modal').modal('hide');
          },
          error: function(xhr,status,error){
            var response_object = JSON.parse(xhr.responseText); 
            associate_errors(response_object.errors, $form);
          }
        });

      });
  });  
 </script> 
