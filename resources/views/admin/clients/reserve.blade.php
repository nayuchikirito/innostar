<div class="modal-dialog modal-lg add-user-form">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title">Add Reservations</h4>
    </div>
 
    <form action="{{ url('/admin/reservations') }}" method="POST" id="add-reservations-form">
    {{ csrf_field() }}
    <div class="modal-body">
      <div class="form-group">
          <label for="datetime">Date and Time</label>
          <div class='input-group date' id='datetimeID'>
                    <input type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="status" value="pending">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="balance" value="0">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="service">Service</label>
          <select name="service" id="service" class="form-control">
            <option selected disabled>Select Service</option>
            @foreach($services as $service)
              <option value="service">{{ $service->name }}</option>
            @endforeach
          </select> 
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="package">Package</label>
          <select name="package" id="package" class="form-control">
            <option selected disabled>Select Package</option>
            @foreach($packages as $package)
              <option value="package">{{ $package->name }}</option>
            @endforeach
          </select> 
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

        $("#add-reservations-form").on('submit', function(e){
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
          data: $("#add-reservations-form").serialize(), 
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
            $("#reservations-table").DataTable().ajax.url( '/admin/get-reservations' ).load();
            $('.modal').modal('hide');
          },
          error: function(xhr,status,error){
            var response_object = JSON.parse(xhr.responseText); 
            associate_errors(response_object.errors, $form);
          }
        });

      });

        $('#datetimeID').datetimepicker({
                    defaultDate: "11/1/2013",
                    disabledDates: [
                        new Date(2013, 11 - 1, 21),
                        "11/22/2013 00:53"
                    ]
                });
  });  
 </script> 