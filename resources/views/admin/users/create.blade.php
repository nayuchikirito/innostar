<div class="modal-dialog modal-lg add-user-form">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title">Add User</h4>
    </div>
 
    <form action="{{ url('/admin/users') }}" method="POST" id="add-users-form">
    {{ csrf_field() }}
    <div class="modal-body">
      <div class="form-group">
          <label for="user_type">User Type</label>
          <select name="user_type" id="user_type" class="form-control">
            <option selected disabled>Select User Type</option>
            <option value="Admin">Admin</option>
            <option value="Secretary">Secretary</option>
          </select> 
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="fname">First Name</label>
          <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter Firstname" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="midname">Middle Name</label>
          <input type="text" class="form-control" id="midname" name="midname" placeholder="Enter Middlename" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="lname">Last Name</label>
          <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Lastname" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="email">Email address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="exampleInputPassword1">Confirm Password</label>
          <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm Password" autocomplete="false">
      </div>  
      <div class="form-group">
          <label for="location">Location</label>
          <input type="text" class="form-control" id="location" name="location" placeholder="Enter Location" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="contact">Contact</label>
          <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter Contact" autocomplete="false">
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

        $("#add-users-form").on('submit', function(e){
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
          data: $("#add-users-form").serialize(), 
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
            $("#users-table").DataTable().ajax.url( '/admin/get-users' ).load();
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