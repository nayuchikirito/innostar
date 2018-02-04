<div class="modal-dialog modal-lg add-details-form">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title">Add Package Details</h4>
    </div>
 
    <form action="{{ url('/admin/package_details/store') }}" method="POST" id="add-details-form">
    {{ csrf_field() }}
    <div class="modal-body">
      <div class="form-group">
          <label for="package_id">What Package</label>
          <select name="package_id" id="package_id" class="form-control">
            <option selected disabled>Select Package</option>
            @foreach($packages as $package)
              <option value="{{ $package->id }}">{{ $package->name }}</option>
            @endforeach
          </select> 
          <span class="help-text text-danger"></span>
      </div>

      @foreach($descriptions as $description)
        <div class="form-group">
          <input type="hidden" name="description_id" value="{{ $description->id }}">
          <label for="{{ $description->name }}">{{ $description->name }} Price:</label>
          <input type="text" name="price"><span><button class="button btn-success" type="submit">Set</button></span>
          <span class="help-text text-danger"></span>
      </div>
      @endforeach
    
    </div>
<!--     <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="submit" class="btn submit-btn btn-success btn-gradient pull-right">Submit</button>
    </div> -->
    </form>

  </div>
</div>

 
<script type="text/javascript">
  $(function(){ 

        $("#add-details-form").on('submit', function(e){
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
          type: 'POST',
          url: $url,
          data: $("#add-details-form").serialize(), 
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
            $("#packages-table").DataTable().ajax.url( '/admin/get-packages' ).load();
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