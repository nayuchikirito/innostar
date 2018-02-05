<script src="{{asset('js/accounting.min.js')}}"></script>
	<script type="text/javascript">
		function associate_errors(errors, $form)
		{	 
		    //remove existing error classes and error messages from form groups
		    $form.find('.form-group').removeClass('has-error').find('.help-text').text('');
		   
		    $.each(errors, function(value, index){
		        //find each form group, which is given a unique id based on the form field's name  add the error class and set the error text
		        $('#'+value).parent().addClass('has-error').find('.help-text').text(index);
		    });
		}

		$(document).off('blur', '.money_input').on('blur', '.money_input', function(){
			var value = $(this).val();
			$(this).val(accounting.formatMoney(value, '',0));
		});

		setInterval(function() {
            //code to be repeated
            deletePendingReservation()
		      }, 5000); // every 5 minutes

		function deletePendingReservation() { 
		  $.ajax({
		   type: "GET",
		   url: "/delete_pending_reservation", 
		   // success: function(msg){
		   // 	console.log(msg);
		   // }
		 });
		}
	</script>
</body>
</html>