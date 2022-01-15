$(document).ready(function() {
    // function getCurrentIndex() {
    //     return currentIndexValue;
    // }
    // console.log('This is drag and drop utility');
    var currentIndex = currentIndexValue;
    const imgBox = $('#' + currentIndex);

    imgBox.on('dragstart', function(e) {
        console.log('DragStart has been triggered');
        // e.target.className += ' hold';
        setTimeout(() => {
            // e.target.className = 'hide';
        }, 0);

    });

    imgBox.on('dragend', function(e) {
        console.log('DragEnd has been triggered');
        // e.target.className = 'imgBox';
    });
    let dropbox = $('#' + currentIndex).clone()[0];
    let prevBox = $('#' + currentIndex);
    // console.log(dropbox);
    $('.drop-box').each(function(index) {

        $(this).on('dragover', function(e) {
            e.preventDefault();
            // console.log('Prevent : ' + e.isDefaultPrevented());
            // console.log('DragOver has been triggered');
        });

        $(this).on('dragenter', function(e) {
            // console.log('DragEnter has been triggered');
            // e.target.className += ' dashed';
        });

        $(this).on('dragleave', function(e) {
            // console.log('DragLeave has been triggered');
            // e.target.className = 'whiteBox'
        });

        $(this).on('drop', function(e) {
            // console.log('Drop has been triggered');
            prevBox.remove();

            e.target.before(dropbox);
            //console.log('Prevent : ' + e.isDefaultPrevented());
            // $('#1').unbind("click");

        });
    });
    $(".container").on('mouseenter', '.drag-hanger', function() {
        $(this).parent().closest('.input-container').prop('draggable', true);

    });
    $(".container").on('mouseleave', '.drag-hanger', function() {
        $(this).parent().closest('.input-container').prop('draggable', false);

    });

});