/**
 * Simple job post helpers:
 * - allow empty description / key responsibilities
 * - quick-add company from job form (+)
 */
(function () {
    function fillQuillHidden(editor, hiddenSelector) {
        if (!editor || !$(hiddenSelector).length) {
            return;
        }
        var html = editor.root ? editor.root.innerHTML : '';
        var payload = JSON.stringify(html);
        $(hiddenSelector).val(String(payload).replace(/"/g, ''));
    }

    function submitJobForm(formSelector, btn) {
        processingBtn(formSelector, btn, 'loading');

        if (typeof details !== 'undefined') {
            fillQuillHidden(details, '#job_desc');
        }
        if (typeof response !== 'undefined') {
            fillQuillHidden(response, '#key_responsibilities');
        }
        if (typeof editJobDescription !== 'undefined') {
            fillQuillHidden(editJobDescription, '#editJobDescription');
        }
        if (typeof editResponse !== 'undefined') {
            fillQuillHidden(editResponse, '#edit_responsibilities');
        }

        if ($('#salaryToErrorMsg').text() !== '') {
            $('#toSalary').focus();
            processingBtn(formSelector, btn);
            return false;
        }

        $(formSelector)[0].submit();
        return false;
    }

    // Override stock required-description handlers (capture phase)
    document.addEventListener(
        'click',
        function (e) {
            var createBtn = e.target.closest('#jobsSaveBtn, #saveDraft');
            var editBtn = e.target.closest('#editJobsSaveBtn');

            if (createBtn && $('#createJobForm').length) {
                if (createBtn.id === 'saveDraft' || createBtn.value === 'draft') {
                    $('#saveAsDraft').attr('value', '1');
                }
                e.preventDefault();
                e.stopImmediatePropagation();
                return submitJobForm('#createJobForm', $(createBtn));
            }

            if (editBtn && $('#editJobForm').length) {
                e.preventDefault();
                e.stopImmediatePropagation();
                return submitJobForm('#editJobForm', $(editBtn));
            }
        },
        true
    );

    listenClick('.createCompanyModal', function () {
        $('#createCompanyModal').modal('show');
    });

    $('#createCompanyModal').on('hidden.bs.modal', function () {
        if (typeof resetModalForm === 'function') {
            resetModalForm('#createCompanyQuickForm');
        } else {
            $('#createCompanyQuickForm')[0].reset();
        }
    });

    listenSubmit('#createCompanyQuickForm', function (e) {
        e.preventDefault();
        processingBtn('#createCompanyQuickForm', '#companyQuickBtnSave', 'loading');

        $.ajax({
            url: route('company.quick.store'),
            type: 'POST',
            data: $(this).serialize(),
            success: function (result) {
                if (result.success) {
                    displaySuccessMessage(result.message);
                    $('#createCompanyModal').modal('hide');
                    var data = {
                        id: result.data.id,
                        text: result.data.name,
                    };
                    var newOption = new Option(data.text, data.id, false, true);
                    $('#companyId').append(newOption).trigger('change');
                }
            },
            error: function (result) {
                var msg =
                    (result.responseJSON &&
                        (result.responseJSON.message ||
                            (result.responseJSON.errors &&
                                Object.values(result.responseJSON.errors)[0][0]))) ||
                    'Unable to create company';
                displayErrorMessage(msg);
            },
            complete: function () {
                processingBtn('#createCompanyQuickForm', '#companyQuickBtnSave');
            },
        });

        return false;
    });
})();
