<div class="modal-header">
    <h4 class="modal-title">Add Reservations</h4>
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
    </div>
   <!--  <div class="text-center">
        <button class="btn-md btn btn-success package-data-btn"><i class="fa fa-calendar"></i> Package</button>
        <button class="btn-md btn btn-primary coord-data-btn"><i class="fa fa-calendar-check-o"></i> On-the-day Coordination</button>
      </div> -->
    <form action="{{ url('/client/coordinations') }}" method="POST" id="add-coordinations-form">
    {{ csrf_field() }}
    <div class="modal-body">
      <h3 class="text-center">On-the-day Coordination</h3>
      <div class="form-group">
          Date
          <input type="date" name="date" id="date" class="form-control">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          Time
          <input type="time" name="time" id="time" class="form-control">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="client_id" id="client_id" value="{{ $client->id }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="status" id="status" value="pending">
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

 
<script type="text/javascript">

  $(function(){ 

        $("#add-coordinations-form").on('submit', function(e){
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
          data: $("#add-coordinations-form").serialize(), 
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
            $('.modal').modal('hide');
          },
          error: function(xhr,status,error){
            var response_object = JSON.parse(xhr.responseText); 
            associate_errors(response_object.errors, $form);
          }
        });

      });

      //  $('#service_id').change(function(){
      //   var serviceID = $(this).val();
      //   var that = this;
      //   var token = $("input[name='_token']").val();
      //   $.ajax({
      //         url: "{{url('select_service')}}/"+serviceID,
      //         method: 'GET',
      //         success: function(data) {
      //           $("select[name='package_id'").html('');
      //           $("select[name='package_id'").html(data);
      //           $('#package_id').change();
      //         }
      //     });
      // });
  

  });  
 </script> 