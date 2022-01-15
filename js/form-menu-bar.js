$(document).ready(function() {
    // $.getScript('ajax/test.js', function() {
    //     alert('Load was performed.');
    // });
    console.log(form_id);
    $('.menu-items').each(function(i) {
        $(this).children('a').attr('href', $(this).children('a').attr('href') + '?id=' + form_id);
    });

    // menu bar
    $('.menu-sub-btn').on('click', function(e) {
        if (!$('.form-menu-bar').is(':visible')) {
            $('.form-menu-bar').fadeIn();
            $('.menu-btn-sub-bar').addClass('fa-caret-up');
        } else {
            $('.form-menu-bar').fadeOut();
            $('.menu-btn-sub-bar').removeClass('fa-caret-up');
        }
        e.stopPropagation();
    });
    $('.form-menu-bar').on('click', function(e) {
        // console.log('Clicked');
        $(this).fadeOut();
        $('.menu-btn-sub-bar').removeClass('fa-caret-up');
        e.stopPropagation();
    });
    $('.menu-items').on('click', function(e) {

        e.stopPropagation();
    });
    $(window).on('resize', function() {
        var win = $(this); //this = window
        // if (win.height() >= 820) { /* ... */ }
        if (win.width() >= 700) {
            $('.form-menu-bar').css('display', 'flex');
        }
    });

    // form link
    $('.option-item').on('click', function(e) {
        e.stopImmediatePropagation();
        e.stopPropagation();
    });
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
    // Remove question
    function removeForm(currentIndex) {
        $('#' + currentIndex).fadeOut();
        var undobtn = `<div id='` + currentIndex + `undo' class='undo-btn noselect'><p>Undo</p></div>`;
        var undofun = $('.undo-section').append(undobtn);
        undoStack.push(setTimeout(function() {
            $('#' + currentIndex + 'undo').remove();
            undoStack.shift();
            $('#' + currentIndex).remove();
        }, 10000));
    }
    $('.data-block').on('click', '.q-block-delete-btn', function(e) {

        removeForm($(this).parent().closest('.forms-data').attr('id'));
        e.stopImmediatePropagation();
        e.stopPropagation();
    });

    // Log Out

    // function signOut() {
    //     var auth2 = gapi.auth2.getAuthInstance();
    //     auth2.signOut().then(function() {
    //         window.location.replace("../login/login_page.php");
    //         console.log('User signed out.');
    //     });
    // }
    // $('.log-out-btn').on('click', function(e) {
    //     signOut();
    // });
});