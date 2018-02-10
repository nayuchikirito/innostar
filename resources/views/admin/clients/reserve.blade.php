<div class="modal-dialog modal-lg add-user-form">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title">Add Reservations</h4>
    </div>
    <div class="text-center">
        <button class="btn-md btn btn-success package-data-btn"><i class="fa fa-calendar"></i> Package</button>
        <button class="btn-md btn btn-primary coord-data-btn"><i class="fa fa-calendar-check-o"></i> On-the-day Coordination</button>
      </div>
    <div class="row">
      <div class="col-md-12 form_holder" ></div>
    </div>
  </div>
</div>

 
<script type="text/javascript">
  var s_id = document.getElementById("service_id");
  // var package_s_id = e.options[e.selectedIndex].value;

  $(function(){ 

        $(document).off('submit', '#add-reservations-form').on('submit', '#add-reservations-form', function(e){
      //  $("#add-reservations-form").on('submit', function(e){
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
          data: $("#add-reservations-form").serialize(), 
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
        $(document).off('submit', '#add-coordinations-form').on('submit', '#add-coordinations-form', function(e){
        //$("#add-coordinations-form").on('submit', function(e){
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
          data: $("#add-coordinations-form").serialize(), 
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
            $('.modal').modal('hide');
          },
          error: function(xhr,status,error){
            var response_object = JSON.parse(xhr.responseText); 
            associate_errors(response_object.errors, $form);
          }
        });

      });

        // $('#datetimeID').datetimepicker({
        //             defaultDate: "11/1/2013",
        //             disabledDates: [
        //                 new Date(2013, 11 - 1, 21),
        //                 "11/22/2013 00:53"
        //             ]
        //         });
    $(document).off('change', '#service_id').on('change', '#service_id', function(){
	  //   $('#service_id').change(function(){
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
    $(document).off('change', '#package_id').on('change', '#package_id', function(){
		//$('#package_id').change(function(){
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
           $.ajax({
                url: "{{url('/admin/get_package_details')}}/"+packageID,
                method: 'GET',
                success: function(data) {
                  $('#desc_detail').html(data);
                }
          });

	      $.ajax({
		          url: "{{url('select_balance')}}/"+packageID,
		          method: 'GET',
		          success: function(data) {
		            $("[name='balance'").val('');
		            $("[name='balance'").val(data);
		          }
		      });
		  });

    $('.package-data-btn').click();
    $(document).off('click', '.package-data-btn').on('click', '.package-data-btn', function(){
      $('.form_holder').html('');
      $('.form_holder').load('{{url("/admin/reserveform")}}'); 
    });

    $(document).off('click', '.coord-data-btn').on('click', '.coord-data-btn', function(){
      $('.form_holder').html('');
      $('.form_holder').load('{{url("/admin/coordform")}}');
    });

  });  
 </script> 