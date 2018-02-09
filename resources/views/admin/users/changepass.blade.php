@extends('admin.includes.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change password
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('admin/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Change Password</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    	<div class="row">
    		<div class="col-md-4 col-xs-12">
    				
		        <div class="box">
		            <div class="box-header with-border">
		              <h3 class="box-title">Change Password</h3>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
		              	
					    <form action="{{ url('/admin/changepassword') }}" method="POST" id="change-pass-form">
					    {{ csrf_field() }} 
					      <div class="form-group">
					          <label for="old_password">Old Password</label>
					          <input type="password" id="old_password" name="old_password" placeholder="Old Password" class="form-control">
					          <span class="help-text text-danger"></span>
					      </div>
					      <div class="form-group">
					          <label for="new_password">New Password</label>
					          <input type="password" id="new_password" name="new_password" placeholder="New Password" class="form-control">
					          <span class="help-text text-danger"></span>
					      </div>
					      <div class="form-group">
					          <label for="confirm_password">Confirm Password</label>
					          <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" class="form-control">
					          <span class="help-text text-danger"></span>
					      </div>
					      <div class="row">
					      	<div class="col-md-12">
				      		      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							      <button type="submit" class="btn submit-btn btn-success btn-gradient pull-right">Submit</button>
					      	</div>
					      </div>
					     </form>
		            </div>
	          	</div>
    		</div>
    	</div>
      </div>
      <!-- /.row --> 

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  $(function(){



        $("#change-pass-form").on('submit', function(e){
        e.preventDefault(); //keeps the form from behaving like a normal (non-ajax) html form
        var $form = $(this);
        var $url = $form.attr('action');
        var formData = {};
        //submit a POST request with the form data
        $form.find('input', 'select').each(function()
        {
            formData[ $(this).attr('name') ] = $(this).val();
        });

        $.ajax({
          type: 'POST',
          url: $url,
          data: $("#change-pass-form").serialize(), 
          success: function(result){
            if(result.success){
              swal({
                  title: result.msg,
                  icon: "success"
                });
            	//window.location.reload();
	            $('input').val('');
            }else{
              swal({
                  title: result.msg,
                  icon: "error"
                });
            }
          },
          error: function(xhr,status,error){
            var response_object = JSON.parse(xhr.responseText); 
            associate_errors(response_object.errors, $form);
          }
        });

      });
  });
</script>
@endsection