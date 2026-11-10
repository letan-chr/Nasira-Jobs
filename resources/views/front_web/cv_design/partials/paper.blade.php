<div id="ncvPaper"
    class="ncv-paper layout-{{ $template->layout }}"
    data-layout="{{ $template->layout }}"
    style="--ncv-accent: {{ $settings['accent_color'] ?? $template->accent_color }}; --ncv-secondary: {{ $template->secondary_color ?? $template->accent_color }};">

    <aside class="ncv-side" data-side>
        <div class="ncv-photo" data-photo aria-hidden="true">
            <span data-initials>AJ</span>
        </div>
        <div class="ncv-side-identity">
            <strong data-field="full_name"></strong>
            <em data-field="title"></em>
        </div>
        <div class="ncv-side-block">
            <h4>Contact</h4>
            <ul class="ncv-contact-list">
                <li><span>Email</span><strong data-field="email"></strong></li>
                <li><span>Phone</span><strong data-field="phone"></strong></li>
                <li><span>Location</span><strong data-field="location"></strong></li>
            </ul>
        </div>
        <div class="ncv-side-block">
            <h4>Skills</h4>
            <ul class="ncv-chips" data-list="skills"></ul>
        </div>
        <div class="ncv-side-block">
            <h4>Languages</h4>
            <ul class="ncv-chips" data-list="languages"></ul>
        </div>
        <div class="ncv-side-block">
            <h4>Links</h4>
            <ul class="ncv-links" data-list="links"></ul>
        </div>
    </aside>

    <div class="ncv-main">
        <header class="ncv-paper-header">
            <div class="ncv-photo ncv-photo-inline" data-photo aria-hidden="true">
                <span data-initials>AJ</span>
            </div>
            <div class="ncv-header-text">
                <h1 data-field="full_name"></h1>
                <p class="ncv-role" data-field="title"></p>
                <p class="ncv-contact-inline">
                    <span data-field="email"></span>
                    <span class="ncv-dot" aria-hidden="true"></span>
                    <span data-field="phone"></span>
                    <span class="ncv-dot" aria-hidden="true"></span>
                    <span data-field="location"></span>
                </p>
            </div>
        </header>

        <section class="ncv-section">
            <h2><span>Professional Summary</span></h2>
            <p class="ncv-summary" data-field="summary"></p>
        </section>

        <section class="ncv-section">
            <h2><span>Experience</span></h2>
            <div class="ncv-entries" data-entries="experience"></div>
        </section>

        <section class="ncv-section">
            <h2><span>Education</span></h2>
            <div class="ncv-entries" data-entries="education"></div>
        </section>

        <section class="ncv-section ncv-section-main-skills">
            <h2><span>Skills</span></h2>
            <ul class="ncv-chips" data-list="skills"></ul>
        </section>

        <section class="ncv-section ncv-section-main-langs">
            <h2><span>Languages</span></h2>
            <ul class="ncv-chips" data-list="languages"></ul>
        </section>
    </div>
</div>
