@php
    $existingRoles = isset($job) ? $job->roles : collect();
    if ($existingRoles->isEmpty()) {
        $existingRoles = collect([(object) ['title' => '', 'requirements' => '']]);
    }
@endphp
<div class="col-12 mb-5">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <label class="form-label mb-1">Positions / Roles</label>
            <div class="text-muted fs-7">Add multiple positions in one job post (optional).</div>
        </div>
        <button type="button" class="btn btn-sm btn-light-primary" id="addJobRoleRow">
            <i class="fa fa-plus me-1"></i> Add position
        </button>
    </div>
    <div id="jobRolesContainer">
        @foreach ($existingRoles as $index => $role)
            <div class="job-role-row border rounded p-4 mb-3 bg-light">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <strong class="job-role-label">Position {{ $index + 1 }}</strong>
                    <button type="button" class="btn btn-sm btn-light-danger remove-job-role-row" title="Remove">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
                <div class="mb-3">
                    <label class="form-label">Position title</label>
                    <input type="text" name="roles[{{ $index }}][title]" class="form-control"
                           value="{{ old('roles.'.$index.'.title', $role->title ?? '') }}"
                           placeholder="e.g. Intern Consultant">
                </div>
                <div>
                    <label class="form-label">Qualifications &amp; Requirements</label>
                    <textarea name="roles[{{ $index }}][requirements]" class="form-control" rows="3"
                              placeholder="Degree, experience, skills...">{{ old('roles.'.$index.'.requirements', $role->requirements ?? '') }}</textarea>
                </div>
            </div>
        @endforeach
    </div>
</div>

<template id="jobRoleRowTemplate">
    <div class="job-role-row border rounded p-4 mb-3 bg-light">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <strong class="job-role-label">Position __INDEX_DISPLAY__</strong>
            <button type="button" class="btn btn-sm btn-light-danger remove-job-role-row" title="Remove">
                <i class="fa fa-trash"></i>
            </button>
        </div>
        <div class="mb-3">
            <label class="form-label">Position title</label>
            <input type="text" name="roles[__INDEX__][title]" class="form-control"
                   placeholder="e.g. Intern Consultant">
        </div>
        <div>
            <label class="form-label">Qualifications &amp; Requirements</label>
            <textarea name="roles[__INDEX__][requirements]" class="form-control" rows="3"
                      placeholder="Degree, experience, skills..."></textarea>
        </div>
    </div>
</template>
