// document.addEventListener('DOMContentLoaded', loadSelectedCandidateData);

Livewire.hook("element.init", () => {
    loadSelectedCandidateData();
})

function loadSelectedCandidateData(){
    if ($('#selectedCandidateStatus').length) {
        $('#selectedCandidateStatus').select2();
    }
}

listenChange("#selectedCandidateStatus", function() {
         Livewire.dispatch("changeStatusFilter", { status: $(this).val() });
     });
listenClick("#selectedCandidate-ResetFilter", function() {
         $("#selectedCandidateStatus").val(5).change();
         hideDropdownManually($('#selectedCandidateFilterBtn'), $('.dropdown-menu'));
     });
function hideDropdownManually(button, menu) {
              button.dropdown('toggle');
     }
