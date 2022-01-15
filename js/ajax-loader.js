    // Ajax Loader
    $(document).ajaxStart(function() {
            // $('#AjaxLoader').show();
            $('.form-submit-btn').val('Saving...');
        })
        .ajaxStop(function() {
            // $('#AjaxLoader').hide();
            $('.form-submit-btn').val('Saved');
        });