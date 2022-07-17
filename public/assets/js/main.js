// AJAX JQUERY AFFICHER LES MESSAGES
$(function () {
    let nb = 3;
    $('#next').click(function () {
        nb++;
        $.get("ajax_msg_contact.php?nb=" + nb, function (data) {
            $('#slide').append(data);
        });
    });
});


