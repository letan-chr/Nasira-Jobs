document.addEventListener('DOMContentLoaded', loadAdminJobData);

function loadAdminJobData() {
    if(!$('#filter_job_active_expire').length){
        return
    }

    $('#filter_featured,#filter_suspended,#filter_freelancer,#filter_expiry_date,#filter_job_active_expire').
        select2();
}

listenClick('.delete-btn', function (event) {
    let jobId = $(this).attr('data-id');
    deleteItem(route('admin.jobs.destroy', jobId), Lang.get('js.job'));
})

listenClick(' .adminJobMakeFeatured ', function (event) {
    let jobId = $(event.currentTarget).data('id');
    $.ajax({
        url : route('job.make.featured',jobId),
        method: 'post',
        cache: false,
        success: function (result) {
            if (result.success) {
                  Livewire.dispatch('refreshDatatable');
                displaySuccessMessage(result.message);
                $('[data-toggle="tooltip"]').tooltip('hide');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
})

listenClick(' .adminJobUnFeatured ', function (event) {
    let jobId = $(event.currentTarget).data('id');
    $.ajax({
        url: route('job.make.unfeatured',jobId),
        method: 'post',
        cache: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                Livewire.dispatch('refreshDatatable');
            }
        },
        error: function (result) {
            displayErrorMessage(result.responseJSON.message);
        },
    });
})

listenChange('.isSuspended', function (event) {
    let id = $(this).attr('data-id');
    let status = $(this).is(':checked') ? 1 : 0;
    // if(status == 1){
    //     $.ajax({
    //         url: route('admin.PendingJobs.AddReason'),
    //         method: 'get',
    //         data: {
    //             id: id,
    //         },
    //         success: function (result) {
    //             if (result.success) {
    //                 $('.pending_job_title').text(result.data.job_title);
    //                 $('#pending_job_id').val(result.data.id);
    //                 $('#reasonModal').appendTo('body').modal('show');
    //             }
    //         },
    //     });
    // }else{
        $.ajax({
            url:route('job.is-suspend',id),
            method: 'post',
            cache: false,
            success: function (result) {
                if (result.success) {
                    displaySuccessMessage(result.message);
                    Livewire.dispatch('refreshDatatable');
                }
            },
            error: function (result) {
                displayErrorMessage(result.responseJSON.message);
            },
        });
    // }
})

listenClick('#jobsFilters', function () {
    $('#jobsFiltersForm').toggleClass('d-block d-none');
})

listenClick('#reset-filter', function () {
    $('#filter_featured,#filter_suspended,#filter_freelancer,#filter_expiry_date,#filter_job_active_expire').
    val('').
    change();
})

listenClick('.job-application-status-reject', function (event) {
    event.preventDefault();
    let id = $(this).attr('data-id');

    $.ajax({
        url: route('employer.PendingJobs.AddReason'),
        method: 'get',
        data: {
            id: id,
        },
        success: function (result) {
            if (result.success) {
                console.log(result.data);
                $('.pending_job_title').text(result.data.job_title);
                $('#showReason').text(result.data.reject_reason);
                $('#reasonshowModal').appendTo('body').modal('show');
            }
        },
    });
})
