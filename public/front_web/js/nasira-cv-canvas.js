(function () {
  const root = document.getElementById('ncvCanvasApp');
  if (!root || typeof grapesjs === 'undefined') return;

  function parseJsonAttr(name, fallback) {
    try {
      const raw = root.getAttribute(name);
      if (raw == null || raw === '') return fallback;
      return JSON.parse(raw);
    } catch (e) {
      return fallback;
    }
  }

  const initialHtml = parseJsonAttr('data-html', '') || '';
  const initialCss = parseJsonAttr('data-css', '') || '';
  const projectJson = parseJsonAttr('data-project', null);
  let zoom = 55;
  const A4_W = 794;
  const A4_H = 1123;

  const statusEl = document.getElementById('ncvStatus');
  const formatBar = document.getElementById('ncvFormatBar');
  const setStatus = (msg) => {
    if (statusEl) statusEl.textContent = msg || 'Editing';
  };

  const TEXT_PRESETS = {
    heading:
      '<div data-gjs-type="text" style="font-family:DM Sans,Arial,sans-serif;font-size:36px;font-weight:700;color:#006837;line-height:1.1;letter-spacing:-0.02em;">Your Full Name</div>',
    subheading:
      '<div data-gjs-type="text" style="font-family:DM Sans,Arial,sans-serif;font-size:15px;font-weight:700;color:#F37021;">Job Title</div>',
    body:
      '<div data-gjs-type="text" style="font-family:DM Sans,Arial,sans-serif;font-size:13px;line-height:1.6;color:#374151;max-width:520px;">Click to edit this paragraph. Keep it clear, specific, and achievement-focused.</div>',
    label:
      '<div data-gjs-type="text" style="font-family:DM Sans,Arial,sans-serif;font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#006837;border-bottom:2px solid #006837;padding:0 0 7px;margin:0 0 10px;font-weight:700;display:inline-block;min-width:140px;">Experience</div>',
  };

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
  let latestPhotoUrl = '';

  const editor = grapesjs.init({
    container: '#ncvGjs',
    height: '100%',
    width: 'auto',
    fromElement: false,
    storageManager: false,
    noticeOnUnload: false,
    showOffsets: true,
    showOffsetsSelected: true,
    assetManager: {
      upload: root.dataset.uploadUrl,
      uploadName: 'file',
      multiUpload: false,
      autoAdd: true,
      headers: { 'X-CSRF-TOKEN': csrfToken },
      credentials: 'same-origin',
    },
    canvas: {
      styles: [
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&family=Libre+Baskerville:wght@400;700&display=swap',
      ],
      scripts: [],
    },
    canvasCss: `
      html,body{margin:0;padding:0;background:#fff;}
      .cv-page{
        box-sizing:border-box!important;
        width:794px!important;
        max-width:794px!important;
        height:1123px!important;
        min-height:1123px!important;
        max-height:1123px!important;
        overflow:hidden!important;
        margin:0 auto!important;
        background:#fff;
      }
      .cv-layout{height:1123px!important;min-height:1123px!important;}
      .cv-side,.cv-main{height:100%!important;min-height:100%!important;overflow:hidden;}
      .cv-side,.cv-main,.cv-band,.cv-body,.cv-card,.cv-section{overflow:hidden;}
      .cv-avatar,img.cv-avatar{object-fit:cover!important;border-radius:50%!important;}
      .cv-side, .cv-main, .cv-band, .cv-body, .cv-card, .cv-page, .cv-top, .cv-inner, .cv-section {
        outline-offset: 2px;
      }
    `,
    deviceManager: {
      devices: [{ id: 'a4', name: 'A4', width: '794px', height: '1123px', widthMedia: '794px' }],
    },
    panels: { defaults: [] },
    blockManager: { appendTo: '#ncvBlocksElements' },
    layerManager: { appendTo: '#ncvLayers' },
    selectorManager: { componentFirst: true },
    styleManager: {
      appendTo: '#ncvStyles',
      sectors: [
        {
          name: 'Text',
          open: true,
          buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color', 'line-height', 'text-align'],
          properties: [
            {
              property: 'font-family',
              type: 'select',
              defaults: 'DM Sans, Arial, sans-serif',
              options: [
                { value: 'DM Sans, Arial, sans-serif', name: 'DM Sans' },
                { value: 'Cormorant Garamond, Georgia, serif', name: 'Cormorant' },
                { value: 'Libre Baskerville, Georgia, serif', name: 'Baskerville' },
                { value: 'IBM Plex Mono, Courier New, monospace', name: 'Mono' },
                { value: 'Arial, Helvetica, sans-serif', name: 'Arial' },
              ],
            },
          ],
        },
        {
          name: 'Size & spacing',
          open: true,
          buildProps: ['width', 'height', 'max-width', 'padding', 'margin'],
        },
        {
          name: 'Fill & border',
          open: true,
          buildProps: ['background-color', 'border-radius', 'border', 'box-shadow', 'opacity'],
        },
        {
          name: 'Layout',
          open: false,
          buildProps: [
            'display',
            'flex-direction',
            'justify-content',
            'align-items',
            'gap',
            'position',
            'top',
            'left',
            'right',
            'bottom',
            'z-index',
          ],
        },
      ],
    },
    traitManager: { appendTo: '#ncvTraits' },
    richTextEditor: {
      actions: ['bold', 'italic', 'underline', 'strikethrough', 'link'],
    },
  });

  const bm = editor.BlockManager;

  const elementBlocks = [
    {
      id: 'cv-experience',
      label: 'Experience',
      media: '<div style="font-size:18px">💼</div>',
      category: 'Resume',
      content:
        '<div style="margin:0 0 14px;font-family:DM Sans,Arial,sans-serif;max-width:520px;">' +
        '<table width="100%" style="width:100%;border-collapse:collapse;"><tr>' +
        '<td style="vertical-align:top;"><div data-gjs-type="text" style="font-size:14px;font-weight:700;color:#111827;">Role Title</div>' +
        '<div data-gjs-type="text" style="font-size:12px;color:#6b7280;margin:3px 0 6px;font-weight:600;">Company · Full-time</div></td>' +
        '<td style="vertical-align:top;text-align:right;"><div data-gjs-type="text" style="font-size:11px;font-weight:700;color:#006837;">2023 – Present</div></td>' +
        '</tr></table>' +
        '<ul style="margin:0;padding-left:16px;font-size:12.5px;line-height:1.55;color:#374151;">' +
        '<li data-gjs-type="text">Achievement with a measurable result.</li>' +
        '<li data-gjs-type="text">Second highlight showing ownership.</li>' +
        '</ul></div>',
    },
    {
      id: 'cv-education',
      label: 'Education',
      media: '<div style="font-size:18px">🎓</div>',
      category: 'Resume',
      content:
        '<div style="margin:0 0 12px;font-family:DM Sans,Arial,sans-serif;max-width:520px;">' +
        '<table width="100%" style="width:100%;border-collapse:collapse;"><tr>' +
        '<td><div data-gjs-type="text" style="font-size:14px;font-weight:700;">Degree Name</div>' +
        '<div data-gjs-type="text" style="font-size:12px;color:#6b7280;font-weight:600;">University · Details</div></td>' +
        '<td style="text-align:right;"><div data-gjs-type="text" style="font-size:11px;font-weight:700;color:#006837;">2019</div></td>' +
        '</tr></table></div>',
    },
    {
      id: 'cv-skills',
      label: 'Skill chips',
      media: '<div style="font-size:18px">✦</div>',
      category: 'Resume',
      content:
        '<div style="font-family:DM Sans,Arial,sans-serif;">' +
        '<span data-gjs-type="text" style="display:inline-block;background:rgba(0,104,55,.1);color:#006837;border:1px solid rgba(0,104,55,.18);border-radius:999px;padding:5px 11px;font-size:11px;font-weight:700;margin:0 6px 7px 0;">Skill</span>' +
        '<span data-gjs-type="text" style="display:inline-block;background:rgba(0,104,55,.1);color:#006837;border:1px solid rgba(0,104,55,.18);border-radius:999px;padding:5px 11px;font-size:11px;font-weight:700;margin:0 6px 7px 0;">Skill</span>' +
        '<span data-gjs-type="text" style="display:inline-block;background:rgba(0,104,55,.1);color:#006837;border:1px solid rgba(0,104,55,.18);border-radius:999px;padding:5px 11px;font-size:11px;font-weight:700;margin:0 6px 7px 0;">Skill</span>' +
        '</div>',
    },
    {
      id: 'cv-avatar',
      label: 'Profile photo',
      media: '<div style="font-size:18px">●</div>',
      category: 'Resume',
      content: {
        type: 'image',
        name: 'Profile photo',
        attributes: {
          src: 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxOTIiIGhlaWdodD0iMTkyIj48ZGVmcz48bGluZWFyR3JhZGllbnQgaWQ9ImciIHgxPSIwIiB5MT0iMCIgeDI9IjEiIHkyPSIxIj48c3RvcCBzdG9wLWNvbG9yPSIjRjM3MDIxIi8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjMDA2ODM3Ii8+PC9saW5lYXJHcmFkaWVudD48L2RlZnM+PHJlY3Qgd2lkdGg9IjE5MiIgaGVpZ2h0PSIxOTIiIGZpbGw9InVybCgjZykiLz48dGV4dCB4PSI5NiIgeT0iMTEwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjZmZmIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iNjQiIGZvbnQtd2VpZ2h0PSI3MDAiPkFKPC90ZXh0Pjwvc3ZnPg==',
          alt: 'Profile photo',
          class: 'cv-avatar',
        },
        style: {
          width: '96px',
          height: '96px',
          'border-radius': '50%',
          'object-fit': 'cover',
          display: 'block',
          margin: '0 auto 16px',
        },
      },
    },
    {
      id: 'cv-header-band',
      label: 'Header band',
      media: '<div style="font-size:18px">▬</div>',
      category: 'Layout',
      content:
        '<div style="background:#006837;color:#fff;padding:30px 34px;font-family:DM Sans,Arial,sans-serif;width:100%;">' +
        '<div data-gjs-type="text" style="font-size:36px;font-weight:700;line-height:1.1;letter-spacing:-0.02em;">Your Full Name</div>' +
        '<div data-gjs-type="text" style="font-size:15px;font-weight:700;margin:8px 0;opacity:.95;">Job Title</div>' +
        '<div data-gjs-type="text" style="font-size:12px;opacity:.9;">email@example.com · phone · location</div></div>',
    },
    {
      id: 'cv-two-col',
      label: 'Sidebar layout',
      media: '<div style="font-size:18px">▥</div>',
      category: 'Layout',
      content:
        '<div data-gjs-name="Layout" data-gjs-selectable="false" data-gjs-hoverable="false" data-gjs-highlightable="false" style="display:flex;min-height:420px;width:100%;font-family:DM Sans,Arial,sans-serif;">' +
        '<aside data-gjs-name="Sidebar" data-gjs-droppable="true" class="cv-side" style="flex:0 0 34%;width:34%;box-sizing:border-box;padding:24px 18px;background:#0f766e;color:#fff;">' +
        '<div data-gjs-type="text" style="font-weight:700;margin-bottom:8px;font-size:16px;">Sidebar</div>' +
        '<div data-gjs-type="text" style="font-size:12px;opacity:.95;line-height:1.5;">Contact, skills, languages</div></aside>' +
        '<main data-gjs-name="Main" data-gjs-droppable="true" class="cv-main" style="flex:1 1 0;min-width:0;box-sizing:border-box;padding:26px;">' +
        '<div data-gjs-type="text" style="font-weight:700;margin-bottom:8px;font-size:16px;">Main content</div>' +
        '<div data-gjs-type="text" style="font-size:13px;color:#374151;line-height:1.55;">Experience and education go here.</div></main></div>',
    },
    {
      id: 'cv-divider',
      label: 'Divider',
      media: '<div style="font-size:18px">—</div>',
      category: 'Layout',
      content: '<div style="height:2px;width:100%;background:#006837;margin:12px 0;border-radius:2px;"></div>',
    },
    {
      id: 'cv-accent-bar',
      label: 'Accent bar',
      media: '<div style="font-size:18px">▮</div>',
      category: 'Layout',
      content:
        '<div style="width:10px;min-height:180px;background:linear-gradient(180deg,#006837,#F37021);border-radius:0;"></div>',
    },
    {
      id: 'cv-card',
      label: 'Card',
      media: '<div style="font-size:18px">□</div>',
      category: 'Layout',
      content:
        '<div style="padding:18px;border:1px solid #e5e7eb;border-radius:14px;background:#fff;font-family:DM Sans,Arial,sans-serif;box-shadow:0 8px 20px rgba(15,23,20,.06);max-width:420px;">' +
        '<div data-gjs-type="text" style="font-weight:700;margin-bottom:6px;">Card title</div>' +
        '<div data-gjs-type="text" style="font-size:13px;color:#4b5563;line-height:1.5;">Card body text</div></div>',
    },
    {
      id: 'cv-image',
      label: 'Image',
      media: '<div style="font-size:18px">🖼</div>',
      category: 'Media',
      content: { type: 'image', style: { width: '120px', height: 'auto', 'border-radius': '8px' } },
    },
    {
      id: 'cv-shape',
      label: 'Accent shape',
      media: '<div style="font-size:18px">◼</div>',
      category: 'Media',
      content:
        '<div style="width:160px;height:16px;background:linear-gradient(90deg,#006837,#F37021);border-radius:999px;"></div>',
    },
  ];

  elementBlocks.forEach((b) => bm.add(b.id, b));

  function loadStarter() {
    if (projectJson && typeof projectJson === 'object' && Object.keys(projectJson).length) {
      editor.loadProjectData(projectJson);
      return;
    }
    editor.setComponents(
      initialHtml ||
        `<div class="cv-page" style="box-sizing:border-box;width:${A4_W}px;height:${A4_H}px;margin:0 auto;background:#fff;padding:36px;font-family:DM Sans,Arial,sans-serif;overflow:hidden;"><div data-gjs-type="text" style="font-size:36px;font-weight:700;color:#006837;">Your Name</div></div>`
    );
    editor.setStyle(initialCss || '');
  }

  function applyZoom() {
    const scale = Math.max(0.35, Math.min(1, zoom / 100));

    if (typeof editor.Canvas.setZoom === 'function') {
      editor.Canvas.setZoom(100);
    }

    const frame = editor.Canvas.getFrameEl();
    const wrap = frame?.parentElement; // .gjs-frame-wrapper
    const frames = wrap?.parentElement; // .gjs-cv-canvas__frames

    if (frame) {
      frame.style.width = `${A4_W}px`;
      frame.style.height = `${A4_H}px`;
      frame.style.display = 'block';
      frame.style.visibility = 'visible';
      frame.style.opacity = '1';
    }

    if (wrap) {
      wrap.style.width = `${A4_W}px`;
      wrap.style.height = `${A4_H}px`;
      wrap.style.display = 'block';
      wrap.style.visibility = 'visible';
      wrap.style.opacity = '1';
      wrap.style.transform = `scale(${scale})`;
      wrap.style.transformOrigin = 'top center';
      // Collapse unused layout height after scale so it doesn't push/overflow
      wrap.style.margin = `0 auto ${Math.round((scale - 1) * A4_H)}px`;
    }

    if (frames) {
      frames.style.width = '100%';
      frames.style.height = '';
      frames.style.minWidth = '';
      frames.style.minHeight = '100%';
      frames.style.maxWidth = '';
      frames.style.maxHeight = '';
      frames.style.overflow = 'visible';
      frames.style.display = 'flex';
      frames.style.justifyContent = 'center';
      frames.style.alignItems = 'flex-start';
      frames.style.padding = '36px 24px 96px';
      frames.style.boxSizing = 'border-box';
    }

    const label = document.getElementById('ncvZoomLabel');
    if (label) label.textContent = `${Math.round(scale * 100)}%`;
  }

  function fitZoomToDesk() {
    const desk = document.querySelector('.canva-desk-scroll') || document.querySelector('.canva-desk');
    if (!desk) {
      zoom = 55;
      applyZoom();
      return;
    }
    const pad = 80;
    const availW = Math.max(280, desk.clientWidth - pad);
    const availH = Math.max(320, desk.clientHeight - pad);
    const byW = (availW / A4_W) * 100;
    const byH = (availH / A4_H) * 100;
    zoom = Math.max(40, Math.min(85, Math.floor(Math.min(byW, byH))));
    applyZoom();
  }

  function selected() {
    return editor.getSelected();
  }

  function showFormatBar(show) {
    formatBar?.classList.toggle('is-visible', !!show);
  }

  function appendHtml(html) {
    const wrapper = editor.getWrapper();
    const page = wrapper.find('.cv-page')[0] || wrapper;
    page.append(html);
    const added = page.components().last();
    if (added) editor.select(added);
    setStatus('Element added');
  }

  function findByName(name) {
    const all = editor.getWrapper().find('*');
    const needle = String(name).toLowerCase();
    return (
      all.find((c) => String(c.getName?.() || c.get('name') || '').toLowerCase() === needle) ||
      all.find((c) => String(c.getAttributes()?.['data-gjs-name'] || '').toLowerCase() === needle) ||
      all.find((c) => {
        const n = String(c.getName?.() || c.get('name') || c.getAttributes()?.['data-gjs-name'] || '').toLowerCase();
        return n.includes(needle);
      })
    );
  }

  function findByClass(cls) {
    return editor.getWrapper().find(`.${cls}`)[0];
  }

  function selectSection(key) {
    let comp = null;
    const k = String(key).toLowerCase();
    if (k === 'card') {
      comp = findByName('Header card') || findByName('About card') || findByClass('cv-card');
    } else if (k === 'sidebar') {
      comp = findByName('Sidebar') || findByClass('cv-side');
    } else if (k === 'main') {
      comp = findByName('Main') || findByName('Main content') || findByClass('cv-main') || findByClass('cv-body') || findByClass('cv-inner');
    } else if (k === 'header') {
      comp = findByName('Header') || findByName('Header card') || findByClass('cv-band') || findByClass('cv-top');
    } else if (k === 'cv page' || k === 'page') {
      comp = findByName('CV Page') || findByClass('cv-page') || editor.getWrapper();
    } else {
      comp = findByName(key);
    }
    if (comp) {
      editor.select(comp);
      setStatus(`${comp.getName?.() || key} selected`);
      return true;
    }
    setStatus(`${key} not in this template`);
    return false;
  }

  function refreshSectionButtons() {
    const names = editor
      .getWrapper()
      .find('*')
      .map((c) => String(c.getName?.() || c.get('name') || c.getAttributes()?.['data-gjs-name'] || '').toLowerCase());
    document.querySelectorAll('#ncvSectionPick [data-section]').forEach((btn) => {
      const key = btn.getAttribute('data-section').toLowerCase();
      let available = false;
      if (key === 'card') available = names.some((n) => n.includes('card')) || !!findByClass('cv-card');
      else if (key === 'sidebar') available = names.includes('sidebar') || !!findByClass('cv-side');
      else if (key === 'main') available = names.includes('main') || names.includes('main content') || !!findByClass('cv-main') || !!findByClass('cv-body');
      else if (key === 'header') available = names.includes('header') || names.includes('header card') || !!findByClass('cv-band') || !!findByClass('cv-top');
      else available = true;
      btn.style.display = available ? '' : 'none';
      btn.classList.remove('is-active');
    });
  }

  editor.on('load', () => {
    setStatus('Editing');
    const body = editor.Canvas.getBody();
    if (body) {
      body.style.background = '#ffffff';
      body.style.margin = '0';
      body.style.width = `${A4_W}px`;
      body.style.height = `${A4_H}px`;
      body.style.overflow = 'hidden';
    }
    const frame = editor.Canvas.getFrameEl();
    if (frame) {
      frame.style.width = `${A4_W}px`;
      frame.style.height = `${A4_H}px`;
      frame.style.background = '#fff';
      frame.style.visibility = 'visible';
      frame.style.opacity = '1';
    }
    // Lock page component to exact A4 px
    editor.getWrapper().find('.cv-page').forEach((page) => {
      page.addStyle({
        width: `${A4_W}px`,
        'max-width': `${A4_W}px`,
        height: `${A4_H}px`,
        'min-height': `${A4_H}px`,
        'max-height': `${A4_H}px`,
        overflow: 'hidden',
        'box-sizing': 'border-box',
      });
    });
    // Fit after layout so desk size is known and paper stays visible
    requestAnimationFrame(() => {
      fitZoomToDesk();
      setTimeout(fitZoomToDesk, 50);
    });
    // Ensure region names stick; Layout shell must not steal hover from Sidebar/Main
    editor.getWrapper().find('*').forEach((comp) => {
      const attrs = comp.getAttributes?.() || {};
      const named = attrs['data-gjs-name'];
      const cls = comp.getClasses?.() || [];

      if (cls.includes('cv-layout') || named === 'Layout' || attrs['data-gjs-selectable'] === 'false') {
        comp.set({
          name: 'Layout',
          selectable: false,
          hoverable: false,
          highlightable: false,
          droppable: false,
          layerable: false,
        });
        return;
      }

      if (named) {
        comp.set({ name: named, droppable: true, highlightable: true, selectable: true, hoverable: true });
      }
      if (cls.includes('cv-side')) comp.set({ name: 'Sidebar', droppable: true, selectable: true, hoverable: true, highlightable: true });
      if (cls.includes('cv-main')) comp.set({ name: 'Main', droppable: true, selectable: true, hoverable: true, highlightable: true });
      if (cls.includes('cv-body') || cls.includes('cv-inner')) {
        if (!comp.get('name') || comp.get('name') === 'Div') comp.set({ name: 'Main', droppable: true });
      }
      if (cls.includes('cv-band') || cls.includes('cv-top')) comp.set({ name: 'Header', droppable: true, selectable: true, hoverable: true });
      if (cls.includes('cv-page')) comp.set({ name: 'CV Page', droppable: true, selectable: true, hoverable: true });
      if (cls.includes('cv-card') && !comp.get('name')) comp.set({ name: 'Card', droppable: true });
    });
    refreshSectionButtons();
    applyZoom();
  });

  const selectedLabel = document.getElementById('ncvSelectedLabel');

  editor.on('component:selected', (comp) => {
    showFormatBar(!!comp && !comp.is('wrapper'));
    const label = comp?.getName?.() || comp?.get('name') || comp?.getAttributes()?.['data-gjs-name'] || 'Element';
    if (selectedLabel) selectedLabel.textContent = label;
    document.querySelectorAll('#ncvSectionPick [data-section]').forEach((btn) => {
      const key = btn.getAttribute('data-section').toLowerCase();
      const n = String(label).toLowerCase();
      const active =
        (key === 'card' && n.includes('card')) ||
        (key === 'sidebar' && n.includes('sidebar')) ||
        (key === 'main' && (n === 'main' || n.includes('main content'))) ||
        (key === 'header' && n.includes('header')) ||
        (key === 'cv page' && n.includes('page'));
      btn.classList.toggle('is-active', active);
    });
  });
  editor.on('component:deselected', () => {
    showFormatBar(false);
    if (selectedLabel) selectedLabel.textContent = 'Nothing selected';
  });

  document.getElementById('ncvSectionPick')?.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-section]');
    if (!btn) return;
    selectSection(btn.getAttribute('data-section'));
  });

  loadStarter();
  editor.setDevice('a4');
  // Flow keeps Sidebar / Main / Card as real sections (best for CV redesign)
  editor.setDragMode('');

  document.querySelectorAll('.canva-rail-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.canva-rail-btn').forEach((b) => b.classList.remove('is-active'));
      document.querySelectorAll('.canva-panel-view').forEach((p) => p.classList.remove('is-active'));
      btn.classList.add('is-active');
      document.querySelector(`.canva-panel-view[data-panel-view="${btn.dataset.panel}"]`)?.classList.add('is-active');
    });
  });

  document.querySelectorAll('.canva-inspector-tabs button').forEach((btn) => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.canva-inspector-tabs button').forEach((b) => b.classList.remove('is-active'));
      document.querySelectorAll('.canva-inspector-pane').forEach((p) => p.classList.remove('is-active'));
      btn.classList.add('is-active');
      document.querySelector(`.canva-inspector-pane[data-inspect-view="${btn.dataset.inspect}"]`)?.classList.add('is-active');
    });
  });

  document.getElementById('ncvTextTiles')?.addEventListener('click', (e) => {
    const tile = e.target.closest('[data-text]');
    if (!tile) return;
    const key = tile.getAttribute('data-text');
    if (TEXT_PRESETS[key]) appendHtml(TEXT_PRESETS[key]);
  });

  const freeBtn = document.getElementById('ncvDragFree');
  const flowBtn = document.getElementById('ncvDragFlow');
  freeBtn?.addEventListener('click', () => {
    editor.setDragMode('absolute');
    freeBtn.classList.add('is-active');
    flowBtn?.classList.remove('is-active');
    setStatus('Free position');
  });
  flowBtn?.addEventListener('click', () => {
    editor.setDragMode('');
    flowBtn.classList.add('is-active');
    freeBtn?.classList.remove('is-active');
    setStatus('Flow layout');
  });

  // Alt+↑ selects parent section (text → Sidebar / Main / Card)
  window.addEventListener(
    'keydown',
    (e) => {
      if (e.altKey && e.key === 'ArrowUp') {
        const sel = selected();
        if (sel?.parent?.()) {
          e.preventDefault();
          editor.select(sel.parent());
          setStatus('Parent section selected');
        }
      }
    },
    true
  );

  document.getElementById('ncvZoomIn')?.addEventListener('click', () => {
    zoom = Math.min(125, zoom + 10);
    applyZoom();
  });
  document.getElementById('ncvZoomOut')?.addEventListener('click', () => {
    zoom = Math.max(40, zoom - 10);
    applyZoom();
  });
  document.getElementById('ncvZoomFit')?.addEventListener('click', () => {
    fitZoomToDesk();
  });
  window.addEventListener('resize', () => {
    // keep current zoom unless user hits Fit
  });

  document.getElementById('ncvUndo')?.addEventListener('click', () => editor.UndoManager.undo());
  document.getElementById('ncvRedo')?.addEventListener('click', () => editor.UndoManager.redo());

  document.getElementById('ncvDuplicate')?.addEventListener('click', () => {
    const sel = selected();
    if (!sel || sel.is('wrapper')) return;
    const cloned = sel.clone();
    sel.parent()?.append(cloned);
    editor.select(cloned);
  });

  document.getElementById('ncvDelete')?.addEventListener('click', () => {
    const sel = selected();
    if (!sel || sel.is('wrapper')) return;
    sel.remove();
    showFormatBar(false);
  });

  document.getElementById('ncvBringFront')?.addEventListener('click', () => {
    const sel = selected();
    if (!sel) return;
    const z = parseInt(sel.getStyle()['z-index'] || '1', 10) || 1;
    sel.addStyle({ 'z-index': String(z + 1) });
  });
  document.getElementById('ncvSendBack')?.addEventListener('click', () => {
    const sel = selected();
    if (!sel) return;
    const z = parseInt(sel.getStyle()['z-index'] || '1', 10) || 1;
    sel.addStyle({ 'z-index': String(Math.max(0, z - 1)) });
  });

  formatBar?.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-cmd]');
    if (!btn) return;
    const cmd = btn.getAttribute('data-cmd');
    const sel = selected();
    if (!sel) return;
    if (cmd === 'bold') {
      const w = sel.getStyle()['font-weight'];
      sel.addStyle({ 'font-weight': String(w) === '700' || String(w) === 'bold' ? '400' : '700' });
    } else if (cmd === 'italic') {
      const s = sel.getStyle()['font-style'];
      sel.addStyle({ 'font-style': s === 'italic' ? 'normal' : 'italic' });
    } else if (cmd === 'underline') {
      const d = sel.getStyle()['text-decoration'];
      sel.addStyle({ 'text-decoration': d === 'underline' ? 'none' : 'underline' });
    } else if (cmd === 'left') sel.addStyle({ 'text-align': 'left' });
    else if (cmd === 'center') sel.addStyle({ 'text-align': 'center' });
    else if (cmd === 'right') sel.addStyle({ 'text-align': 'right' });
  });

  document.getElementById('ncvClear')?.addEventListener('click', () => {
    if (!confirm('Reset the page to a blank resume canvas?')) return;
    editor.setComponents(
      `<div class="cv-page" style="box-sizing:border-box;width:${A4_W}px;height:${A4_H}px;margin:0 auto;background:#fff;padding:36px;font-family:DM Sans,Arial,sans-serif;overflow:hidden;">` +
        '<div data-gjs-type="text" style="font-size:36px;font-weight:700;color:#006837;letter-spacing:-0.02em;">Your Name</div>' +
        '<div data-gjs-type="text" style="font-size:15px;font-weight:700;color:#F37021;margin-top:6px;">Your Title</div>' +
        '<div data-gjs-type="text" style="font-size:12px;color:#6b7280;margin-top:8px;">email@example.com · phone · location</div>' +
        '</div>'
    );
    editor.setStyle('');
  });

  document.getElementById('ncvTemplateSwitch')?.addEventListener('change', (e) => {
    const base = root.dataset.templatesUrl.replace(/\/?$/, '');
    window.location.href = `${base}/editor/${e.target.value}`;
  });

  let colorMode = 'background';
  const fillInput = document.getElementById('ncvFillColor');
  const textInput = document.getElementById('ncvTextColor');
  const customColor = document.getElementById('ncvCustomColor');
  const uploadStatus = document.getElementById('ncvUploadStatus');

  function toHex(val, fallback) {
    if (!val) return fallback;
    const s = String(val).trim();
    if (s.startsWith('#') && s.length >= 7) return s.slice(0, 7);
    const rgb = s.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/i);
    if (rgb) {
      const h = (n) => Number(n).toString(16).padStart(2, '0');
      return `#${h(rgb[1])}${h(rgb[2])}${h(rgb[3])}`;
    }
    return fallback;
  }

  function contrastColor(hex) {
    const h = toHex(hex, '#ffffff').replace('#', '');
    const r = parseInt(h.slice(0, 2), 16) / 255;
    const g = parseInt(h.slice(2, 4), 16) / 255;
    const b = parseInt(h.slice(4, 6), 16) / 255;
    const lum = 0.2126 * r + 0.7152 * g + 0.0722 * b;
    return lum > 0.58 ? '#111827' : '#ffffff';
  }

  function syncColorInputs(comp) {
    if (!comp) return;
    const style = comp.getStyle() || {};
    const bg = style['background-color'] || style.background || '#ffffff';
    const fg = style.color || '#111827';
    if (fillInput) fillInput.value = toHex(bg, '#ffffff');
    if (textInput) textInput.value = toHex(fg, '#111827');
    if (customColor) customColor.value = toHex(colorMode === 'text' ? fg : bg, '#006837');
  }

  function applyForeground(comp, color) {
    comp.addStyle({ color });
    // Update nested text so sidebar/main contrast stays readable (no overflow clash)
    comp.find('*').forEach((child) => {
      if (child.get('type') === 'image') return;
      const tag = (child.get('tagName') || '').toLowerCase();
      if (['img', 'svg', 'path'].includes(tag)) return;
      const st = child.getStyle() || {};
      // Skip elements that clearly have their own solid chip/pill backgrounds unless text-only
      child.addStyle({ color });
      if (st.background && String(st.background).includes('gradient')) return;
    });
  }

  function applyColor(color, mode) {
    const sel = selected();
    if (!sel || sel.is('wrapper')) {
      setStatus('Click Page / Sidebar / Main first');
      return false;
    }
    // Keep fills clipped inside the selected region
    sel.addStyle({ overflow: 'hidden' });

    if (mode === 'text') {
      applyForeground(sel, color);
      setStatus('Text color updated');
    } else {
      // Use solid background-color only (avoids shorthand overflow conflicts)
      sel.addStyle({
        'background-color': color,
        background: color,
        'background-image': 'none',
      });
      if (document.getElementById('ncvAutoContrast')?.checked) {
        applyForeground(sel, contrastColor(color));
      }
      setStatus('Background updated');
    }
    syncColorInputs(sel);
    return true;
  }

  function applyPageBackground(color) {
    const page = editor.getWrapper().find('.cv-page')[0] || editor.getWrapper();
    page.addStyle({
      'background-color': color,
      background: color,
      'background-image': 'none',
      overflow: 'hidden',
    });
    if (document.getElementById('ncvAutoContrast')?.checked) {
      // Only recolor page-level text; leave distinct Sidebar if present
      const sidebar = findByClass('cv-side');
      if (!sidebar) applyForeground(page, contrastColor(color));
    }
    editor.select(page);
    syncColorInputs(page);
    setStatus('CV page background updated');
  }

  async function uploadPhotoFile(file) {
    if (!file) return null;
    if (!file.type.startsWith('image/')) {
      alert('Please choose an image file.');
      return null;
    }
    if (file.size > 5 * 1024 * 1024) {
      alert('Image must be 5MB or smaller.');
      return null;
    }
    if (uploadStatus) uploadStatus.textContent = 'Uploading…';

    // Prefer server upload; fall back to local data URL
    try {
      const fd = new FormData();
      fd.append('file', file);
      const res = await fetch(root.dataset.uploadUrl, {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          'X-CSRF-TOKEN': csrfToken,
        },
        body: fd,
      });
      const json = await res.json();
      const src = json?.data?.src || json?.data?.url;
      if (res.ok && src) {
        latestPhotoUrl = src;
        editor.AssetManager.add(src);
        showUploadPreview(src);
        if (uploadStatus) uploadStatus.textContent = 'Photo ready — click Replace or Add.';
        return src;
      }
    } catch (e) {
      /* fall through to local */
    }

    const local = await new Promise((resolve) => {
      const reader = new FileReader();
      reader.onload = () => resolve(reader.result);
      reader.readAsDataURL(file);
    });
    latestPhotoUrl = local;
    editor.AssetManager.add(local);
    showUploadPreview(local);
    if (uploadStatus) uploadStatus.textContent = 'Photo ready (local) — click Replace or Add.';
    return local;
  }

  function showUploadPreview(src) {
    const box = document.getElementById('ncvUploadPreview');
    const img = document.getElementById('ncvUploadPreviewImg');
    if (!box || !img) return;
    img.src = src;
    box.hidden = false;
  }

  function findProfilePhoto() {
    return (
      findByName('Profile photo') ||
      editor.getWrapper().find('img.cv-avatar')[0] ||
      editor.getWrapper().find('.cv-avatar')[0] ||
      editor.getWrapper().find('img')[0]
    );
  }

  function setPhotoSrc(comp, src) {
    if (!comp) return;
    if (comp.get('type') === 'image' || (comp.get('tagName') || '').toLowerCase() === 'img') {
      comp.set('src', src);
      comp.addAttributes({ src, alt: 'Profile photo' });
      comp.addStyle({
        width: '96px',
        height: '96px',
        'border-radius': '50%',
        'object-fit': 'cover',
        overflow: 'hidden',
        display: 'block',
      });
      comp.addClass('cv-avatar');
      return;
    }
    // Replace non-image avatar wrapper with an image
    const parent = comp.parent();
    const idx = parent ? parent.components().indexOf(comp) : 0;
    comp.replaceWith({
      type: 'image',
      name: 'Profile photo',
      attributes: { src, alt: 'Profile photo', class: 'cv-avatar' },
      style: {
        width: '96px',
        height: '96px',
        'border-radius': '50%',
        'object-fit': 'cover',
        display: 'block',
        margin: '0 auto 16px',
        overflow: 'hidden',
      },
    });
    if (parent) {
      const next = parent.components().at(idx);
      if (next) editor.select(next);
    }
  }

  document.getElementById('ncvColorMode')?.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-mode]');
    if (!btn) return;
    colorMode = btn.getAttribute('data-mode');
    document.querySelectorAll('#ncvColorMode button').forEach((b) => b.classList.remove('is-active'));
    btn.classList.add('is-active');
    setStatus(colorMode === 'text' ? 'Text color mode' : 'Background color mode');
  });

  document.getElementById('ncvBrandSwatches')?.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-color]');
    if (!btn) return;
    applyColor(btn.getAttribute('data-color'), colorMode);
  });

  customColor?.addEventListener('input', () => applyColor(customColor.value, colorMode));
  fillInput?.addEventListener('input', () => applyColor(fillInput.value, 'background'));
  textInput?.addEventListener('input', () => applyColor(textInput.value, 'text'));

  document.getElementById('ncvPageBg')?.addEventListener('click', () => {
    const color = customColor?.value || fillInput?.value || '#ffffff';
    applyPageBackground(color);
  });

  document.getElementById('ncvPhotoInput')?.addEventListener('change', async (e) => {
    const file = e.target.files?.[0];
    if (!file) return;
    const src = await uploadPhotoFile(file);
    e.target.value = '';
    if (!src) return;

    // Simple flow: replace existing profile photo, or add one to sidebar/page
    const existing = findProfilePhoto();
    if (existing) {
      setPhotoSrc(existing, src);
      editor.select(findProfilePhoto() || existing);
      if (uploadStatus) uploadStatus.textContent = 'Profile photo updated on CV.';
      setStatus('Profile photo updated');
      return;
    }
    const target = findByClass('cv-side') || findByClass('cv-page') || editor.getWrapper();
    target.append({
      type: 'image',
      name: 'Profile photo',
      attributes: { src, alt: 'Profile photo', class: 'cv-avatar' },
      style: {
        width: '96px',
        height: '96px',
        'border-radius': '50%',
        'object-fit': 'cover',
        display: 'block',
        margin: '0 auto 16px',
        overflow: 'hidden',
      },
    });
    if (uploadStatus) uploadStatus.textContent = 'Photo added to CV.';
    setStatus('Photo added');
  });

  editor.on('component:selected', (comp) => syncColorInputs(comp));

  // Double-click any image → pick a new photo
  editor.on('component:selected', (comp) => {
    if (!comp) return;
    const isImg = comp.get('type') === 'image' || (comp.get('tagName') || '').toLowerCase() === 'img';
    if (!isImg) return;
    const el = comp.getEl();
    if (!el || el.dataset.ncvPhotoBound) return;
    el.dataset.ncvPhotoBound = '1';
    el.addEventListener('dblclick', () => document.getElementById('ncvPhotoInput')?.click());
  });

  function getExportCss() {
    let css = editor.getCss({ avoidProtected: true }) || editor.getCss() || '';
    // html2canvas often fails on @import; keep local rules only
    css = css.replace(/@import\s+url\([^)]+\)\s*;?/gi, '');
    return (
      css +
      `
      *{box-sizing:border-box;-webkit-print-color-adjust:exact!important;print-color-adjust:exact!important;}
      html,body{margin:0!important;padding:0!important;background:#fff!important;}
      .cv-page{
        width:794px!important;max-width:794px!important;
        min-height:1123px!important;height:1123px!important;max-height:none!important;
        margin:0!important;overflow:hidden!important;background:#fff!important;
        position:relative!important;
      }
      .cv-layout{height:1123px!important;min-height:1123px!important;}
      img{max-width:100%;}
    `
    );
  }

  function buildPdfSource() {
    // Prefer cloning the live canvas so PDF matches what the user sees
    const frameDoc = editor.Canvas.getDocument?.();
    const livePage = frameDoc?.querySelector?.('.cv-page');
    const host = document.createElement('div');
    host.id = 'ncvPdfExportHost';
    host.setAttribute('aria-hidden', 'true');
    host.style.cssText =
      'position:fixed;left:0;top:0;width:794px;min-height:1123px;background:#fff;z-index:2147483646;opacity:0;pointer-events:none;overflow:hidden;';

    const style = document.createElement('style');
    style.textContent = getExportCss();
    host.appendChild(style);

    if (livePage) {
      host.appendChild(livePage.cloneNode(true));
    } else {
      const html = editor.getHtml() || '';
      const wrap = document.createElement('div');
      wrap.innerHTML = html;
      const page = wrap.querySelector('.cv-page') || wrap;
      if (!page.classList.contains('cv-page')) page.classList.add('cv-page');
      host.appendChild(page);
    }

    document.body.appendChild(host);
    return host;
  }

  async function waitForExportReady(host) {
    try {
      if (document.fonts?.ready) await document.fonts.ready;
    } catch (e) {
      /* ignore */
    }
    const imgs = [...host.querySelectorAll('img')];
    await Promise.all(
      imgs.map(
        (img) =>
          new Promise((resolve) => {
            if (img.complete) return resolve();
            img.onload = () => resolve();
            img.onerror = () => resolve();
            setTimeout(resolve, 1200);
          })
      )
    );
    await new Promise((r) => setTimeout(r, 200));
  }

  let pdfBusy = false;
  document.getElementById('ncvPreviewPdf')?.addEventListener('click', async () => {
    if (pdfBusy) return;
    if (typeof html2pdf === 'undefined') {
      alert('PDF library failed to load. Check your internet connection and refresh.');
      return;
    }

    pdfBusy = true;
    const btn = document.getElementById('ncvPreviewPdf');
    if (btn) btn.disabled = true;
    setStatus('Preparing PDF…');

    let host = null;
    try {
      host = buildPdfSource();
      const target = host.querySelector('.cv-page') || host;
      if (!target || !String(target.innerHTML || '').trim()) {
        throw new Error('CV content is empty. Please refresh and try again.');
      }

      await waitForExportReady(host);

      const title = (document.getElementById('ncvCvTitle')?.value || 'resume')
        .replace(/[^\w\-]+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-|-$/g, '')
        .toLowerCase() || 'resume';

      // Temporarily make host paintable for html2canvas (still non-interactive)
      host.style.opacity = '1';
      host.style.left = '0';
      host.style.top = '0';

      await html2pdf()
        .set({
          margin: 0,
          filename: `${title}.pdf`,
          pagebreak: { mode: ['avoid-all', 'css', 'legacy'] },
          image: { type: 'jpeg', quality: 0.98 },
          html2canvas: {
            scale: 2,
            useCORS: true,
            allowTaint: true,
            backgroundColor: '#ffffff',
            logging: false,
            width: A4_W,
            windowWidth: A4_W,
            scrollX: 0,
            scrollY: 0,
          },
          jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
        })
        .from(target)
        .save();

      setStatus('PDF ready');
    } catch (err) {
      console.error('CV PDF export failed', err);
      setStatus('PDF failed');
      alert(err?.message || 'PDF download failed. Please try again.');
    } finally {
      host?.remove();
      pdfBusy = false;
      if (btn) btn.disabled = false;
    }
  });

  function buildSavePayload() {
    const html = editor.getHtml() || '';
    const css = editor.getCss() || '';
    return {
      cv_template_id: Number(root.dataset.templateId),
      title: (document.getElementById('ncvCvTitle')?.value || 'My Resume').trim() || 'My Resume',
      html,
      css,
      project_json: editor.getProjectData(),
      design_id: root.dataset.designId || null,
      is_default: true,
    };
  }

  function apiMessage(json, fallback) {
    return json?.message || json?.error || fallback;
  }

  async function persistGuestDraft() {
    if (root.dataset.canSave === '1' || !root.dataset.guestDraftUrl) return;
    try {
      await fetch(root.dataset.guestDraftUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
          'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify(buildSavePayload()),
        credentials: 'same-origin',
      });
    } catch (e) {
      /* ignore autosave errors */
    }
  }

  let saveBusy = false;
  document.getElementById('ncvSaveCanvas')?.addEventListener('click', async () => {
    if (saveBusy) return;
    saveBusy = true;
    const btn = document.getElementById('ncvSaveCanvas');
    if (btn) btn.disabled = true;
    setStatus('Saving…');

    const payload = buildSavePayload();
    if (!payload.html || payload.html.length < 20) {
      setStatus('Nothing to save');
      alert('CV content looks empty. Please refresh the page and try again.');
      saveBusy = false;
      if (btn) btn.disabled = false;
      return;
    }

    try {
      // Guests: store draft in session (PDF download still works anytime)
      if (root.dataset.canSave !== '1') {
        const res = await fetch(root.dataset.guestDraftUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            'X-CSRF-TOKEN': csrfToken,
          },
          body: JSON.stringify(payload),
          credentials: 'same-origin',
        });
        const json = await res.json().catch(() => ({}));
        if (!res.ok) {
          setStatus('Draft failed');
          alert(apiMessage(json, 'Could not store draft in session.'));
          return;
        }
        setStatus('Draft in session');
        const goLogin = confirm(
          'Draft saved in this browser session.\n\nLogin as a candidate to keep your final CV permanently.\nYou can Download PDF anytime without login.\n\nGo to login now?'
        );
        if (goLogin) window.location.href = root.dataset.loginUrl;
        return;
      }

      const res = await fetch(root.dataset.saveUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
          'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify(payload),
        credentials: 'same-origin',
      });
      const json = await res.json().catch(() => ({}));
      if (!res.ok) {
        setStatus('Save failed');
        alert(apiMessage(json, 'Could not save.'));
        return;
      }
      const id = json.data?.id || json.id;
      if (id) root.dataset.designId = String(id);
      setStatus('Saved to account');
    } catch (e) {
      setStatus('Save failed');
      alert('Save failed. Please try again.');
    } finally {
      saveBusy = false;
      if (btn) btn.disabled = false;
    }
  });

  // Autosave guest draft every 45s
  setInterval(() => {
    if (root.dataset.canSave !== '1') persistGuestDraft();
  }, 45000);

  window.addEventListener('keydown', (e) => {
    const meta = e.ctrlKey || e.metaKey;
    if (meta && e.key.toLowerCase() === 'z') {
      e.preventDefault();
      if (e.shiftKey) editor.UndoManager.redo();
      else editor.UndoManager.undo();
    }
    if (meta && e.key.toLowerCase() === 'y') {
      e.preventDefault();
      editor.UndoManager.redo();
    }
    if ((e.key === 'Delete' || e.key === 'Backspace') && !e.target.closest('input,textarea,[contenteditable="true"]')) {
      const sel = selected();
      if (sel && !sel.is('wrapper')) {
        e.preventDefault();
        sel.remove();
        showFormatBar(false);
      }
    }
  });
})();
