(function () {
    function reindexRoles() {
        $('#jobRolesContainer .job-role-row').each(function (index) {
            $(this).find('.job-role-label').text('Position ' + (index + 1));
            $(this).find('input[name*="[title]"]').attr('name', 'roles[' + index + '][title]');
            $(this).find('textarea[name*="[requirements]"]').attr('name', 'roles[' + index + '][requirements]');
        });
    }

    $(document).on('click', '#addJobRoleRow', function () {
        var template = document.getElementById('jobRoleRowTemplate');
        if (!template) return;
        var index = $('#jobRolesContainer .job-role-row').length;
        var html = template.innerHTML
            .replace(/__INDEX__/g, String(index))
            .replace(/__INDEX_DISPLAY__/g, String(index + 1));
        $('#jobRolesContainer').append(html);
        reindexRoles();
    });

    $(document).on('click', '.remove-job-role-row', function () {
        var $rows = $('#jobRolesContainer .job-role-row');
        if ($rows.length <= 1) {
            $(this).closest('.job-role-row').find('input, textarea').val('');
            return;
        }
        $(this).closest('.job-role-row').remove();
        reindexRoles();
    });
})();
