<div class="modal-dialog modal-lg add-package-form">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title">Edit Package</h4>
    </div>
 
    <form action="{{ url('/admin/packages/'.$package->id) }}" method="PATCH" id="edit-packages-form">
    {{ csrf_field() }}
    <div class="modal-body">
      <div class="form-group">
          <label for="service_id">For What Service?</label>
          <select name="service_id" id="service_id" class="form-control">
            <option selected disabled>Select Service</option>
            @foreach($services as $service)
              <option value="{{ $service->id }}" {{ $package->service_id == ' $service->id ' ? 'selected':'' }}>{{ $service->name }}</option>
            @endforeach
          </select> 
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Name" autocomplete="false" value="{{ $package->name }}">
          <span class="help-text text-danger"></span>
      </div>
       <div class="form-group">
          <label for="price">Price</label>
          <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" autocomplete="false" value="{{ $package->price }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="description">Description</label>
          <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" autocomplete="false" value="{{ $package->description }}">
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

        $("#edit-packages-form").on('submit', function(e){
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
          data: $("#edit-packages-form").serialize(), 
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