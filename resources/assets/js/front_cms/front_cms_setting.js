// document.addEventListener('DOMContentLoaded', loadFrontCmsData);

Livewire.hook("element.init", () => {
    loadFrontCmsData();
});

function loadFrontCmsData() {
    if ($('#aboutImageOne').length) {
        $('#currency').select2({
            width: '100%',
        });
    }
    listenChange('#aboutImageOne', function () {
        if (isValidFile($(this), '#validationErrorsBox')) {
            displayPhoto(this, '#aboutImagePreviewOne');
        }
    });
    listenChange('#aboutImageTwo', function () {
        if (isValidFile($(this), '#validationErrorsBox')) {
            displayPhoto(this, '#aboutImagePreviewTwo');
        }
    });
    listenChange('#aboutImageThree', function () {
        if (isValidFile($(this), '#validationErrorsBox')) {
            displayPhoto(this, '#aboutImagePreviewThree');
        }
    });
}
