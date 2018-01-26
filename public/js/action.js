$(document).ready(function(){

});

$("#assign-supplier-0").click(function(){
  alert("i'm clicked!");
});

function assignSupplier(supplier, reservationId){
  var url = $("#assign-suppliers-url").attr("data");
  var token = $("#_token").val();
  var supplierId = $("select#supplier_"+supplier).val();
  var price = $("input#supplier_price_"+supplier).val();
  $.ajax({
    type: 'POST',
    url: url,
    data: {
      _token: token,
      price: price,
      status: "pending",
      reservationId: reservationId,
      supplierId: supplierId
    },
    success: function(result){
      alert("Record saved successfully!");
    },
    error: function(xhr,status,error){
      // var response_object = JSON.parse(xhr.responseText);
      // associate_errors(response_object.errors, $form);
      alert("Failed to save changes!");
    }
  });
  // $.get({
  //   url: "http://localhost:8000/get-reservations",
  //   success: function(result){
  //       console.log("result",result);
  //   },
  //   error: function(e){
  //     console.log("error", e);
  //   }
  // });
}
