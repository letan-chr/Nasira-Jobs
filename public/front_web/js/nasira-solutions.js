/**
 * Nasira Solutions — production browser tools
 * Files stay on-device; no server upload for converters.
 */
(function () {
  'use strict';

  var page, slug, root;

  /* ---------- helpers ---------- */
  function h(html) {
    var d = document.createElement('div');
    d.innerHTML = String(html).trim();
    return d.firstChild;
  }

  function fmtBytes(n) {
    if (n < 1024) return n + ' B';
    if (n < 1048576) return (n / 1024).toFixed(1) + ' KB';
    return (n / 1048576).toFixed(2) + ' MB';
  }

  function downloadBlob(blob, name) {
    if (window.saveAs) {
      saveAs(blob, name);
      return;
    }
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = name;
    document.body.appendChild(a);
    a.click();
    a.remove();
    setTimeout(function () { URL.revokeObjectURL(url); }, 2000);
  }

  function downloadDataUrl(dataUrl, name) {
    var a = document.createElement('a');
    a.href = dataUrl;
    a.download = name;
    a.click();
  }

  function dataUrlToBlob(dataUrl) {
    var parts = dataUrl.split(',');
    var mime = parts[0].match(/:(.*?);/)[1];
    var bin = atob(parts[1]);
    var arr = new Uint8Array(bin.length);
    for (var i = 0; i < bin.length; i++) arr[i] = bin.charCodeAt(i);
    return new Blob([arr], { type: mime });
  }

  function setMsg(panel, text, isError) {
    var box = panel.querySelector('.nasira-tool-msg');
    if (!box) {
      box = document.createElement('div');
      box.className = 'nasira-tool-msg';
      panel.appendChild(box);
    }
    box.textContent = text || '';
    box.classList.toggle('is-error', !!isError);
    box.style.display = text ? 'block' : 'none';
  }

  function setProgress(panel, pct, label) {
    var bar = panel.querySelector('.nasira-tool-progress');
    if (!bar) {
      bar = document.createElement('div');
      bar.className = 'nasira-tool-progress';
      bar.innerHTML = '<span></span>';
      panel.appendChild(bar);
    }
    bar.style.display = pct == null ? 'none' : 'block';
    if (pct != null) bar.firstChild.style.width = Math.max(0, Math.min(100, pct)) + '%';
    if (label) setMsg(panel, label, false);
  }

  function setBusy(panel, busy) {
    panel.classList.toggle('nasira-tool-busy', !!busy);
  }

  function dropHtml(accept, hint) {
    return (
      '<label class="nasira-dropzone">' +
        '<input type="file" accept="' + (accept || '*/*') + '" />' +
        '<strong>Drop a file here or click to browse</strong>' +
        '<span>' + (hint || '') + '</span>' +
      '</label>'
    );
  }

  function bindDrop(panel, onFiles, multi) {
    var zone = panel.querySelector('.nasira-dropzone, .nasira-bgrem-upload, #upload-zone');
    var input = panel.querySelector('input[type="file"]');
    if (!zone || !input) return;
    if (multi) input.multiple = true;

    function take(list) {
      var files = Array.prototype.slice.call(list || []);
      if (!files.length) return;
      onFiles(multi ? files : files[0]);
    }

    zone.addEventListener('dragover', function (e) {
      e.preventDefault();
      zone.classList.add('is-drag');
    });
    zone.addEventListener('dragleave', function () { zone.classList.remove('is-drag'); });
    zone.addEventListener('drop', function (e) {
      e.preventDefault();
      zone.classList.remove('is-drag');
      take(e.dataTransfer.files);
    });
    input.addEventListener('change', function () {
      take(input.files);
      input.value = '';
    });
  }

  function loadImage(file) {
    return new Promise(function (resolve, reject) {
      if (!file || !/^image\//.test(file.type)) {
        reject(new Error('Please choose a valid image file (JPG, PNG, WEBP, GIF).'));
        return;
      }
      if (file.size > ((window.NasiraSolutionsLimits && window.NasiraSolutionsLimits.maxBytes) || (40 * 1024 * 1024))) {
        reject(new Error('Image is too large (max 40 MB).'));
        return;
      }
      var url = URL.createObjectURL(file);
      var img = new Image();
      img.onload = function () {
        URL.revokeObjectURL(url);
        resolve({ img: img, file: file, w: img.naturalWidth, h: img.naturalHeight });
      };
      img.onerror = function () {
        URL.revokeObjectURL(url);
        reject(new Error('Could not decode that image.'));
      };
      img.src = url;
    });
  }

  function drawScaled(img, maxSide) {
    var w = img.naturalWidth || img.width;
    var h = img.naturalHeight || img.height;
    if (maxSide && Math.max(w, h) > maxSide) {
      var s = maxSide / Math.max(w, h);
      w = Math.round(w * s);
      h = Math.round(h * s);
    }
    var c = document.createElement('canvas');
    c.width = w;
    c.height = h;
    var ctx = c.getContext('2d');
    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';
    ctx.drawImage(img, 0, 0, w, h);
    return c;
  }

  function canvasToBlob(canvas, type, quality) {
    return new Promise(function (resolve) {
      canvas.toBlob(function (blob) {
        if (blob) return resolve(blob);
        resolve(dataUrlToBlob(canvas.toDataURL(type || 'image/png', quality)));
      }, type || 'image/png', quality);
    });
  }

  function waitFor(getter, label, tries) {
    tries = tries || 100;
    return new Promise(function (resolve, reject) {
      var n = 0;
      (function tick() {
        var v = getter();
        if (v) return resolve(v);
        if (++n > tries) return reject(new Error((label || 'Library') + ' failed to load. Check your connection and refresh.'));
        setTimeout(tick, 100);
      })();
    });
  }

  function ensurePdfJs() {
    return waitFor(function () { return window.pdfjsLib; }, 'PDF.js').then(function (lib) {
      lib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
      return lib;
    });
  }

  function ensurePdfLib() {
    return waitFor(function () { return window.PDFLib; }, 'PDF-lib');
  }

  function ensureDocx() {
    return waitFor(function () { return window.docx; }, 'DOCX exporter');
  }

  function ensureMammoth() {
    return waitFor(function () { return window.mammoth; }, 'Word reader');
  }

  function ensureHtml2Pdf() {
    return waitFor(function () { return window.html2pdf; }, 'PDF exporter');
  }

  function ensureJSZip() {
    return waitFor(function () { return window.JSZip; }, 'ZIP library');
  }

  function ensureCropper() {
    return waitFor(function () { return window.Cropper; }, 'Cropper');
  }

  function ensureQr() {
    return waitFor(function () { return window.QRCode; }, 'QR library');
  }

  function metaRow(items) {
    return '<div class="nasira-tool-meta">' + items.map(function (it) {
      return '<span><strong>' + it[0] + ':</strong> ' + it[1] + '</span>';
    }).join('') + '</div>';
  }

  /* ---------- IMAGE TOOLS ---------- */
  function baseName(name) {
    return String(name || 'image').replace(/\.[^.]+$/, '');
  }

  function targetSize(w, h, mode, width, height, percent) {
    mode = mode || 'keep';
    if (mode === 'keep') return { w: w, h: h };
    if (mode === 'percent') {
      var p = Math.max(1, Math.min(400, percent || 100)) / 100;
      return { w: Math.max(1, Math.round(w * p)), h: Math.max(1, Math.round(h * p)) };
    }
    if (mode === 'width' && width > 0) {
      return { w: width, h: Math.max(1, Math.round(h * (width / w))) };
    }
    if (mode === 'height' && height > 0) {
      return { w: Math.max(1, Math.round(w * (height / h))), h: height };
    }
    if (mode === 'both' && width > 0 && height > 0) {
      return { w: width, h: height };
    }
    return { w: w, h: h };
  }

  function pngFileToJpgBlob(file, opts) {
    opts = opts || {};
    return loadImage(file).then(function (res) {
      var size = targetSize(
        res.w,
        res.h,
        opts.sizeMode,
        parseInt(opts.width, 10) || 0,
        parseInt(opts.height, 10) || 0,
        parseFloat(opts.percent) || 100
      );
      var c = document.createElement('canvas');
      c.width = size.w;
      c.height = size.h;
      var ctx = c.getContext('2d');
      ctx.fillStyle = opts.bg || '#ffffff';
      ctx.fillRect(0, 0, c.width, c.height);
      ctx.imageSmoothingEnabled = true;
      ctx.imageSmoothingQuality = 'high';
      ctx.drawImage(res.img, 0, 0, c.width, c.height);
      var q = typeof opts.quality === 'number' ? opts.quality : 0.92;
      return canvasToBlob(c, 'image/jpeg', q).then(function (blob) {
        return { blob: blob, width: c.width, height: c.height, original: file.size };
      });
    });
  }

  function buildPngToJpg() {
    root.innerHTML = '';
    var panel = h(
      '<div class="nasira-fc">' +
        '<div class="nasira-fc-card">' +
          '<div class="nasira-fc-badge">Free · private · browser-side</div>' +
          '<h2>PNG to JPG</h2>' +
          '<p>Convert PNG to JPG online — FreeConvert-style: upload, set options, convert, download. Transparent areas get a solid fill so JPG stays clean.</p>' +
          '<label class="nasira-fc-drop" id="upload-zone">' +
            '<input type="file" accept="image/png,.png,image/*" multiple />' +
            '<span class="nasira-fc-drop-btn"><i class="fa-solid fa-folder-open"></i> Choose Files</span>' +
            '<strong>or drop PNG files here</strong>' +
            '<span>Batch supported · max 40 MB each</span>' +
          '</label>' +
          '<ul class="nasira-fc-files" id="file-list" hidden></ul>' +
          '<details class="nasira-fc-advanced" id="advanced">' +
            '<summary>Advanced settings <span>(optional)</span></summary>' +
            '<div class="nasira-fc-advanced-body">' +
              '<div class="nasira-tool-field">' +
                '<label>Output size</label>' +
                '<select id="size-mode">' +
                  '<option value="keep">Keep original</option>' +
                  '<option value="width">Set width (keep ratio)</option>' +
                  '<option value="height">Set height (keep ratio)</option>' +
                  '<option value="both">Exact width &amp; height</option>' +
                  '<option value="percent">Scale by percentage</option>' +
                '</select>' +
              '</div>' +
              '<div class="nasira-fc-size-fields" id="size-fields">' +
                '<div class="nasira-tool-field" data-for="width both" hidden><label>Width (px)</label><input type="number" id="width" min="1" max="8000" placeholder="e.g. 1200" /></div>' +
                '<div class="nasira-tool-field" data-for="height both" hidden><label>Height (px)</label><input type="number" id="height" min="1" max="8000" placeholder="e.g. 800" /></div>' +
                '<div class="nasira-tool-field" data-for="percent" hidden><label>Scale %</label><input type="number" id="percent" min="1" max="400" value="100" /></div>' +
              '</div>' +
              '<div class="nasira-tool-field">' +
                '<label>Transparent fill color</label>' +
                '<div class="nasira-fc-color-row">' +
                  '<input type="color" id="bg" value="#ffffff" />' +
                  '<input type="text" id="bg-hex" value="#FFFFFF" maxlength="7" />' +
                  '<span>Replaces PNG transparency (JPG has no alpha)</span>' +
                '</div>' +
              '</div>' +
              '<div class="nasira-tool-field">' +
                '<label>JPG quality <span id="qv">92%</span></label>' +
                '<input type="range" id="q" min="0.4" max="1" step="0.01" value="0.92" />' +
              '</div>' +
            '</div>' +
          '</details>' +
          '<div class="nasira-tool-actions nasira-fc-actions">' +
            '<button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="convert" disabled>Convert</button>' +
            '<button type="button" class="nasira-tool-btn nasira-tool-btn--ghost" id="clear" disabled>Clear</button>' +
          '</div>' +
          '<div class="nasira-tool-progress" id="progress" style="display:none"><span></span></div>' +
          '<div class="nasira-fc-results" id="results" hidden></div>' +
          '<div class="nasira-tool-actions" id="zip-wrap" hidden>' +
            '<button type="button" class="nasira-tool-btn" id="zip">Download all (.zip)</button>' +
          '</div>' +
          '<div class="nasira-tool-msg" id="fc-msg" style="display:none"></div>' +
        '</div>' +
        '<ol class="nasira-fc-howto">' +
          '<li><strong>Choose</strong> one or more PNG files.</li>' +
          '<li>Open <strong>Advanced settings</strong> if you need size, fill color, or quality.</li>' +
          '<li>Click <strong>Convert</strong>, then <strong>Download</strong> when status is Done.</li>' +
        '</ol>' +
      '</div>'
    );
    root.appendChild(panel);

    var queue = [];
    var outputs = [];

    function fcMsg(text, isError) {
      var box = panel.querySelector('#fc-msg');
      box.textContent = text || '';
      box.classList.toggle('is-error', !!isError);
      box.style.display = text ? 'block' : 'none';
    }

    function syncSizeFields() {
      var mode = panel.querySelector('#size-mode').value;
      panel.querySelectorAll('#size-fields .nasira-tool-field').forEach(function (el) {
        var forModes = (el.getAttribute('data-for') || '').split(/\s+/);
        el.hidden = forModes.indexOf(mode) === -1;
      });
    }

    function renderList() {
      var list = panel.querySelector('#file-list');
      list.innerHTML = '';
      list.hidden = !queue.length;
      panel.querySelector('#convert').disabled = !queue.length;
      panel.querySelector('#clear').disabled = !queue.length;
      queue.forEach(function (item, idx) {
        var li = document.createElement('li');
        li.innerHTML =
          '<div><strong></strong><small></small></div>' +
          '<button type="button" data-rm="' + idx + '">Remove</button>';
        li.querySelector('strong').textContent = item.file.name;
        li.querySelector('small').textContent = fmtBytes(item.file.size);
        list.appendChild(li);
      });
    }

    function addFiles(files) {
      var arr = Array.prototype.slice.call(files || []);
      arr.forEach(function (file) {
        var okType = /^image\//.test(file.type || '') || /\.png$/i.test(file.name);
        if (!okType) {
          fcMsg('Skipped non-image file: ' + file.name, true);
          return;
        }
        if (file.size > ((window.NasiraSolutionsLimits && window.NasiraSolutionsLimits.maxBytes) || (40 * 1024 * 1024))) {
          fcMsg(file.name + ' is larger than 40 MB.', true);
          return;
        }
        queue.push({ file: file });
      });
      outputs = [];
      panel.querySelector('#results').hidden = true;
      panel.querySelector('#zip-wrap').hidden = true;
      renderList();
      if (queue.length) fcMsg(queue.length + ' file(s) ready. Click Convert.');
    }

    function optionsFromUi() {
      return {
        sizeMode: panel.querySelector('#size-mode').value,
        width: panel.querySelector('#width').value,
        height: panel.querySelector('#height').value,
        percent: panel.querySelector('#percent').value,
        bg: panel.querySelector('#bg-hex').value || panel.querySelector('#bg').value || '#ffffff',
        quality: parseFloat(panel.querySelector('#q').value) || 0.92
      };
    }

    function setProgress(pct) {
      var bar = panel.querySelector('#progress');
      bar.style.display = pct == null ? 'none' : 'block';
      if (pct != null) bar.firstChild.style.width = Math.max(0, Math.min(100, pct)) + '%';
    }

    function renderResults() {
      var box = panel.querySelector('#results');
      box.hidden = !outputs.length;
      box.innerHTML = '';
      outputs.forEach(function (out, idx) {
        var row = document.createElement('div');
        row.className = 'nasira-fc-result-row';
        row.innerHTML =
          '<div class="nasira-fc-result-info">' +
            '<img alt="" />' +
            '<div><strong></strong><small></small></div>' +
          '</div>' +
          '<span class="nasira-fc-status is-done">Done</span>' +
          '<button type="button" class="nasira-tool-btn nasira-tool-btn--orange" data-dl="' + idx + '">Download</button>';
        row.querySelector('img').src = out.url;
        row.querySelector('strong').textContent = out.name;
        row.querySelector('small').textContent =
          out.width + '×' + out.height + ' · ' + fmtBytes(out.original) + ' → ' + fmtBytes(out.blob.size);
        box.appendChild(row);
      });
      panel.querySelector('#zip-wrap').hidden = outputs.length < 2;
    }

    bindDrop(panel, function (fileOrFiles) {
      addFiles(Array.isArray(fileOrFiles) ? fileOrFiles : [fileOrFiles]);
    }, true);

    panel.querySelector('#file-list').addEventListener('click', function (e) {
      var btn = e.target.closest('[data-rm]');
      if (!btn) return;
      queue.splice(parseInt(btn.getAttribute('data-rm'), 10), 1);
      renderList();
    });

    panel.querySelector('#size-mode').addEventListener('change', syncSizeFields);
    syncSizeFields();

    panel.querySelector('#q').addEventListener('input', function () {
      panel.querySelector('#qv').textContent = Math.round(parseFloat(this.value) * 100) + '%';
    });

    panel.querySelector('#bg').addEventListener('input', function () {
      panel.querySelector('#bg-hex').value = this.value.toUpperCase();
    });
    panel.querySelector('#bg-hex').addEventListener('input', function () {
      if (/^#([A-Fa-f0-9]{6})$/.test(this.value)) {
        panel.querySelector('#bg').value = this.value;
      }
    });

    panel.querySelector('#clear').addEventListener('click', function () {
      queue = [];
      outputs.forEach(function (o) { try { URL.revokeObjectURL(o.url); } catch (e) {} });
      outputs = [];
      renderList();
      panel.querySelector('#results').hidden = true;
      panel.querySelector('#zip-wrap').hidden = true;
      setProgress(null);
      fcMsg('');
    });

    panel.querySelector('#convert').addEventListener('click', function () {
      if (!queue.length) return;
      var opts = optionsFromUi();
      outputs.forEach(function (o) { try { URL.revokeObjectURL(o.url); } catch (e) {} });
      outputs = [];
      setBusy(panel, true);
      setProgress(5);
      fcMsg('Converting…');

      var chain = Promise.resolve();
      queue.forEach(function (item, idx) {
        chain = chain.then(function () {
          setProgress(Math.round(((idx) / queue.length) * 90) + 5);
          fcMsg('Converting ' + (idx + 1) + ' / ' + queue.length + '…');
          return pngFileToJpgBlob(item.file, opts).then(function (res) {
            outputs.push({
              name: baseName(item.file.name) + '.jpg',
              blob: res.blob,
              url: URL.createObjectURL(res.blob),
              width: res.width,
              height: res.height,
              original: res.original
            });
          });
        });
      });

      chain.then(function () {
        setProgress(100);
        renderResults();
        fcMsg('Done — ' + outputs.length + ' JPG file(s) ready.');
      }).catch(function (e) {
        fcMsg(e.message || 'Conversion failed.', true);
      }).finally(function () {
        setBusy(panel, false);
        setTimeout(function () { setProgress(null); }, 600);
      });
    });

    panel.querySelector('#results').addEventListener('click', function (e) {
      var btn = e.target.closest('[data-dl]');
      if (!btn) return;
      var out = outputs[parseInt(btn.getAttribute('data-dl'), 10)];
      if (out) downloadBlob(out.blob, out.name);
    });

    panel.querySelector('#zip').addEventListener('click', function () {
      if (outputs.length < 2) return;
      ensureJSZip().then(function (JSZip) {
        var zip = new JSZip();
        outputs.forEach(function (o) { zip.file(o.name, o.blob); });
        return zip.generateAsync({ type: 'blob' }).then(function (blob) {
          downloadBlob(blob, 'nasira-png-to-jpg.zip');
        });
      }).catch(function (e) {
        fcMsg(e.message || 'Could not build ZIP.', true);
      });
    });
  }

  function buildImageConvert(outExt, mime, defaultQ) {
    root.innerHTML = '';
    var panel = h(
      '<div>' +
        dropHtml('image/*', 'Max 40 MB · PNG, JPG, WEBP, GIF') +
        '<div class="nasira-tool-field"><label>Quality <span id="qv">' + Math.round(defaultQ * 100) + '%</span></label>' +
        '<input type="range" id="q" min="0.5" max="1" step="0.05" value="' + defaultQ + '"' + (mime === 'image/png' ? ' disabled' : '') + ' /></div>' +
        '<div class="nasira-tool-preview" hidden><img alt="Preview" /></div>' +
        '<div id="meta"></div>' +
        '<div class="nasira-tool-actions">' +
          '<button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="dl" disabled>Download .' + outExt + '</button>' +
        '</div>' +
      '</div>'
    );
    root.appendChild(panel);
    var canvas = null;
    var srcFile = null;

    panel.querySelector('#q').addEventListener('input', function () {
      panel.querySelector('#qv').textContent = Math.round(parseFloat(this.value) * 100) + '%';
      if (canvas && mime !== 'image/png') refreshPreview();
    });

    function refreshPreview() {
      var q = parseFloat(panel.querySelector('#q').value) || defaultQ;
      canvas.toBlob(function (blob) {
        if (!blob) return;
        var url = URL.createObjectURL(blob);
        var img = panel.querySelector('.nasira-tool-preview img');
        img.onload = function () { URL.revokeObjectURL(url); };
        img.src = url;
        panel.querySelector('#meta').innerHTML = metaRow([
          ['Original', fmtBytes(srcFile.size)],
          ['Output', fmtBytes(blob.size)],
          ['Size', canvas.width + ' × ' + canvas.height]
        ]);
      }, mime, q);
    }

    bindDrop(panel, function (file) {
      setBusy(panel, true);
      loadImage(file).then(function (res) {
        srcFile = res.file;
        canvas = drawScaled(res.img, 5000);
        if (mime === 'image/jpeg') {
          var filled = document.createElement('canvas');
          filled.width = canvas.width;
          filled.height = canvas.height;
          var ctx = filled.getContext('2d');
          ctx.fillStyle = '#ffffff';
          ctx.fillRect(0, 0, filled.width, filled.height);
          ctx.drawImage(canvas, 0, 0);
          canvas = filled;
        }
        panel.querySelector('.nasira-tool-preview').hidden = false;
        panel.querySelector('#dl').disabled = false;
        refreshPreview();
        setMsg(panel, 'Ready to download as .' + outExt);
      }).catch(function (e) {
        setMsg(panel, e.message, true);
      }).finally(function () { setBusy(panel, false); });
    });

    panel.querySelector('#dl').addEventListener('click', function () {
      if (!canvas) return;
      var q = parseFloat(panel.querySelector('#q').value) || defaultQ;
      canvasToBlob(canvas, mime, q).then(function (blob) {
        downloadBlob(blob, 'nasira-converted.' + outExt);
      });
    });
  }

  function buildWebp() {
    root.innerHTML = '';
    var panel = h(
      '<div>' +
        dropHtml('image/*', 'Convert to WEBP, PNG, or JPG') +
        '<div class="nasira-tool-field"><label>Output format</label>' +
        '<select id="fmt"><option value="webp">WEBP</option><option value="png">PNG</option><option value="jpeg">JPG</option></select></div>' +
        '<div class="nasira-tool-field"><label>Quality <span id="qv">90%</span></label><input type="range" id="q" min="0.5" max="1" step="0.05" value="0.9" /></div>' +
        '<div class="nasira-tool-preview" hidden><img alt="Preview" /></div><div id="meta"></div>' +
        '<div class="nasira-tool-actions"><button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="dl" disabled>Download</button></div>' +
      '</div>'
    );
    root.appendChild(panel);
    var canvas = null;
    var srcFile = null;
    panel.querySelector('#q').addEventListener('input', function () {
      panel.querySelector('#qv').textContent = Math.round(parseFloat(this.value) * 100) + '%';
    });
    bindDrop(panel, function (file) {
      loadImage(file).then(function (res) {
        srcFile = res.file;
        canvas = drawScaled(res.img, 5000);
        panel.querySelector('.nasira-tool-preview').hidden = false;
        panel.querySelector('.nasira-tool-preview img').src = canvas.toDataURL();
        panel.querySelector('#dl').disabled = false;
        panel.querySelector('#meta').innerHTML = metaRow([
          ['Original', fmtBytes(srcFile.size)],
          ['Pixels', canvas.width + ' × ' + canvas.height]
        ]);
      }).catch(function (e) { setMsg(panel, e.message, true); });
    });
    panel.querySelector('#dl').addEventListener('click', function () {
      if (!canvas) return;
      var fmt = panel.querySelector('#fmt').value;
      var mime = 'image/' + fmt;
      var ext = fmt === 'jpeg' ? 'jpg' : fmt;
      canvasToBlob(canvas, mime, parseFloat(panel.querySelector('#q').value)).then(function (blob) {
        downloadBlob(blob, 'nasira-image.' + ext);
        setMsg(panel, 'Downloaded ' + fmtBytes(blob.size));
      });
    });
  }

  function buildCompressor() {
    root.innerHTML = '';
    var panel = h(
      '<div>' +
        dropHtml('image/*', 'Shrink photos before CV / portal upload') +
        '<div class="row g-2">' +
          '<div class="col-md-6"><div class="nasira-tool-field"><label>Quality <span id="qv">72%</span></label><input type="range" id="q" min="0.35" max="0.95" step="0.05" value="0.72" /></div></div>' +
          '<div class="col-md-6"><div class="nasira-tool-field"><label>Max long side (px)</label><input type="number" id="mw" value="1600" min="400" max="4000" /></div></div>' +
        '</div>' +
        '<div class="nasira-tool-preview" hidden><img alt="Preview" /></div><div id="meta"></div>' +
        '<div class="nasira-tool-actions"><button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="dl" disabled>Download compressed JPG</button></div>' +
      '</div>'
    );
    root.appendChild(panel);
    var canvas = null;
    var srcFile = null;

    function rebuild() {
      if (!panel._img) return;
      var maxW = parseInt(panel.querySelector('#mw').value, 10) || 1600;
      canvas = drawScaled(panel._img, maxW);
      var q = parseFloat(panel.querySelector('#q').value);
      canvasToBlob(canvas, 'image/jpeg', q).then(function (blob) {
        var url = URL.createObjectURL(blob);
        var imgEl = panel.querySelector('.nasira-tool-preview img');
        imgEl.onload = function () { URL.revokeObjectURL(url); };
        imgEl.src = url;
        panel.querySelector('.nasira-tool-preview').hidden = false;
        panel.querySelector('#dl').disabled = false;
        panel._blob = blob;
        var saved = Math.max(0, 100 - Math.round((blob.size / srcFile.size) * 100));
        panel.querySelector('#meta').innerHTML = metaRow([
          ['Original', fmtBytes(srcFile.size)],
          ['Compressed', fmtBytes(blob.size)],
          ['Saved', saved + '%'],
          ['Output', canvas.width + ' × ' + canvas.height]
        ]);
      });
    }

    panel.querySelector('#q').addEventListener('input', function () {
      panel.querySelector('#qv').textContent = Math.round(parseFloat(this.value) * 100) + '%';
      rebuild();
    });
    panel.querySelector('#mw').addEventListener('change', rebuild);

    bindDrop(panel, function (file) {
      loadImage(file).then(function (res) {
        srcFile = res.file;
        panel._img = res.img;
        rebuild();
        setMsg(panel, 'Adjust quality until the size fits your upload limit.');
      }).catch(function (e) { setMsg(panel, e.message, true); });
    });

    panel.querySelector('#dl').addEventListener('click', function () {
      if (panel._blob) downloadBlob(panel._blob, 'nasira-compressed.jpg');
    });
  }

  function buildResizer() {
    root.innerHTML = '';
    var panel = h(
      '<div>' +
        dropHtml('image/*', 'Exact pixel resize for avatars & banners') +
        '<div class="row g-2">' +
          '<div class="col-4"><div class="nasira-tool-field"><label>Width</label><input type="number" id="w" value="400" min="1" /></div></div>' +
          '<div class="col-4"><div class="nasira-tool-field"><label>Height</label><input type="number" id="h" value="400" min="1" /></div></div>' +
          '<div class="col-4"><div class="nasira-tool-field"><label>Lock ratio</label><select id="lock"><option value="1">Yes</option><option value="0">No</option></select></div></div>' +
        '</div>' +
        '<div class="nasira-tool-field"><label>Format</label><select id="fmt"><option value="image/png">PNG</option><option value="image/jpeg">JPG</option><option value="image/webp">WEBP</option></select></div>' +
        '<div class="nasira-tool-preview" hidden><img alt="Preview" /></div>' +
        '<div class="nasira-tool-actions"><button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="dl" disabled>Download</button></div>' +
      '</div>'
    );
    root.appendChild(panel);
    var ratio = 1;

    function render() {
      if (!panel._img) return;
      var w = Math.max(1, parseInt(panel.querySelector('#w').value, 10) || 1);
      var h = Math.max(1, parseInt(panel.querySelector('#h').value, 10) || 1);
      var c = document.createElement('canvas');
      c.width = w; c.height = h;
      var ctx = c.getContext('2d');
      ctx.imageSmoothingQuality = 'high';
      ctx.drawImage(panel._img, 0, 0, w, h);
      panel._canvas = c;
      panel.querySelector('.nasira-tool-preview').hidden = false;
      panel.querySelector('.nasira-tool-preview img').src = c.toDataURL();
      panel.querySelector('#dl').disabled = false;
    }

    panel.querySelector('#w').addEventListener('input', function () {
      if (panel.querySelector('#lock').value === '1' && panel._img) {
        panel.querySelector('#h').value = Math.round(parseInt(this.value, 10) / ratio);
      }
      render();
    });
    panel.querySelector('#h').addEventListener('input', function () {
      if (panel.querySelector('#lock').value === '1' && panel._img) {
        panel.querySelector('#w').value = Math.round(parseInt(this.value, 10) * ratio);
      }
      render();
    });

    bindDrop(panel, function (file) {
      loadImage(file).then(function (res) {
        panel._img = res.img;
        ratio = res.w / res.h;
        panel.querySelector('#w').value = res.w;
        panel.querySelector('#h').value = res.h;
        render();
      }).catch(function (e) { setMsg(panel, e.message, true); });
    });

    panel.querySelector('#dl').addEventListener('click', function () {
      if (!panel._canvas) return;
      var mime = panel.querySelector('#fmt').value;
      var ext = mime === 'image/jpeg' ? 'jpg' : mime.split('/')[1];
      canvasToBlob(panel._canvas, mime, 0.92).then(function (blob) {
        downloadBlob(blob, 'nasira-resized.' + ext);
      });
    });
  }

  function buildCropperTool(passportMode) {
    root.innerHTML = '';
    var panel = h(
      '<div>' +
        dropHtml('image/*', passportMode ? 'Square passport / CV photo' : 'Drag handles to crop') +
        (passportMode
          ? '<div class="nasira-tool-field"><label>Output size (px)</label><input type="number" id="sz" value="600" min="200" max="2000" /></div>' +
            '<div class="nasira-tool-field"><label>Background</label><select id="bg"><option value="transparent">Transparent PNG</option><option value="#ffffff">White</option><option value="#e8f0ec">Soft green</option><option value="#c4d4e8">Soft blue</option></select></div>'
          : '<div class="nasira-tool-field"><label>Aspect</label><select id="aspect"><option value="free">Free</option><option value="1">1:1</option><option value="1.333">4:3</option><option value="1.777">16:9</option><option value="0.8">4:5</option></select></div>') +
        '<div class="nasira-crop-wrap" hidden><img id="crop-img" alt="Crop" /></div>' +
        '<div class="nasira-tool-actions">' +
          '<button type="button" class="nasira-tool-btn nasira-tool-btn--ghost" id="rotate" disabled>Rotate</button>' +
          '<button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="dl" disabled>Download crop</button>' +
        '</div>' +
      '</div>'
    );
    root.appendChild(panel);
    var cropper = null;

    function kill() {
      if (cropper) { cropper.destroy(); cropper = null; }
    }

    bindDrop(panel, function (file) {
      loadImage(file).then(function () {
        return ensureCropper().then(function (Cropper) {
          kill();
          var wrap = panel.querySelector('.nasira-crop-wrap');
          var img = panel.querySelector('#crop-img');
          wrap.hidden = false;
          img.src = URL.createObjectURL(file);
          img.onload = function () {
            cropper = new Cropper(img, {
              viewMode: 1,
              dragMode: 'move',
              aspectRatio: passportMode ? 1 : NaN,
              autoCropArea: 0.85,
              background: false,
              responsive: true
            });
            panel.querySelector('#dl').disabled = false;
            panel.querySelector('#rotate').disabled = false;
            setMsg(panel, 'Adjust the crop area, then download.');
          };
        });
      }).catch(function (e) { setMsg(panel, e.message, true); });
    });

    var aspect = panel.querySelector('#aspect');
    if (aspect) {
      aspect.addEventListener('change', function () {
        if (!cropper) return;
        var v = aspect.value;
        cropper.setAspectRatio(v === 'free' ? NaN : parseFloat(v));
      });
    }

    panel.querySelector('#rotate').addEventListener('click', function () {
      if (cropper) cropper.rotate(90);
    });

    panel.querySelector('#dl').addEventListener('click', function () {
      if (!cropper) return;
      var size = passportMode ? (parseInt(panel.querySelector('#sz').value, 10) || 600) : undefined;
      var canvas = cropper.getCroppedCanvas(size ? { width: size, height: size, imageSmoothingQuality: 'high' } : { maxWidth: 3000, maxHeight: 3000, imageSmoothingQuality: 'high' });
      if (!canvas) return;

      if (passportMode) {
        var bg = panel.querySelector('#bg').value;
        if (bg !== 'transparent') {
          var out = document.createElement('canvas');
          out.width = canvas.width;
          out.height = canvas.height;
          var ctx = out.getContext('2d');
          ctx.fillStyle = bg;
          ctx.fillRect(0, 0, out.width, out.height);
          ctx.drawImage(canvas, 0, 0);
          canvasToBlob(out, 'image/jpeg', 0.92).then(function (blob) {
            downloadBlob(blob, 'nasira-passport.jpg');
          });
          return;
        }
        canvasToBlob(canvas, 'image/png').then(function (blob) {
          downloadBlob(blob, 'nasira-passport.png');
        });
        return;
      }

      canvasToBlob(canvas, 'image/png').then(function (blob) {
        downloadBlob(blob, 'nasira-crop.png');
      });
    });
  }

  function chromaFallback(file, sens) {
    return loadImage(file).then(function (res) {
      var c = drawScaled(res.img, 1400);
      var ctx = c.getContext('2d', { willReadFrequently: true });
      var data = ctx.getImageData(0, 0, c.width, c.height);
      var d = data.data;
      var w = c.width;
      var h = c.height;
      var thr = (sens || 38) * 2.35;

      // Sample border ring (more robust than 4 corners only).
      var samples = [];
      function pushSample(x, y) {
        var i = (y * w + x) * 4;
        samples.push([d[i], d[i + 1], d[i + 2]]);
      }
      for (var x = 0; x < w; x += Math.max(1, Math.floor(w / 40))) {
        pushSample(x, 0);
        pushSample(x, h - 1);
      }
      for (var y = 0; y < h; y += Math.max(1, Math.floor(h / 40))) {
        pushSample(0, y);
        pushSample(w - 1, y);
      }
      var br = 0, bg = 0, bb = 0;
      samples.forEach(function (s) { br += s[0]; bg += s[1]; bb += s[2]; });
      br /= samples.length; bg /= samples.length; bb /= samples.length;

      // Flood-fill from edges so only connected backdrop is removed.
      var visited = new Uint8Array(w * h);
      var queue = [];
      function enqueue(x, y) {
        if (x < 0 || y < 0 || x >= w || y >= h) return;
        var idx = y * w + x;
        if (visited[idx]) return;
        var i = idx * 4;
        var dist = Math.sqrt(
          Math.pow(d[i] - br, 2) + Math.pow(d[i + 1] - bg, 2) + Math.pow(d[i + 2] - bb, 2)
        );
        if (dist >= thr) return;
        visited[idx] = 1;
        queue.push(idx);
      }
      for (x = 0; x < w; x++) { enqueue(x, 0); enqueue(x, h - 1); }
      for (y = 0; y < h; y++) { enqueue(0, y); enqueue(w - 1, y); }

      while (queue.length) {
        var cur = queue.pop();
        var cx = cur % w;
        var cy = (cur / w) | 0;
        var ci = cur * 4;
        var dist = Math.sqrt(
          Math.pow(d[ci] - br, 2) + Math.pow(d[ci + 1] - bg, 2) + Math.pow(d[ci + 2] - bb, 2)
        );
        d[ci + 3] = Math.max(0, Math.min(255, Math.round((dist / thr) * 255)));
        enqueue(cx + 1, cy);
        enqueue(cx - 1, cy);
        enqueue(cx, cy + 1);
        enqueue(cx, cy - 1);
      }

      ctx.putImageData(data, 0, 0);
      return canvasToBlob(c, 'image/png');
    });
  }


  function prepareImageForBg(file) {
    return loadImageFile(file).then(function (img) {
      var maxEdge = 1600;
      var w = img.naturalWidth || img.width;
      var h = img.naturalHeight || img.height;
      var scale = Math.min(1, maxEdge / Math.max(w, h));
      if (scale >= 0.999 && file.size < 3 * 1024 * 1024) {
        return file;
      }
      var c = document.createElement('canvas');
      c.width = Math.max(1, Math.round(w * scale));
      c.height = Math.max(1, Math.round(h * scale));
      var ctx = c.getContext('2d');
      ctx.drawImage(img, 0, 0, c.width, c.height);
      return canvasToBlob(c, 'image/png');
    });
  }

  function loadImageFile(file) {
    return new Promise(function (resolve, reject) {
      var url = URL.createObjectURL(file);
      var img = new Image();
      img.onload = function () {
        URL.revokeObjectURL(url);
        resolve(img);
      };
      img.onerror = function () {
        URL.revokeObjectURL(url);
        reject(new Error('Could not read image.'));
      };
      img.src = url;
    });
  }

  function waitForBgAi(timeoutMs) {
    timeoutMs = timeoutMs || 45000;
    return new Promise(function (resolve, reject) {
      var start = Date.now();
      function tick() {
        if (window.NasiraBgRemove && typeof window.NasiraBgRemove.removeBackground === 'function') {
          resolve(window.NasiraBgRemove);
          return;
        }
        if (window.NasiraBgRemoveError && Date.now() - start > 1500) {
          reject(window.NasiraBgRemoveError instanceof Error
            ? window.NasiraBgRemoveError
            : new Error('AI library failed to load'));
          return;
        }
        if (Date.now() - start > timeoutMs) {
          reject(new Error('AI model timed out while loading'));
          return;
        }
        setTimeout(tick, 250);
      }
      window.addEventListener('nasira-bg-ready', tick, { once: true });
      tick();
    });
  }

  function blobToImage(blob) {
    return new Promise(function (resolve, reject) {
      var url = URL.createObjectURL(blob);
      var img = new Image();
      img.onload = function () {
        URL.revokeObjectURL(url);
        resolve(img);
      };
      img.onerror = function () {
        URL.revokeObjectURL(url);
        reject(new Error('Could not render result image.'));
      };
      img.src = url;
    });
  }

  function composeOnBackground(cutoutBlob, bg) {
    if (bg === 'transparent' || !bg) {
      return Promise.resolve(cutoutBlob);
    }
    return blobToImage(cutoutBlob).then(function (img) {
      var c = document.createElement('canvas');
      c.width = img.naturalWidth || img.width;
      c.height = img.naturalHeight || img.height;
      var ctx = c.getContext('2d');
      ctx.fillStyle = bg;
      ctx.fillRect(0, 0, c.width, c.height);
      ctx.drawImage(img, 0, 0);
      return canvasToBlob(c, 'image/jpeg', 0.92);
    });
  }

  function buildBackgroundRemover() {
    root.innerHTML = '';
    var panel = h(
      '<div class="nasira-bgrem">' +
        '<div class="nasira-bgrem-stage" data-stage="upload" id="stage-upload">' +
          '<div class="nasira-bgrem-hero">' +
            '<p class="nasira-bgrem-brand">Nasira Jobs</p>' +
            '<h2>Remove Image Background</h2>' +
            '<p class="nasira-bgrem-tagline">' +
              '<em>100% Automatically</em> and <strong>Free</strong>' +
            '</p>' +
            '<p class="nasira-bgrem-lead">Cut out the subject from any photo in seconds. Private on-device AI — your file never leaves this browser.</p>' +
            '<label class="nasira-bgrem-upload" id="upload-zone">' +
              '<input type="file" accept="image/png,image/jpeg,image/jpg,image/webp,image/gif" />' +
              '<span class="nasira-bgrem-upload-btn"><i class="fa-solid fa-arrow-up-from-bracket"></i> Upload Image</span>' +
              '<span class="nasira-bgrem-upload-or">or drop a file here</span>' +
              '<span class="nasira-bgrem-upload-hint">JPG, PNG, WEBP · up to 40 MB</span>' +
            '</label>' +
            '<div class="nasira-bgrem-uses" aria-label="Popular uses">' +
              '<span>E-commerce</span>' +
              '<span>Headshots</span>' +
              '<span>Product photos</span>' +
              '<span>Transparent PNG</span>' +
              '<span>CV photos</span>' +
            '</div>' +
          '</div>' +
        '</div>' +
        '<div class="nasira-bgrem-stage" data-stage="busy" id="stage-busy" hidden>' +
          '<div class="nasira-bgrem-busy">' +
            '<div class="nasira-spinner nasira-spinner--lg"></div>' +
            '<h3 id="busy-title">Removing background…</h3>' +
            '<p id="busy-sub">First run may download the AI model, then it stays cached.</p>' +
            '<div class="nasira-tool-progress" style="display:block"><span id="busy-bar" style="width:18%"></span></div>' +
          '</div>' +
        '</div>' +
        '<div class="nasira-bgrem-stage" data-stage="result" id="stage-result" hidden>' +
          '<div class="nasira-bgrem-result">' +
            '<div class="nasira-bgrem-canvas-wrap">' +
              '<div class="nasira-bgrem-checker" id="result-board">' +
                '<img id="result-img" alt="Background removed" />' +
              '</div>' +
              '<div class="nasira-bgrem-orig">' +
                '<span>Original</span>' +
                '<img id="orig-img" alt="Original" />' +
              '</div>' +
            '</div>' +
            '<aside class="nasira-bgrem-sidebar">' +
              '<p class="nasira-bgrem-side-kicker">Your cutout is ready</p>' +
              '<h3>Download</h3>' +
              '<button type="button" class="nasira-bgrem-dl" id="dl">Download HD</button>' +
              '<div class="nasira-bgrem-bgopts">' +
                '<span>Change background</span>' +
                '<div class="nasira-bgrem-swatches" role="group" aria-label="Background">' +
                  '<button type="button" class="is-active nasira-bgrem-swatch-check" data-bg="transparent" title="Transparent"></button>' +
                  '<button type="button" data-bg="#ffffff" title="White" style="background:#fff"></button>' +
                  '<button type="button" data-bg="#000000" title="Black" style="background:#000"></button>' +
                  '<button type="button" data-bg="#006837" title="Nasira green" style="background:#006837"></button>' +
                  '<button type="button" data-bg="#f37021" title="Orange" style="background:#f37021"></button>' +
                  '<button type="button" data-bg="#eff6f1" title="Soft mint" style="background:#eff6f1"></button>' +
                  '<label class="nasira-bgrem-custom" title="Custom color"><input type="color" id="custom-bg" value="#c7d2fe" /><i class="fa-solid fa-plus"></i></label>' +
                '</div>' +
              '</div>' +
              '<button type="button" class="nasira-bgrem-again" id="again">Upload another image</button>' +
              '<p class="nasira-bgrem-meta" id="meta"></p>' +
            '</aside>' +
          '</div>' +
        '</div>' +
        '<div class="nasira-tool-msg" id="bgrem-msg" style="display:none"></div>' +
      '</div>'
    );
    root.appendChild(panel);

    var cutoutBlob = null;
    var downloadBlobRef = null;
    var currentBg = 'transparent';
    var origUrl = null;
    var resultUrl = null;

    function showStage(name) {
      panel.querySelectorAll('.nasira-bgrem-stage').forEach(function (el) {
        el.hidden = el.getAttribute('data-stage') !== name;
      });
    }

    function setBusyProgress(pct, title, sub) {
      var bar = panel.querySelector('#busy-bar');
      if (bar) bar.style.width = Math.max(0, Math.min(100, pct)) + '%';
      if (title) panel.querySelector('#busy-title').textContent = title;
      if (sub) panel.querySelector('#busy-sub').textContent = sub;
    }

    function msg(text, isError) {
      var box = panel.querySelector('#bgrem-msg');
      box.textContent = text || '';
      box.classList.toggle('is-error', !!isError);
      box.style.display = text ? 'block' : 'none';
    }

    function revoke(url) {
      if (url) try { URL.revokeObjectURL(url); } catch (e) {}
    }

    function renderResultPreview() {
      if (!cutoutBlob) return;
      setBusy(panel, true);
      composeOnBackground(cutoutBlob, currentBg).then(function (blob) {
        downloadBlobRef = blob;
        revoke(resultUrl);
        resultUrl = URL.createObjectURL(blob);
        var img = panel.querySelector('#result-img');
        img.src = resultUrl;
        var board = panel.querySelector('#result-board');
        board.classList.toggle('is-solid', currentBg !== 'transparent');
        if (currentBg !== 'transparent') board.style.background = currentBg;
        else board.style.background = '';
        panel.querySelector('#meta').textContent =
          (currentBg === 'transparent' ? 'Transparent PNG' : 'Image with background') +
          ' · ' + fmtBytes(blob.size);
        showStage('result');
      }).catch(function (e) {
        msg(e.message || 'Could not render result.', true);
      }).finally(function () { setBusy(panel, false); });
    }

    function process(file) {
      if (!file || !/^image\//.test(file.type || '')) {
        msg('Please choose a JPG, PNG, WEBP, or GIF image.', true);
        return;
      }
      if (file.size > ((window.NasiraSolutionsLimits && window.NasiraSolutionsLimits.maxBytes) || (40 * 1024 * 1024))) {
        msg('Image is too large (max 40 MB).', true);
        return;
      }

      msg('');
      showStage('busy');
      setBusyProgress(12, 'Preparing image…', 'Optimizing for a fast cutout.');
      revoke(origUrl);
      origUrl = URL.createObjectURL(file);
      panel.querySelector('#orig-img').src = origUrl;

      var usedFallback = false;
      setBusyProgress(22, 'Preparing image…', 'Resizing if needed for a cleaner cutout.');

      prepareImageForBg(file)
        .then(function (prepared) {
          setBusyProgress(35, 'Loading AI…', 'First run downloads the model (~40–80 MB), then it is cached.');
          return waitForBgAi(120000).then(function (api) {
            setBusyProgress(55, 'Removing background…', 'AI is separating subject from backdrop.');
            var defaults = api.configDefaults || {};
            var publicPath = defaults.publicPath
              || 'https://staticimgly.com/@imgly/background-removal-data/1.5.5/dist/';
            var model = defaults.model || 'isnet_fp16';
            return api.removeBackground(prepared, {
              publicPath: publicPath,
              model: model,
              proxyToWorker: true,
              device: 'cpu',
              output: { format: 'image/png', quality: 0.95, type: 'foreground' },
              progress: function (key, current, total) {
                if (!total) return;
                var pct = 55 + Math.round((current / total) * 40);
                setBusyProgress(pct, 'Removing background…', String(key || 'Processing'));
              }
            });
          }).catch(function (aiErr) {
            console.warn('AI background removal failed, using studio fallback', aiErr);
            usedFallback = true;
            setBusyProgress(70, 'Using studio fallback…', 'AI unavailable — estimating backdrop from edges.');
            return chromaFallback(file, 40);
          });
        })
        .then(function (blob) {
          if (!blob) throw new Error('No result image produced.');
          cutoutBlob = blob;
          currentBg = 'transparent';
          panel.querySelectorAll('.nasira-bgrem-swatches button').forEach(function (b) {
            b.classList.toggle('is-active', b.getAttribute('data-bg') === 'transparent');
          });
          setBusyProgress(100, 'Done', usedFallback ? 'Studio fallback ready.' : 'AI cutout ready.');
          renderResultPreview();
          if (usedFallback) {
            msg('AI model could not run in this browser session, so a studio edge-removal fallback was used. Best on plain backgrounds. Try again after the AI finishes downloading.', false);
          } else {
            msg('');
          }
        })
        .catch(function (e) {
          console.warn('Background removal failed', e);
          showStage('upload');
          msg((e && e.message ? e.message : 'Background removal failed') + '. Try another photo (JPG/PNG) and wait for the AI model to finish loading.', true);
        });
    }

    bindDrop(panel, process);

    panel.querySelector('#dl').addEventListener('click', function () {
      if (!downloadBlobRef) return;
      var name = currentBg === 'transparent' ? 'nasira-no-background.png' : 'nasira-photo.jpg';
      downloadBlob(downloadBlobRef, name);
    });

    panel.querySelector('#again').addEventListener('click', function () {
      cutoutBlob = null;
      downloadBlobRef = null;
      revoke(resultUrl);
      revoke(origUrl);
      resultUrl = null;
      origUrl = null;
      msg('');
      showStage('upload');
    });

    panel.querySelectorAll('.nasira-bgrem-swatches button[data-bg]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        currentBg = btn.getAttribute('data-bg');
        panel.querySelectorAll('.nasira-bgrem-swatches button').forEach(function (b) {
          b.classList.toggle('is-active', b === btn);
        });
        renderResultPreview();
      });
    });

    panel.querySelector('#custom-bg').addEventListener('input', function () {
      currentBg = this.value;
      panel.querySelectorAll('.nasira-bgrem-swatches button').forEach(function (b) {
        b.classList.remove('is-active');
      });
      renderResultPreview();
    });
  }

  /* ---------- DOCUMENT TOOLS ---------- */
  function buildPdfToWord() {
    root.innerHTML = '';
    var panel = h(
      '<div>' +
        '<p style="color:#5f6e66;font-size:.92rem;margin-bottom:1rem">Extracts text from your PDF and builds a real <strong>.docx</strong> Word file.</p>' +
        dropHtml('application/pdf,.pdf', 'Text-based PDFs work best (not scanned photos)') +
        '<div class="nasira-tool-field"><label>Preview text</label><textarea id="preview" readonly placeholder="Extracted text appears here…"></textarea></div>' +
        '<div class="nasira-tool-actions">' +
          '<button type="button" class="nasira-tool-btn" id="copy" disabled>Copy text</button>' +
          '<button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="dl" disabled>Download .docx</button>' +
        '</div>' +
      '</div>'
    );
    root.appendChild(panel);
    var pagesText = [];

    bindDrop(panel, function (file) {
      if (file.type && file.type !== 'application/pdf' && !/\.pdf$/i.test(file.name)) {
        setMsg(panel, 'Please upload a PDF file.', true);
        return;
      }
      setBusy(panel, true);
      setProgress(panel, 10, 'Reading PDF…');
      Promise.all([ensurePdfJs(), ensureDocx()]).then(function (libs) {
        var pdfjs = libs[0];
        return file.arrayBuffer().then(function (buf) {
          return pdfjs.getDocument({ data: new Uint8Array(buf) }).promise.then(function (pdf) {
            pagesText = [];
            var chain = Promise.resolve();
            for (var i = 1; i <= pdf.numPages; i++) {
              (function (n) {
                chain = chain.then(function () {
                  setProgress(panel, Math.round((n / pdf.numPages) * 80) + 10, 'Extracting page ' + n + ' / ' + pdf.numPages);
                  return pdf.getPage(n).then(function (page) {
                    return page.getTextContent().then(function (tc) {
                      var line = '';
                      var lastY = null;
                      var out = [];
                      tc.items.forEach(function (it) {
                        var y = it.transform ? it.transform[5] : null;
                        if (lastY !== null && y !== null && Math.abs(y - lastY) > 6) {
                          out.push(line.trim());
                          line = '';
                        }
                        line += (it.str || '') + (it.hasEOL ? '\n' : ' ');
                        lastY = y;
                      });
                      if (line.trim()) out.push(line.trim());
                      pagesText.push(out.join('\n'));
                    });
                  });
                });
              })(i);
            }
            return chain.then(function () {
              panel.querySelector('#preview').value = pagesText.join('\n\n');
              panel.querySelector('#copy').disabled = !pagesText.join('').trim();
              panel.querySelector('#dl').disabled = !pagesText.join('').trim();
              setProgress(panel, 100, 'Extracted ' + pdf.numPages + ' page(s). Download Word when ready.');
            });
          });
        });
      }).catch(function (e) {
        setMsg(panel, e.message || 'Could not read PDF.', true);
        setProgress(panel, null);
      }).finally(function () { setBusy(panel, false); });
    });

    panel.querySelector('#copy').addEventListener('click', function () {
      navigator.clipboard.writeText(panel.querySelector('#preview').value || '');
      setMsg(panel, 'Copied to clipboard.');
    });

    panel.querySelector('#dl').addEventListener('click', function () {
      ensureDocx().then(function (docxLib) {
        var children = [];
        pagesText.forEach(function (page, idx) {
          if (idx > 0) children.push(new docxLib.Paragraph({ children: [] }));
          page.split(/\n/).forEach(function (line) {
            children.push(new docxLib.Paragraph({
              children: [new docxLib.TextRun({ text: line || ' ', font: 'Calibri', size: 22 })]
            }));
          });
        });
        var doc = new docxLib.Document({
          sections: [{ properties: {}, children: children.length ? children : [new docxLib.Paragraph({ children: [new docxLib.TextRun('')] })] }]
        });
        return docxLib.Packer.toBlob(doc).then(function (blob) {
          downloadBlob(blob, 'nasira-from-pdf.docx');
          setMsg(panel, 'Word document downloaded.');
        });
      }).catch(function (e) { setMsg(panel, e.message, true); });
    });
  }

  function buildWordToPdf() {
    root.innerHTML = '';
    var panel = h(
      '<div>' +
        '<p style="color:#5f6e66;font-size:.92rem;margin-bottom:1rem">Upload a <strong>.docx</strong> Word file and download a PDF. Layout is approximate for complex docs.</p>' +
        dropHtml('.docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'Microsoft Word .docx only') +
        '<div id="preview-html" class="nasira-tool-preview" style="text-align:left;padding:1rem;border:1px solid rgba(0,104,55,.12);border-radius:12px;display:none;max-height:360px;overflow:auto;background:#fff"></div>' +
        '<div class="nasira-tool-actions"><button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="dl" disabled>Download PDF</button></div>' +
      '</div>'
    );
    root.appendChild(panel);

    bindDrop(panel, function (file) {
      if (!/\.docx$/i.test(file.name) && file.type !== 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
        setMsg(panel, 'Please upload a .docx file (not legacy .doc).', true);
        return;
      }
      setBusy(panel, true);
      setProgress(panel, 20, 'Reading Word document…');
      Promise.all([ensureMammoth(), ensureHtml2Pdf()]).then(function () {
        return file.arrayBuffer().then(function (buf) {
          return mammoth.convertToHtml({ arrayBuffer: buf }).then(function (result) {
            var box = panel.querySelector('#preview-html');
            box.style.display = 'block';
            box.innerHTML = result.value || '<p>(Empty document)</p>';
            panel._html = result.value;
            panel.querySelector('#dl').disabled = false;
            setProgress(panel, 100, 'Ready — download PDF.');
            if (result.messages && result.messages.length) {
              setMsg(panel, 'Converted with ' + result.messages.length + ' notice(s). Check the preview.');
            }
          });
        });
      }).catch(function (e) {
        setMsg(panel, e.message || 'Could not read Word file.', true);
        setProgress(panel, null);
      }).finally(function () { setBusy(panel, false); });
    });

    panel.querySelector('#dl').addEventListener('click', function () {
      var node = document.createElement('div');
      node.style.padding = '18px';
      node.style.fontFamily = 'Calibri, Arial, sans-serif';
      node.style.fontSize = '12pt';
      node.style.color = '#111';
      node.style.lineHeight = '1.45';
      node.innerHTML = panel._html || '';
      setProgress(panel, 50, 'Building PDF…');
      html2pdf().set({
        margin: [12, 12, 12, 12],
        filename: 'nasira-from-word.pdf',
        image: { type: 'jpeg', quality: 0.95 },
        html2canvas: { scale: 2, useCORS: true },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
      }).from(node).save().then(function () {
        setProgress(panel, 100, 'PDF downloaded.');
      }).catch(function () {
        setMsg(panel, 'PDF export failed.', true);
      });
    });
  }

  function buildPdfMerger() {
    root.innerHTML = '';
    var panel = h(
      '<div>' +
        dropHtml('application/pdf,.pdf', 'Select multiple PDFs (Ctrl/Cmd + click)') +
        '<ul class="nasira-file-list" id="list"></ul>' +
        '<div class="nasira-tool-actions">' +
          '<button type="button" class="nasira-tool-btn nasira-tool-btn--ghost" id="clear" disabled>Clear</button>' +
          '<button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="go" disabled>Merge & download</button>' +
        '</div>' +
      '</div>'
    );
    root.appendChild(panel);
    var files = [];

    function renderList() {
      var list = panel.querySelector('#list');
      list.innerHTML = files.map(function (f, i) {
        return '<li><span>' + (i + 1) + '. ' + f.name + ' (' + fmtBytes(f.size) + ')</span><button type="button" data-i="' + i + '">Remove</button></li>';
      }).join('');
      list.querySelectorAll('button').forEach(function (btn) {
        btn.addEventListener('click', function () {
          files.splice(parseInt(btn.getAttribute('data-i'), 10), 1);
          renderList();
        });
      });
      panel.querySelector('#go').disabled = files.length < 2;
      panel.querySelector('#clear').disabled = !files.length;
    }

    bindDrop(panel, function (picked) {
      var arr = Array.isArray(picked) ? picked : [picked];
      arr.forEach(function (f) {
        if (f.type === 'application/pdf' || /\.pdf$/i.test(f.name)) files.push(f);
      });
      renderList();
      setMsg(panel, files.length + ' PDF(s) queued. Need at least 2 to merge.');
    }, true);

    panel.querySelector('#clear').addEventListener('click', function () {
      files = [];
      renderList();
      setMsg(panel, '');
    });

    panel.querySelector('#go').addEventListener('click', function () {
      setBusy(panel, true);
      setProgress(panel, 5, 'Merging…');
      ensurePdfLib().then(function (PDFLib) {
        return PDFLib.PDFDocument.create().then(function (merged) {
          var chain = Promise.resolve();
          files.forEach(function (file, idx) {
            chain = chain.then(function () {
              setProgress(panel, Math.round(((idx + 1) / files.length) * 85), 'Adding ' + file.name);
              return file.arrayBuffer().then(function (buf) {
                return PDFLib.PDFDocument.load(buf, { ignoreEncryption: true }).then(function (doc) {
                  return merged.copyPages(doc, doc.getPageIndices()).then(function (pages) {
                    pages.forEach(function (p) { merged.addPage(p); });
                  });
                });
              });
            });
          });
          return chain.then(function () {
            return merged.save().then(function (bytes) {
              downloadBlob(new Blob([bytes], { type: 'application/pdf' }), 'nasira-merged.pdf');
              setProgress(panel, 100, 'Merged PDF downloaded (' + fmtBytes(bytes.length) + ').');
            });
          });
        });
      }).catch(function (e) {
        setMsg(panel, e.message || 'Merge failed. One file may be encrypted.', true);
        setProgress(panel, null);
      }).finally(function () { setBusy(panel, false); });
    });
  }

  function buildPdfSplitter() {
    root.innerHTML = '';
    var panel = h(
      '<div>' +
        '<p style="color:#5f6e66;font-size:.92rem;margin-bottom:1rem">Splits every page into its own PDF and downloads a ZIP.</p>' +
        dropHtml('application/pdf,.pdf', 'One PDF file') +
        '<div id="meta"></div>' +
        '<div class="nasira-tool-actions"><button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="go" disabled>Split & download ZIP</button></div>' +
      '</div>'
    );
    root.appendChild(panel);
    var pdfBytes = null;
    var pageCount = 0;

    bindDrop(panel, function (file) {
      setBusy(panel, true);
      Promise.all([ensurePdfLib(), file.arrayBuffer()]).then(function (res) {
        pdfBytes = res[1];
        return res[0].PDFDocument.load(pdfBytes, { ignoreEncryption: true }).then(function (doc) {
          pageCount = doc.getPageCount();
          panel.querySelector('#go').disabled = pageCount < 1;
          panel.querySelector('#meta').innerHTML = metaRow([
            ['File', file.name],
            ['Pages', String(pageCount)],
            ['Size', fmtBytes(file.size)]
          ]);
          setMsg(panel, 'Ready to split ' + pageCount + ' page(s).');
        });
      }).catch(function (e) {
        setMsg(panel, e.message || 'Could not open PDF.', true);
      }).finally(function () { setBusy(panel, false); });
    });

    panel.querySelector('#go').addEventListener('click', function () {
      if (!pdfBytes) return;
      setBusy(panel, true);
      Promise.all([ensurePdfLib(), ensureJSZip()]).then(function (libs) {
        var PDFLib = libs[0];
        var JSZip = libs[1];
        return PDFLib.PDFDocument.load(pdfBytes, { ignoreEncryption: true }).then(function (src) {
          var zip = new JSZip();
          var chain = Promise.resolve();
          var total = src.getPageCount();
          for (var i = 0; i < total; i++) {
            (function (idx) {
              chain = chain.then(function () {
                setProgress(panel, Math.round(((idx + 1) / total) * 90), 'Splitting page ' + (idx + 1) + ' / ' + total);
                return PDFLib.PDFDocument.create().then(function (out) {
                  return out.copyPages(src, [idx]).then(function (pages) {
                    out.addPage(pages[0]);
                    return out.save().then(function (bytes) {
                      var num = String(idx + 1);
                      if (num.length < 2) num = '0' + num;
                      zip.file('page-' + num + '.pdf', bytes);
                    });
                  });
                });
              });
            })(i);
          }
          return chain.then(function () {
            return zip.generateAsync({ type: 'blob' }).then(function (blob) {
              downloadBlob(blob, 'nasira-pdf-pages.zip');
              setProgress(panel, 100, 'ZIP downloaded with ' + total + ' PDF(s).');
            });
          });
        });
      }).catch(function (e) {
        setMsg(panel, e.message || 'Split failed.', true);
        setProgress(panel, null);
      }).finally(function () { setBusy(panel, false); });
    });
  }

  function buildPdfCompressor() {
    root.innerHTML = '';
    var panel = h(
      '<div>' +
        '<p style="color:#5f6e66;font-size:.92rem;margin-bottom:1rem">Re-renders pages as optimized images and rebuilds a smaller PDF — ideal for image-heavy resumes.</p>' +
        dropHtml('application/pdf,.pdf', 'PDF under ~40 MB recommended') +
        '<div class="nasira-tool-field"><label>Quality</label><select id="q"><option value="0.55">Smaller file</option><option value="0.72" selected>Balanced</option><option value="0.88">Higher quality</option></select></div>' +
        '<div class="nasira-tool-field"><label>Scale</label><select id="scale"><option value="1.1">Compact</option><option value="1.4" selected>Standard</option><option value="1.8">Sharp</option></select></div>' +
        '<div id="meta"></div>' +
        '<div class="nasira-tool-actions"><button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="go" disabled>Compress & download</button></div>' +
      '</div>'
    );
    root.appendChild(panel);
    var pdfFile = null;

    bindDrop(panel, function (file) {
      pdfFile = file;
      panel.querySelector('#go').disabled = false;
      panel.querySelector('#meta').innerHTML = metaRow([['Original', fmtBytes(file.size)], ['Name', file.name]]);
      setMsg(panel, 'Ready to compress.');
    });

    panel.querySelector('#go').addEventListener('click', function () {
      if (!pdfFile) return;
      setBusy(panel, true);
      var quality = parseFloat(panel.querySelector('#q').value);
      var scale = parseFloat(panel.querySelector('#scale').value);
      Promise.all([ensurePdfJs(), ensurePdfLib()]).then(function (libs) {
        var pdfjs = libs[0];
        var PDFLib = libs[1];
        return pdfFile.arrayBuffer().then(function (buf) {
          return pdfjs.getDocument({ data: new Uint8Array(buf) }).promise.then(function (pdf) {
            return PDFLib.PDFDocument.create().then(function (outDoc) {
              var chain = Promise.resolve();
              for (var i = 1; i <= pdf.numPages; i++) {
                (function (n) {
                  chain = chain.then(function () {
                    setProgress(panel, Math.round((n / pdf.numPages) * 90), 'Compressing page ' + n + ' / ' + pdf.numPages);
                    return pdf.getPage(n).then(function (page) {
                      var viewport = page.getViewport({ scale: scale });
                      var canvas = document.createElement('canvas');
                      canvas.width = Math.floor(viewport.width);
                      canvas.height = Math.floor(viewport.height);
                      return page.render({ canvasContext: canvas.getContext('2d'), viewport: viewport }).promise.then(function () {
                        return canvasToBlob(canvas, 'image/jpeg', quality).then(function (blob) {
                          return blob.arrayBuffer().then(function (imgBytes) {
                            return outDoc.embedJpg(imgBytes).then(function (img) {
                              var pageOut = outDoc.addPage([img.width, img.height]);
                              pageOut.drawImage(img, { x: 0, y: 0, width: img.width, height: img.height });
                            });
                          });
                        });
                      });
                    });
                  });
                })(i);
              }
              return chain.then(function () {
                return outDoc.save().then(function (bytes) {
                  downloadBlob(new Blob([bytes], { type: 'application/pdf' }), 'nasira-compressed.pdf');
                  var saved = Math.max(0, 100 - Math.round((bytes.length / pdfFile.size) * 100));
                  panel.querySelector('#meta').innerHTML = metaRow([
                    ['Original', fmtBytes(pdfFile.size)],
                    ['Compressed', fmtBytes(bytes.length)],
                    ['Saved', saved + '%']
                  ]);
                  setProgress(panel, 100, 'Compressed PDF downloaded.');
                });
              });
            });
          });
        });
      }).catch(function (e) {
        setMsg(panel, e.message || 'Compression failed.', true);
        setProgress(panel, null);
      }).finally(function () { setBusy(panel, false); });
    });
  }

  function buildTextPdf(isMd) {
    root.innerHTML = '';
    var panel = h(
      '<div>' +
        '<div class="nasira-tool-field"><label>' + (isMd ? 'Markdown' : 'Text') + '</label>' +
        '<textarea id="txt" placeholder="' + (isMd ? '# My Resume Notes\n\n- Point one\n- Point two' : 'Paste or type your content…') + '"></textarea></div>' +
        '<div class="nasira-tool-field"><label>Title</label><input type="text" id="title" value="Nasira Document" /></div>' +
        '<div class="nasira-tool-actions"><button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="go">Download PDF</button></div>' +
      '</div>'
    );
    root.appendChild(panel);

    function mdToHtml(raw) {
      return raw
        .replace(/&/g, '&amp;').replace(/</g, '&lt;')
        .replace(/^### (.*)$/gm, '<h3>$1</h3>')
        .replace(/^## (.*)$/gm, '<h2>$1</h2>')
        .replace(/^# (.*)$/gm, '<h1>$1</h1>')
        .replace(/^\- (.*)$/gm, '<li>$1</li>')
        .replace(/(<li>.*<\/li>\n?)+/g, function (m) { return '<ul>' + m + '</ul>'; })
        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
        .replace(/\*(.*?)\*/g, '<em>$1</em>')
        .replace(/\n\n/g, '<br/><br/>')
        .replace(/\n/g, '<br/>');
    }

    panel.querySelector('#go').addEventListener('click', function () {
      var raw = panel.querySelector('#txt').value || '';
      if (!raw.trim()) {
        setMsg(panel, 'Please enter some content first.', true);
        return;
      }
      ensureHtml2Pdf().then(function () {
        var node = document.createElement('div');
        node.style.padding = '8px';
        node.style.fontFamily = 'Georgia, "Times New Roman", serif';
        node.style.fontSize = '12pt';
        node.style.color = '#111';
        var title = panel.querySelector('#title').value || 'Nasira Document';
        if (isMd) {
          node.innerHTML = '<h1 style="font-size:18pt;margin:0 0 12px">' + title.replace(/</g, '') + '</h1>' + mdToHtml(raw);
        } else {
          node.style.whiteSpace = 'pre-wrap';
          node.textContent = title + '\n\n' + raw;
        }
        return html2pdf().set({
          margin: 14,
          filename: 'nasira-notes.pdf',
          html2canvas: { scale: 2 },
          jsPDF: { unit: 'mm', format: 'a4' }
        }).from(node).save();
      }).then(function () {
        setMsg(panel, 'PDF downloaded.');
      }).catch(function (e) {
        setMsg(panel, e.message || 'Export failed.', true);
      });
    });
  }

  /* ---------- CAREER ---------- */
  function buildCoverLetter() {
    root.innerHTML =
      '<div>' +
        '<div class="row g-2">' +
          '<div class="col-md-6"><div class="nasira-tool-field"><label>Your name</label><input type="text" id="name" /></div></div>' +
          '<div class="col-md-6"><div class="nasira-tool-field"><label>Target role</label><input type="text" id="role" placeholder="Marketing Officer" /></div></div>' +
          '<div class="col-md-6"><div class="nasira-tool-field"><label>Company</label><input type="text" id="company" /></div></div>' +
          '<div class="col-md-6"><div class="nasira-tool-field"><label>Years of experience</label><input type="number" id="years" value="2" min="0" max="40" /></div></div>' +
        '</div>' +
        '<div class="nasira-tool-field"><label>Top strengths (comma separated)</label><input type="text" id="strengths" placeholder="communication, Excel, teamwork" /></div>' +
        '<div class="nasira-tool-field"><label>Tone</label><select id="tone"><option value="professional">Professional</option><option value="confident">Confident</option><option value="warm">Warm</option></select></div>' +
        '<div class="nasira-tool-actions">' +
          '<button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="gen">Generate draft</button>' +
          '<button type="button" class="nasira-tool-btn" id="copy" disabled>Copy</button>' +
          '<button type="button" class="nasira-tool-btn nasira-tool-btn--ghost" id="pdf" disabled>Download PDF</button>' +
        '</div>' +
        '<div class="nasira-tool-field"><label>Draft</label><textarea id="out"></textarea></div>' +
      '</div>';

    root.querySelector('#gen').addEventListener('click', function () {
      var name = root.querySelector('#name').value.trim() || '[Your Name]';
      var role = root.querySelector('#role').value.trim() || 'the open position';
      var company = root.querySelector('#company').value.trim() || '[Company]';
      var years = root.querySelector('#years').value || '2';
      var strengths = root.querySelector('#strengths').value.trim() || 'relevant skills and a strong work ethic';
      var tone = root.querySelector('#tone').value;
      var open = tone === 'warm'
        ? 'I hope this message finds you well. '
        : tone === 'confident'
          ? 'I am excited to submit my application for '
          : 'I am writing to express my interest in ';
      var body = tone === 'confident'
        ? open + 'the ' + role + ' role at ' + company + '. With ' + years + ' year(s) of experience and strengths in ' + strengths + ', I am ready to deliver results from day one.\n\n'
        : open + (tone === 'warm' ? 'I would love to be considered for the ' + role + ' role at ' + company + '. ' : 'the ' + role + ' role at ' + company + '. ') +
          'With ' + years + ' year(s) of experience and strengths in ' + strengths + ', I am confident I can contribute meaningfully to your team.\n\n';
      root.querySelector('#out').value =
        'Dear Hiring Manager,\n\n' + body +
        'I am motivated, reliable, and eager to grow with ' + company + '. I would welcome the opportunity to discuss how my background aligns with your goals.\n\n' +
        'Thank you for your time and consideration.\n\nSincerely,\n' + name;
      root.querySelector('#copy').disabled = false;
      root.querySelector('#pdf').disabled = false;
      setMsg(root, 'Draft ready — edit freely before sending.');
    });

    root.querySelector('#copy').addEventListener('click', function () {
      navigator.clipboard.writeText(root.querySelector('#out').value || '');
      setMsg(root, 'Copied.');
    });

    root.querySelector('#pdf').addEventListener('click', function () {
      ensureHtml2Pdf().then(function () {
        var node = document.createElement('div');
        node.style.whiteSpace = 'pre-wrap';
        node.style.fontFamily = 'Georgia, serif';
        node.style.fontSize = '12pt';
        node.style.padding = '12px';
        node.textContent = root.querySelector('#out').value || '';
        return html2pdf().set({ margin: 16, filename: 'nasira-cover-letter.pdf', html2canvas: { scale: 2 }, jsPDF: { unit: 'mm', format: 'a4' } }).from(node).save();
      });
    });
  }

  function buildResumeChecklist() {
    var items = [
      'Contact details are correct and professional',
      'Headline / title matches the jobs you want',
      'Summary is 3–4 lines, not a biography',
      'Experience uses action verbs and measurable results',
      'Skills match keywords from the job post',
      'Education and dates are accurate',
      'No spelling or grammar issues after a fresh read',
      'PDF exports cleanly on one or two pages',
      'File name is clear (e.g. Name_Role_CV.pdf)',
      'Links (LinkedIn / portfolio) open correctly'
    ];
    var key = 'nasira_resume_check_v1';
    var saved = {};
    try { saved = JSON.parse(localStorage.getItem(key) || '{}'); } catch (e) { saved = {}; }

    root.innerHTML =
      '<ul class="nasira-checklist nasira-check-grid" id="list">' +
      items.map(function (t, i) {
        return '<li><input type="checkbox" id="c' + i + '"' + (saved[i] ? ' checked' : '') + ' /><label for="c' + i + '">' + t + '</label></li>';
      }).join('') +
      '</ul><div class="nasira-tool-msg" id="score"></div>' +
      '<div class="nasira-tool-actions"><button type="button" class="nasira-tool-btn nasira-tool-btn--ghost" id="reset">Reset</button></div>';

    function update() {
      var state = {};
      var n = 0;
      items.forEach(function (_, i) {
        var on = root.querySelector('#c' + i).checked;
        state[i] = on;
        if (on) n++;
      });
      localStorage.setItem(key, JSON.stringify(state));
      var pct = Math.round((n / items.length) * 100);
      root.querySelector('#score').style.display = 'block';
      root.querySelector('#score').textContent = n + ' / ' + items.length + ' complete (' + pct + '%)' +
        (n === items.length ? ' — you look application-ready!' : '');
    }
    root.querySelectorAll('input').forEach(function (cb) { cb.addEventListener('change', update); });
    root.querySelector('#reset').addEventListener('click', function () {
      root.querySelectorAll('input').forEach(function (cb) { cb.checked = false; });
      update();
    });
    update();
  }

  function buildSalary() {
    root.innerHTML =
      '<div>' +
        '<div class="row g-2">' +
          '<div class="col-md-4"><div class="nasira-tool-field"><label>Gross amount</label><input type="number" id="amt" value="15000" min="0" /></div></div>' +
          '<div class="col-md-4"><div class="nasira-tool-field"><label>Period</label><select id="period"><option value="month">Monthly</option><option value="year">Yearly</option></select></div></div>' +
          '<div class="col-md-4"><div class="nasira-tool-field"><label>Deductions %</label><input type="number" id="ded" value="10" min="0" max="60" step="0.5" /></div></div>' +
        '</div>' +
        '<div class="nasira-tool-field"><label>Currency label</label><input type="text" id="cur" value="ETB" /></div>' +
        '<div class="nasira-tool-actions"><button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="go">Calculate</button></div>' +
        '<div class="nasira-tool-msg" id="out" style="display:none"></div>' +
      '</div>';
    function calc() {
      var amt = parseFloat(root.querySelector('#amt').value) || 0;
      var ded = (parseFloat(root.querySelector('#ded').value) || 0) / 100;
      var period = root.querySelector('#period').value;
      var cur = root.querySelector('#cur').value || '';
      var monthly = period === 'year' ? amt / 12 : amt;
      var yearly = period === 'year' ? amt : amt * 12;
      var out = root.querySelector('#out');
      out.style.display = 'block';
      out.innerHTML =
        '<strong>Est. net monthly:</strong> ' + cur + ' ' + Math.round(monthly * (1 - ded)).toLocaleString() + '<br/>' +
        '<strong>Est. net yearly:</strong> ' + cur + ' ' + Math.round(yearly * (1 - ded)).toLocaleString() + '<br/>' +
        '<strong>Gross monthly:</strong> ' + cur + ' ' + Math.round(monthly).toLocaleString() +
        '<br/><small>Estimate only — not tax or legal advice.</small>';
    }
    root.querySelector('#go').addEventListener('click', calc);
    calc();
  }

  function buildInterview() {
    var banks = {
      general: [
        ['Tell me about yourself.', 'Keep it to ~90 seconds: present role/studies → relevant strengths → why this job.'],
        ['Why do you want this role?', 'Connect company mission + role duties to your skills and goals.'],
        ['What are your strengths?', 'Pick 2–3 strengths and give a short example for each.'],
        ['Describe a challenge you solved.', 'Use STAR: Situation, Task, Action, Result.'],
        ['Where do you see yourself in 2–3 years?', 'Show growth ambition aligned with the company path.'],
        ['Do you have questions for us?', 'Ask about success metrics, team, and next steps.']
      ],
      technical: [
        ['Walk me through a recent project.', 'Focus on problem, your contribution, tools, and outcome.'],
        ['How do you debug under pressure?', 'Explain a calm process: reproduce → isolate → fix → verify.'],
        ['How do you stay updated?', 'Mention courses, docs, communities — be specific.']
      ],
      customer: [
        ['Describe a difficult customer situation.', 'Show empathy, listening, and a fair resolution.'],
        ['How do you handle competing priorities?', 'Talk about urgency vs impact and clear communication.']
      ]
    };
    root.innerHTML =
      '<div class="nasira-tool-field"><label>Question set</label>' +
      '<select id="set"><option value="general">General</option><option value="technical">Technical</option><option value="customer">Customer / Service</option></select></div>' +
      '<div id="cards"></div>';
    function render() {
      var set = root.querySelector('#set').value;
      root.querySelector('#cards').innerHTML = banks[set].map(function (q) {
        return '<div class="nasira-interview-card"><h4>' + q[0] + '</h4><p>' + q[1] + '</p></div>';
      }).join('');
    }
    root.querySelector('#set').addEventListener('change', render);
    render();
  }

  function buildKeywords() {
    root.innerHTML =
      '<div>' +
        '<div class="nasira-tool-field"><label>Paste the job description</label><textarea id="jd" placeholder="Paste JD text…"></textarea></div>' +
        '<div class="nasira-tool-actions">' +
          '<button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="go">Extract keywords</button>' +
          '<button type="button" class="nasira-tool-btn" id="copy" disabled>Copy list</button>' +
        '</div>' +
        '<div class="nasira-keyword-cloud" id="cloud"></div>' +
      '</div>';
    var stop = 'the and for with that this from your you are our will have has been their they who what when where which into about able must should can may also such other than then all any not but job role work working team company a an of to in on is as by be or at we us if'.split(' ').reduce(function (o, w) { o[w] = 1; return o; }, {});
    var last = [];
    root.querySelector('#go').addEventListener('click', function () {
      var text = (root.querySelector('#jd').value || '').toLowerCase().replace(/[^a-z0-9+#.\s-]/g, ' ');
      var counts = {};
      text.split(/\s+/).forEach(function (w) {
        if (w.length < 3 || stop[w]) return;
        counts[w] = (counts[w] || 0) + 1;
      });
      last = Object.keys(counts).sort(function (a, b) { return counts[b] - counts[a]; }).slice(0, 30);
      root.querySelector('#cloud').innerHTML = last.map(function (w) {
        return '<span title="' + counts[w] + '×">' + w + '</span>';
      }).join('') || '<span>No keywords found</span>';
      root.querySelector('#copy').disabled = !last.length;
      setMsg(root, last.length ? 'Add the strongest keywords into your CV skills/experience.' : 'Paste a longer job description.');
    });
    root.querySelector('#copy').addEventListener('click', function () {
      navigator.clipboard.writeText(last.join(', '));
      setMsg(root, 'Keyword list copied.');
    });
  }

  /* ---------- PRODUCTIVITY ---------- */
  function buildQr() {
    root.innerHTML =
      '<div>' +
        '<div class="nasira-tool-field"><label>URL or text</label><input type="text" id="url" placeholder="https://linkedin.com/in/you" /></div>' +
        '<div class="nasira-tool-field"><label>Size (px)</label><input type="number" id="sz" value="220" min="120" max="512" /></div>' +
        '<div class="nasira-tool-actions">' +
          '<button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="go">Generate QR</button>' +
          '<button type="button" class="nasira-tool-btn" id="dl" disabled>Download PNG</button>' +
        '</div>' +
        '<div id="qr" class="nasira-tool-preview"></div>' +
      '</div>';
    root.querySelector('#go').addEventListener('click', function () {
      ensureQr().then(function (QRCode) {
        var val = root.querySelector('#url').value.trim();
        var box = root.querySelector('#qr');
        box.innerHTML = '';
        if (!val) {
          setMsg(root, 'Enter a URL or text first.', true);
          return;
        }
        var size = parseInt(root.querySelector('#sz').value, 10) || 220;
        new QRCode(box, { text: val, width: size, height: size, correctLevel: QRCode.CorrectLevel.M });
        root.querySelector('#dl').disabled = false;
        setMsg(root, 'QR ready — add it to your CV or business card.');
      }).catch(function (e) { setMsg(root, e.message, true); });
    });
    root.querySelector('#dl').addEventListener('click', function () {
      var canvas = root.querySelector('#qr canvas');
      var img = root.querySelector('#qr img');
      if (canvas) {
        canvas.toBlob(function (blob) { downloadBlob(blob, 'nasira-qr.png'); });
      } else if (img) {
        downloadDataUrl(img.src, 'nasira-qr.png');
      }
    });
  }

  function buildWordCounter() {
    root.innerHTML =
      '<div class="nasira-tool-field"><label>Text</label><textarea id="t" placeholder="Paste cover letter or summary…"></textarea></div>' +
      '<div class="nasira-tool-msg" id="stats" style="display:block">0 words · 0 characters · 0 sentences</div>';
    function upd() {
      var t = root.querySelector('#t').value || '';
      var words = t.trim() ? t.trim().split(/\s+/).length : 0;
      var sentences = t.trim() ? (t.match(/[.!?]+/g) || []).length || 1 : 0;
      var paras = t.trim() ? t.split(/\n\s*\n/).filter(Boolean).length : 0;
      root.querySelector('#stats').textContent =
        words + ' words · ' + t.length + ' characters · ' + sentences + ' sentences · ' + paras + ' paragraphs · ~' +
        Math.max(words ? 1 : 0, Math.ceil(words / 200)) + ' min read';
    }
    root.querySelector('#t').addEventListener('input', upd);
  }

  function buildCase() {
    root.innerHTML =
      '<div class="nasira-tool-field"><label>Text</label><textarea id="t"></textarea></div>' +
      '<div class="nasira-tool-actions">' +
        '<button type="button" class="nasira-tool-btn" data-m="upper">UPPER</button>' +
        '<button type="button" class="nasira-tool-btn" data-m="lower">lower</button>' +
        '<button type="button" class="nasira-tool-btn" data-m="title">Title Case</button>' +
        '<button type="button" class="nasira-tool-btn" data-m="sentence">Sentence case</button>' +
        '<button type="button" class="nasira-tool-btn" data-m="snake">snake_case</button>' +
        '<button type="button" class="nasira-tool-btn" data-m="kebab">kebab-case</button>' +
        '<button type="button" class="nasira-tool-btn" data-m="camel">camelCase</button>' +
      '</div>';
    root.querySelectorAll('[data-m]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var t = root.querySelector('#t');
        var v = t.value || '';
        var m = btn.getAttribute('data-m');
        if (m === 'upper') t.value = v.toUpperCase();
        if (m === 'lower') t.value = v.toLowerCase();
        if (m === 'title') t.value = v.toLowerCase().replace(/\b\w/g, function (c) { return c.toUpperCase(); });
        if (m === 'sentence') t.value = v.toLowerCase().replace(/(^\s*\w|[.!?]\s*\w)/g, function (c) { return c.toUpperCase(); });
        if (m === 'snake') t.value = v.trim().toLowerCase().replace(/\s+/g, '_').replace(/[^\w_]/g, '');
        if (m === 'kebab') t.value = v.trim().toLowerCase().replace(/\s+/g, '-').replace(/[^\w-]/g, '');
        if (m === 'camel') {
          t.value = v.trim().toLowerCase().replace(/[^a-z0-9]+([a-z0-9])/g, function (_, c) { return c.toUpperCase(); });
        }
      });
    });
  }

  function buildLorem() {
    var words = 'opportunity career growth talent skills experience professional dedicated reliable creative analytical collaborative leadership communication problem-solving innovation excellence results strategy development training mentorship portfolio interview application resume cover letter employer candidate marketplace'.split(' ');
    root.innerHTML =
      '<div class="row g-2">' +
        '<div class="col-md-4"><div class="nasira-tool-field"><label>Paragraphs</label><input type="number" id="n" value="3" min="1" max="12" /></div></div>' +
        '<div class="col-md-4"><div class="nasira-tool-field"><label>Sentences / paragraph</label><input type="number" id="s" value="4" min="2" max="10" /></div></div>' +
        '<div class="col-md-4"><div class="nasira-tool-field"><label>Start with “Lorem”</label><select id="classic"><option value="1">Yes</option><option value="0">No</option></select></div></div>' +
      '</div>' +
      '<div class="nasira-tool-actions"><button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="go">Generate</button><button type="button" class="nasira-tool-btn" id="copy">Copy</button></div>' +
      '<div class="nasira-tool-field"><textarea id="out"></textarea></div>';
    function sentence() {
      var len = 8 + Math.floor(Math.random() * 10);
      var arr = [];
      for (var i = 0; i < len; i++) arr.push(words[Math.floor(Math.random() * words.length)]);
      var s = arr.join(' ');
      return s.charAt(0).toUpperCase() + s.slice(1) + '.';
    }
    root.querySelector('#go').addEventListener('click', function () {
      var n = parseInt(root.querySelector('#n').value, 10) || 3;
      var s = parseInt(root.querySelector('#s').value, 10) || 4;
      var out = [];
      for (var i = 0; i < n; i++) {
        var lines = [];
        for (var j = 0; j < s; j++) lines.push(sentence());
        if (i === 0 && root.querySelector('#classic').value === '1') {
          lines[0] = 'Lorem ipsum dolor sit amet, ' + lines[0].charAt(0).toLowerCase() + lines[0].slice(1);
        }
        out.push(lines.join(' '));
      }
      root.querySelector('#out').value = out.join('\n\n');
    });
    root.querySelector('#copy').addEventListener('click', function () {
      navigator.clipboard.writeText(root.querySelector('#out').value || '');
      setMsg(root, 'Copied.');
    });
  }


  function buildColor() {
    root.innerHTML =
      '<div class="nasira-cp">' +
        '<div class="nasira-cp-main">' +
          '<div class="nasira-cp-map-wrap">' +
            '<canvas id="cp-map" width="280" height="200" aria-label="Saturation and brightness"></canvas>' +
            '<div class="nasira-cp-map-cursor" id="cp-map-cur"></div>' +
          '</div>' +
          '<div class="nasira-cp-hue-wrap">' +
            '<canvas id="cp-hue" width="24" height="200" aria-label="Hue"></canvas>' +
            '<div class="nasira-cp-hue-cursor" id="cp-hue-cur"></div>' +
          '</div>' +
          '<div class="nasira-cp-preview-col">' +
            '<div class="nasira-cp-preview" id="cp-preview">' +
              '<span class="nasira-cp-preview-dark">Text</span>' +
              '<span class="nasira-cp-preview-light">Text</span>' +
            '</div>' +
            '<div class="nasira-cp-alpha">' +
              '<label>Opacity <strong id="cp-a-label">100%</strong></label>' +
              '<input type="range" id="cp-alpha" min="0" max="100" value="100" />' +
            '</div>' +
          '</div>' +
        '</div>' +
        '<div class="nasira-cp-fields">' +
          '<div class="nasira-tool-field"><label>HEX</label><input type="text" id="cp-hex" value="#006837" spellcheck="false" /></div>' +
          '<div class="nasira-tool-field"><label>R</label><input type="number" id="cp-r" min="0" max="255" value="0" /></div>' +
          '<div class="nasira-tool-field"><label>G</label><input type="number" id="cp-g" min="0" max="255" value="104" /></div>' +
          '<div class="nasira-tool-field"><label>B</label><input type="number" id="cp-b" min="0" max="255" value="55" /></div>' +
          '<div class="nasira-tool-field"><label>H</label><input type="number" id="cp-h" min="0" max="360" value="152" /></div>' +
          '<div class="nasira-tool-field"><label>S%</label><input type="number" id="cp-s" min="0" max="100" value="100" /></div>' +
          '<div class="nasira-tool-field"><label>L%</label><input type="number" id="cp-l" min="0" max="100" value="20" /></div>' +
        '</div>' +
        '<div class="nasira-tool-actions">' +
          '<button type="button" class="nasira-tool-btn" id="cp-copy-hex">Copy HEX</button>' +
          '<button type="button" class="nasira-tool-btn" id="cp-copy-rgb">Copy RGB</button>' +
          '<button type="button" class="nasira-tool-btn" id="cp-copy-hsl">Copy HSL</button>' +
          '<button type="button" class="nasira-tool-btn nasira-tool-btn--ghost" id="cp-copy-rgba">Copy RGBA</button>' +
        '</div>' +
        '<div class="nasira-tool-msg" id="cp-msg" style="display:none"></div>' +
        '<div class="nasira-cp-image">' +
          '<div class="nasira-cp-image-head">' +
            '<h4>Pick color from image</h4>' +
            '<p>Upload a photo, then click anywhere on it to sample that pixel.</p>' +
          '</div>' +
          '<label class="nasira-cp-image-upload" id="cp-img-zone">' +
            '<input type="file" id="cp-img-file" accept="image/png,image/jpeg,image/jpg,image/webp,image/gif" />' +
            '<i class="fa-solid fa-image"></i>' +
            '<strong>Upload image</strong>' +
            '<span>JPG, PNG, WEBP, GIF · click to pick colors</span>' +
          '</label>' +
          '<div class="nasira-cp-image-stage" id="cp-img-stage" hidden>' +
            '<div class="nasira-cp-image-canvas-wrap">' +
              '<canvas id="cp-img-canvas"></canvas>' +
              '<div class="nasira-cp-image-crosshair" id="cp-img-cross" hidden></div>' +
            '</div>' +
            '<div class="nasira-cp-image-side">' +
              '<div class="nasira-cp-image-sample" id="cp-img-sample"></div>' +
              '<div class="nasira-cp-image-meta" id="cp-img-meta">Click the image to sample</div>' +
              '<div class="nasira-cp-image-history" id="cp-img-history" aria-label="Sampled colors"></div>' +
              '<button type="button" class="nasira-tool-btn nasira-tool-btn--ghost" id="cp-img-clear">Clear image</button>' +
            '</div>' +
          '</div>' +
        '</div>' +
        '<div class="nasira-cp-shades">' +
          '<h4>Shades &amp; tints</h4>' +
          '<div class="nasira-cp-shade-row" id="cp-shades"></div>' +
        '</div>' +
      '</div>';

    var state = { h: 152, s: 1, v: 0.41, a: 1 };
    var map = root.querySelector('#cp-map');
    var hue = root.querySelector('#cp-hue');
    var mapCtx = map.getContext('2d');
    var hueCtx = hue.getContext('2d');
    var dragging = null;

    function clamp(n, min, max) { return Math.max(min, Math.min(max, n)); }

    function hsvToRgb(h, s, v) {
      h = ((h % 360) + 360) % 360;
      var c = v * s;
      var x = c * (1 - Math.abs(((h / 60) % 2) - 1));
      var m = v - c;
      var r = 0, g = 0, b = 0;
      if (h < 60) { r = c; g = x; }
      else if (h < 120) { r = x; g = c; }
      else if (h < 180) { g = c; b = x; }
      else if (h < 240) { g = x; b = c; }
      else if (h < 300) { r = x; b = c; }
      else { r = c; b = x; }
      return {
        r: Math.round((r + m) * 255),
        g: Math.round((g + m) * 255),
        b: Math.round((b + m) * 255)
      };
    }

    function rgbToHsv(r, g, b) {
      r /= 255; g /= 255; b /= 255;
      var max = Math.max(r, g, b), min = Math.min(r, g, b);
      var d = max - min;
      var h = 0, s = max === 0 ? 0 : d / max, v = max;
      if (d) {
        if (max === r) h = ((g - b) / d + (g < b ? 6 : 0)) * 60;
        else if (max === g) h = ((b - r) / d + 2) * 60;
        else h = ((r - g) / d + 4) * 60;
      }
      return { h: h, s: s, v: v };
    }

    function rgbToHsl(r, g, b) {
      r /= 255; g /= 255; b /= 255;
      var max = Math.max(r, g, b), min = Math.min(r, g, b);
      var h = 0, s = 0, l = (max + min) / 2;
      if (max !== min) {
        var d = max - min;
        s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
        if (max === r) h = ((g - b) / d + (g < b ? 6 : 0)) * 60;
        else if (max === g) h = ((b - r) / d + 2) * 60;
        else h = ((r - g) / d + 4) * 60;
      }
      return { h: Math.round(h), s: Math.round(s * 100), l: Math.round(l * 100) };
    }

    function hslToRgb(h, s, l) {
      s /= 100; l /= 100;
      var c = (1 - Math.abs(2 * l - 1)) * s;
      var x = c * (1 - Math.abs(((h / 60) % 2) - 1));
      var m = l - c / 2;
      var r = 0, g = 0, b = 0;
      if (h < 60) { r = c; g = x; }
      else if (h < 120) { r = x; g = c; }
      else if (h < 180) { g = c; b = x; }
      else if (h < 240) { g = x; b = c; }
      else if (h < 300) { r = x; b = c; }
      else { r = c; b = x; }
      return {
        r: Math.round((r + m) * 255),
        g: Math.round((g + m) * 255),
        b: Math.round((b + m) * 255)
      };
    }

    function toHex(r, g, b) {
      return '#' + [r, g, b].map(function (n) {
        var s = clamp(n, 0, 255).toString(16);
        return s.length < 2 ? '0' + s : s;
      }).join('').toUpperCase();
    }

    function paintHue() {
      var grd = hueCtx.createLinearGradient(0, 0, 0, hue.height);
      for (var i = 0; i <= 6; i++) {
        var rgb = hsvToRgb(i * 60, 1, 1);
        grd.addColorStop(i / 6, 'rgb(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ')');
      }
      hueCtx.fillStyle = grd;
      hueCtx.fillRect(0, 0, hue.width, hue.height);
    }

    function paintMap() {
      var base = hsvToRgb(state.h, 1, 1);
      mapCtx.fillStyle = 'rgb(' + base.r + ',' + base.g + ',' + base.b + ')';
      mapCtx.fillRect(0, 0, map.width, map.height);
      var white = mapCtx.createLinearGradient(0, 0, map.width, 0);
      white.addColorStop(0, '#fff');
      white.addColorStop(1, 'rgba(255,255,255,0)');
      mapCtx.fillStyle = white;
      mapCtx.fillRect(0, 0, map.width, map.height);
      var black = mapCtx.createLinearGradient(0, 0, 0, map.height);
      black.addColorStop(0, 'rgba(0,0,0,0)');
      black.addColorStop(1, '#000');
      mapCtx.fillStyle = black;
      mapCtx.fillRect(0, 0, map.width, map.height);
    }

    function updateCursors() {
      root.querySelector('#cp-map-cur').style.left = (state.s * map.width) + 'px';
      root.querySelector('#cp-map-cur').style.top = ((1 - state.v) * map.height) + 'px';
      root.querySelector('#cp-hue-cur').style.top = ((state.h / 360) * hue.height) + 'px';
    }

    function renderShades(rgb) {
      var row = root.querySelector('#cp-shades');
      row.innerHTML = '';
      for (var i = 0; i <= 10; i++) {
        var factor = i / 10;
        var mixR, mixG, mixB;
        if (factor <= 0.5) {
          var tw = 1 - factor * 2;
          mixR = Math.round(rgb.r + (255 - rgb.r) * tw);
          mixG = Math.round(rgb.g + (255 - rgb.g) * tw);
          mixB = Math.round(rgb.b + (255 - rgb.b) * tw);
        } else {
          var tb = (factor - 0.5) * 2;
          mixR = Math.round(rgb.r * (1 - tb));
          mixG = Math.round(rgb.g * (1 - tb));
          mixB = Math.round(rgb.b * (1 - tb));
        }
        var hex = toHex(mixR, mixG, mixB);
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.title = hex;
        btn.style.background = hex;
        btn.setAttribute('data-hex', hex);
        btn.addEventListener('click', function (ev) {
          applyHex(ev.currentTarget.getAttribute('data-hex'));
        });
        row.appendChild(btn);
      }
    }

    function syncUi() {
      var rgb = hsvToRgb(state.h, state.s, state.v);
      var hex = toHex(rgb.r, rgb.g, rgb.b);
      var hsl = rgbToHsl(rgb.r, rgb.g, rgb.b);
      var preview = root.querySelector('#cp-preview');
      preview.style.background = 'rgba(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ',' + state.a + ')';
      root.querySelector('#cp-hex').value = hex;
      root.querySelector('#cp-r').value = rgb.r;
      root.querySelector('#cp-g').value = rgb.g;
      root.querySelector('#cp-b').value = rgb.b;
      root.querySelector('#cp-h').value = Math.round(hsl.h);
      root.querySelector('#cp-s').value = hsl.s;
      root.querySelector('#cp-l').value = hsl.l;
      root.querySelector('#cp-a-label').textContent = Math.round(state.a * 100) + '%';
      root.querySelector('#cp-alpha').value = Math.round(state.a * 100);
      paintMap();
      updateCursors();
      renderShades(rgb);
      root._cp = {
        hex: hex,
        rgb: rgb.r + ', ' + rgb.g + ', ' + rgb.b,
        hsl: 'hsl(' + hsl.h + ', ' + hsl.s + '%, ' + hsl.l + '%)',
        rgba: 'rgba(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ', ' + (Math.round(state.a * 100) / 100) + ')'
      };
    }

    function applyHex(hex) {
      if (!/^#?[0-9a-fA-F]{6}$/.test(hex)) return;
      if (hex[0] !== '#') hex = '#' + hex;
      var r = parseInt(hex.slice(1, 3), 16);
      var g = parseInt(hex.slice(3, 5), 16);
      var b = parseInt(hex.slice(5, 7), 16);
      var hsv = rgbToHsv(r, g, b);
      state.h = hsv.h; state.s = hsv.s; state.v = hsv.v;
      syncUi();
    }

    function pickMap(ev) {
      var rect = map.getBoundingClientRect();
      var x = clamp((ev.clientX - rect.left) / rect.width, 0, 1);
      var y = clamp((ev.clientY - rect.top) / rect.height, 0, 1);
      state.s = x;
      state.v = 1 - y;
      syncUi();
    }

    function pickHue(ev) {
      var rect = hue.getBoundingClientRect();
      var y = clamp((ev.clientY - rect.top) / rect.height, 0, 1);
      state.h = y * 360;
      syncUi();
    }

    function onMove(ev) {
      if (dragging === 'map') pickMap(ev);
      if (dragging === 'hue') pickHue(ev);
    }

    function onUp() { dragging = null; }

    map.addEventListener('mousedown', function (ev) { dragging = 'map'; pickMap(ev); });
    hue.addEventListener('mousedown', function (ev) { dragging = 'hue'; pickHue(ev); });
    window.addEventListener('mousemove', onMove);
    window.addEventListener('mouseup', onUp);

    map.addEventListener('touchstart', function (ev) {
      dragging = 'map';
      pickMap(ev.touches[0]);
      ev.preventDefault();
    }, { passive: false });
    hue.addEventListener('touchstart', function (ev) {
      dragging = 'hue';
      pickHue(ev.touches[0]);
      ev.preventDefault();
    }, { passive: false });
    window.addEventListener('touchmove', function (ev) {
      if (!dragging) return;
      onMove(ev.touches[0]);
      ev.preventDefault();
    }, { passive: false });
    window.addEventListener('touchend', onUp);

    root.querySelector('#cp-alpha').addEventListener('input', function () {
      state.a = clamp(Number(this.value) / 100, 0, 1);
      syncUi();
    });

    root.querySelector('#cp-hex').addEventListener('change', function () {
      applyHex(this.value.trim());
    });

    ['r', 'g', 'b'].forEach(function (ch) {
      root.querySelector('#cp-' + ch).addEventListener('change', function () {
        var r = clamp(Number(root.querySelector('#cp-r').value) || 0, 0, 255);
        var g = clamp(Number(root.querySelector('#cp-g').value) || 0, 0, 255);
        var b = clamp(Number(root.querySelector('#cp-b').value) || 0, 0, 255);
        var hsv = rgbToHsv(r, g, b);
        state.h = hsv.h; state.s = hsv.s; state.v = hsv.v;
        syncUi();
      });
    });

    ['h', 's', 'l'].forEach(function (ch) {
      root.querySelector('#cp-' + ch).addEventListener('change', function () {
        var hh = clamp(Number(root.querySelector('#cp-h').value) || 0, 0, 360);
        var ss = clamp(Number(root.querySelector('#cp-s').value) || 0, 0, 100);
        var ll = clamp(Number(root.querySelector('#cp-l').value) || 0, 0, 100);
        var rgb = hslToRgb(hh, ss, ll);
        var hsv = rgbToHsv(rgb.r, rgb.g, rgb.b);
        state.h = hsv.h; state.s = hsv.s; state.v = hsv.v;
        syncUi();
      });
    });

    function flash(msg) {
      var box = root.querySelector('#cp-msg');
      box.textContent = msg;
      box.style.display = 'block';
      setTimeout(function () { box.style.display = 'none'; }, 1600);
    }

    root.querySelector('#cp-copy-hex').addEventListener('click', function () {
      navigator.clipboard.writeText(root._cp.hex); flash('HEX copied.');
    });
    root.querySelector('#cp-copy-rgb').addEventListener('click', function () {
      navigator.clipboard.writeText('rgb(' + root._cp.rgb + ')'); flash('RGB copied.');
    });
    root.querySelector('#cp-copy-hsl').addEventListener('click', function () {
      navigator.clipboard.writeText(root._cp.hsl); flash('HSL copied.');
    });
    root.querySelector('#cp-copy-rgba').addEventListener('click', function () {
      navigator.clipboard.writeText(root._cp.rgba); flash('RGBA copied.');
    });

    /* ---- Pick color from uploaded image ---- */
    var imgCanvas = root.querySelector('#cp-img-canvas');
    var imgCtx = imgCanvas.getContext('2d', { willReadFrequently: true });
    var imgHistory = [];
    var imgDragging = false;

    function applyRgb(r, g, b, note) {
      var hsv = rgbToHsv(r, g, b);
      state.h = hsv.h; state.s = hsv.s; state.v = hsv.v;
      syncUi();
      var hex = toHex(r, g, b);
      root.querySelector('#cp-img-sample').style.background = hex;
      root.querySelector('#cp-img-meta').textContent = hex + ' · rgb(' + r + ', ' + g + ', ' + b + ')';
      if (note) flash(note);
      if (imgHistory[0] !== hex) {
        imgHistory.unshift(hex);
        if (imgHistory.length > 12) imgHistory.pop();
        var hist = root.querySelector('#cp-img-history');
        hist.innerHTML = '';
        imgHistory.forEach(function (h) {
          var btn = document.createElement('button');
          btn.type = 'button';
          btn.title = h;
          btn.style.background = h;
          btn.addEventListener('click', function () { applyHex(h); });
          hist.appendChild(btn);
        });
      }
    }

    function sampleImageAt(clientX, clientY) {
      var rect = imgCanvas.getBoundingClientRect();
      if (!rect.width || !rect.height) return;
      var x = Math.floor(clamp((clientX - rect.left) / rect.width, 0, 0.999999) * imgCanvas.width);
      var y = Math.floor(clamp((clientY - rect.top) / rect.height, 0, 0.999999) * imgCanvas.height);
      var pixel = imgCtx.getImageData(x, y, 1, 1).data;
      applyRgb(pixel[0], pixel[1], pixel[2], 'Color sampled from image.');
      var cross = root.querySelector('#cp-img-cross');
      cross.hidden = false;
      cross.style.left = ((x + 0.5) / imgCanvas.width * 100) + '%';
      cross.style.top = ((y + 0.5) / imgCanvas.height * 100) + '%';
    }

    function loadPickerImage(file) {
      if (!file || !/^image\//.test(file.type || '')) {
        flash('Please choose an image file.');
        return;
      }
      var url = URL.createObjectURL(file);
      var img = new Image();
      img.onload = function () {
        URL.revokeObjectURL(url);
        var maxW = 900;
        var maxH = 520;
        var scale = Math.min(1, maxW / img.naturalWidth, maxH / img.naturalHeight);
        imgCanvas.width = Math.max(1, Math.round(img.naturalWidth * scale));
        imgCanvas.height = Math.max(1, Math.round(img.naturalHeight * scale));
        imgCtx.clearRect(0, 0, imgCanvas.width, imgCanvas.height);
        imgCtx.drawImage(img, 0, 0, imgCanvas.width, imgCanvas.height);
        root.querySelector('#cp-img-zone').hidden = true;
        root.querySelector('#cp-img-stage').hidden = false;
        root.querySelector('#cp-img-cross').hidden = true;
        root.querySelector('#cp-img-meta').textContent = 'Click the image to sample a color';
        flash('Image ready — click to pick a color.');
      };
      img.onerror = function () {
        URL.revokeObjectURL(url);
        flash('Could not load that image.');
      };
      img.src = url;
    }

    root.querySelector('#cp-img-file').addEventListener('change', function (ev) {
      var f = ev.target.files && ev.target.files[0];
      if (f) loadPickerImage(f);
      ev.target.value = '';
    });

    var zone = root.querySelector('#cp-img-zone');
    zone.addEventListener('dragover', function (ev) {
      ev.preventDefault();
      zone.classList.add('is-drag');
    });
    zone.addEventListener('dragleave', function () { zone.classList.remove('is-drag'); });
    zone.addEventListener('drop', function (ev) {
      ev.preventDefault();
      zone.classList.remove('is-drag');
      var f = ev.dataTransfer && ev.dataTransfer.files && ev.dataTransfer.files[0];
      if (f) loadPickerImage(f);
    });

    imgCanvas.addEventListener('mousedown', function (ev) {
      imgDragging = true;
      sampleImageAt(ev.clientX, ev.clientY);
    });
    imgCanvas.addEventListener('mousemove', function (ev) {
      if (imgDragging) sampleImageAt(ev.clientX, ev.clientY);
    });
    window.addEventListener('mouseup', function () { imgDragging = false; });

    imgCanvas.addEventListener('touchstart', function (ev) {
      if (!ev.touches[0]) return;
      sampleImageAt(ev.touches[0].clientX, ev.touches[0].clientY);
      ev.preventDefault();
    }, { passive: false });
    imgCanvas.addEventListener('touchmove', function (ev) {
      if (!ev.touches[0]) return;
      sampleImageAt(ev.touches[0].clientX, ev.touches[0].clientY);
      ev.preventDefault();
    }, { passive: false });

    root.querySelector('#cp-img-clear').addEventListener('click', function () {
      imgCtx.clearRect(0, 0, imgCanvas.width, imgCanvas.height);
      imgCanvas.width = 0;
      imgCanvas.height = 0;
      root.querySelector('#cp-img-stage').hidden = true;
      root.querySelector('#cp-img-zone').hidden = false;
      root.querySelector('#cp-img-cross').hidden = true;
      root.querySelector('#cp-img-meta').textContent = 'Click the image to sample';
    });

    paintHue();
    applyHex('#006837');
  }


  function buildBase64() {
    root.innerHTML =
      '<div>' +
        '<div class="nasira-tool-field"><label>Mode</label><select id="mode"><option value="encode">Image → Base64</option><option value="decode">Base64 → Image download</option></select></div>' +
        '<div id="enc">' + dropHtml('image/*', 'Encode image as data URL') + '</div>' +
        '<div class="nasira-tool-field"><label>Base64 / Data URL</label><textarea id="out" placeholder="data:image/png;base64,..."></textarea></div>' +
        '<div class="nasira-tool-actions">' +
          '<button type="button" class="nasira-tool-btn" id="copy">Copy</button>' +
          '<button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="dec">Download from Base64</button>' +
        '</div>' +
        '<div class="nasira-tool-preview" hidden><img id="prev" alt="Decoded" /></div>' +
      '</div>';
    bindDrop(root, function (file) {
      var reader = new FileReader();
      reader.onload = function () {
        root.querySelector('#out').value = reader.result;
        setMsg(root, 'Encoded ' + fmtBytes(file.size) + ' → ' + fmtBytes(reader.result.length) + ' text.');
      };
      reader.readAsDataURL(file);
    });
    root.querySelector('#copy').addEventListener('click', function () {
      navigator.clipboard.writeText(root.querySelector('#out').value || '');
      setMsg(root, 'Copied.');
    });
    root.querySelector('#dec').addEventListener('click', function () {
      var v = (root.querySelector('#out').value || '').trim();
      if (!v) return;
      if (v.indexOf('data:') !== 0) v = 'data:image/png;base64,' + v;
      try {
        var blob = dataUrlToBlob(v);
        var ext = (blob.type.split('/')[1] || 'png').replace('jpeg', 'jpg');
        downloadBlob(blob, 'nasira-from-base64.' + ext);
        var prev = root.querySelector('#prev');
        prev.src = v;
        root.querySelector('.nasira-tool-preview').hidden = false;
      } catch (e) {
        setMsg(root, 'Invalid Base64 data.', true);
      }
    });
  }

  function buildTimezone() {
    root.innerHTML =
      '<div>' +
        '<div class="nasira-tool-field"><label>Interview date & time (your local clock)</label><input type="datetime-local" id="dt" /></div>' +
        '<div class="nasira-tool-actions"><button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="go">Compare zones</button></div>' +
        '<div class="nasira-tool-msg" id="out" style="display:none"></div>' +
      '</div>';
    var zones = [
      ['UTC', 'UTC'],
      ['East Africa (Nairobi)', 'Africa/Nairobi'],
      ['Addis Ababa', 'Africa/Addis_Ababa'],
      ['Cairo', 'Africa/Cairo'],
      ['London', 'Europe/London'],
      ['Berlin', 'Europe/Berlin'],
      ['Dubai', 'Asia/Dubai'],
      ['India', 'Asia/Kolkata'],
      ['New York', 'America/New_York'],
      ['Los Angeles', 'America/Los_Angeles']
    ];
    root.querySelector('#go').addEventListener('click', function () {
      var v = root.querySelector('#dt').value;
      if (!v) {
        setMsg(root, 'Pick a date and time first.', true);
        return;
      }
      var d = new Date(v);
      var lines = zones.map(function (z) {
        try {
          return '<strong>' + z[0] + ':</strong> ' +
            new Intl.DateTimeFormat('en-GB', { timeZone: z[1], weekday: 'short', dateStyle: 'medium', timeStyle: 'short' }).format(d);
        } catch (e) {
          return '<strong>' + z[0] + ':</strong> unavailable';
        }
      });
      var out = root.querySelector('#out');
      out.style.display = 'block';
      out.innerHTML = lines.join('<br/>');
    });
  }

  /* ---------- router ---------- */
  var map = {
    'background-remover': buildBackgroundRemover,
    'png-to-jpg': buildPngToJpg,
    'jpg-to-png': function () { buildImageConvert('png', 'image/png', 1); },
    'webp-converter': buildWebp,
    'image-compressor': buildCompressor,
    'docx-to-pdf': buildWordToPdf,
    'time-converter': buildTimezone,
    'image-resizer': buildResizer,
    'image-cropper': function () { buildCropperTool(false); },
    'passport-photo': function () { buildCropperTool(true); },
    'pdf-to-word': buildPdfToWord,
    'word-to-pdf': buildWordToPdf,
    'pdf-merger': buildPdfMerger,
    'pdf-splitter': buildPdfSplitter,
    'pdf-compressor': buildPdfCompressor,
    'txt-to-pdf': function () { buildTextPdf(false); },
    'markdown-to-pdf': function () { buildTextPdf(true); },
    'cover-letter-helper': buildCoverLetter,
    'resume-checker': buildResumeChecklist,
    'salary-calculator': buildSalary,
    'interview-prep': buildInterview,
    'job-description-keywords': buildKeywords,
    'qr-code-generator': buildQr,
    'word-counter': buildWordCounter,
    'case-converter': buildCase,
    'lorem-generator': buildLorem,
    'color-picker': buildColor,
    'base64-image': buildBase64,
    'timezone-converter': buildTimezone
  };

  function bootSpecial() {
    if (!map[slug]) {
      root.innerHTML = '<div class="nasira-tool-msg">This tool is unavailable. <a href="/solutions">Browse all solutions</a>.</div>';
      return;
    }
    try {
      map[slug]();
    } catch (err) {
      console.error(err);
      root.innerHTML = '<div class="nasira-tool-msg is-error">Could not start this tool. Please refresh the page.</div>';
    }
  }

  function boot() {
    page = document.querySelector('.nasira-tool-page');
    if (!page) return;
    slug = page.getAttribute('data-tool');
    root = document.getElementById('nasira-tool-root');
    if (!root || !slug) return;

    var meta = window.NasiraToolMeta || null;
    var engine = (meta && meta.engine) || page.getAttribute('data-engine') || 'special';
    var usesFreeConvert = ['ffmpeg', 'image', 'heic', 'pdf', 'doc', 'ebook', 'archive', 'unit'].indexOf(engine) !== -1;

    if (usesFreeConvert) {
      var tries = 0;
      (function waitFc() {
        if (window.NasiraFreeConvert && window.NasiraFreeConvert.canHandle(meta || { engine: engine })) {
          try {
            window.NasiraFreeConvert.mount(root, meta || { slug: slug, name: slug, desc: '', engine: engine, outputs: [] });
          } catch (err) {
            console.error(err);
            root.innerHTML = '<div class="nasira-tool-msg is-error">Could not start this converter. Please refresh the page.</div>';
          }
          return;
        }
        if (++tries > 80) {
          root.innerHTML = '<div class="nasira-tool-msg is-error">Converter engine failed to load. Refresh the page.</div>';
          return;
        }
        setTimeout(waitFc, 50);
      })();
      return;
    }

    bootSpecial();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
