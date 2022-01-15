class Stack {

    // Array is used to implement stack
    constructor() {
        this.items = [];
    }

    // Functions to be implemented
    // push(item)
    push(element) {
            // push element into the items
            this.items.push(element);
        }
        // pop()
    pop() {
            // return top most element in the stack
            // and removes it from the stack
            // Underflow if stack is empty
            if (this.items.length == 0)
                return "Underflow";
            return this.items.pop();
        }
        // Pop Form Front
    shift() {
        if (this.items.length == 0)
            return "Underflow";
        return this.items.shift();
    }
}


$(document).ready(function() {
    // Intialize Undo Stack
    let undoStack = new Stack();
    // Undo Remove 
    $('.undo-section').on('click', '.undo-btn', function(e) {
        var blockid = $(this).attr('id');
        blockid = blockid.replace('undo', '');
        // console.log(blockid);
        $('#' + blockid).fadeIn();
        clearTimeout(undoStack.pop());
        $(this).remove();

        e.stopPropagation();
    });
    // Question Delete from DB
    function formDeleteFromDB(blockid) {
        console.log('Deleted:' + blockid);
        jQuery.ajax({
            type: "POST",
            url: "../ajax/db_operations.php",
            data: "delete_form=" + blockid,
            success: function(result) {

                // console.log('php response : ' + result);
                var reponse = jQuery.parseJSON(result);
                console.log(reponse);
            },
            error: function(errorData) {
                console.log("Error");
                console.log(errorData);
            }
        });
    }
    // Remove question

    function removeForm(form_id) {
        console.log('Removed:' + form_id);
        var undobtn = `<div id='` + form_id + `undo' class='undo-btn noselect'><p>Undo</p></div>`;
        $('.undo-section').append(undobtn);
        undoStack.push(setTimeout(function() {
            $('#' + form_id + 'undo').remove();
            undoStack.shift();
            console.log('Deleted:' + form_id);

            formDeleteFromDB(form_id);
            $('#' + form_id).remove();
        }, 10000));
    }

    // delete event
    $('.block-delete-btn').on('click', function(e) {
        console.log('clicked');
        var from_id = $(this).parent().closest('.form-data-block-con').attr('id');
        $('#' + from_id).fadeOut();
        removeForm(from_id);
        e.stopPropagation();
    });
});