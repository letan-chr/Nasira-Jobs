listenClick(".live-btn", function(event) {
    event.preventDefault();
    let id = $(this).attr("data-id");
    let status = $(this).attr("data-status");
    $.ajax({
        url: route("admin.PendingJobs.changStatus"),
        method: "post",
        data: {
            id: id,
            status: status
        },
        success: function(result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                Livewire.dispatch("refresh");
                Livewire.dispatch("refreshDatatable");
            }
        }
    });
});

listenClick(".suspend-btn", function(event) {
    event.preventDefault();
    let id = $(this).attr("data-id");
    $("#reject_reason").val("");
    $.ajax({
        url: route("admin.PendingJobs.AddReason"),
        method: "get",
        data: {
            id: id
        },
        success: function(result) {
            if (result.success) {
                $(".pending_job_title").text(result.data.job_title);
                $("#pending_job_id").val(result.data.id);
                $("#reasonModal")
                    .appendTo("body")
                    .modal("show");
            }
        }
    });
});

listenSubmit("#addReasonForm", function(event) {
    event.preventDefault();
    let id = $("#reject_reason").val().length;
    let textValue = $('#reject_reason').val().trim();
    if (id == 0 || !textValue) {
        displayErrorMessage(Lang.get("js.enter_reason"));
        return false;
    }
    $.ajax({
        url: route("admin.PendingJobs.changStatus"),
        method: "post",
        data: new FormData(this),
        dataType: "JSON",
        processData: false,
        contentType: false,
        success: function(result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                $("#reasonModal").modal("hide");
                $("#reject_reason").val("");
                Livewire.dispatch("refresh");
                Livewire.dispatch("refreshDatatable");
            }
        }
    });
});

listenClick("#rejectBtnCancel", function() {
    $("#reject_reason").val("");
    Livewire.dispatch("refresh");
    Livewire.dispatch("refreshDatatable");
});
