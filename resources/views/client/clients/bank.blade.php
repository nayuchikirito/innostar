
    <div class="modal-header">
      <h4 class="modal-title">Payment Details</h4>
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
    </div>
    <div class="text-center">
        <button class="btn-md btn btn-success package-data-btn"><i class="fa fa-calendar"></i> Bank</button>
        <button class="btn-md btn btn-danger mlhuillier-data-btn"><i class="fa fa-calendar-check-o"></i> Mlhuillier</button>
        <button class="btn-md btn btn-primary coord-data-btn"><i class="fa fa-calendar-check-o"></i> Western Union</button>
      </div>
    <form action="{{ url('/client/payments') }}" method="POST" id="add-payments-form">
    {{ csrf_field() }}
    <div class="modal-body font-mine">
      <h3 class="text-center">BPI Bank Payment</h3>
      <div class="form-group">
          <label for="amount">Amount</label>
          <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Amount" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="details">Tracking Number</label>
          <input type="text" class="form-control" id="details" name="details" placeholder="Enter Receipt Number" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          Date of Payment
          <input type="date" name="date" class="form-control">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          Time of Payment
          <input type="time" name="time" class="form-control">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="type" value="bank">
          <span class="help-text text-danger"></span>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="submit" class="btn submit-btn btn-success btn-gradient pull-right">Pay</button>
    </div>
    </form>


    <form action="{{ url('/client/payments') }}" method="POST" id="add-mlhuillier-form" class="hidden">
    {{ csrf_field() }}
    <div class="modal-body font-mine">
      <h3 class="text-center">Mlhuillier</h3>
      <div class="form-group">
          <label for="amount">Amount</label>
          <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Amount" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="details">Tracking Number</label>
          <input type="text" class="form-control" id="details" name="details" placeholder="Enter Receipt Number" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          Date of Payment
          <input type="date" name="date" class="form-control">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          Time of Payment
          <input type="time" name="time" class="form-control">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="type" value="bank">
          <span class="help-text text-danger"></span>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="submit" class="btn submit-btn btn-success btn-gradient pull-right">Pay</button>
    </div>
    </form>


    <form action="{{ url('/client/payments') }}" method="POST" id="add-western-form" class="hidden">
    {{ csrf_field() }}
    <div class="modal-body font-mine">
      <h3 class="text-center">BPI Bank Payment</h3>
      <div class="form-group">
          <label for="amount">Amount</label>
          <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Amount" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="details">Tracking Number</label>
          <input type="text" class="form-control" id="details" name="details" placeholder="Enter Receipt Number" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          Date of Payment
          <input type="date" name="date" class="form-control">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          Time of Payment
          <input type="time" name="time" class="form-control">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="type" value="bank">
          <span class="help-text text-danger"></span>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="submit" class="btn submit-btn btn-success btn-gradient pull-right">Pay</button>
    </div>
    </form>

<script type="text/javascript">

  $(function(){ 

        $("#add-payments-form").on('submit', function(e){
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
          data: $("#add-payments-form").serialize(), 
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

    // $(document).off('click', '.package-data-btn').on('click', '.package-data-btn', function(){
    //   $('#add-reservations-form').removeClass('hidden');
    //   $('#add-coordinations-form').addClass('hidden');
    // });

    // $(document).off('click', '.coord-data-btn').on('click', '.coord-data-btn', function(){
    //   $('#add-coordinations-form').removeClass('hidden');
    //   $('#add-reservations-form').addClass('hidden');
    // });


  });  
 </script> 