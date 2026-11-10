@php
    $title = html_entity_decode($job->job_title ?? '');
    $companyName = $job->company->user->full_name ?? ($job->company->user->first_name ?? 'Company');
    $location = !empty($job->full_location) ? $job->full_location : 'Location not available';
    $category = $job->jobCategory->name ?? '';
    $shift = $job->jobShift->shift ?? null;
    $skill = $job->jobsSkill[0]->name ?? null;
    $skillExtra = max(0, ($job->jobsSkill->count() ?? 0) - 1);
@endphp
<a href="{{ route('front.job.details', $job->job_id) }}" class="nasira-job-item">
    <span class="nasira-job-logo">
        <img src="{{ $job->company->company_url }}" alt="" />
    </span>
    <span class="nasira-job-main">
        <span class="nasira-job-top">
            <strong class="nasira-job-title" title="{{ $title }}">{{ Str::limit($title, 42, '...') }}</strong>
            @if ($job->activeFeatured)
                <span class="nasira-job-badge">Featured</span>
            @endif
        </span>
        <span class="nasira-job-company">{{ $companyName }}</span>
        <span class="nasira-job-meta">
            @if ($category)
                <span><i class="fa-solid fa-briefcase"></i> {{ $category }}</span>
            @endif
            <span><i class="fa-solid fa-location-dot"></i> {{ Str::limit($location, 36, '...') }}</span>
            @if ($shift)
                <span><i class="fa-solid fa-clock"></i> {{ $shift }}</span>
            @endif
        </span>
        @if ($skill)
            <span class="nasira-job-tags">
                <span>{{ $skill }}</span>
                @if ($skillExtra > 0)
                    <span>+{{ $skillExtra }}</span>
                @endif
            </span>
        @endif
    </span>
    <span class="nasira-job-go">
        View <i class="fa-solid fa-arrow-right"></i>
    </span>
</a>
