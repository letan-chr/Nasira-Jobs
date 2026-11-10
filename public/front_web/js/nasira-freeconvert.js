/**
 * Nasira FreeConvert — production browser converters
 * Upload → Convert → Download (ZIP for batches). Files stay on-device.
 */
(function (global) {
  'use strict';

  var ffmpegInstance = null;
  var ffmpegLoading = null;
  var MAX_BYTES = (window.NasiraSolutionsLimits && window.NasiraSolutionsLimits.maxBytes) || (40 * 1024 * 1024);

  /* ---------- utils ---------- */
  function fmtBytes(n) {
    n = Number(n) || 0;
    if (n < 1024) return n + ' B';
    if (n < 1048576) return (n / 1024).toFixed(1) + ' KB';
    return (n / 1048576).toFixed(2) + ' MB';
  }

  function downloadBlob(blob, name) {
    if (!blob) return;
    if (global.saveAs) return global.saveAs(blob, name);
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = name || 'download.bin';
    document.body.appendChild(a);
    a.click();
    a.remove();
    setTimeout(function () { URL.revokeObjectURL(url); }, 4000);
  }

  function baseName(name) {
    return String(name || 'file').replace(/\.[^.]+$/, '') || 'file';
  }

  function extOf(name) {
    var m = String(name || '').match(/\.([^.]+)$/);
    return m ? m[1].toLowerCase() : '';
  }

  function h(html) {
    var d = document.createElement('div');
    d.innerHTML = String(html).trim();
    return d.firstChild;
  }

  function escapeHtml(s) {
    return String(s)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  function mimeForExt(ext) {
    var map = {
      jpg: 'image/jpeg', jpeg: 'image/jpeg', png: 'image/png', webp: 'image/webp', gif: 'image/gif',
      svg: 'image/svg+xml', pdf: 'application/pdf', mp3: 'audio/mpeg', wav: 'audio/wav', ogg: 'audio/ogg',
      aac: 'audio/aac', m4a: 'audio/mp4', mp4: 'video/mp4', webm: 'video/webm', mov: 'video/quicktime',
      mkv: 'video/x-matroska', avi: 'video/x-msvideo', zip: 'application/zip', epub: 'application/epub+zip',
      txt: 'text/plain'
    };
    return map[String(ext || '').toLowerCase()] || 'application/octet-stream';
  }

  function canvasToBlob(canvas, mime, quality) {
    return new Promise(function (resolve, reject) {
      try {
        canvas.toBlob(function (blob) {
          if (blob) return resolve(blob);
          try {
            var dataUrl = canvas.toDataURL(mime || 'image/png', quality);
            resolve(dataUrlToBlob(dataUrl));
          } catch (e) {
            reject(e);
          }
        }, mime || 'image/png', quality);
      } catch (e) {
        reject(e);
      }
    });
  }

  function dataUrlToBlob(dataUrl) {
    var parts = String(dataUrl).split(',');
    var mime = (parts[0].match(/:(.*?);/) || [])[1] || 'application/octet-stream';
    var bin = atob(parts[1] || '');
    var arr = new Uint8Array(bin.length);
    for (var i = 0; i < bin.length; i++) arr[i] = bin.charCodeAt(i);
    return new Blob([arr], { type: mime });
  }

  function loadImageFile(file) {
    return new Promise(function (resolve, reject) {
      if (!file) return reject(new Error('No file selected.'));
      var url = URL.createObjectURL(file);
      var img = new Image();
      img.decoding = 'async';
      img.onload = function () {
        URL.revokeObjectURL(url);
        if (!img.naturalWidth) return reject(new Error('Invalid image: ' + file.name));
        resolve(img);
      };
      img.onerror = function () {
        URL.revokeObjectURL(url);
        reject(new Error('Could not decode image: ' + file.name));
      };
      img.src = url;
    });
  }

  function waitFor(getter, label, tries) {
    tries = tries || 150;
    return new Promise(function (resolve, reject) {
      var n = 0;
      (function tick() {
        var v = getter();
        if (v) return resolve(v);
        if (++n > tries) return reject(new Error((label || 'Library') + ' failed to load. Refresh and try again.'));
        setTimeout(tick, 100);
      })();
    });
  }

  function ensureJSZip() { return waitFor(function () { return global.JSZip; }, 'JSZip'); }
  function ensurePdfLib() { return waitFor(function () { return global.PDFLib; }, 'PDF-lib'); }
  function ensureMammoth() { return waitFor(function () { return global.mammoth; }, 'Mammoth'); }
  function ensureHeic2Any() { return waitFor(function () { return global.heic2any; }, 'HEIC converter'); }
  function ensureHtml2Pdf() { return waitFor(function () { return global.html2pdf; }, 'html2pdf'); }
  function ensurePdfJs() {
    return waitFor(function () { return global.pdfjsLib; }, 'PDF.js').then(function (lib) {
      lib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
      return lib;
    });
  }

  function waitForFFmpegLibs() {
    return new Promise(function (resolve, reject) {
      var start = Date.now();
      function tick() {
        if (global.FFmpegWASM && global.FFmpegUtil) return resolve();
        if (Date.now() - start > 90000) {
          return reject(new Error('Media engine failed to load. Check your connection and refresh.'));
        }
        setTimeout(tick, 200);
      }
      global.addEventListener('nasira-ffmpeg-ready', tick, { once: true });
      tick();
    });
  }

  async function getFFmpeg(onProgress) {
    if (ffmpegInstance) {
      if (onProgress) {
        ffmpegInstance.on('progress', function (p) {
          if (p && typeof p.progress === 'number') onProgress(Math.round(p.progress * 100));
        });
      }
      return ffmpegInstance;
    }
    if (ffmpegLoading) return ffmpegLoading;

    ffmpegLoading = (async function () {
      await waitForFFmpegLibs();
      if (global.NasiraFfmpegLoadError || !global.FFmpegWASM || !global.FFmpegUtil) {
        throw new Error('Media engine unavailable in this browser. Try Chrome/Edge, or refresh.');
      }
      var FFmpeg = global.FFmpegWASM.FFmpeg;
      var fetchFile = global.FFmpegUtil.fetchFile;
      var toBlobURL = global.FFmpegUtil.toBlobURL;
      var ffmpeg = new FFmpeg();
      ffmpeg.on('log', function () {});
      if (onProgress) {
        ffmpeg.on('progress', function (p) {
          if (p && typeof p.progress === 'number') onProgress(Math.round(p.progress * 100));
        });
      }
      var base = 'https://cdn.jsdelivr.net/npm/@ffmpeg/core@0.12.6/dist/umd';
      await ffmpeg.load({
        coreURL: await toBlobURL(base + '/ffmpeg-core.js', 'text/javascript'),
        wasmURL: await toBlobURL(base + '/ffmpeg-core.wasm', 'application/wasm'),
      });
      ffmpeg._fetchFile = fetchFile;
      ffmpegInstance = ffmpeg;
      return ffmpeg;
    })();

    try {
      return await ffmpegLoading;
    } catch (e) {
      ffmpegLoading = null;
      throw e;
    }
  }

  /* ---------- converters ---------- */
  async function convertImageFile(file, outExt, opts) {
    opts = opts || {};
    outExt = (outExt || 'png').toLowerCase();
    if (outExt === 'jpeg') outExt = 'jpg';

    var img = await loadImageFile(file);
    var w = img.naturalWidth;
    var h = img.naturalHeight;
    var maxSide = opts.maxSide || 0;
    if (maxSide > 0 && Math.max(w, h) > maxSide) {
      var s = maxSide / Math.max(w, h);
      w = Math.max(1, Math.round(w * s));
      h = Math.max(1, Math.round(h * s));
    }

    if (outExt === 'svg') {
      var c0 = document.createElement('canvas');
      c0.width = w;
      c0.height = h;
      c0.getContext('2d').drawImage(img, 0, 0, w, h);
      var dataUrl = c0.toDataURL('image/png');
      var svg =
        '<?xml version="1.0" encoding="UTF-8"?>\n' +
        '<svg xmlns="http://www.w3.org/2000/svg" width="' + w + '" height="' + h + '" viewBox="0 0 ' + w + ' ' + h + '">' +
        '<image width="' + w + '" height="' + h + '" href="' + dataUrl + '" />' +
        '</svg>';
      return new Blob([svg], { type: 'image/svg+xml' });
    }

    var canvas = document.createElement('canvas');
    canvas.width = w;
    canvas.height = h;
    var ctx = canvas.getContext('2d');
    if (outExt === 'jpg') {
      ctx.fillStyle = opts.bg || '#ffffff';
      ctx.fillRect(0, 0, w, h);
    }
    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';
    ctx.drawImage(img, 0, 0, w, h);
    return canvasToBlob(canvas, mimeForExt(outExt), typeof opts.quality === 'number' ? opts.quality : 0.92);
  }

  async function convertHeicFile(file, outExt, opts) {
    opts = opts || {};
    outExt = (outExt || 'jpg').toLowerCase();
    var heic2any = await ensureHeic2Any();
    var toType = outExt === 'png' ? 'image/png' : 'image/jpeg';
    var converted = await heic2any({
      blob: file,
      toType: toType,
      quality: typeof opts.quality === 'number' ? opts.quality : 0.92
    });
    var blob = Array.isArray(converted) ? converted[0] : converted;
    if (!blob) throw new Error('HEIC conversion returned empty result.');

    if (outExt !== 'pdf') return blob;

    var PDFLib = await ensurePdfLib();
    var bytes = await blob.arrayBuffer();
    var pdf = await PDFLib.PDFDocument.create();
    var image = toType === 'image/png' ? await pdf.embedPng(bytes) : await pdf.embedJpg(bytes);
    var page = pdf.addPage([image.width, image.height]);
    page.drawImage(image, { x: 0, y: 0, width: image.width, height: image.height });
    var out = await pdf.save();
    return new Blob([out], { type: 'application/pdf' });
  }

  function ffmpegArgs(slug, inName, outName, outExt, opts) {
    opts = opts || {};
    var crf = String(opts.crf || 28);
    var bitrate = opts.bitrate || '128k';

    if (slug === 'video-compressor') {
      return ['-i', inName, '-vcodec', 'libx264', '-crf', crf, '-preset', 'fast', '-acodec', 'aac', '-b:a', '128k', '-movflags', '+faststart', outName];
    }
    if (slug === 'mp3-compressor' || slug === 'wav-compressor') {
      return ['-i', inName, '-vn', '-codec:a', 'libmp3lame', '-b:a', bitrate, outName];
    }
    if (slug === 'gif-compressor' || outExt === 'gif') {
      return ['-i', inName, '-vf', 'fps=12,scale=480:-1:flags=lanczos', '-loop', '0', outName];
    }
    if (outExt === 'mp3') {
      return ['-i', inName, '-vn', '-acodec', 'libmp3lame', '-b:a', '192k', outName];
    }
    if (outExt === 'ogg') {
      return ['-i', inName, '-vn', '-c:a', 'libvorbis', '-q:a', '5', outName];
    }
    if (outExt === 'wav') {
      return ['-i', inName, '-vn', '-acodec', 'pcm_s16le', outName];
    }
    if (outExt === 'aac' || outExt === 'm4a') {
      return ['-i', inName, '-vn', '-c:a', 'aac', '-b:a', '192k', outName];
    }
    if (outExt === 'webm') {
      return ['-i', inName, '-c:v', 'libvpx', '-b:v', '1M', '-c:a', 'libvorbis', outName];
    }
    if (outExt === 'mp4' || outExt === 'mov' || outExt === 'mkv' || outExt === 'avi') {
      return ['-i', inName, '-c:v', 'libx264', '-preset', 'fast', '-crf', '23', '-c:a', 'aac', '-movflags', '+faststart', outName];
    }
    if (outExt === 'png') {
      return ['-i', inName, '-plays', '0', outName];
    }
    return ['-i', inName, '-y', outName];
  }

  async function runFfmpeg(file, outExt, tool, opts, onProgress) {
    var ffmpeg = await getFFmpeg(onProgress);
    var fetchFile = ffmpeg._fetchFile;
    var safeIn = 'input_' + Date.now() + '.' + (extOf(file.name) || 'bin');
    var safeOut = 'output_' + Date.now() + '.' + outExt;
    await ffmpeg.writeFile(safeIn, await fetchFile(file));
    try {
      var args = ffmpegArgs(tool.slug, safeIn, safeOut, outExt, opts);
      var code = await ffmpeg.exec(args);
      if (code !== 0 && code !== undefined && code !== null) {
        // some builds return undefined on success
      }
      var data = await ffmpeg.readFile(safeOut);
      return new Blob([data.buffer], { type: mimeForExt(outExt) });
    } finally {
      try { await ffmpeg.deleteFile(safeIn); } catch (e) {}
      try { await ffmpeg.deleteFile(safeOut); } catch (e) {}
    }
  }

  async function imagesToGif(files, onProgress) {
    if (!files.length) throw new Error('Add at least one image.');
    var ffmpeg = await getFFmpeg(onProgress);
    var fetchFile = ffmpeg._fetchFile;
    var written = [];
    try {
      for (var i = 0; i < files.length; i++) {
        var ext = extOf(files[i].name) || 'png';
        if (ext === 'jpeg') ext = 'jpg';
        var name = 'frame_' + String(i).padStart(3, '0') + '.' + ext;
        await ffmpeg.writeFile(name, await fetchFile(files[i]));
        written.push(name);
      }
      var firstExt = extOf(files[0].name) || 'png';
      if (firstExt === 'jpeg') firstExt = 'jpg';
      await ffmpeg.exec([
        '-framerate', '2',
        '-i', 'frame_%03d.' + firstExt,
        '-vf', 'scale=480:-1:flags=lanczos',
        '-loop', '0',
        'out.gif'
      ]);
      var data = await ffmpeg.readFile('out.gif');
      return new Blob([data.buffer], { type: 'image/gif' });
    } finally {
      for (var j = 0; j < written.length; j++) {
        try { await ffmpeg.deleteFile(written[j]); } catch (e) {}
      }
      try { await ffmpeg.deleteFile('out.gif'); } catch (e) {}
    }
  }

  async function imagesToPdf(files) {
    var PDFLib = await ensurePdfLib();
    var pdf = await PDFLib.PDFDocument.create();
    for (var i = 0; i < files.length; i++) {
      var bytes = await files[i].arrayBuffer();
      var image;
      var type = files[i].type || '';
      var ext = extOf(files[i].name);
      try {
        if (type.indexOf('png') !== -1 || ext === 'png') image = await pdf.embedPng(bytes);
        else image = await pdf.embedJpg(bytes);
      } catch (e1) {
        try {
          image = await pdf.embedPng(bytes);
        } catch (e2) {
          image = await pdf.embedJpg(bytes);
        }
      }
      var page = pdf.addPage([image.width, image.height]);
      page.drawImage(image, { x: 0, y: 0, width: image.width, height: image.height });
    }
    var out = await pdf.save();
    return new Blob([out], { type: 'application/pdf' });
  }

  async function pdfToImages(file, outExt) {
    var pdfjs = await ensurePdfJs();
    var buf = await file.arrayBuffer();
    var pdf = await pdfjs.getDocument({ data: new Uint8Array(buf) }).promise;
    var blobs = [];
    for (var p = 1; p <= pdf.numPages; p++) {
      var page = await pdf.getPage(p);
      var viewport = page.getViewport({ scale: 1.75 });
      var canvas = document.createElement('canvas');
      canvas.width = viewport.width;
      canvas.height = viewport.height;
      await page.render({ canvasContext: canvas.getContext('2d'), viewport: viewport }).promise;
      var mime = outExt === 'png' ? 'image/png' : 'image/jpeg';
      var blob = await canvasToBlob(canvas, mime, 0.92);
      blobs.push({ name: baseName(file.name) + '-page-' + p + '.' + outExt, blob: blob });
    }
    if (!blobs.length) throw new Error('PDF has no pages.');
    return blobs;
  }

  async function buildEpub(title, bodyHtml) {
    var JSZip = await ensureJSZip();
    var zip = new JSZip();
    zip.file('mimetype', 'application/epub+zip', { compression: 'STORE' });
    zip.folder('META-INF').file(
      'container.xml',
      '<?xml version="1.0"?><container version="1.0" xmlns="urn:oasis:names:tc:opendocument:xmlns:container">' +
      '<rootfiles><rootfile full-path="OEBPS/content.opf" media-type="application/oebps-package+xml"/></rootfiles></container>'
    );
    var oebps = zip.folder('OEBPS');
    oebps.file(
      'content.opf',
      '<?xml version="1.0" encoding="UTF-8"?>' +
      '<package xmlns="http://www.idpf.org/2007/opf" unique-identifier="BookId" version="2.0">' +
      '<metadata xmlns:dc="http://purl.org/dc/elements/1.1/">' +
      '<dc:title>' + escapeHtml(title) + '</dc:title><dc:language>en</dc:language>' +
      '<dc:identifier id="BookId">nasira-' + Date.now() + '</dc:identifier></metadata>' +
      '<manifest><item id="ch1" href="chapter.xhtml" media-type="application/xhtml+xml"/>' +
      '<item id="ncx" href="toc.ncx" media-type="application/x-dtbncx+xml"/></manifest>' +
      '<spine toc="ncx"><itemref idref="ch1"/></spine></package>'
    );
    oebps.file(
      'toc.ncx',
      '<?xml version="1.0"?><ncx xmlns="http://www.daisy.org/z3986/2005/ncx/" version="2005-1">' +
      '<docTitle><text>' + escapeHtml(title) + '</text></docTitle>' +
      '<navMap><navPoint id="nav1" playOrder="1"><navLabel><text>Start</text></navLabel><content src="chapter.xhtml"/></navPoint></navMap></ncx>'
    );
    oebps.file(
      'chapter.xhtml',
      '<?xml version="1.0" encoding="UTF-8"?>' +
      '<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml"><head><title>' + escapeHtml(title) +
      '</title></head><body>' + bodyHtml + '</body></html>'
    );
    return zip.generateAsync({ type: 'blob', mimeType: 'application/epub+zip' });
  }

  async function pdfToEpub(file) {
    var pdfjs = await ensurePdfJs();
    var buf = await file.arrayBuffer();
    var pdf = await pdfjs.getDocument({ data: new Uint8Array(buf) }).promise;
    var parts = [];
    for (var p = 1; p <= pdf.numPages; p++) {
      var page = await pdf.getPage(p);
      var tc = await page.getTextContent();
      var text = tc.items.map(function (it) { return it.str; }).join(' ').trim();
      parts.push('<h2>Page ' + p + '</h2><p>' + escapeHtml(text || '(No extractable text on this page)') + '</p>');
    }
    return buildEpub(baseName(file.name), parts.join('\n'));
  }

  async function epubToPdf(file) {
    var JSZip = await ensureJSZip();
    var zip = await JSZip.loadAsync(file);
    var texts = [];
    var names = Object.keys(zip.files).filter(function (n) {
      return /\.(xhtml|html|htm)$/i.test(n) && !zip.files[n].dir;
    });
    for (var i = 0; i < names.length; i++) {
      var html = await zip.files[names[i]].async('string');
      var tmp = document.createElement('div');
      tmp.innerHTML = html;
      var t = (tmp.innerText || tmp.textContent || '').trim();
      if (t) texts.push(t);
    }
    if (!texts.length) throw new Error('No readable text found in this EPUB.');
    var html2pdf = await ensureHtml2Pdf();
    var holder = document.createElement('div');
    holder.style.cssText = 'padding:24px;font-family:Georgia,serif;white-space:pre-wrap;position:fixed;left:-99999px;top:0;width:800px;';
    holder.textContent = texts.join('\n\n');
    document.body.appendChild(holder);
    try {
      return await html2pdf().set({
        margin: 12,
        filename: baseName(file.name) + '.pdf',
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
      }).from(holder).outputPdf('blob');
    } finally {
      holder.remove();
    }
  }

  async function textToEpub(file) {
    var text = await file.text();
    var paras = String(text).split(/\n+/).map(function (line) {
      return '<p>' + escapeHtml(line) + '</p>';
    }).join('\n');
    return buildEpub(baseName(file.name), paras || '<p></p>');
  }

  async function docxToPdf(file) {
    var mammoth = await ensureMammoth();
    var html2pdf = await ensureHtml2Pdf();
    var result = await mammoth.convertToHtml({ arrayBuffer: await file.arrayBuffer() });
    var holder = document.createElement('div');
    holder.style.cssText = 'padding:24px;font-family:Georgia,serif;position:fixed;left:-99999px;top:0;width:800px;';
    holder.innerHTML = result.value || '<p></p>';
    document.body.appendChild(holder);
    try {
      return await html2pdf().set({
        margin: 12,
        filename: baseName(file.name) + '.pdf',
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
      }).from(holder).outputPdf('blob');
    } finally {
      holder.remove();
    }
  }

  async function docxToTxt(file) {
    var mammoth = await ensureMammoth();
    var result = await mammoth.extractRawText({ arrayBuffer: await file.arrayBuffer() });
    return new Blob([result.value || ''], { type: 'text/plain;charset=utf-8' });
  }

  async function archiveZip(files) {
    var JSZip = await ensureJSZip();
    var zip = new JSZip();
    files.forEach(function (f) { zip.file(f.name, f); });
    return zip.generateAsync({ type: 'blob' });
  }

  async function archiveUnzip(file) {
    var JSZip = await ensureJSZip();
    var zip = await JSZip.loadAsync(file);
    var outs = [];
    var names = Object.keys(zip.files);
    for (var i = 0; i < names.length; i++) {
      var n = names[i];
      if (zip.files[n].dir) continue;
      var blob = await zip.files[n].async('blob');
      outs.push({ name: n.split('/').pop() || n, blob: blob });
    }
    if (!outs.length) throw new Error('ZIP is empty.');
    return outs;
  }

  function unitConvert(value, from, to, category) {
    if (global.NasiraUnits && typeof global.NasiraUnits.convert === 'function') {
      return global.NasiraUnits.convert(value, from, to, category);
    }
    // Tiny fallback if catalog script failed to load.
    var tables = {
      length: { m: 1, km: 1000, cm: 0.01, mm: 0.001, mi: 1609.344, yd: 0.9144, ft: 0.3048, in: 0.0254 },
      mass: { kg: 1, g: 0.001, mg: 0.000001, lb: 0.45359237, oz: 0.0283495231, t: 1000 },
      data: { B: 1, KB: 1024, MB: 1048576, GB: 1073741824, TB: 1099511627776 }
    };
    if (category === 'temperature') {
      var c = from === 'C' ? value : from === 'F' ? (value - 32) * 5 / 9 : value - 273.15;
      if (to === 'C') return c;
      if (to === 'F') return c * 9 / 5 + 32;
      return c + 273.15;
    }
    var t = tables[category] || tables.length;
    return value * t[from] / t[to];
  }

  function defaultAccept(tool) {
    if (tool.accept) return tool.accept;
    if (tool.engine === 'ffmpeg') return 'video/*,audio/*,image/gif,.gif,.mp4,.mov,.webm,.avi,.mkv,.mp3,.wav,.ogg,.m4a,.aac';
    if (tool.engine === 'image' || tool.engine === 'heic') return 'image/*,.heic,.heif,.jfif,.svg,.webp';
    if (tool.engine === 'pdf') return 'application/pdf,.pdf,image/*';
    if (tool.engine === 'doc') return '.docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document';
    if (tool.engine === 'ebook') return '.epub,.pdf,.txt,text/plain,application/pdf,application/epub+zip';
    if (tool.engine === 'archive') return '.zip,application/zip,*/*';
    return '*/*';
  }

  function canHandle(tool) {
    if (!tool || !tool.engine) return false;
    return ['ffmpeg', 'image', 'heic', 'pdf', 'doc', 'ebook', 'archive', 'unit'].indexOf(tool.engine) !== -1;
  }

  /* ---------- UI ---------- */
  function mount(root, tool) {
    if (!root || !tool) return;
    if (tool.engine === 'unit') return mountUnit(root, tool);
    if (tool.engine === 'archive') return mountArchive(root, tool);
    return mountConverter(root, tool);
  }

  function mountConverter(root, tool) {
    var outputs = (tool.outputs && tool.outputs.length) ? tool.outputs.slice() : ['bin'];
    var accept = defaultAccept(tool);
    var allowMulti = true;

    root.innerHTML = '';
    var panel = h(
      '<div class="nasira-fc">' +
        '<div class="nasira-fc-card">' +
          '<div class="nasira-fc-badge">Production converter · private in browser</div>' +
          '<h2></h2><p></p>' +
          '<label class="nasira-fc-drop" id="upload-zone">' +
            '<input type="file" />' +
            '<span class="nasira-fc-drop-btn"><i class="fa-solid fa-folder-open"></i> Choose Files</span>' +
            '<strong>or drop files here</strong>' +
            '<span>On-device conversion · recommended max ' + fmtBytes(MAX_BYTES) + ' each</span>' +
          '</label>' +
          '<ul class="nasira-fc-files" id="file-list" hidden></ul>' +
          '<details class="nasira-fc-advanced" open>' +
            '<summary>Conversion settings</summary>' +
            '<div class="nasira-fc-advanced-body">' +
              '<div class="nasira-tool-field" id="out-wrap"><label>Output format</label><select id="out-ext"></select></div>' +
              '<div class="nasira-tool-field" id="quality-wrap"><label>Quality <span id="qv">92%</span></label>' +
              '<input type="range" id="q" min="0.4" max="1" step="0.01" value="0.92" /></div>' +
              '<div class="nasira-tool-field" id="bg-wrap" hidden><label>Fill color (for JPG / no alpha)</label>' +
              '<div class="nasira-fc-color-row"><input type="color" id="bg" value="#ffffff" />' +
              '<input type="text" id="bg-hex" value="#FFFFFF" maxlength="7" /></div></div>' +
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
          '<div class="nasira-tool-msg" id="msg" style="display:none"></div>' +
        '</div>' +
        '<ol class="nasira-fc-howto">' +
          '<li><strong>Choose</strong> your file(s).</li>' +
          '<li>Pick output format / quality if needed.</li>' +
          '<li>Click <strong>Convert</strong>, then <strong>Download</strong>.</li>' +
        '</ol>' +
      '</div>'
    );
    root.appendChild(panel);
    panel.querySelector('h2').textContent = tool.name;
    panel.querySelector('p').textContent = tool.desc;

    var input = panel.querySelector('input[type="file"]');
    input.accept = accept;
    input.multiple = allowMulti;

    var outSel = panel.querySelector('#out-ext');
    outputs.forEach(function (o) {
      var opt = document.createElement('option');
      opt.value = o;
      opt.textContent = String(o).toUpperCase();
      outSel.appendChild(opt);
    });
    if (outputs.length <= 1) panel.querySelector('#out-wrap').hidden = true;

    var queue = [];
    var results = [];

    function msg(text, isError) {
      var box = panel.querySelector('#msg');
      box.textContent = text || '';
      box.classList.toggle('is-error', !!isError);
      box.style.display = text ? 'block' : 'none';
    }

    function setProgress(pct) {
      var bar = panel.querySelector('#progress');
      bar.style.display = pct == null ? 'none' : 'block';
      if (pct != null) bar.firstChild.style.width = Math.max(0, Math.min(100, pct)) + '%';
    }

    function syncBg() {
      var ext = outSel.value;
      panel.querySelector('#bg-wrap').hidden = !(ext === 'jpg' || ext === 'jpeg');
      var showQ = tool.engine === 'image' || tool.engine === 'heic' || ext === 'jpg' || ext === 'webp' || ext === 'mp3';
      panel.querySelector('#quality-wrap').hidden = !showQ && tool.engine === 'ffmpeg' && ext !== 'mp3';
    }
    outSel.addEventListener('change', syncBg);
    syncBg();

    panel.querySelector('#q').addEventListener('input', function () {
      panel.querySelector('#qv').textContent = Math.round(parseFloat(this.value) * 100) + '%';
    });
    panel.querySelector('#bg').addEventListener('input', function () {
      panel.querySelector('#bg-hex').value = this.value.toUpperCase();
    });
    panel.querySelector('#bg-hex').addEventListener('change', function () {
      if (/^#([A-Fa-f0-9]{6})$/.test(this.value)) panel.querySelector('#bg').value = this.value;
    });

    function renderList() {
      var list = panel.querySelector('#file-list');
      list.innerHTML = '';
      list.hidden = !queue.length;
      panel.querySelector('#convert').disabled = !queue.length;
      panel.querySelector('#clear').disabled = !queue.length;
      queue.forEach(function (f, idx) {
        var li = document.createElement('li');
        li.innerHTML = '<div><strong></strong><small></small></div><button type="button">Remove</button>';
        li.querySelector('strong').textContent = f.name;
        li.querySelector('small').textContent = fmtBytes(f.size);
        li.querySelector('button').onclick = function () {
          queue.splice(idx, 1);
          renderList();
        };
        list.appendChild(li);
      });
    }

    function addFiles(fileList) {
      Array.prototype.slice.call(fileList || []).forEach(function (f) {
        if (f.size > MAX_BYTES) {
          msg(f.name + ' exceeds ' + fmtBytes(MAX_BYTES) + '.', true);
          return;
        }
        queue.push(f);
      });
      clearResults();
      renderList();
      if (queue.length) msg(queue.length + ' file(s) ready. Click Convert.');
    }

    function clearResults() {
      results.forEach(function (o) { try { URL.revokeObjectURL(o.url); } catch (e) {} });
      results = [];
      panel.querySelector('#results').hidden = true;
      panel.querySelector('#zip-wrap').hidden = true;
    }

    var zone = panel.querySelector('#upload-zone');
    zone.addEventListener('dragover', function (e) { e.preventDefault(); zone.classList.add('is-drag'); });
    zone.addEventListener('dragleave', function () { zone.classList.remove('is-drag'); });
    zone.addEventListener('drop', function (e) {
      e.preventDefault();
      zone.classList.remove('is-drag');
      addFiles(e.dataTransfer.files);
    });
    input.addEventListener('change', function () {
      addFiles(input.files);
      input.value = '';
    });

    panel.querySelector('#clear').addEventListener('click', function () {
      queue = [];
      clearResults();
      renderList();
      setProgress(null);
      msg('');
    });

    function pushResult(name, blob) {
      results.push({ name: name, blob: blob, url: URL.createObjectURL(blob) });
    }

    function renderResults() {
      var box = panel.querySelector('#results');
      box.hidden = !results.length;
      box.innerHTML = '';
      results.forEach(function (out) {
        var row = document.createElement('div');
        row.className = 'nasira-fc-result-row';
        row.innerHTML =
          '<div class="nasira-fc-result-info"><div><strong></strong><small></small></div></div>' +
          '<span class="nasira-fc-status is-done">Done</span>' +
          '<button type="button" class="nasira-tool-btn nasira-tool-btn--orange">Download</button>';
        row.querySelector('strong').textContent = out.name;
        row.querySelector('small').textContent = fmtBytes(out.blob.size);
        row.querySelector('button').onclick = function () { downloadBlob(out.blob, out.name); };
        box.appendChild(row);
      });
      panel.querySelector('#zip-wrap').hidden = results.length < 2;
    }

    async function convertQueue() {
      var outExt = (outSel.value || outputs[0] || 'bin').toLowerCase();
      var opts = {
        quality: parseFloat(panel.querySelector('#q').value) || 0.92,
        bg: panel.querySelector('#bg-hex').value || '#ffffff',
        bitrate: (parseFloat(panel.querySelector('#q').value) || 0.92) > 0.85 ? '192k' : '128k',
        crf: Math.round(36 - (parseFloat(panel.querySelector('#q').value) || 0.92) * 14)
      };

      clearResults();
      setProgress(5);
      msg(tool.engine === 'ffmpeg' ? 'Loading media engine (first run may take a minute)…' : 'Converting…');

      if (tool.slug === 'image-to-gif') {
        setProgress(15);
        var gif = await imagesToGif(queue, function (p) { setProgress(15 + Math.round(p * 0.75)); });
        pushResult('nasira-animation.gif', gif);
        return;
      }

      if (tool.slug === 'jpg-to-pdf' || (tool.slug === 'pdf-converter' && outExt === 'pdf' && queue.every(function (f) { return /^image\//.test(f.type || '') || /\.(jpg|jpeg|png|webp)$/i.test(f.name); }))) {
        setProgress(25);
        // normalize webp/png to jpeg-compatible embeds via canvas when needed
        var normalized = [];
        for (var i = 0; i < queue.length; i++) {
          var f = queue[i];
          if (/\.(png|webp)$/i.test(f.name) || f.type === 'image/png' || f.type === 'image/webp') {
            normalized.push(await convertImageFile(f, 'jpg', { quality: 0.92, bg: '#ffffff' }));
            normalized[normalized.length - 1] = new File([normalized[normalized.length - 1]], baseName(f.name) + '.jpg', { type: 'image/jpeg' });
          } else {
            normalized.push(f);
          }
          setProgress(25 + Math.round((i / queue.length) * 40));
        }
        var pdfBlob = await imagesToPdf(normalized);
        pushResult(baseName(queue[0].name) + (queue.length > 1 ? '-images' : '') + '.pdf', pdfBlob);
        return;
      }

      if (tool.slug === 'pdf-to-jpg' || (tool.slug === 'pdf-converter' && (outExt === 'jpg' || outExt === 'png'))) {
        for (var p = 0; p < queue.length; p++) {
          setProgress(Math.round((p / queue.length) * 90) + 5);
          var pages = await pdfToImages(queue[p], outExt === 'png' ? 'png' : 'jpg');
          pages.forEach(function (pg) { pushResult(pg.name, pg.blob); });
        }
        return;
      }

      for (var j = 0; j < queue.length; j++) {
        var file = queue[j];
        setProgress(Math.round((j / queue.length) * 90) + 5);
        msg('Converting ' + (j + 1) + ' / ' + queue.length + ': ' + file.name);

        var blob;
        if (tool.engine === 'image') {
          blob = await convertImageFile(file, outExt, opts);
        } else if (tool.engine === 'heic') {
          blob = await convertHeicFile(file, outExt, opts);
        } else if (tool.engine === 'ffmpeg') {
          blob = await runFfmpeg(file, outExt, tool, opts, function (p) {
            setProgress(Math.round((j / queue.length) * 90) + 5 + Math.round(p * 0.85 / Math.max(queue.length, 1)));
          });
        } else if (tool.engine === 'doc') {
          blob = outExt === 'txt' ? await docxToTxt(file) : await docxToPdf(file);
        } else if (tool.engine === 'ebook') {
          if (/\.pdf$/i.test(file.name) || file.type === 'application/pdf') blob = await pdfToEpub(file);
          else if (/\.epub$/i.test(file.name)) blob = await epubToPdf(file);
          else blob = await textToEpub(file);
        } else if (tool.engine === 'pdf') {
          if (/\.pdf$/i.test(file.name) || file.type === 'application/pdf') {
            if (outExt === 'jpg' || outExt === 'png') {
              var imgs = await pdfToImages(file, outExt);
              imgs.forEach(function (pg) { pushResult(pg.name, pg.blob); });
              continue;
            }
            throw new Error('Choose JPG/PNG output to export PDF pages, or use JPG to PDF for images.');
          }
          blob = await imagesToPdf([file]);
        } else {
          throw new Error('Unsupported engine for ' + tool.name);
        }

        if (blob) pushResult(baseName(file.name) + '.' + outExt, blob);
      }
    }

    panel.querySelector('#convert').addEventListener('click', async function () {
      if (!queue.length) return;
      panel.querySelector('#convert').disabled = true;
      try {
        await convertQueue();
        setProgress(100);
        renderResults();
        if (!results.length) throw new Error('No output produced.');
        msg('Done — ' + results.length + ' file(s) ready to download.');
      } catch (err) {
        console.error(err);
        msg(err.message || 'Conversion failed.', true);
      } finally {
        panel.querySelector('#convert').disabled = !queue.length;
        setTimeout(function () { setProgress(null); }, 800);
      }
    });

    panel.querySelector('#zip').addEventListener('click', async function () {
      try {
        var JSZip = await ensureJSZip();
        var zip = new JSZip();
        results.forEach(function (o) { zip.file(o.name, o.blob); });
        downloadBlob(await zip.generateAsync({ type: 'blob' }), baseName(tool.slug) + '-converted.zip');
      } catch (e) {
        msg(e.message || 'Could not build ZIP.', true);
      }
    });
  }

  function mountArchive(root, tool) {
    root.innerHTML = '';
    var panel = h(
      '<div class="nasira-fc"><div class="nasira-fc-card">' +
        '<div class="nasira-fc-badge">Archive converter</div><h2></h2><p></p>' +
        '<div class="nasira-tool-field"><label>Mode</label>' +
        '<select id="mode"><option value="zip">Zip files → .zip</option><option value="unzip">Unzip .zip → files</option></select></div>' +
        '<label class="nasira-fc-drop" id="upload-zone"><input type="file" multiple />' +
        '<span class="nasira-fc-drop-btn">Choose Files</span><strong>or drop here</strong></label>' +
        '<div class="nasira-tool-actions nasira-fc-actions">' +
        '<button type="button" class="nasira-tool-btn nasira-tool-btn--orange" id="go" disabled>Convert</button></div>' +
        '<div class="nasira-fc-results" id="results" hidden></div>' +
        '<div class="nasira-tool-msg" id="msg" style="display:none"></div></div></div>'
    );
    root.appendChild(panel);
    panel.querySelector('h2').textContent = tool.name;
    panel.querySelector('p').textContent = tool.desc;
    var files = [];
    var input = panel.querySelector('input');
    var mode = panel.querySelector('#mode');
    function syncAccept() {
      input.multiple = mode.value === 'zip';
      input.accept = mode.value === 'unzip' ? '.zip,application/zip' : '*/*';
    }
    syncAccept();
    mode.addEventListener('change', syncAccept);
    function sync() { panel.querySelector('#go').disabled = !files.length; }
    input.addEventListener('change', function () {
      files = Array.prototype.slice.call(input.files || []);
      sync();
    });
    panel.querySelector('#upload-zone').addEventListener('drop', function (e) {
      e.preventDefault();
      files = Array.prototype.slice.call(e.dataTransfer.files || []);
      sync();
    });
    panel.querySelector('#go').addEventListener('click', async function () {
      var box = panel.querySelector('#results');
      var msgEl = panel.querySelector('#msg');
      msgEl.classList.remove('is-error');
      try {
        if (mode.value === 'zip') {
          var blob = await archiveZip(files);
          downloadBlob(blob, 'nasira-archive.zip');
          msgEl.style.display = 'block';
          msgEl.textContent = 'ZIP ready (' + fmtBytes(blob.size) + ').';
        } else {
          var outs = await archiveUnzip(files[0]);
          box.hidden = false;
          box.innerHTML = '';
          outs.forEach(function (o) {
            var row = document.createElement('div');
            row.className = 'nasira-fc-result-row';
            row.innerHTML = '<div class="nasira-fc-result-info"><div><strong></strong><small></small></div></div>' +
              '<span class="nasira-fc-status">Done</span><button type="button" class="nasira-tool-btn nasira-tool-btn--orange">Download</button>';
            row.querySelector('strong').textContent = o.name;
            row.querySelector('small').textContent = fmtBytes(o.blob.size);
            row.querySelector('button').onclick = function () { downloadBlob(o.blob, o.name); };
            box.appendChild(row);
          });
          msgEl.style.display = 'block';
          msgEl.textContent = outs.length + ' file(s) extracted.';
        }
      } catch (e) {
        msgEl.style.display = 'block';
        msgEl.classList.add('is-error');
        msgEl.textContent = e.message || 'Archive failed.';
      }
    });
  }

  function mountUnit(root, tool) {
    root.innerHTML = '';
    var catalog = (global.NasiraUnits && global.NasiraUnits.catalog) || null;
    var totalUnits = (global.NasiraUnits && global.NasiraUnits.count) ? global.NasiraUnits.count() : 0;
    var panel = h(
      '<div class="nasira-fc"><div class="nasira-fc-card" style="text-align:left">' +
        '<div class="nasira-fc-badge">Unit converter · ' + (totalUnits || '500+') + ' units</div>' +
        '<h2 style="text-align:center"></h2>' +
        '<p style="text-align:center"></p>' +
        '<div class="nasira-tool-field"><label>Category</label><select id="cat"></select></div>' +
        '<div class="nasira-tool-field"><label>Search units</label>' +
        '<input type="search" id="q" placeholder="Filter by name or symbol (e.g. mile, kWh, psi)" /></div>' +
        '<div class="row g-2 align-items-end">' +
          '<div class="col-md-3"><div class="nasira-tool-field"><label>Value</label>' +
          '<input type="number" id="val" value="1" step="any" /></div></div>' +
          '<div class="col-md-4"><div class="nasira-tool-field"><label>From</label><select id="from" size="8" style="height:auto;min-height:12rem"></select></div></div>' +
          '<div class="col-md-1 d-grid"><button type="button" class="nasira-tool-btn nasira-tool-btn--ghost" id="swap" title="Swap">⇄</button></div>' +
          '<div class="col-md-4"><div class="nasira-tool-field"><label>To</label><select id="to" size="8" style="height:auto;min-height:12rem"></select></div></div>' +
        '</div>' +
        '<div class="nasira-tool-msg" id="out" style="display:block;margin-top:1rem"></div>' +
        '<p class="text-muted small mb-0 mt-2" id="unit-count"></p>' +
      '</div></div>'
    );
    root.appendChild(panel);
    panel.querySelector('h2').textContent = tool.name;
    panel.querySelector('p').textContent = tool.desc || 'Convert between 500+ units across science, engineering, cooking, and more.';

    if (!catalog) {
      panel.querySelector('#out').textContent = 'Unit catalog failed to load. Refresh the page.';
      panel.querySelector('#out').classList.add('is-error');
      return;
    }

    var catSel = panel.querySelector('#cat');
    Object.keys(catalog).forEach(function (key) {
      var o = document.createElement('option');
      o.value = key;
      o.textContent = catalog[key].label + ' (' + Object.keys(catalog[key].units).length + ')';
      catSel.appendChild(o);
    });

    function unitEntries(catKey, query) {
      var units = catalog[catKey].units;
      var q = String(query || '').trim().toLowerCase();
      return Object.keys(units).map(function (id) {
        return { id: id, name: units[id].name || id };
      }).filter(function (u) {
        if (!q) return true;
        return u.id.toLowerCase().indexOf(q) !== -1 || u.name.toLowerCase().indexOf(q) !== -1;
      }).sort(function (a, b) {
        return a.name.localeCompare(b.name);
      });
    }

    function fillSelect(sel, entries, preferred) {
      var keep = preferred || sel.value;
      sel.innerHTML = '';
      entries.forEach(function (u) {
        var o = document.createElement('option');
        o.value = u.id;
        o.textContent = u.name + ' (' + u.id + ')';
        sel.appendChild(o);
      });
      if (keep && entries.some(function (u) { return u.id === keep; })) {
        sel.value = keep;
      } else if (entries.length) {
        sel.selectedIndex = 0;
      }
    }

    function fill() {
      var cat = catSel.value;
      var q = panel.querySelector('#q').value;
      var entries = unitEntries(cat, q);
      fillSelect(panel.querySelector('#from'), entries);
      fillSelect(panel.querySelector('#to'), entries);
      if (panel.querySelector('#to').options.length > 1) {
        panel.querySelector('#to').selectedIndex = Math.min(1, panel.querySelector('#to').options.length - 1);
      }
      panel.querySelector('#unit-count').textContent =
        entries.length + ' units shown in this category · ' + totalUnits + ' total across all categories';
      calc();
    }

    function fmt(n) {
      if (!isFinite(n)) return '—';
      var abs = Math.abs(n);
      if (abs !== 0 && (abs < 1e-6 || abs >= 1e9)) return n.toExponential(8);
      return (Math.round(n * 1e10) / 1e10).toString();
    }

    function calc() {
      var v = parseFloat(panel.querySelector('#val').value);
      if (isNaN(v)) {
        panel.querySelector('#out').textContent = 'Enter a number.';
        return;
      }
      var from = panel.querySelector('#from').value;
      var to = panel.querySelector('#to').value;
      if (!from || !to) {
        panel.querySelector('#out').textContent = 'No units match your search.';
        return;
      }
      try {
        var r = unitConvert(v, from, to, catSel.value);
        var fromName = catalog[catSel.value].units[from].name;
        var toName = catalog[catSel.value].units[to].name;
        panel.querySelector('#out').textContent =
          v + ' ' + fromName + ' = ' + fmt(r) + ' ' + toName;
        panel.querySelector('#out').classList.remove('is-error');
      } catch (e) {
        panel.querySelector('#out').textContent = e.message || 'Conversion failed.';
        panel.querySelector('#out').classList.add('is-error');
      }
    }

    panel.querySelector('#swap').addEventListener('click', function () {
      var a = panel.querySelector('#from').value;
      var b = panel.querySelector('#to').value;
      panel.querySelector('#from').value = b;
      panel.querySelector('#to').value = a;
      calc();
    });

    catSel.addEventListener('change', function () {
      panel.querySelector('#q').value = '';
      fill();
    });
    panel.querySelector('#q').addEventListener('input', fill);
    panel.querySelector('#val').addEventListener('input', calc);
    panel.querySelector('#from').addEventListener('change', calc);
    panel.querySelector('#to').addEventListener('change', calc);
    fill();
  }

  global.NasiraFreeConvert = {
    canHandle: canHandle,
    mount: mount
  };
})(window);
