
document.addEventListener('DOMContentLoaded', loadAutoFieldsData);

function loadAutoFieldsData() {
    window.changeCredentials = function changeCredentials(email, password) {
        $('#email').val(email);
        $('#password').val(password);
    };
}
    listenClick('.admin-login', function () {
        changeCredentials('super@admin.com', 'password');
    });
    listenClick('.candidate-login', function () {
        changeCredentials('candidate@admin.com', 'password');
    });
    listenClick('.employee-login', function () {
        changeCredentials('company@admin.com', 'password');
    });
