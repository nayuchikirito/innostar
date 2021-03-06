<div class="modal-dialog modal-lg add-user-form">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title">Edit Payment</h4>
    </div>
  <form action="{{ url('/admin/payments_coord/'.$payment->id) }}" method="PATCH" id="edit-payments-form">
    {{ csrf_field() }}
    <div class="modal-body">
      <h3 class="text-center">Edit Payment</h3>
      <div class="form-group">
          <label for="amount">Amount</label>
          <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Amount" autocomplete="false" value="{{ $payment->amount }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="or">Official Receipt Number</label>
          <input type="text" class="form-control" id="or" name="or" placeholder="Enter Receipt Number" autocomplete="false" value="{{ $payment->or }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="coordination_id" value="{{ $payment->coordination_id }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="type" value="cash">
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

        $("#edit-payments-form").on('submit', function(e){

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
          data: $("#edit-payments-form").serialize(), 
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
            $("#payments-table").DataTable().ajax.url( '/admin/get-payments-coord' ).load();
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