
listen('click', '.admin-login', function () {
    $('#formInputEmail').val('super@admin.com');
    $('#formInputPassword').val('password');
});

// hide/show password JS code
listenClick(".change-type", function() {
    let inputField = $(this).siblings();
    let oldType = inputField.attr('type');
    let type = !isEmpty(oldType) ? oldType : 'password';
    if (type == 'password') {
        $(this).children().addClass('fa-eye')
        $(this).children().removeClass('fa-eye-slash')
        inputField.attr('type', 'text')
    } else {
        $(this).children().removeClass('fa-eye')
        $(this).children().addClass('fa-eye-slash')
        inputField.attr('type', 'password')
    }
});
