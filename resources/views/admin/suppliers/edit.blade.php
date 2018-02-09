<div class="modal-dialog modal-lg add-supplier-form">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title">Edit Supplier</h4>
    </div>
 
    <form action="{{ url('/admin/suppliers/'.$supplier->id) }}" method="PATCH" id="edit-suppliers-form">
    {{ csrf_field() }}
    <div class="modal-body">
      <input type="hidden" name="user_type" value="Suppliers">

      <div class="form-group">
          <label for="type">Supplier Type</label>
          <select name="type" id="type" class="form-control">
            <option selected disabled>Select Supplier Type</option>
            <option value="Florist" {{ $supplier->supplier->type == 'Florist' ? ' selected':'' }}>Florist</option>
            <option value="Photo & Video" {{ $supplier->supplier->type == 'Photo & Video' ? ' selected':'' }}>Photo & Video</option>
            <option value="Reception" {{ $supplier->supplier->type == 'Reception' ? ' selected':'' }}>Reception</option>
            <option value="Souvenir" {{ $supplier->supplier->type == 'Souvenir' ? ' selected':'' }}>Souvenir</option>
            <option value="Invitation" {{ $supplier->supplier->type == 'Invitation' ? ' selected':'' }}>Invitation</option> 
          </select> 
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Enter Supplier Name" autocomplete="false" value="{{ $supplier->supplier->name }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="fname">First Name</label>
          <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter Firstname" autocomplete="false" value="{{ $supplier->fname }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="midname">Last Name</label>
          <input type="text" class="form-control" id="midname" name="midname" placeholder="Enter Middlename" autocomplete="false" value="{{ $supplier->midname }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="lname">Last Name</label>
          <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Lastname" autocomplete="false" value="{{ $supplier->lname }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" autocomplete="false" value="{{ $supplier->email }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="password_confirm">Confirm Password</label>
          <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm Password" autocomplete="false">
      </div>  
      <div class="form-group">
          <label for="location">Location</label>
          <input type="text" class="form-control" id="location" name="location" placeholder="Enter Location" autocomplete="false" value="{{ $supplier->location }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="contact">Contact</label>
          <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Contact" autocomplete="false" value="{{ $supplier->contact }}">
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

        $("#edit-suppliers-form").on('submit', function(e){
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
          type: 'PATCH',
          url: $url,
          data: $("#edit-suppliers-form").serialize(), 
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
            $("#suppliers-table").DataTable().ajax.url( '/admin/get-suppliers' ).load();
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