
    <div class="modal-header">
      <h4 class="modal-title">Request</h4>
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
    </div>
    <form action="{{ url('/client/change_request') }}" method="POST" id="add-payments-form">
    {{ csrf_field() }}
    <div class="modal-body font-mine">
      <h3 class="text-center">Request Change of Date</h3>
      <div class="form-group">
          Event
          <input name="event" class="form-control" value="{{ $reservation->package->service->name }}" readonly>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          Original Date of Event
          <input name="orig_date" class="form-control" value="{{ date('M d, Y | h:i A', strtotime($reservation->date)) }}" readonly>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          New Date
          <input type="date" name="date" id="date" class="form-control">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          New Time
          <input type="time" name="time" id="time" class="form-control">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
          <span class="help-text text-danger"></span>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="submit" class="btn submit-btn btn-success btn-gradient pull-right">Send Request</button>
    </div>
    </form>


<script type="text/javascript">

  $(function(){ 

        $("#add-payments-form").on('submit', function(e){
        e.preventDefault(); //keeps the form from behaving like a normal (non-ajax) html form
        var $form = $(this);
        var $url = $form.attr('action');
        var formData = {};
        //submit a POST request with the form data
        $form.find('input', 'select').each(function(){
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
          type: 'POST',
          url: $url,
          data: $("#add-payments-form").serialize(), 
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
            // $("#reservations-table").DataTable().ajax.url( '/admin/get-reservations' ).load();
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
