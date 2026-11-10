(function () {
  const root = document.getElementById('ncvEditor');
  if (!root) return;

  const paper = document.getElementById('ncvPaper');
  const initial = JSON.parse(document.getElementById('ncvInitialContent').textContent || '{}');
  const state = {
    content: normalize(initial),
    settings: {
      accent_color: document.getElementById('ncvAccent')?.value || '#006837',
      show_photo: document.getElementById('ncvShowPhoto')?.checked ?? true,
    },
  };

  function normalize(data) {
    return {
      full_name: data.full_name || '',
      title: data.title || '',
      email: data.email || '',
      phone: data.phone || '',
      location: data.location || '',
      summary: data.summary || '',
      skills: Array.isArray(data.skills) ? data.skills : [],
      languages: Array.isArray(data.languages) ? data.languages : [],
      experience: Array.isArray(data.experience) ? data.experience : [],
      education: Array.isArray(data.education) ? data.education : [],
      links: Array.isArray(data.links) ? data.links : [],
    };
  }

  function escapeHtml(str) {
    return String(str || '')
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  function initials(name) {
    return String(name || '')
      .trim()
      .split(/\s+/)
      .filter(Boolean)
      .slice(0, 2)
      .map((p) => p[0]?.toUpperCase() || '')
      .join('') || 'CV';
  }

  function renderPaper() {
    const c = state.content;
    paper.querySelectorAll('[data-field]').forEach((el) => {
      el.textContent = c[el.getAttribute('data-field')] || '';
    });

    paper.querySelectorAll('[data-initials]').forEach((el) => {
      el.textContent = initials(c.full_name);
    });

    paper.querySelectorAll('[data-list="skills"]').forEach((ul) => {
      ul.innerHTML = (c.skills || []).map((s) => `<li>${escapeHtml(s)}</li>`).join('');
    });
    paper.querySelectorAll('[data-list="languages"]').forEach((ul) => {
      ul.innerHTML = (c.languages || []).map((s) => `<li>${escapeHtml(s)}</li>`).join('');
    });
    paper.querySelectorAll('[data-list="links"]').forEach((ul) => {
      ul.innerHTML = (c.links || []).map((s) => `<li>${escapeHtml(s)}</li>`).join('');
    });

    // Hide empty contact dots
    paper.querySelectorAll('.ncv-contact-inline').forEach((row) => {
      const parts = Array.from(row.querySelectorAll('[data-field]'));
      parts.forEach((span, idx) => {
        const empty = !(span.textContent || '').trim();
        span.style.display = empty ? 'none' : '';
        const dot = span.nextElementSibling;
        if (dot && dot.classList.contains('ncv-dot')) {
          const next = parts[idx + 1];
          const nextEmpty = !next || !(next.textContent || '').trim();
          dot.style.display = empty || nextEmpty ? 'none' : '';
        }
      });
    });

    const exp = paper.querySelector('[data-entries="experience"]');
    if (exp) {
      exp.innerHTML = (c.experience || [])
        .map(
          (item) => `<article class="ncv-item">
            <div class="ncv-item-top">
              <h3>${escapeHtml(item.title)}</h3>
              <span class="dates">${escapeHtml(item.dates)}</span>
            </div>
            <div class="meta">${escapeHtml(item.company)}</div>
            <p>${escapeHtml(item.description)}</p>
          </article>`
        )
        .join('');
    }

    const edu = paper.querySelector('[data-entries="education"]');
    if (edu) {
      edu.innerHTML = (c.education || [])
        .map(
          (item) => `<article class="ncv-item">
            <div class="ncv-item-top">
              <h3>${escapeHtml(item.degree)}</h3>
              <span class="dates">${escapeHtml(item.year)}</span>
            </div>
            <div class="meta">${escapeHtml(item.school)}</div>
            <p>${escapeHtml(item.details)}</p>
          </article>`
        )
        .join('');
    }

    paper.style.setProperty('--ncv-accent', state.settings.accent_color);
    paper.querySelectorAll('[data-photo]').forEach((el) => {
      el.classList.toggle('is-on', !!state.settings.show_photo);
    });
  }

  function bindScalars() {
    root.querySelectorAll('[data-bind]').forEach((input) => {
      const key = input.getAttribute('data-bind');
      input.value = state.content[key] || '';
      input.addEventListener('input', () => {
        state.content[key] = input.value;
        renderPaper();
      });
    });
  }

  function csv(arr) {
    return (arr || []).join(', ');
  }

  function parseCsv(text) {
    return String(text || '')
      .split(',')
      .map((s) => s.trim())
      .filter(Boolean);
  }

  function parseLines(text) {
    return String(text || '')
      .split(/\r?\n/)
      .map((s) => s.trim())
      .filter(Boolean);
  }

  function renderExpForms() {
    const wrap = document.getElementById('ncvExpList');
    wrap.innerHTML = state.content.experience
      .map(
        (item, i) => `<div class="ncv-entry" data-exp="${i}">
        <label class="ncv-label">Job title<input data-exp-field="title" value="${escapeHtml(item.title)}"></label>
        <label class="ncv-label">Company<input data-exp-field="company" value="${escapeHtml(item.company)}"></label>
        <label class="ncv-label">Dates<input data-exp-field="dates" value="${escapeHtml(item.dates)}"></label>
        <label class="ncv-label">Highlights<textarea data-exp-field="description" rows="3">${escapeHtml(item.description)}</textarea></label>
        <div class="ncv-entry-actions"><button type="button" data-remove-exp="${i}">Remove</button></div>
      </div>`
      )
      .join('');
  }

  function renderEduForms() {
    const wrap = document.getElementById('ncvEduList');
    wrap.innerHTML = state.content.education
      .map(
        (item, i) => `<div class="ncv-entry" data-edu="${i}">
        <label class="ncv-label">Degree / qualification<input data-edu-field="degree" value="${escapeHtml(item.degree)}"></label>
        <label class="ncv-label">School / university<input data-edu-field="school" value="${escapeHtml(item.school)}"></label>
        <label class="ncv-label">Year<input data-edu-field="year" value="${escapeHtml(item.year)}"></label>
        <label class="ncv-label">Details<input data-edu-field="details" value="${escapeHtml(item.details)}"></label>
        <div class="ncv-entry-actions"><button type="button" data-remove-edu="${i}">Remove</button></div>
      </div>`
      )
      .join('');
  }

  // Tabs
  root.querySelectorAll('.ncv-tabs button').forEach((btn) => {
    btn.addEventListener('click', () => {
      root.querySelectorAll('.ncv-tabs button').forEach((b) => b.classList.remove('is-active'));
      root.querySelectorAll('.ncv-tab-pane').forEach((p) => p.classList.remove('is-active'));
      btn.classList.add('is-active');
      root.querySelector(`.ncv-tab-pane[data-pane="${btn.dataset.tab}"]`)?.classList.add('is-active');
    });
  });

  document.getElementById('ncvSkills').value = csv(state.content.skills);
  document.getElementById('ncvLanguages').value = csv(state.content.languages);
  document.getElementById('ncvLinks').value = (state.content.links || []).join('\n');

  document.getElementById('ncvSkills').addEventListener('input', (e) => {
    state.content.skills = parseCsv(e.target.value);
    renderPaper();
  });
  document.getElementById('ncvLanguages').addEventListener('input', (e) => {
    state.content.languages = parseCsv(e.target.value);
    renderPaper();
  });
  document.getElementById('ncvLinks').addEventListener('input', (e) => {
    state.content.links = parseLines(e.target.value);
    renderPaper();
  });

  document.getElementById('ncvAccent').addEventListener('input', (e) => {
    state.settings.accent_color = e.target.value;
    renderPaper();
  });
  document.getElementById('ncvShowPhoto').addEventListener('change', (e) => {
    state.settings.show_photo = e.target.checked;
    renderPaper();
  });

  document.getElementById('ncvAddExp').addEventListener('click', () => {
    state.content.experience.push({
      title: 'New role',
      company: 'Company',
      dates: '2024 – Present',
      description: 'Describe impact, ownership, and results.',
    });
    renderExpForms();
    renderPaper();
  });

  document.getElementById('ncvAddEdu').addEventListener('click', () => {
    state.content.education.push({
      degree: 'Degree',
      school: 'Institution',
      year: '2024',
      details: '',
    });
    renderEduForms();
    renderPaper();
  });

  document.getElementById('ncvExpList').addEventListener('input', (e) => {
    const field = e.target.getAttribute('data-exp-field');
    const entry = e.target.closest('[data-exp]');
    if (!field || !entry) return;
    state.content.experience[Number(entry.getAttribute('data-exp'))][field] = e.target.value;
    renderPaper();
  });

  document.getElementById('ncvExpList').addEventListener('click', (e) => {
    const btn = e.target.closest('[data-remove-exp]');
    if (!btn) return;
    state.content.experience.splice(Number(btn.getAttribute('data-remove-exp')), 1);
    renderExpForms();
    renderPaper();
  });

  document.getElementById('ncvEduList').addEventListener('input', (e) => {
    const field = e.target.getAttribute('data-edu-field');
    const entry = e.target.closest('[data-edu]');
    if (!field || !entry) return;
    state.content.education[Number(entry.getAttribute('data-edu'))][field] = e.target.value;
    renderPaper();
  });

  document.getElementById('ncvEduList').addEventListener('click', (e) => {
    const btn = e.target.closest('[data-remove-edu]');
    if (!btn) return;
    state.content.education.splice(Number(btn.getAttribute('data-remove-edu')), 1);
    renderEduForms();
    renderPaper();
  });

  document.getElementById('ncvDownloadBtn').addEventListener('click', () => {
    if (typeof html2pdf === 'undefined') {
      alert('PDF library failed to load. Please refresh and try again.');
      return;
    }
    const name = (state.content.full_name || 'cv').replace(/\s+/g, '-').toLowerCase();
    html2pdf()
      .set({
        margin: 0,
        filename: name + '-cv.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true, backgroundColor: '#ffffff' },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
        pagebreak: { mode: ['avoid-all', 'css', 'legacy'] },
      })
      .from(paper)
      .save();
  });

  document.getElementById('ncvSaveBtn').addEventListener('click', async () => {
    if (root.dataset.canSave !== '1') {
      window.location.href = root.dataset.loginUrl;
      return;
    }
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    const payload = {
      cv_template_id: Number(root.dataset.templateId),
      title: document.getElementById('ncvDesignTitle').value || 'My Professional CV',
      content: state.content,
      settings: state.settings,
      design_id: root.dataset.designId || null,
      is_default: true,
    };

    try {
      const res = await fetch(root.dataset.saveUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
          'X-CSRF-TOKEN': token,
        },
        body: JSON.stringify(payload),
      });
      const json = await res.json();
      if (!res.ok) {
        alert(json.message || 'Could not save CV design.');
        return;
      }
      if (json.data?.id) root.dataset.designId = json.data.id;
      alert(json.message || 'Saved.');
    } catch (err) {
      alert('Save failed. Please try again.');
    }
  });

  bindScalars();
  renderExpForms();
  renderEduForms();
  renderPaper();
})();
