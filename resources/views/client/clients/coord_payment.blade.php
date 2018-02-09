
    <div class="modal-header">
      <h4 class="modal-title">Payment Details</h4>
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
    </div>
    <div class="text-center">
        <button class="btn-md btn btn-success bank-data-btn"><i class="fa fa-calendar"></i> Bank</button>
        <button class="btn-md btn btn-danger mlhuillier-data-btn"><i class="fa fa-calendar-check-o"></i> Mlhuillier</button>
        <button class="btn-md btn btn-primary western-data-btn"><i class="fa fa-calendar-check-o"></i> Western Union</button>
      </div>
    <form action="{{ url('/client/payments_coord') }}" method="POST" id="add-payments-form">
    {{ csrf_field() }}
    <div class="modal-body font-mine">
      <h3 class="text-center">BPI Bank Payment</h3>
      <div class="form-group">
          <label for="amount">Amount</label>
          <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Amount" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="details">Transaction Number</label>
          <input type="text" class="form-control" id="details" name="details" placeholder="********" autocomplete="false">
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
          <input type="hidden" name="coordination_id" value="{{ $coordination->id }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="type" value="bank">
          <span class="help-text text-danger"></span>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="submit" class="btn submit-btn btn-success btn-gradient pull-right">Send Payment Details</button>
    </div>
    </form>


    <form action="{{ url('/client/payments') }}" method="POST" id="add-payments2-form" class="d-none">
    {{ csrf_field() }}
    <div class="modal-body font-mine">
      <h3 class="text-center">Mlhuillier</h3>
      <div class="form-group">
          <label for="amount">Amount</label>
          <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Amount" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="details">KPTN</label>
          <input type="text" class="form-control" id="details" name="details" placeholder="0000-000-0000-000-0000" autocomplete="false">
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
          <input type="hidden" name="coordination_id" value="{{ $coordination->id }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="type" value="mlhuillier">
          <span class="help-text text-danger"></span>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="submit" class="btn submit-btn btn-success btn-gradient pull-right">Send Payment Details</button>
    </div>
    </form>


    <form action="{{ url('/client/payments') }}" method="POST" id="add-payments3-form" class="d-none">
    {{ csrf_field() }}
    <div class="modal-body font-mine">
      <h3 class="text-center">Western Union</h3>
      <div class="form-group">
          <label for="amount">Amount</label>
          <input type="text" class="form-control" id="amount" name="amount" placeholder="Enter Amount" autocomplete="false">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <label for="details">MTCN</label>
          <input type="text" class="form-control" id="details" name="details" placeholder="000-000-0000" autocomplete="false">
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
          <input type="hidden" name="coordination_id" value="{{ $coordination->id }}">
          <span class="help-text text-danger"></span>
      </div>
      <div class="form-group">
          <input type="hidden" name="type" value="western union">
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
            // $("#reservations-table").DataTable().ajax.url( '/admin/get-reservations' ).load();
            $('.modal').modal('hide');
          },
          error: function(xhr,status,error){
            var response_object = JSON.parse(xhr.responseText); 
            associate_errors(response_object.errors, $form);
          }
        });

      });


        $("#add-payments2-form").on('submit', function(e){
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
          data: $("#add-payments2-form").serialize(), 
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


        $("#add-payments3-form").on('submit', function(e){
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
          data: $("#add-payments3-form").serialize(), 
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

    $(document).off('click', '.bank-data-btn').on('click', '.bank-data-btn', function(){
      $('#add-payments-form').removeClass('d-none');
      $('#add-payments2-form').addClass('d-none');
      $('#add-payments3-form').addClass('d-none');
    });

    $(document).off('click', '.mlhuillier-data-btn').on('click', '.mlhuillier-data-btn', function(){
      $('#add-payments2-form').removeClass('d-none');
      $('#add-payments-form').addClass('d-none');
      $('#add-payments3-form').addClass('d-none');
    });

    $(document).off('click', '.western-data-btn').on('click', '.western-data-btn', function(){
      $('#add-payments3-form').removeClass('d-none');
      $('#add-payments-form').addClass('d-none');
      $('#add-payments2-form').addClass('d-none');
    });


  });  
 </script> 