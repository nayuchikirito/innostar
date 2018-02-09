@extends('client.includes.app')

@section('title')
    Innovation Star
@endsection 
@section('content') 
      @include('navigations.client-nav')
 <header class="masthead text-center text-white d-flex">
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <h1 class="text-uppercase">
              <strong>Change Password</strong>
            </h1>
            <hr>
          </div>
          <div class="col-lg-8 mx-auto p-4 bg-dark">
            <form action="{{ url('/client/changepassword') }}" method="POST" id="change-pass-form">
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
                        <button type="button" class="btn btn-default float-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn submit-btn btn-success btn-gradient float-right">Submit</button>
                  </div>
                </div>
               </form>
            <!-- <a class="btn btn-primary btn-xl reserve-data-btn">Reserve</a> -->
            <a class="btn btn-primary btn-xl mt-5" href="{{ url('/') }}"> Back to Home</a>
          </div>
        </div>
      </div>
    </header>
 
    <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;" id="addmodal">
        <div class="modal-dialog modal-lg add-user-form">
          <div class="modal-content" id="modal-content">
            
          
          

           </div>
        </div>
    </div>

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

      // $(document).off('click','request-data-btn').on('click','.request-data-btn', function(e){
      //   e.preventDefault();
      //   var that = this;
      //   Auth::user()->notify(new UserRequests());
      // });
  });

  </script>
@endsection

    

    
