<div class="modal-header">
    <h4 class="modal-title">Add Reservations</h4>
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
    </div>
    <div class="text-center">
        <button class="btn-md btn btn-success package-data-btn"><i class="fa fa-calendar"></i> Package</button>
        <button class="btn-md btn btn-primary coord-data-btn"><i class="fa fa-calendar-check-o"></i> On-the-day Coordination</button>
      </div>
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
          Time
          <input type="time" name="time" class="form-control">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="client_id" value="{{ $client->id }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="status" value="pending">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="assigned" value="0">
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
          <input type="hidden" name="balance" id="balance">
          <span class="help-text text-danger"></span>
      </div>

      <div class="form-group" id="description_label">
          <label for="description">Description</label>
          <textarea type="text" class="form-control" id="description" name="description" autocomplete="false" readonly="true"></textarea>
          <span class="help-text text-danger"></span>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="submit" class="btn submit-btn btn-success btn-gradient pull-right">Submit</button>
    </div>
    </form>

    <!-- form for coordination -->
    <form action="{{ url('/admin/coordinations') }}" method="POST" id="add-coordinations-form" class="hidden">
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
          <input type="date" name="date" class="form-control">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          Time
          <input type="time" name="time" class="form-control">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="client_id" value="{{ $client->id }}">
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
  var s_id = document.getElementById("service_id");
  // var package_s_id = e.options[e.selectedIndex].value;

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
            // $("#reservations-table").DataTable().ajax.url( '/admin/get-reservations' ).load();
            $('.modal').modal('hide');
          },
          error: function(xhr,status,error){
            var response_object = JSON.parse(xhr.responseText); 
            associate_errors(response_object.errors, $form);
          }
        });

      });

       $('#service_id').change(function(){
        var serviceID = $(this).val();
        var that = this;
        var token = $("input[name='_token']").val();
        $.ajax({
              url: "{{url('select_service')}}/"+serviceID,
              method: 'GET',
              success: function(data) {
                $("select[name='package_id'").html('');
                $("select[name='package_id'").html(data);
                $('#package_id').change();
              }
          });
      });
    //$('#service_id').change();

    $('#package_id').change(function(){
        var packageID = $(this).val();
        var that = this;
        var token = $("input[name='_token']").val();
        $.ajax({
              url: "{{url('select_package')}}/"+packageID,
              method: 'GET',
              success: function(data) {
                $("[name='description'").html('');
                $("[name='description'").html(data);
              }
          });
      });

    $('#package_id').change(function(){
        var packageID = $(this).val();
        var that = this;
        var token = $("input[name='_token']").val();
        $.ajax({
              url: "{{url('select_balance')}}/"+packageID,
              method: 'GET',
              success: function(data) {
                $("[name='balance'").val('');
                $("[name='balance'").val(data);
              }
          });
      });

    $(document).off('click', '.package-data-btn').on('click', '.package-data-btn', function(){
      $('#add-reservations-form').removeClass('hidden');
      $('#add-coordinations-form').addClass('hidden');
    });

    $(document).off('click', '.coord-data-btn').on('click', '.coord-data-btn', function(){
      $('#add-coordinations-form').removeClass('hidden');
      $('#add-reservations-form').addClass('hidden');
    });

  });  
 </script> 