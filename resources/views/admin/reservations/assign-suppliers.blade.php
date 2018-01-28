<div class="modal-dialog modal-lg add-user-form">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title">Assign Suppliers</h4>
      <div id="assign-suppliers-url" data="{{ url('/admin/reservations/assign-suppliers') }}"></div>
      <input type="hidden" id="_token" value="{{ csrf_token() }}" />
    </div>
    {{ csrf_field() }}
    <div class="modal-body">
      <!-- <h3 class="text-center">Package Reservation</h3> -->
      <!-- <div class="form-group">
          Date and Time
          <input type="datetime-local" name="datetime" class="form-control" value="{{ $reservation->date }}">
          <span class="help-text text-danger"></span>
      </div> -->
      <!-- <div class="row form-group">
            <div class="col-xs-12">
                <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                  @foreach($suppliers as $key=>$supplier)
                    <li class={{Request::path()}}><a href={{"#step-".$key}}>
                        <h6 class="list-group-item-heading">{{$supplier}}</h6>
                        <p class="list-group-item-text">First step description</p>
                    </a></li>
                  @endforeach
                </ul>
            </div>
    	</div> -->
        @foreach($suppliers as $key=>$supplier)
        {{$assignedPrice = null}}
        {{$noSpaceSupp = preg_replace("/[^A-Za-z0-9]/", "", $supplier)}}
        {{$statusConfirmed = false}}
          <div class="row setup-content" id={{"step-".$key}}>
              <div class="col-xs-12">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="service">{{$supplier}}</label>
                        <select name="supplier_{{$supplier}}" id="supplier_{{$noSpaceSupp}}" class="form-control">
                          <option selected disabled>Select {{$supplier}}</option>
                          @foreach($suppliersList as $slKey=>$slist)
                            @if($slKey == $supplier)
                              @foreach($slist as $sl)
                                @if($sl->assignedPrice != null)
                                  {{$assignedPrice = $sl->assignedPrice}}
                                @endif
                                @if($sl->assignedStatus == 'confirmed')
                                  {{$statusConfirmed = true}}
                                @endif
                                <option name="optn-{{$noSpaceSupp}}" value="{{$sl->supplierId}}" {{ ($sl->assignedSupplierId != null ? "selected":"") }}>{{$sl->lname.", ".$sl->fname." ".$sl->midname}}</option>
                              @endforeach
                            @endif
                          @endforeach
                        </select>
                        <span class="help-text text-danger"></span>

                    </div>
                  </div>
                  <div class="col-md-4">
                    <label for="fname">Price</label>
                    <input type="text" class="form-control" id="supplier_price_{{$noSpaceSupp}}" placeholder="Price" autocomplete="false" value={{$assignedPrice}}>
                  </div>
                  <div class="col-md-2">
                    <br>
                    @if($statusConfirmed == false)
                      <button id="assign-supplier-{{$key}}" class="btn btn-primary" onclick="assignSupplier('{{$noSpaceSupp}}','{{$reservationId}}')">Assign</button>
                    @endif
                  </div>
              </div>
          </div>
        @endforeach

        <!-- <div class="row setup-content" id="step-2">
            <div class="col-xs-12">
                <div class="col-md-12 well">
                    <h1 class="text-center"> STEP 2</h1>
                </div>
            </div>
        </div>
        <div class="row setup-content" id="step-3">
            <div class="col-xs-12">
                <div class="col-md-12 well">
                    <h1 class="text-center"> STEP 3</h1>
                </div>
            </div>
        </div> -->
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <!-- <button type="submit" class="btn btn-success btn-gradient pull-right">Submit</button> -->
    </div>

    <script type="text/javascript">

  $(function(){

        $("#edit-reservations-form").on('submit', function(e){
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
          data: $("#edit-reservations-form").serialize(),
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

        $('#service_id').click(function(){
        var serviceID = $(this).val();
        var that = this;
        var token = $("input[name='_token']").val();
        $.ajax({
              url: "{{url('select_service')}}/"+serviceID,
              method: 'GET',
              success: function(data) {
                $("select[name='package_id'").html('');
                $("select[name='package_id'").html(data);
                $('#package_id').change();
              }
          });
      });
    //$('#service_id').change();

    $('#package_id').change(function(){
        var packageID = $(this).val();
        var that = this;
        var token = $("input[name='_token']").val();
        $.ajax({
              url: "{{url('select_package')}}/"+packageID,
              method: 'GET',
              success: function(data) {
                $("[name='description'").html('');
                $("[name='description'").html(data);
              }
          });
      });

    $('#package_id').change(function(){
        var packageID = $(this).val();
        var that = this;
        var token = $("input[name='_token']").val();
        $.ajax({
              url: "{{url('select_balance')}}/"+packageID,
              method: 'GET',
              success: function(data) {
                $("[name='balance'").val('');
                $("[name='balance'").val(data);
              }
          });
      });
  });
 </script>
