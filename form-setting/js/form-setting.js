$(document).ready(function() {
   $('.resubmit').on('change',function(){
     var resubmit_status = $(this).is(":checked");
     var resubmitData = {'ID': form_id, 'resubmit': resubmit_status ? 1 : 0};
    //  console.log(resubmitData);
     resubmitData = JSON.stringify(resubmitData);
     jQuery.ajax({
        type: "POST",
        url: "ajax/update_form.php",
        data: "resubmit_Update=" + resubmitData,
        success: function(result) {

            var reponse = jQuery.parseJSON(result);
            console.log(reponse);
        },
        error: function(errorData) {
            console.log(errorData);
        }
    });
   });
   $('.random-order').on('change',function(){
    var order_status = $(this).is(":checked");
     var orderData = {'ID': form_id, 'order': order_status ? 1 : 0};
    //  console.log(orderData);
     orderData = JSON.stringify(orderData);
     jQuery.ajax({
        type: "POST",
        url: "ajax/update_form.php",
        data: "order_Update=" + orderData,
        success: function(result) {

            var reponse = jQuery.parseJSON(result);
            console.log(reponse);
        },
        error: function(errorData) {
            console.log(errorData);
        }
    });
  });
  $('.editable').on('change',function(){
    var editable_status = $(this).is(":checked");
     var editableData = {'ID': form_id, 'editable': editable_status ? 1 : 0};
    //  console.log(orderData);
    editableData = JSON.stringify(editableData);
     jQuery.ajax({
        type: "POST",
        url: "ajax/update_form.php",
        data: "editable_Update=" + editableData,
        success: function(result) {

            var reponse = jQuery.parseJSON(result);
            console.log(reponse);
        },
        error: function(errorData) {
            console.log(errorData);
        }
    });
  });
  $(document).ajaxStart(function() {
      // $('#AjaxLoader').show();
      $('#formStatus').html('Saving...');
  })
  .ajaxStop(function() {
      // $('#AjaxLoader').hide();
      $('#formStatus').html('Saved');
  });
});