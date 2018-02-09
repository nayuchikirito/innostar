<div class="modal-dialog add-details-form">
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
      <div class="row">
        <div class="col-md-6">
          <label>TOTAL PACKAGE PRICE:</label>
          <h4 id="total" class="text-center" style="margin: 0px;">0.00</h4>
        </div>
        <div class="col-md-6">
          <label>CURENT DETAIL PRICE:</label>
          <h4 id="curent_total" class="text-center" style="margin: 0px;">0.00</h4>
        </div>
      </div>
      @foreach($descriptions as $description)


      <div class="form-group">
          <label for="{{ $description->id }}">{{ $description->name }}</label>
          <input type="number" min="0" class="form-control  price_input" id="{{ $description->id }}" name="{{ $description->id }}" placeholder="Enter {{ $description->name }} Price" autocomplete="false" required>
          <span class="help-text text-danger"></span>
      </div>
        <!-- <div class="form-group">
          <input type="hidden" name="description_id" value="{{ $description->id }}">
          <label for="{{ $description->name }}">{{ $description->name }} Price:</label>
          <input type="text" name="price"><span><button class="button btn-success" type="submit">Set</button></span>
          <span class="help-text text-danger"></span>
      </div> -->
      @endforeach
    <h3 style="margin: 10px 0px;padding: 0px 20px;">
       <span class="help-text text-danger hidden" id="error_in_price">Error! Detail total price exceeds package price.</span>
       <span class="help-text text-danger hidden" id="error_in_price2">Error! Detail total price is less than package price.</span>
    </h3>
    
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
    $(document).off('click', '#package_id').on('click', '#package_id', function(){
      var that = this;
        $.ajax({
          type: 'GET',
          url: 'getPackageDetail/'+$(that).val(),
          success: function(result){
            console.log(result);
            for(var i = 0 ; i  <  result.packages.length ; i++){
              console.log(result.packages[i]);
              $('#'+result.packages[i]['id']).val(result.packages[i]['price']);
            }
            if(result.packages.length == 0){
              $('.price_input').val('');
            }
            var t = parseFloat(result.package.price);
            $('#total').html(accounting.formatMoney(t, '',2));
           computeTotal();
          },
        });
    });
    $('.price_input').change(function(){
      computeTotal();
    });
    function computeTotal(){
      var total = 0;
      $('.price_input').each(function(){
        total += parseFloat($(this).val());
      });
      $("#curent_total").html(accounting.formatMoney(total, '',2));
      console.log(total);
      var to = $('#total').html()+''; 
      if(parseFloat(total) > parseFloat(to.replace(",",''))){
        $('#error_in_price').removeClass('hidden');
        $('#error_in_price2').removeClass('hidden');
        $('#error_in_price2').addClass('hidden');
      }else if(parseFloat(total) < parseFloat(to.replace(",",''))){
        $('#error_in_price').removeClass('hidden');
        $('#error_in_price').addClass('hidden');
        $('#error_in_price2').removeClass('hidden');
      }else{
        $('#error_in_price').removeClass('hidden');
        $('#error_in_price2').removeClass('hidden');
        $('#error_in_price').addClass('hidden');
        $('#error_in_price2').addClass('hidden');
      }
    }
     computeTotal();
        $("#add-details-form").on('submit', function(e){
        e.preventDefault();
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
              $('.modal').modal('hide');
              $("#packages-table").DataTable().ajax.url( '/admin/get-packages' ).load();
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