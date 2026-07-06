/* ============================================================
   ProEditor – editor.js  |  Version 2.0
   Production-ready Vanilla JavaScript Rich Text Editor
   ============================================================ */

   (function (global) {
    'use strict';
  
    /* ── Utilities ── */
    const $ = (sel, ctx = document) => ctx.querySelector(sel);
    const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));
  
    function el(tag, props = {}, children = []) {
      const e = document.createElement(tag);
      for (const [k, v] of Object.entries(props)) {
        if (k === 'class') e.className = v;
        else if (k === 'html') e.innerHTML = v;
        else if (k === 'contenteditable') e.contentEditable = v;
        else if (k === 'style') e.style.cssText = v;
        else if (k.startsWith('data-')) e.setAttribute(k, v);
        else e[k] = v;
      }
      children.forEach(c => c && e.appendChild(typeof c === 'string' ? document.createTextNode(c) : c));
      return e;
    }
  
    /* SVG icon factory */
    function icon(path, vb = '0 0 24 24', size = 15) {
      return `<svg width="${size}" height="${size}" viewBox="${vb}" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">${path}</svg>`;
    }
  
    const ICONS = {
      bold: icon('<path d="M6 4h8a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/><path d="M6 12h9a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/>'),
      italic: icon('<line x1="19" y1="4" x2="10" y2="4"/><line x1="14" y1="20" x2="5" y2="20"/><line x1="15" y1="4" x2="9" y2="20"/>'),
      underline: icon('<path d="M6 3v7a6 6 0 0 0 6 6 6 6 0 0 0 6-6V3"/><line x1="4" y1="21" x2="20" y2="21"/>'),
      strikethrough: icon('<line x1="18" y1="12" x2="6" y2="12"/><path d="M16 6C16 6 14.5 4 12 4s-4 1-4 3 1.5 3 4 3h0c2.5 0 4 1 4 3s-2 3-4 3-4-2-4-2"/>'),
      superscript: icon('<path d="M4 19l8-8"/><path d="M12 19 4 11"/><path d="M20 12h-4c0-1.5.442-2 1.5-2.5S20 8.334 20 7.002c0-.472-.17-.93-.484-1.29a2.105 2.105 0 0 0-2.617-.436c-.42.239-.738.614-.899 1.06"/>'),
      subscript: icon('<path d="M4 5l8 8"/><path d="M12 5 4 13"/><path d="M20 21h-4c0-1.5.442-2 1.5-2.5S20 17.334 20 16.002c0-.472-.17-.93-.484-1.29a2.105 2.105 0 0 0-2.617-.436c-.42.239-.738.614-.899 1.06"/>'),
      removeFormat: icon('<path d="M15 5H7"/><path d="m5 20 14-14"/><path d="m20 20-5-5 1.5-1.5"/>'),
      code: icon('<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>'),
      blockquote: icon('<path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/>'),
      alignLeft: icon('<line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/>'),
      alignCenter: icon('<line x1="21" y1="6" x2="3" y2="6"/><line x1="17" y1="10" x2="7" y2="10"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="7" y2="18"/>'),
      alignRight: icon('<line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="10" x2="9" y2="10"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="21" y1="18" x2="9" y2="18"/>'),
      alignJustify: icon('<line x1="21" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="21" y1="18" x2="3" y2="18"/>'),
      listOl: icon('<line x1="10" y1="6" x2="21" y2="6"/><line x1="10" y1="12" x2="21" y2="12"/><line x1="10" y1="18" x2="21" y2="18"/><path d="M4 6h1v4"/><path d="M4 10h2"/><path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/>'),
      listUl: icon('<line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>'),
      taskList: icon('<path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6l0 .01"/><path d="m2 12 2 2 4-4"/>'),
      table: icon('<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M3 15h18M9 3v18M15 3v18"/>'),
      image: icon('<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>'),
      video: icon('<polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/>'),
      link: icon('<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>'),
      unlink: icon('<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/><line x1="2" y1="2" x2="22" y2="22"/>'),
      emoji: icon('<circle cx="12" cy="12" r="10"/><path d="M8 13s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/>'),
      source: icon('<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>'),
      fullscreen: icon('<path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/>'),
      exitFullscreen: icon('<path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"/>'),
      undo: icon('<path d="M3 7v6h6"/><path d="M21 17a9 9 0 0 0-9-9 9 9 0 0 0-6 2.3L3 13"/>'),
      redo: icon('<path d="M21 7v6h-6"/><path d="M3 17a9 9 0 0 1 9-9 9 9 0 0 1 6 2.3l3 2.7"/>'),
      fontColor: icon('<path d="M4 20h4l6.5-14.5L8.5 4z"/><line x1="3" y1="20" x2="21" y2="20"/>'),
      bgColor: icon('<path d="M2 10l9-9 9 9-9 9z"/><path d="M21 20v2"/><rect x="19" y="16" width="4" height="4" rx="1"/>'),
      sidebar: icon('<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M15 3v18"/>'),
      hr: icon('<line x1="3" y1="12" x2="21" y2="12"/><polyline points="8 8 3 12 8 16"/><polyline points="16 8 21 12 16 16"/>'),
    };
  
    /* ── Color Palette ── */
    const COLOR_PALETTE = [
      '#000000','#434343','#666666','#999999','#b7b7b7','#cccccc','#d9d9d9','#ffffff',
      '#ff0000','#ff9900','#ffff00','#00ff00','#00ffff','#0000ff','#9900ff','#ff00ff',
      '#f4cccc','#fce5cd','#fff2cc','#d9ead3','#d0e0e3','#cfe2f3','#d9d2e9','#ead1dc',
      '#ea9999','#f9cb9c','#ffe599','#b6d7a8','#a2c4c9','#9fc5e8','#b4a7d6','#d5a6bd',
      '#cc0000','#e69138','#f1c232','#6aa84f','#45818e','#3d85c8','#674ea7','#a64d79',
      '#990000','#b45309','#bf9000','#38761d','#134f5c','#1155cc','#351c75','#741b47',
      '#4f46e5','#7c3aed','#db2777','#ef4444','#f59e0b','#10b981','#3b82f6','#6b7280',
    ];
  
    /* ── Emoji Data ── */
    const EMOJI_DATA = {
      'Smileys': ['😀','😁','😂','🤣','😃','😄','😅','😆','😇','😉','😊','🙂','🙃','😋','😌','😍','🥰','😘','😗','😙','😚','😜','😝','😛','🤑','🤗','🤭','🤫','🤔','🤐','🤨','😐','😑','😶','😏','😒','🙄','😬','🤥','😌','😔','😪','🤤','😴','😷','🤒','🤕','🤢','🤮','🤧','🥵','🥶','🥴','😵','🤯','🤠','🥳','😎','🤓','🧐'],
      'People': ['👋','🤚','🖐','✋','🖖','👌','🤌','🤏','✌️','🤞','🤟','🤘','🤙','👈','👉','👆','🖕','👇','☝️','👍','👎','✊','👊','🤛','🤜','👏','🙌','🤲','🤝','🙏','💪','🦾','🦵','🦶','👂','🦻','👃','🧠','🦷','🦴','👀','👁️','👅','👄'],
      'Nature': ['🐶','🐱','🐭','🐹','🐰','🦊','🐻','🐼','🐨','🐯','🦁','🐮','🐷','🐸','🐵','🙈','🙉','🙊','🐔','🐧','🐦','🐤','🦆','🦅','🦉','🦇','🐺','🐗','🐴','🦄','🐝','🐛','🦋','🐌','🐞','🐜','🌸','🌹','🌺','🌻','🌼','🌷','🌱','🌿','🍃','🍂','🍁'],
      'Food': ['🍎','🍊','🍋','🍇','🍓','🫐','🍈','🍒','🍑','🥭','🍍','🥝','🍅','🥥','🥑','🍆','🥔','🥕','🌽','🍔','🍟','🍕','🌭','🥪','🥙','🧆','🌮','🌯','🥗','🍜','🍝','🍣','🍱','🍛','🍲','🥘','🍦','🍧','🍨','🍩','🍪','🎂','🍰','🧁','🍫','🍬','🍭','☕','🍵','🧃','🥤'],
      'Travel': ['🚗','🚕','🚙','🚌','🏎','🚓','🚑','🚒','✈️','🚀','🛸','🚁','🛶','⛵','🚢','🏠','🏡','🏢','🏣','🏤','🏥','🏦','🏧','🗼','🗽','🗿','⛩️','🏰','🎡','🎢','🎠','⛲','🌋','🏔️','🌍','🌎','🌏','🌐'],
      'Objects': ['💎','🔑','🗝️','🔐','🔒','🔓','🔨','⚒️','🛠️','⛏️','🔧','🔩','⚙️','🗜️','💡','🔦','🕯️','💰','💵','💳','💻','🖥️','🖨️','⌨️','🖱️','📱','📷','📸','📹','🎥','📺','📻','🎙️','🎚️','🎛️','📡','🔭','📡','⏱️','⏰','📚','📖','✏️','🖊️','🖋️','📝'],
      'Symbols': ['❤️','🧡','💛','💚','💙','💜','🖤','🤍','🤎','💔','❣️','💕','💞','💓','💗','💖','💘','💝','💟','☮️','✝️','☪️','🕉️','✡️','🔯','🕎','☯️','☦️','🛐','⛎','♈','♉','♊','♋','♌','♍','♎','♏','♐','♑','♒','♓','🆔','⚡','🌈','🌊','💫','⭐','🌟','💥','🔥','🌀','⚠️','🚫','✅','❌','❓','❗'],
    };
  
    /* ── Font Families & Sizes ── */
    const FONTS = ['Arial','Georgia','Times New Roman','Courier New','Verdana','Trebuchet MS','Impact','Comic Sans MS','Palatino','Garamond','Helvetica','Tahoma','Roboto','Open Sans','Lato','Montserrat','Raleway','Playfair Display','Merriweather','Source Code Pro'];
    const SIZES = [8,9,10,11,12,13,14,15,16,18,20,22,24,26,28,30,36,42,48,60,72,96];
  
    /* ╔══════════════════════════════════════════════════════════╗
       ║                   MAIN EDITOR CLASS                      ║
       ╚══════════════════════════════════════════════════════════╝ */
  
    class ProEditor {
      constructor(textarea, options = {}) {
        this.options = options;
        this.textarea = textarea;
        this.undoStack = [];
        this.redoStack = [];
        this.savedRange = null;
        this.colorTarget = null; // 'fore' | 'back'
        this.isFullscreen = false;
        this.selectedImage = null;
        this.selectedTable = null;
        this.selectedCell = null;
        this.mergeStartCell = null;
        this.imageFile = null;
        this.sidebarOpen = true;
  
        this._build();
        this._bindToolbar();
        this._bindContent();
        this._bindModals();
        this._bindColorPopup();
        this._buildTableGrid();
        this._buildEmojiPicker();
        this._saveHistory();
      }
  
      /* ══════════════════════════════════════
         BUILD DOM
         ══════════════════════════════════════ */
      _build() {
        const ta = this.textarea;
        const initialHTML = ta.value || '';
  
        // Wrapper
        this.wrapper = el('div', { class: 'pe-wrapper' });
  
        // Toolbar area
        this.toolbarWrap = el('div', { class: 'pe-toolbar-wrap' });
        this.toolbar = el('div', { class: 'pe-toolbar' });
        this.toolbarWrap.appendChild(this.toolbar);
        this._buildToolbar();
  
        // Body: content + sidebar
        this.body = el('div', { class: 'pe-body' });
  
        // Content wrap
        this.contentWrap = el('div', { class: 'pe-content-wrap' });
        this.content = el('div', {
          class: 'pe-content',
          contenteditable: 'true',
          'data-placeholder': 'Start writing here…',
          html: initialHTML,
          spellcheck: 'true',
        });
        this.contentWrap.appendChild(this.content);
  
        // Sidebar
        this.sidebar = el('div', { class: 'pe-sidebar' });
        this._buildSidebar();
  
        this.body.appendChild(this.contentWrap);
        this.body.appendChild(this.sidebar);
  
        // Status bar
        this.statusbar = el('div', { class: 'pe-statusbar' });
        this._buildStatusbar();
  
        // Assemble
        this.wrapper.appendChild(this.toolbarWrap);
        this.wrapper.appendChild(this.body);
        this.wrapper.appendChild(this.statusbar);

        if (this.options.height) {
          const h = parseInt(this.options.height, 10);
          if (!Number.isNaN(h) && h > 0) {
            this.wrapper.classList.add('pe-compact');
            this.wrapper.style.minHeight = `${h}px`;
            this.body.style.minHeight = `${Math.max(h - 80, 200)}px`;
            this.content.style.minHeight = `${Math.max(h - 180, 150)}px`;
          }
        }

        // Replace textarea
        ta.parentNode.insertBefore(this.wrapper, ta);
        ta.style.display = 'none';
        this.textarea = ta;
      }
  
      /* ══════════════════════════════════════
         BUILD TOOLBAR
         ══════════════════════════════════════ */
      _buildToolbar() {
        const tb = this.toolbar;
  
        const group = (...items) => {
          const g = el('div', { class: 'pe-toolbar-group' });
          items.forEach(i => g.appendChild(i));
          tb.appendChild(g);
          tb.appendChild(el('div', { class: 'pe-toolbar-sep' }));
        };
  
        const btn = (cmd, tip, iconHtml, extra = {}) => {
          const b = el('button', { class: 'pe-btn', 'data-tip': tip, 'data-cmd': cmd, html: iconHtml, type: 'button', ...extra });
          return b;
        };
  
        const sel = (cls, opts, id) => {
          const s = el('select', { class: `pe-select ${cls}`, id });
          opts.forEach(o => s.appendChild(el('option', { value: o.v }, [o.l || o.v])));
          return s;
        };
  
        // Undo / Redo
        group(
          btn('undo', 'Undo (Ctrl+Z)', ICONS.undo, { id: 'pe-btn-undo' }),
          btn('redo', 'Redo (Ctrl+Y)', ICONS.redo, { id: 'pe-btn-redo' })
        );
  
        // Headings
        const headingSel = sel('pe-select-heading', [
          { v: 'p', l: 'Paragraph' },
          { v: 'h1', l: 'Heading 1' },
          { v: 'h2', l: 'Heading 2' },
          { v: 'h3', l: 'Heading 3' },
          { v: 'h4', l: 'Heading 4' },
          { v: 'h5', l: 'Heading 5' },
          { v: 'h6', l: 'Heading 6' },
        ], 'pe-heading-sel');
        const hg = el('div', { class: 'pe-toolbar-group' });
        hg.appendChild(headingSel);
        tb.appendChild(hg);
        tb.appendChild(el('div', { class: 'pe-toolbar-sep' }));
  
        // Font family
        const fontOpts = [{ v: '', l: 'Font Family' }, ...FONTS.map(f => ({ v: f, l: f }))];
        const fontSel = sel('pe-select-font-family', fontOpts, 'pe-font-family-sel');
  
        // Font size
        const sizeOpts = [{ v: '', l: 'Size' }, ...SIZES.map(s => ({ v: s, l: s + 'px' }))];
        const sizeSel = sel('pe-select-font-size', sizeOpts, 'pe-font-size-sel');
  
        const fg = el('div', { class: 'pe-toolbar-group' });
        fg.appendChild(fontSel);
        fg.appendChild(sizeSel);
        tb.appendChild(fg);
        tb.appendChild(el('div', { class: 'pe-toolbar-sep' }));
  
        // Text formatting
        group(
          btn('bold', 'Bold (Ctrl+B)', ICONS.bold, { id: 'pe-btn-bold' }),
          btn('italic', 'Italic (Ctrl+I)', ICONS.italic, { id: 'pe-btn-italic' }),
          btn('underline', 'Underline (Ctrl+U)', ICONS.underline, { id: 'pe-btn-underline' }),
          btn('strikeThrough', 'Strikethrough', ICONS.strikethrough),
          btn('superscript', 'Superscript', ICONS.superscript),
          btn('subscript', 'Subscript', ICONS.subscript),
          btn('removeFormat', 'Remove Formatting', ICONS.removeFormat),
          btn('insertCodeBlock', 'Code Block', ICONS.code, { id: 'pe-btn-code' }),
          btn('formatBlock_blockquote', 'Blockquote', ICONS.blockquote, { id: 'pe-btn-bq' })
        );
  
        // Font color & background
        const fcBtn = el('button', { class: 'pe-btn pe-color-btn', 'data-tip': 'Font Color', 'data-cmd': 'foreColor', id: 'pe-btn-fore', type: 'button' });
        fcBtn.innerHTML = ICONS.fontColor + '<span class="pe-color-indicator" id="pe-fore-indicator" style="background:#000"></span>';
        const bcBtn = el('button', { class: 'pe-btn pe-color-btn', 'data-tip': 'Highlight Color', 'data-cmd': 'backColor', id: 'pe-btn-back', type: 'button' });
        bcBtn.innerHTML = ICONS.bgColor + '<span class="pe-color-indicator" id="pe-back-indicator" style="background:#ffff00"></span>';
        const cg = el('div', { class: 'pe-toolbar-group' });
        cg.appendChild(fcBtn);
        cg.appendChild(bcBtn);
        tb.appendChild(cg);
        tb.appendChild(el('div', { class: 'pe-toolbar-sep' }));
  
        // Alignment
        group(
          btn('justifyLeft', 'Align Left', ICONS.alignLeft),
          btn('justifyCenter', 'Align Center', ICONS.alignCenter),
          btn('justifyRight', 'Align Right', ICONS.alignRight),
          btn('justifyFull', 'Justify', ICONS.alignJustify)
        );
  
        // Lists
        group(
          btn('insertOrderedList', 'Ordered List', ICONS.listOl),
          btn('insertUnorderedList', 'Unordered List', ICONS.listUl)
        );
  
        // Line height / letter spacing
        const lhSel = sel('pe-select-line-height', [
          { v: '', l: 'Line H' },
          ...['1','1.2','1.4','1.5','1.6','1.8','2','2.5','3'].map(v => ({ v, l: v }))
        ], 'pe-lh-sel');
        const lsSel = sel('pe-select-letter-spacing', [
          { v: '', l: 'Spacing' },
          ...['-2','-1','0','1','2','3','4','5','6','8','10'].map(v => ({ v, l: v + 'px' }))
        ], 'pe-ls-sel');
        const typo = el('div', { class: 'pe-toolbar-group' });
        typo.appendChild(lhSel);
        typo.appendChild(lsSel);
        tb.appendChild(typo);
        tb.appendChild(el('div', { class: 'pe-toolbar-sep' }));
  
        // Insert objects
        group(
          btn('insertTable', 'Insert Table', ICONS.table, { id: 'pe-btn-table' }),
          btn('insertImage', 'Insert Image', ICONS.image, { id: 'pe-btn-image' }),
          btn('insertVideo', 'Embed Video', ICONS.video, { id: 'pe-btn-video' }),
          btn('insertLink', 'Insert Link (Ctrl+K)', ICONS.link, { id: 'pe-btn-link' }),
          btn('insertHR', 'Horizontal Rule', ICONS.hr),
          btn('insertEmoji', 'Emoji', ICONS.emoji, { id: 'pe-btn-emoji' })
        );
  
        // Utility
        group(
          btn('toggleSource', 'Source Code', ICONS.source, { id: 'pe-btn-source' }),
          btn('toggleFullscreen', 'Fullscreen', ICONS.fullscreen, { id: 'pe-btn-fs' }),
          btn('toggleSidebar', 'Properties Panel', ICONS.sidebar, { id: 'pe-btn-sidebar' })
        );
      }
  
      /* ══════════════════════════════════════
         BIND TOOLBAR EVENTS
         ══════════════════════════════════════ */
      _bindToolbar() {
        const tb = this.toolbar;
  
        tb.addEventListener('mousedown', e => {
          const btn = e.target.closest('[data-cmd]');
          if (btn) {
            e.preventDefault();
            this._saveRange();
            this._execCmd(btn.dataset.cmd);
            this._updateToolbarState();
            return;
          }
          if (e.target.closest('select')) this._saveRange();
        });
  
        /* Heading select */
        tb.querySelector('.pe-select-heading')?.addEventListener('change', e => {
          this._applyBlockFormat(e.target.value);
        });
  
        /* Font family */
        $('#pe-font-family-sel').addEventListener('change', e => {
          this._restoreRange();
          document.execCommand('fontName', false, e.target.value);
          this._saveHistory();
        });
  
        /* Font size */
        $('#pe-font-size-sel').addEventListener('change', e => {
          this._restoreRange();
          const px = e.target.value;
          if (!px) return;
          const sel = window.getSelection();
          if (sel && !sel.isCollapsed) {
            const range = sel.getRangeAt(0);
            const span = el('span', { style: `font-size:${px}px` });
            try { range.surroundContents(span); } catch(ex) {
              const frag = range.extractContents();
              span.appendChild(frag);
              range.insertNode(span);
            }
            this._saveHistory();
          }
        });
  
        /* Line height */
        tb.querySelector('.pe-select-line-height')?.addEventListener('change', e => {
          const v = e.target.value;
          if (!v) return;
          this._applyLineHeight(v);
        });

        /* Letter spacing */
        tb.querySelector('.pe-select-letter-spacing')?.addEventListener('change', e => {
          const v = e.target.value;
          if (v === '') return;
          this._applyLetterSpacing(v);
        });
      }
  
      _execCmd(cmd) {
        this._restoreRange();
        switch (cmd) {
          case 'undo': this._undo(); break;
          case 'redo': this._redo(); break;
          case 'insertCodeBlock': this._insertCodeBlock(); break;
          case 'formatBlock_blockquote': document.execCommand('formatBlock', false, '<blockquote>'); break;
          case 'insertTable': this._openModal('pe-table-modal'); break;
          case 'insertImage': this._openModal('pe-image-modal'); break;
          case 'insertVideo': this._openModal('pe-video-modal'); break;
          case 'insertLink': this._openLinkModal(); break;
          case 'insertHR': document.execCommand('insertHorizontalRule'); break;
          case 'insertEmoji': this._openModal('pe-emoji-modal'); break;
          case 'toggleSource': this._toggleSource(); break;
          case 'toggleFullscreen': this._toggleFullscreen(); break;
          case 'toggleSidebar': this._toggleSidebar(); break;
          case 'foreColor': this._openColorPopup('fore'); break;
          case 'backColor': this._openColorPopup('back'); break;
          default:
            document.execCommand(cmd, false, null);
            this._saveHistory();
        }
      }
  
      /* ══════════════════════════════════════
         BIND CONTENT EVENTS
         ══════════════════════════════════════ */
      _bindContent() {
        const c = this.content;
  
        c.addEventListener('input', () => {
          this._syncTextarea();
          this._updateWordCount();
          this._saveHistoryDebounced();
          this._updateSidebar();
        });
  
        c.addEventListener('keydown', e => this._handleKeydown(e));
        c.addEventListener('keyup', () => this._updateToolbarState());
        c.addEventListener('mouseup', () => { this._saveRange(); this._updateToolbarState(); this._updateSidebar(); });
        c.addEventListener('focus', () => this._updateToolbarState());
  
        c.addEventListener('click', e => {
          const img = e.target.closest('.pe-img-wrap');
          if (img) { this._selectImage(img); return; }
          if (e.target.tagName === 'IMG' && !e.target.closest('.pe-img-wrap')) {
            this._wrapAndSelectImage(e.target);
            return;
          }
          const td = e.target.closest('td, th');
          if (td) { this._selectCell(td); }
          const tbl = e.target.closest('table');
          if (tbl) { this.selectedTable = tbl; this._updateSidebar(); }
          else { this.selectedTable = null; }
          if (!img) this._deselectImage();
        });
  
        c.addEventListener('contextmenu', e => this._showContextMenu(e));
  
        /* Drag & drop images */
        c.addEventListener('dragover', e => e.preventDefault());
        c.addEventListener('drop', e => {
          const files = e.dataTransfer?.files;
          if (files?.length) {
            const f = Array.from(files).find(f => f.type.startsWith('image/'));
            if (f) { e.preventDefault(); this._insertImageFromFile(f); }
          }
        });
  
        /* Paste images */
        c.addEventListener('paste', e => {
          const items = e.clipboardData?.items;
          if (!items) return;
          for (const item of items) {
            if (item.type.startsWith('image/')) {
              e.preventDefault();
              this._insertImageFromFile(item.getAsFile());
              return;
            }
          }
        });
      }
  
      _handleKeydown(e) {
        // Shortcuts
        if (e.ctrlKey || e.metaKey) {
          switch (e.key.toLowerCase()) {
            case 'z': e.preventDefault(); e.shiftKey ? this._redo() : this._undo(); return;
            case 'y': e.preventDefault(); this._redo(); return;
            case 'b': e.preventDefault(); document.execCommand('bold'); this._updateToolbarState(); return;
            case 'i': e.preventDefault(); document.execCommand('italic'); this._updateToolbarState(); return;
            case 'u': e.preventDefault(); document.execCommand('underline'); this._updateToolbarState(); return;
            case 'k': e.preventDefault(); this._saveRange(); this._openLinkModal(); return;
          }
        }
        // Tab in tables
        if (e.key === 'Tab') {
          const td = e.target.closest ? e.target.closest('td, th') : null;
          const inCell = window.getSelection()?.anchorNode?.closest?.('td, th');
          if (inCell) {
            e.preventDefault();
            this._tableTabNav(e.shiftKey);
            return;
          }
        }
      }
  
      /* ══════════════════════════════════════
         UNDO / REDO
         ══════════════════════════════════════ */
      _saveHistory() {
        const html = this.content.innerHTML;
        if (this.undoStack[this.undoStack.length - 1] === html) return;
        this.undoStack.push(html);
        if (this.undoStack.length > 200) this.undoStack.shift();
        this.redoStack = [];
        this._syncTextarea();
      }
  
      _saveHistoryDebounced() {
        clearTimeout(this._histTimer);
        this._histTimer = setTimeout(() => this._saveHistory(), 800);
      }
  
      _undo() {
        if (this.undoStack.length < 2) return;
        this.redoStack.push(this.undoStack.pop());
        this.content.innerHTML = this.undoStack[this.undoStack.length - 1] || '';
        this._syncTextarea();
        this._updateWordCount();
      }
  
      _redo() {
        if (!this.redoStack.length) return;
        const html = this.redoStack.pop();
        this.undoStack.push(html);
        this.content.innerHTML = html;
        this._syncTextarea();
        this._updateWordCount();
      }
  
      /* ══════════════════════════════════════
         TOOLBAR STATE
         ══════════════════════════════════════ */
      _updateToolbarState() {
        const cmds = ['bold','italic','underline','strikeThrough','superscript','subscript'];
        cmds.forEach(cmd => {
          const b = this.toolbar.querySelector(`[data-cmd="${cmd}"]`);
          if (b) b.classList.toggle('active', document.queryCommandState(cmd));
        });
  
        // Heading
        const hs = this.toolbar.querySelector('.pe-select-heading');
        if (hs) hs.value = this._getCurrentBlockTag();
  
        // Align
        ['justifyLeft','justifyCenter','justifyRight','justifyFull'].forEach(cmd => {
          const b = this.toolbar.querySelector(`[data-cmd="${cmd}"]`);
          if (b) b.classList.toggle('active', document.queryCommandState(cmd));
        });
      }
  
      /* ══════════════════════════════════════
         RANGE HELPERS
         ══════════════════════════════════════ */
      _saveRange() {
        const sel = window.getSelection();
        if (sel?.rangeCount) this.savedRange = sel.getRangeAt(0).cloneRange();
      }
  
      _restoreRange() {
        if (!this.savedRange) return;
        this.content.focus();
        const sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(this.savedRange);
      }
  
      _getBlockNode() {
        const sel = window.getSelection();
        if (!sel?.rangeCount) return null;
        let node = sel.getRangeAt(0).startContainer;
        if (node.nodeType === 3) node = node.parentNode;
        if (node === this.content) return this.content;
        while (node && node !== this.content) {
          const d = getComputedStyle(node).display;
          if (d === 'block' || d === 'list-item') return node;
          node = node.parentNode;
        }
        return this.content;
      }

      _isFormatBlock(node) {
        if (!node || node === this.content || node.nodeType !== 1) return false;
        return ['P', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'DIV', 'BLOCKQUOTE', 'PRE', 'LI'].includes(node.tagName);
      }

      _findFormatBlock(container, offset) {
        let node = container;
        if (node.nodeType === 3) node = node.parentNode;
        else if (node.nodeType === 1 && offset < node.childNodes.length) {
          const child = node.childNodes[offset];
          if (child) node = child.nodeType === 3 ? child.parentNode : child;
        }
        while (node && node !== this.content) {
          if (this._isFormatBlock(node)) return node;
          node = node.parentNode;
        }
        return null;
      }

      _getBlocksInRange(range) {
        const startBlock = this._findFormatBlock(range.startContainer, range.startOffset);
        const endBlock = this._findFormatBlock(range.endContainer, range.endOffset);
        if (!startBlock && !endBlock) return [];
        if (startBlock && endBlock && startBlock !== endBlock) {
          const blocks = [startBlock];
          let next = startBlock.nextElementSibling;
          while (next && next !== endBlock) {
            if (this._isFormatBlock(next)) blocks.push(next);
            next = next.nextElementSibling;
          }
          blocks.push(endBlock);
          return blocks;
        }
        return startBlock ? [startBlock] : (endBlock ? [endBlock] : []);
      }

      _replaceBlockTag(node, tagName) {
        if (!node || node === this.content) return node;
        const nextTag = tagName.toLowerCase();
        if (node.tagName.toLowerCase() === nextTag) return node;
        const newBlock = document.createElement(nextTag);
        if (node.hasAttribute('style')) newBlock.setAttribute('style', node.getAttribute('style'));
        if (node.hasAttribute('class')) newBlock.setAttribute('class', node.getAttribute('class'));
        while (node.firstChild) newBlock.appendChild(node.firstChild);
        if (!newBlock.childNodes.length) newBlock.appendChild(document.createElement('br'));
        node.parentNode.replaceChild(newBlock, node);
        return newBlock;
      }

      _placeCaretIn(node, atStart = false) {
        const range = document.createRange();
        range.selectNodeContents(node);
        range.collapse(atStart);
        const sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
        this._saveRange();
      }

      _getCurrentBlockTag() {
        const block = this._getBlockNode();
        if (!block || block === this.content) return 'p';
        const tag = block.tagName.toLowerCase();
        if (['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'].includes(tag)) return tag;
        return 'p';
      }

      _applyBlockFormat(tag) {
        const tagName = (tag || 'p').toLowerCase();
        this._restoreRange();
        this.content.focus();
        const sel = window.getSelection();
        if (!sel?.rangeCount) return;

        const range = sel.getRangeAt(0);
        if (!this.content.contains(range.commonAncestorContainer)) return;

        let blocks = this._getBlocksInRange(range);
        if (!blocks.length) {
          const node = this._getBlockNode();
          if (node && node !== this.content) blocks = [node];
        }

        if (!blocks.length) {
          if (!sel.isCollapsed) {
            const extracted = range.extractContents();
            const block = document.createElement(tagName);
            block.appendChild(extracted);
            range.insertNode(block);
            this._placeCaretIn(block);
          } else {
            const block = document.createElement(tagName);
            block.appendChild(document.createElement('br'));
            range.insertNode(block);
            this._placeCaretIn(block, true);
          }
        } else {
          blocks = blocks.map(block => this._replaceBlockTag(block, tagName));
          if (blocks.length === 1) {
            if (!sel.isCollapsed) {
              const newRange = document.createRange();
              newRange.selectNodeContents(blocks[0]);
              sel.removeAllRanges();
              sel.addRange(newRange);
            } else {
              this._placeCaretIn(blocks[0]);
            }
          }
        }

        this._saveRange();
        this._saveHistory();
        this._updateToolbarState();
      }

      _resolveStyleBlock() {
        this._restoreRange();
        let node = this._getBlockNode();
        if (node && node !== this.content) return node;
        const sel = window.getSelection();
        if (!sel?.rangeCount) return this.content;
        const range = sel.getRangeAt(0);
        const p = document.createElement('p');
        p.appendChild(document.createElement('br'));
        range.insertNode(p);
        this._placeCaretIn(p, true);
        return p;
      }

      _applyLineHeight(v) {
        this._restoreRange();
        const sel = window.getSelection();
        if (!sel?.rangeCount) return;
        const block = this._resolveStyleBlock();
        if (block) block.style.lineHeight = v;
        this._saveHistory();
      }

      _applyLetterSpacing(v) {
        this._restoreRange();
        const sel = window.getSelection();
        if (!sel?.rangeCount) return;
        const spacing = v + 'px';
        if (!sel.isCollapsed) {
          const range = sel.getRangeAt(0);
          const span = el('span', { style: `letter-spacing:${spacing}` });
          try { range.surroundContents(span); } catch (ex) {
            const frag = range.extractContents();
            span.appendChild(frag);
            range.insertNode(span);
          }
        } else {
          const block = this._resolveStyleBlock();
          if (block) block.style.letterSpacing = spacing;
        }
        this._saveHistory();
      }
  
      _insertAtCursor(node) {
        this._restoreRange();
        const sel = window.getSelection();
        if (!sel?.rangeCount) { this.content.appendChild(node); return; }
        const range = sel.getRangeAt(0);
        range.collapse(false);
        range.insertNode(node);
        range.setStartAfter(node);
        range.collapse(true);
        sel.removeAllRanges();
        sel.addRange(range);
      }
  
      /* ══════════════════════════════════════
         CODE BLOCK
         ══════════════════════════════════════ */
      _insertCodeBlock() {
        const sel = window.getSelection();
        const text = sel?.toString() || '';
        const pre = el('pre', {}, [el('code', { html: text || 'code here' })]);
        this._insertAtCursor(pre);
        this._saveHistory();
      }
  
      /* ══════════════════════════════════════
         TABLE
         ══════════════════════════════════════ */
      _buildTableGrid() {
        const grid = $('#pe-table-grid');
        if (!grid) return;
        grid.innerHTML = '';
        for (let r = 0; r < 8; r++) {
          for (let c = 0; c < 10; c++) {
            const cell = el('div', { class: 'pe-grid-cell', 'data-r': r + 1, 'data-c': c + 1 });
            grid.appendChild(cell);
          }
        }
        let hR = 0, hC = 0;
        grid.addEventListener('mousemove', e => {
          const cell = e.target.closest('.pe-grid-cell');
          if (!cell) return;
          hR = +cell.dataset.r; hC = +cell.dataset.c;
          $$('.pe-grid-cell', grid).forEach(c => {
            c.classList.toggle('active', +c.dataset.r <= hR && +c.dataset.c <= hC);
          });
          $('#pe-table-grid-label').textContent = `${hR} × ${hC}`;
          $('#pe-table-rows').value = hR;
          $('#pe-table-cols').value = hC;
        });
        grid.addEventListener('click', () => this._doInsertTable());
      }
  
      _doInsertTable() {
        const rows = +$('#pe-table-rows').value || 3;
        const cols = +$('#pe-table-cols').value || 3;
        const hasHeader = $('#pe-table-header').checked;
        const table = el('table');
        if (hasHeader) {
          const thead = el('thead');
          const tr = el('tr');
          for (let c = 0; c < cols; c++) {
            const th = el('th', { html: `Header ${c+1}` });
            this._addResizeHandles(th);
            tr.appendChild(th);
          }
          thead.appendChild(tr);
          table.appendChild(thead);
        }
        const tbody = el('tbody');
        const start = hasHeader ? 1 : 0;
        for (let r = start; r < rows; r++) {
          const tr = el('tr');
          for (let c = 0; c < cols; c++) {
            const td = el('td', { html: '&nbsp;' });
            this._addResizeHandles(td);
            tr.appendChild(td);
          }
          tbody.appendChild(tr);
        }
        table.appendChild(tbody);
        this._insertAtCursor(table);
        this._addTableEvents(table);
        this._closeModal('pe-table-modal');
        this._saveHistory();
      }
  
      _addResizeHandles(cell) {
        const cr = el('div', { class: 'pe-col-resizer' });
        const rr = el('div', { class: 'pe-row-resizer' });
        cell.appendChild(cr);
        cell.appendChild(rr);
        this._bindCellResize(cr, rr, cell);
      }
  
      _bindCellResize(cr, rr, cell) {
        let startX, startY, startW, startH;
  
        cr.addEventListener('mousedown', e => {
          e.preventDefault();
          e.stopPropagation();
          startX = e.clientX;
          startW = cell.offsetWidth;
          cr.classList.add('resizing');
          const move = e2 => { cell.style.width = Math.max(40, startW + e2.clientX - startX) + 'px'; };
          const up = () => { cr.classList.remove('resizing'); document.removeEventListener('mousemove', move); document.removeEventListener('mouseup', up); this._saveHistory(); };
          document.addEventListener('mousemove', move);
          document.addEventListener('mouseup', up);
        });
  
        rr.addEventListener('mousedown', e => {
          e.preventDefault();
          e.stopPropagation();
          startY = e.clientY;
          startH = cell.offsetHeight;
          rr.classList.add('resizing');
          const move = e2 => { cell.style.height = Math.max(24, startH + e2.clientY - startY) + 'px'; };
          const up = () => { rr.classList.remove('resizing'); document.removeEventListener('mousemove', move); document.removeEventListener('mouseup', up); this._saveHistory(); };
          document.addEventListener('mousemove', move);
          document.addEventListener('mouseup', up);
        });
      }
  
      _addTableEvents(table) {
        // Cell click selection
        table.addEventListener('click', e => {
          const td = e.target.closest('td, th');
          if (td) this._selectCell(td);
        });
      }
  
      _selectCell(td) {
        $$('.pe-cell-selected', this.content).forEach(c => c.classList.remove('pe-cell-selected'));
        td.classList.add('pe-cell-selected');
        this.selectedCell = td;
        this.selectedTable = td.closest('table');
        this._updateSidebar();
      }
  
      _tableTabNav(backward) {
        const sel = window.getSelection();
        const cell = sel?.anchorNode?.closest?.('td, th');
        if (!cell) return;
        const table = cell.closest('table');
        const cells = $$('td, th', table);
        const idx = cells.indexOf(cell);
        const next = cells[backward ? idx - 1 : idx + 1];
        if (next) {
          next.focus();
          const r = document.createRange();
          r.selectNodeContents(next);
          r.collapse(false);
          sel.removeAllRanges();
          sel.addRange(r);
        }
      }
  
      /* Table operations */
      _tableOp(op) {
        const td = this.selectedCell;
        if (!td) return;
        const table = td.closest('table');
        const tr = td.closest('tr');
        const idx = Array.from(tr.children).indexOf(td);
  
        if (op === 'addRowAbove' || op === 'addRowBelow') {
          const cols = tr.cells.length;
          const newTr = el('tr');
          for (let i = 0; i < cols; i++) {
            const newTd = el('td', { html: '&nbsp;' });
            this._addResizeHandles(newTd);
            newTr.appendChild(newTd);
          }
          if (op === 'addRowAbove') tr.parentNode.insertBefore(newTr, tr);
          else tr.parentNode.insertBefore(newTr, tr.nextSibling);
        } else if (op === 'deleteRow') {
          tr.remove();
        } else if (op === 'addColLeft' || op === 'addColRight') {
          $$('tr', table).forEach(row => {
            const ref = row.cells[idx];
            const newTd = row.closest('thead') ? el('th', { html: '&nbsp;' }) : el('td', { html: '&nbsp;' });
            this._addResizeHandles(newTd);
            if (op === 'addColLeft') row.insertBefore(newTd, ref);
            else row.insertBefore(newTd, ref ? ref.nextSibling : null);
          });
        } else if (op === 'deleteCol') {
          $$('tr', table).forEach(row => {
            if (row.cells[idx]) row.cells[idx].remove();
          });
        } else if (op === 'mergeCells') {
          this._mergeCells(td);
        } else if (op === 'splitCell') {
          this._splitCell(td);
        } else if (op === 'addHeader') {
          if (!$('thead', table)) {
            const thead = el('thead');
            const cols = tr.cells.length;
            const htr = el('tr');
            for (let i = 0; i < cols; i++) {
              const th = el('th', { html: 'Header' });
              this._addResizeHandles(th);
              htr.appendChild(th);
            }
            thead.appendChild(htr);
            table.insertBefore(thead, table.firstChild);
          }
        } else if (op === 'addFooter') {
          if (!$('tfoot', table)) {
            const tfoot = el('tfoot');
            const cols = tr.cells.length;
            const ftr = el('tr');
            for (let i = 0; i < cols; i++) {
              const ftd = el('td', { html: 'Footer' });
              this._addResizeHandles(ftd);
              ftr.appendChild(ftd);
            }
            tfoot.appendChild(ftr);
            table.appendChild(tfoot);
          }
        }
        this._saveHistory();
      }
  
      _mergeCells(startTd) {
        if (!this.mergeStartCell) {
          this.mergeStartCell = startTd;
          startTd.style.outline = '2px dashed var(--pe-warning)';
          this._showToast('Click the target cell to merge into');
          return;
        }
        const a = this.mergeStartCell;
        const b = startTd;
        if (a === b) { a.style.outline = ''; this.mergeStartCell = null; return; }
        a.innerHTML += ' ' + b.innerHTML;
        const acs = +a.getAttribute('colspan') || 1;
        const bcs = +b.getAttribute('colspan') || 1;
        const ars = +a.getAttribute('rowspan') || 1;
        const brs = +b.getAttribute('rowspan') || 1;
        if (a.closest('tr') === b.closest('tr')) {
          a.setAttribute('colspan', acs + bcs);
        } else {
          a.setAttribute('rowspan', ars + brs);
        }
        b.remove();
        a.style.outline = '';
        this.mergeStartCell = null;
        this._saveHistory();
      }
  
      _splitCell(td) {
        const cs = +td.getAttribute('colspan') || 1;
        const rs = +td.getAttribute('rowspan') || 1;
        if (cs < 2 && rs < 2) return;
        const tr = td.closest('tr');
        const idx = Array.from(tr.children).indexOf(td);
        if (cs > 1) {
          td.setAttribute('colspan', 1);
          for (let i = 1; i < cs; i++) {
            const newTd = el('td', { html: '&nbsp;' });
            this._addResizeHandles(newTd);
            tr.insertBefore(newTd, td.nextSibling);
          }
        }
        if (rs > 1) {
          td.setAttribute('rowspan', 1);
          let nextTr = tr.nextElementSibling;
          for (let i = 1; i < rs; i++) {
            if (!nextTr) break;
            const newTd = el('td', { html: '&nbsp;' });
            this._addResizeHandles(newTd);
            nextTr.insertBefore(newTd, nextTr.cells[idx] || null);
            nextTr = nextTr.nextElementSibling;
          }
        }
        this._saveHistory();
      }
  
      /* ══════════════════════════════════════
         IMAGE
         ══════════════════════════════════════ */
      _wrapAndSelectImage(img) {
        const wrap = el('div', { class: 'pe-img-wrap' });
        img.parentNode.insertBefore(wrap, img);
        wrap.appendChild(img);
        this._selectImage(wrap);
      }
  
      _selectImage(wrap) {
        this._deselectImage();
        this.selectedImage = wrap;
        wrap.classList.add('selected');
        this._addImageHandles(wrap);
        this._updateSidebar();
      }
  
      _deselectImage() {
        if (this.selectedImage) {
          this.selectedImage.classList.remove('selected');
          $$('.pe-resize-handle', this.selectedImage).forEach(h => h.remove());
          this.selectedImage = null;
        }
      }
  
      _addImageHandles(wrap) {
        ['nw','n','ne','e','se','s','sw','w'].forEach(pos => {
          const h = el('div', { class: `pe-resize-handle ${pos}` });
          wrap.appendChild(h);
          this._bindImageResize(h, wrap, pos);
        });
      }
  
      _bindImageResize(handle, wrap, pos) {
        let startX, startY, startW, startH;
        handle.addEventListener('mousedown', e => {
          e.preventDefault();
          e.stopPropagation();
          startX = e.clientX; startY = e.clientY;
          const img = wrap.querySelector('img');
          startW = img.offsetWidth; startH = img.offsetHeight;
          const img$ = img;
          const ratio = startW / startH;
  
          const move = e2 => {
            const dx = e2.clientX - startX;
            const dy = e2.clientY - startY;
            let newW = startW, newH = startH;
            if (pos.includes('e')) newW = Math.max(40, startW + dx);
            if (pos.includes('w')) newW = Math.max(40, startW - dx);
            if (pos.includes('s')) newH = Math.max(30, startH + dy);
            if (pos.includes('n')) newH = Math.max(30, startH - dy);
            // Lock aspect for corner handles
            if (pos.length === 2) newH = newW / ratio;
            img$.style.width = newW + 'px';
            img$.style.height = newH + 'px';
            this._updateSidebar();
          };
          const up = () => {
            document.removeEventListener('mousemove', move);
            document.removeEventListener('mouseup', up);
            this._saveHistory();
          };
          document.addEventListener('mousemove', move);
          document.addEventListener('mouseup', up);
        });
      }
  
      _uploadImageFile(file) {
        if (!this.options.uploadUrl) {
          return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = e => resolve(e.target.result);
            reader.onerror = () => reject(new Error('Failed to read image file.'));
            reader.readAsDataURL(file);
          });
        }

        const formData = new FormData();
        formData.append('file', file);

        return fetch(this.options.uploadUrl, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': this.options.uploadToken || '',
          },
          body: formData,
          credentials: 'same-origin',
        })
          .then(response => {
            if (!response.ok) {
              throw new Error('Image upload failed.');
            }
            return response.json();
          })
          .then(data => data.location);
      }

      _insertImageFromFile(file) {
        this._uploadImageFile(file)
          .then(src => this._doInsertImage(src, '', 'center'))
          .catch(() => this._showToast('Image upload failed. Please try again.'));
      }
  
      _doInsertImage(src, alt, align) {
        const img = el('img', { src, alt: alt || '' });
        const wrap = el('div', { class: `pe-img-wrap${align === 'center' ? ' pe-img-center' : align === 'left' ? ' pe-img-left' : align === 'right' ? ' pe-img-right' : ''}` });
        wrap.appendChild(img);
        this._insertAtCursor(wrap);
        this._addTableEvents; // noop here; just for ref
        this._selectImage(wrap);
        this._saveHistory();
      }
  
      /* ══════════════════════════════════════
         VIDEO
         ══════════════════════════════════════ */
      _doInsertVideo(url, w, h, controls) {
        const wrap = el('div', { class: 'pe-video-wrap' });
        const ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/);
        const vmMatch = url.match(/vimeo\.com\/(\d+)/);
        if (ytMatch) {
          const iframe = el('iframe', { src: `https://www.youtube.com/embed/${ytMatch[1]}`, width: w, height: h, allowfullscreen: true, frameborder: '0', allow: 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' });
          wrap.appendChild(iframe);
        } else if (vmMatch) {
          const iframe = el('iframe', { src: `https://player.vimeo.com/video/${vmMatch[1]}`, width: w, height: h, allowfullscreen: true, frameborder: '0' });
          wrap.appendChild(iframe);
        } else if (url.endsWith('.mp4') || url.includes('mp4')) {
          const video = el('video', { src: url, width: w, height: h });
          if (controls) video.controls = true;
          wrap.appendChild(video);
        } else {
          const iframe = el('iframe', { src: url, width: w, height: h, frameborder: '0' });
          wrap.appendChild(iframe);
        }
        this._insertAtCursor(wrap);
        this._saveHistory();
      }
  
      /* ══════════════════════════════════════
         LINK
         ══════════════════════════════════════ */
      _openLinkModal() {
        const sel = window.getSelection();
        const text = sel?.toString() || '';
        const a = sel?.anchorNode?.parentElement?.closest('a');
        $('#pe-link-url').value = a?.href || '';
        $('#pe-link-text').value = a ? a.textContent : text;
        $('#pe-link-blank').checked = a?.target === '_blank';
        this._openModal('pe-link-modal');
      }
  
      _doInsertLink() {
        const url = $('#pe-link-url').value.trim();
        if (!url) return;
        const text = $('#pe-link-text').value.trim() || url;
        const blank = $('#pe-link-blank').checked;
        this._restoreRange();
        const sel = window.getSelection();
        const a = el('a', { href: url, html: text });
        if (blank) a.target = '_blank';
        if (sel?.rangeCount) {
          const range = sel.getRangeAt(0);
          if (!range.collapsed) range.deleteContents();
          range.insertNode(a);
        } else {
          this.content.appendChild(a);
        }
        this._closeModal('pe-link-modal');
        this._saveHistory();
      }
  
      /* ══════════════════════════════════════
         EMOJI PICKER
         ══════════════════════════════════════ */
      _buildEmojiPicker() {
        const catContainer = $('#pe-emoji-categories');
        const grid = $('#pe-emoji-grid');
        if (!catContainer || !grid) return;
        let activeCat = Object.keys(EMOJI_DATA)[0];
  
        const renderCat = (cat) => {
          grid.innerHTML = '';
          EMOJI_DATA[cat].forEach(emoji => {
            const item = el('div', { class: 'pe-emoji-item', title: emoji, html: emoji });
            item.addEventListener('click', () => {
              this._restoreRange();
              document.execCommand('insertText', false, emoji);
              this._closeModal('pe-emoji-modal');
              this._saveHistory();
            });
            grid.appendChild(item);
          });
        };
  
        Object.keys(EMOJI_DATA).forEach(cat => {
          const btn = el('button', { class: `pe-emoji-cat-btn${cat === activeCat ? ' active' : ''}`, html: cat, type: 'button' });
          btn.addEventListener('click', () => {
            activeCat = cat;
            $$('.pe-emoji-cat-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            renderCat(cat);
          });
          catContainer.appendChild(btn);
        });
  
        // Search
        $('#pe-emoji-search')?.addEventListener('input', e => {
          const q = e.target.value.toLowerCase();
          if (!q) { renderCat(activeCat); return; }
          grid.innerHTML = '';
          Object.values(EMOJI_DATA).flat().forEach(emoji => {
            if (emoji.includes(q)) {
              const item = el('div', { class: 'pe-emoji-item', html: emoji });
              item.addEventListener('click', () => {
                this._restoreRange();
                document.execCommand('insertText', false, emoji);
                this._closeModal('pe-emoji-modal');
                this._saveHistory();
              });
              grid.appendChild(item);
            }
          });
        });
  
        renderCat(activeCat);
      }
  
      /* ══════════════════════════════════════
         COLOR POPUP
         ══════════════════════════════════════ */
      _bindColorPopup() {
        const swatches = $('#pe-color-swatches');
        if (!swatches) return;
        COLOR_PALETTE.forEach(color => {
          const sw = el('div', { class: 'pe-color-swatch', style: `background:${color}`, title: color });
          sw.addEventListener('click', () => {
            this._applyColor(color);
            this._hideColorPopup();
          });
          swatches.appendChild(sw);
        });
  
        $('#pe-color-apply')?.addEventListener('click', () => {
          const val = $('#pe-color-custom-input')?.value;
          if (val) { this._applyColor(val); this._hideColorPopup(); }
        });
  
        document.addEventListener('click', e => {
          const popup = $('#pe-color-popup');
          if (popup && !popup.contains(e.target) && !e.target.closest('[data-cmd="foreColor"]') && !e.target.closest('[data-cmd="backColor"]')) {
            this._hideColorPopup();
          }
        });
      }
  
      _openColorPopup(target) {
        this.colorTarget = target;
        const btn = target === 'fore' ? $('#pe-btn-fore') : $('#pe-btn-back');
        const popup = $('#pe-color-popup');
        if (!popup || !btn) return;
        const rect = btn.getBoundingClientRect();
        popup.style.top = (rect.bottom + 4) + 'px';
        popup.style.left = rect.left + 'px';
        popup.style.display = 'block';
      }
  
      _hideColorPopup() {
        const popup = $('#pe-color-popup');
        if (popup) popup.style.display = 'none';
      }
  
      _applyColor(color) {
        this._restoreRange();
        if (this.colorTarget === 'fore') {
          document.execCommand('foreColor', false, color);
          const ind = $('#pe-fore-indicator');
          if (ind) ind.style.background = color;
        } else {
          document.execCommand('backColor', false, color);
          const ind = $('#pe-back-indicator');
          if (ind) ind.style.background = color;
        }
        this._saveHistory();
      }
  
      /* ══════════════════════════════════════
         SOURCE / FULLSCREEN / SIDEBAR
         ══════════════════════════════════════ */
      _toggleSource() {
        const ta = $('#pe-source-textarea');
        if (!ta) return;
        ta.value = this._formatHTML(this.content.innerHTML);
        this._openModal('pe-source-modal');
      }
  
      _applySource() {
        const ta = $('#pe-source-textarea');
        if (!ta) return;
        this.content.innerHTML = ta.value;
        this._closeModal('pe-source-modal');
        this._syncTextarea();
        this._saveHistory();
      }
  
      _formatHTML(html) {
        let indent = 0;
        return html
          .replace(/></g, '>\n<')
          .split('\n')
          .map(line => {
            if (/^<\//.test(line.trim())) indent = Math.max(0, indent - 1);
            const out = '  '.repeat(indent) + line.trim();
            if (/^<[^/!]/.test(line.trim()) && !/<\//.test(line) && !line.trim().endsWith('/>')) indent++;
            return out;
          })
          .join('\n');
      }
  
      _toggleFullscreen() {
        this.isFullscreen = !this.isFullscreen;
        this.wrapper.classList.toggle('pe-fullscreen', this.isFullscreen);
        const btn = $('#pe-btn-fs');
        if (btn) btn.innerHTML = this.isFullscreen ? ICONS.exitFullscreen : ICONS.fullscreen;
        document.body.style.overflow = this.isFullscreen ? 'hidden' : '';
      }
  
      _toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
        this.sidebar.classList.toggle('collapsed', !this.sidebarOpen);
        const btn = $('#pe-btn-sidebar');
        if (btn) btn.classList.toggle('active', this.sidebarOpen);
      }
  
      /* ══════════════════════════════════════
         SIDEBAR
         ══════════════════════════════════════ */
      _buildSidebar() {
        const sb = this.sidebar;
        sb.innerHTML = `
          <div class="pe-sidebar-header">
            Properties
            <button class="pe-sidebar-close" id="pe-sb-close">✕</button>
          </div>
          <div class="pe-sidebar-body" id="pe-sidebar-body">
            <div id="pe-sb-general">
              <div class="pe-sidebar-section">
                <div class="pe-sidebar-section-title">HTML Output</div>
                <div class="pe-output-tabs">
                  <button class="pe-output-tab active" data-out="clean">Clean</button>
                  <button class="pe-output-tab" data-out="inline">Inline CSS</button>
                  <button class="pe-output-tab" data-out="email">Email</button>
                </div>
                <pre class="pe-output-code" id="pe-output-code"></pre>
                <button class="pe-copy-btn" id="pe-copy-html">Copy HTML</button>
              </div>
            </div>
            <div id="pe-sb-image" style="display:none">
              <div class="pe-sidebar-section">
                <div class="pe-sidebar-section-title">Image Properties</div>
                <div class="pe-prop-row"><span class="pe-prop-label">Width</span><input class="pe-prop-input" id="pe-img-w" type="number" min="10" /></div>
                <div class="pe-prop-row"><span class="pe-prop-label">Height</span><input class="pe-prop-input" id="pe-img-h" type="number" min="10" /></div>
                <div class="pe-prop-row"><span class="pe-prop-label">Alt text</span><input class="pe-prop-input" id="pe-img-alt-prop" type="text" /></div>
                <div class="pe-prop-row"><span class="pe-prop-label">Align</span>
                  <select class="pe-prop-select" id="pe-img-align-prop">
                    <option value="">Inline</option>
                    <option value="left">Left</option>
                    <option value="center">Center</option>
                    <option value="right">Right</option>
                  </select>
                </div>
                <div class="pe-sidebar-actions">
                  <button class="pe-sidebar-btn danger" id="pe-sb-img-delete">🗑 Delete Image</button>
                </div>
              </div>
            </div>
            <div id="pe-sb-table" style="display:none">
              <div class="pe-sidebar-section">
                <div class="pe-sidebar-section-title">Table Actions</div>
                <div class="pe-sidebar-actions" id="pe-sb-table-actions"></div>
              </div>
              <div class="pe-sidebar-section">
                <div class="pe-sidebar-section-title">Table Properties</div>
                <div class="pe-prop-row"><span class="pe-prop-label">Width</span><input class="pe-prop-input" id="pe-tbl-w" type="text" placeholder="100%" /></div>
                <div class="pe-prop-row"><span class="pe-prop-label">Border W</span><input class="pe-prop-input" id="pe-tbl-bw" type="number" min="0" /></div>
                <div class="pe-prop-row"><span class="pe-prop-label">Border C</span><input class="pe-prop-input" id="pe-tbl-bc" type="color" /></div>
                <div class="pe-prop-row"><span class="pe-prop-label">BG Color</span><input class="pe-prop-input" id="pe-tbl-bg" type="color" /></div>
                <div class="pe-prop-row"><span class="pe-prop-label">Cell Pad</span><input class="pe-prop-input" id="pe-tbl-cp" type="number" min="0" /></div>
              </div>
              <div class="pe-sidebar-section" id="pe-sb-cell-section" style="display:none">
                <div class="pe-sidebar-section-title">Cell Properties</div>
                <div class="pe-prop-row"><span class="pe-prop-label">BG Color</span><input class="pe-prop-input" id="pe-cell-bg" type="color" /></div>
                <div class="pe-prop-row"><span class="pe-prop-label">Text Color</span><input class="pe-prop-input" id="pe-cell-tc" type="color" /></div>
                <div class="pe-prop-row"><span class="pe-prop-label">V-Align</span>
                  <select class="pe-prop-select" id="pe-cell-va">
                    <option value="top">Top</option><option value="middle">Middle</option><option value="bottom">Bottom</option>
                  </select>
                </div>
                <div class="pe-prop-row"><span class="pe-prop-label">H-Align</span>
                  <select class="pe-prop-select" id="pe-cell-ha">
                    <option value="left">Left</option><option value="center">Center</option><option value="right">Right</option>
                  </select>
                </div>
                <div class="pe-prop-row"><span class="pe-prop-label">Width</span><input class="pe-prop-input" id="pe-cell-w" type="text" /></div>
                <div class="pe-prop-row"><span class="pe-prop-label">Height</span><input class="pe-prop-input" id="pe-cell-h" type="text" /></div>
              </div>
            </div>
          </div>`;
  
        // Close button
        setTimeout(() => {
          $('#pe-sb-close')?.addEventListener('click', () => this._toggleSidebar());
  
          // Output tabs
          $$('.pe-output-tab').forEach(tab => {
            tab.addEventListener('click', () => {
              $$('.pe-output-tab').forEach(t => t.classList.remove('active'));
              tab.classList.add('active');
              this._renderOutput(tab.dataset.out);
            });
          });
  
          // Copy HTML
          $('#pe-copy-html')?.addEventListener('click', () => {
            const code = $('#pe-output-code')?.textContent;
            navigator.clipboard?.writeText(code || '');
            this._showToast('HTML copied!');
          });
  
          // Image props
          ['#pe-img-w','#pe-img-h','#pe-img-alt-prop'].forEach(sel => {
            $(sel)?.addEventListener('input', () => this._applyImageProps());
          });
          $('#pe-img-align-prop')?.addEventListener('change', () => this._applyImageProps());
          $('#pe-sb-img-delete')?.addEventListener('click', () => {
            this.selectedImage?.remove();
            this.selectedImage = null;
            this._updateSidebar();
            this._saveHistory();
          });
  
          // Build table action buttons
          const tableActions = [
            ['➕ Row Above', 'addRowAbove'], ['➕ Row Below', 'addRowBelow'],
            ['➖ Delete Row', 'deleteRow'], ['⬅ Col Left', 'addColLeft'],
            ['Col Right ➡', 'addColRight'], ['➖ Delete Col', 'deleteCol'],
            ['⊞ Merge Cells', 'mergeCells'], ['⊡ Split Cell', 'splitCell'],
            ['🔝 Add Header', 'addHeader'], ['🔚 Add Footer', 'addFooter'],
          ];
          const taa = $('#pe-sb-table-actions');
          if (taa) {
            tableActions.forEach(([label, op]) => {
              const b = el('button', { class: 'pe-sidebar-btn', html: label, type: 'button' });
              b.addEventListener('click', () => this._tableOp(op));
              taa.appendChild(b);
            });
          }
  
          // Table property bindings
          const tblInputs = [
            ['#pe-tbl-w', 'width'], ['#pe-tbl-bw', 'borderWidth'],
            ['#pe-tbl-bc', 'borderColor'], ['#pe-tbl-bg', 'backgroundColor'],
            ['#pe-tbl-cp', 'cellPadding'],
          ];
          tblInputs.forEach(([sel, prop]) => {
            $(sel)?.addEventListener('input', () => this._applyTableProps());
          });
  
          // Cell property bindings
          const cellInputs = ['#pe-cell-bg','#pe-cell-tc','#pe-cell-va','#pe-cell-ha','#pe-cell-w','#pe-cell-h'];
          cellInputs.forEach(sel => {
            $(sel)?.addEventListener('input', () => this._applyCellProps());
            $(sel)?.addEventListener('change', () => this._applyCellProps());
          });
        }, 50);
      }
  
      _updateSidebar() {
        this._renderOutput('clean');
  
        const imgSection = $('#pe-sb-image');
        const tblSection = $('#pe-sb-table');
        const genSection = $('#pe-sb-general');
        const cellSection = $('#pe-sb-cell-section');
        if (!imgSection) return;
  
        if (this.selectedImage) {
          imgSection.style.display = 'block';
          tblSection.style.display = 'none';
          const img = this.selectedImage.querySelector('img');
          if (img) {
            const iw = $('#pe-img-w'); if (iw) iw.value = img.offsetWidth || '';
            const ih = $('#pe-img-h'); if (ih) ih.value = img.offsetHeight || '';
            const ia = $('#pe-img-alt-prop'); if (ia) ia.value = img.alt || '';
            const ialign = $('#pe-img-align-prop');
            if (ialign) {
              const cls = this.selectedImage.className;
              ialign.value = cls.includes('pe-img-left') ? 'left' : cls.includes('pe-img-right') ? 'right' : cls.includes('pe-img-center') ? 'center' : '';
            }
          }
        } else if (this.selectedTable) {
          imgSection.style.display = 'none';
          tblSection.style.display = 'block';
          // Fill table props
          const tbl = this.selectedTable;
          const tw = $('#pe-tbl-w'); if (tw) tw.value = tbl.style.width || '';
          const tbw = $('#pe-tbl-bw'); if (tbw) tbw.value = parseInt(tbl.style.borderWidth) || 0;
          const tbc = $('#pe-tbl-bc'); if (tbc) tbc.value = tbl.style.borderColor || '#e2e2ec';
          const tbg = $('#pe-tbl-bg'); if (tbg) tbg.value = tbl.style.backgroundColor || '#ffffff';
          const tcp = $('#pe-tbl-cp'); if (tcp) tcp.value = tbl.getAttribute('cellpadding') || 0;
  
          if (this.selectedCell) {
            if (cellSection) cellSection.style.display = 'block';
            const cbg = $('#pe-cell-bg'); if (cbg) cbg.value = this.selectedCell.style.backgroundColor || '#ffffff';
            const ctc = $('#pe-cell-tc'); if (ctc) ctc.value = this.selectedCell.style.color || '#000000';
            const cva = $('#pe-cell-va'); if (cva) cva.value = this.selectedCell.style.verticalAlign || 'top';
            const cha = $('#pe-cell-ha'); if (cha) cha.value = this.selectedCell.style.textAlign || 'left';
            const cw = $('#pe-cell-w'); if (cw) cw.value = this.selectedCell.style.width || '';
            const ch = $('#pe-cell-h'); if (ch) ch.value = this.selectedCell.style.height || '';
          } else {
            if (cellSection) cellSection.style.display = 'none';
          }
        } else {
          imgSection.style.display = 'none';
          tblSection.style.display = 'none';
        }
      }
  
      _renderOutput(mode) {
        const codeEl = $('#pe-output-code');
        if (!codeEl) return;
        let html = this.content.innerHTML;
        if (mode === 'clean') {
          html = html.replace(/\s(class|data-[^=]*)="[^"]*"/g, '');
          html = html.replace(/<div class="pe-[^"]*">/g, '').replace(/<\/div>/g, '');
        } else if (mode === 'email') {
          html = `<!DOCTYPE html><html><body style="font-family:Arial,sans-serif;font-size:14px;color:#1e1e2e;max-width:600px;margin:0 auto">\n${html}\n</body></html>`;
        }
        codeEl.textContent = this._formatHTML(html).substring(0, 2000);
      }
  
      _applyImageProps() {
        if (!this.selectedImage) return;
        const img = this.selectedImage.querySelector('img');
        if (!img) return;
        const w = $('#pe-img-w')?.value;
        const h = $('#pe-img-h')?.value;
        const alt = $('#pe-img-alt-prop')?.value;
        const align = $('#pe-img-align-prop')?.value;
        if (w) img.style.width = w + 'px';
        if (h) img.style.height = h + 'px';
        if (alt !== undefined) img.alt = alt;
        this.selectedImage.className = 'pe-img-wrap' + (align === 'center' ? ' pe-img-center' : align === 'left' ? ' pe-img-left' : align === 'right' ? ' pe-img-right' : '');
      }
  
      _applyTableProps() {
        const tbl = this.selectedTable;
        if (!tbl) return;
        const w = $('#pe-tbl-w')?.value;
        const bw = $('#pe-tbl-bw')?.value;
        const bc = $('#pe-tbl-bc')?.value;
        const bg = $('#pe-tbl-bg')?.value;
        const cp = $('#pe-tbl-cp')?.value;
        if (w) tbl.style.width = w;
        if (bw !== undefined) { tbl.style.borderWidth = bw + 'px'; tbl.style.borderStyle = bw > 0 ? 'solid' : ''; }
        if (bc) tbl.style.borderColor = bc;
        if (bg) tbl.style.backgroundColor = bg;
        if (cp) tbl.setAttribute('cellpadding', cp);
      }
  
      _applyCellProps() {
        const td = this.selectedCell;
        if (!td) return;
        const bg = $('#pe-cell-bg')?.value;
        const tc = $('#pe-cell-tc')?.value;
        const va = $('#pe-cell-va')?.value;
        const ha = $('#pe-cell-ha')?.value;
        const cw = $('#pe-cell-w')?.value;
        const ch = $('#pe-cell-h')?.value;
        if (bg) td.style.backgroundColor = bg;
        if (tc) td.style.color = tc;
        if (va) td.style.verticalAlign = va;
        if (ha) td.style.textAlign = ha;
        if (cw) td.style.width = cw;
        if (ch) td.style.height = ch;
      }
  
      /* ══════════════════════════════════════
         STATUS BAR
         ══════════════════════════════════════ */
      _buildStatusbar() {
        this.statusbar.innerHTML = `
          <div class="pe-statusbar-left">
            <span class="pe-status-item">Words: <span class="pe-status-badge" id="pe-word-count">0</span></span>
            <span class="pe-status-item">Chars: <span class="pe-status-badge" id="pe-char-count">0</span></span>
            <span class="pe-status-item">Lines: <span class="pe-status-badge" id="pe-line-count">0</span></span>
          </div>
          <div class="pe-statusbar-right">
            <span class="pe-status-item" style="color:var(--pe-primary);font-weight:500">ProEditor v2.0</span>
            <span class="pe-status-item" id="pe-save-status">Ready</span>
          </div>`;
        this._updateWordCount();
      }
  
      _updateWordCount() {
        const text = this.content.innerText || '';
        const words = text.trim().split(/\s+/).filter(w => w).length;
        const chars = text.length;
        const lines = text.split('\n').length;
        const wc = $('#pe-word-count');
        const cc = $('#pe-char-count');
        const lc = $('#pe-line-count');
        if (wc) wc.textContent = words;
        if (cc) cc.textContent = chars;
        if (lc) lc.textContent = lines;
      }
  
      /* ══════════════════════════════════════
         CONTEXT MENU
         ══════════════════════════════════════ */
      _showContextMenu(e) {
        e.preventDefault();
        const menu = $('#pe-context-menu');
        if (!menu) return;
        menu.innerHTML = '';
  
        const addItem = (label, action, danger = false) => {
          const item = el('div', { class: `pe-ctx-item${danger ? ' danger' : ''}`, html: label });
          item.addEventListener('click', () => { action(); menu.style.display = 'none'; });
          menu.appendChild(item);
        };
        const addSep = () => menu.appendChild(el('div', { class: 'pe-ctx-sep' }));
        const addLabel = (label) => menu.appendChild(el('div', { class: 'pe-ctx-label', html: label }));
  
        const td = e.target.closest('td, th');
        const img = e.target.closest('.pe-img-wrap, img');
        const a = e.target.closest('a');
  
        if (img) {
          addLabel('Image');
          addItem('📐 Image Properties', () => { this._updateSidebar(); if (!this.sidebarOpen) this._toggleSidebar(); });
          addItem('🗑 Delete Image', () => { img.closest('.pe-img-wrap')?.remove() || img.remove(); this._saveHistory(); }, true);
          addSep();
        }
  
        if (td) {
          addLabel('Table Cell');
          addItem('➕ Insert Row Above', () => this._tableOp('addRowAbove'));
          addItem('➕ Insert Row Below', () => this._tableOp('addRowBelow'));
          addItem('➖ Delete Row', () => this._tableOp('deleteRow'), true);
          addSep();
          addItem('⬅ Insert Column Left', () => this._tableOp('addColLeft'));
          addItem('Insert Column Right ➡', () => this._tableOp('addColRight'));
          addItem('➖ Delete Column', () => this._tableOp('deleteCol'), true);
          addSep();
          addItem('⊞ Merge Cells', () => this._tableOp('mergeCells'));
          addItem('⊡ Split Cell', () => this._tableOp('splitCell'));
          addSep();
          addItem('⚙ Cell Properties', () => { if (!this.sidebarOpen) this._toggleSidebar(); this._updateSidebar(); });
          addSep();
        }
  
        if (a) {
          addItem('✏️ Edit Link', () => { this._saveRange(); this._openLinkModal(); });
          addItem('🔗 Remove Link', () => { const sel = window.getSelection(); sel.selectAllChildren(a); document.execCommand('unlink'); this._saveHistory(); }, true);
          addSep();
        }
  
        addLabel('Edit');
        addItem('✂️ Cut', () => document.execCommand('cut'));
        addItem('📋 Copy', () => document.execCommand('copy'));
        addItem('📌 Paste', () => document.execCommand('paste'));
        addSep();
        addItem('↩ Undo', () => this._undo());
        addItem('↪ Redo', () => this._redo());
        addSep();
        addLabel('Format');
        addItem('<b>B</b> Bold', () => document.execCommand('bold'));
        addItem('<i>I</i> Italic', () => document.execCommand('italic'));
        addItem('<u>U</u> Underline', () => document.execCommand('underline'));
        addItem('🗑 Remove Formatting', () => document.execCommand('removeFormat'));
  
        menu.style.display = 'block';
        const mw = menu.offsetWidth, mh = menu.offsetHeight;
        let x = e.clientX, y = e.clientY;
        if (x + mw > window.innerWidth) x = window.innerWidth - mw - 8;
        if (y + mh > window.innerHeight) y = window.innerHeight - mh - 8;
        menu.style.left = x + 'px';
        menu.style.top = y + 'px';
  
        const hide = (ev) => { if (!menu.contains(ev.target)) { menu.style.display = 'none'; document.removeEventListener('click', hide); } };
        setTimeout(() => document.addEventListener('click', hide), 50);
      }
  
      /* ══════════════════════════════════════
         MODALS
         ══════════════════════════════════════ */
      _bindModals() {
        // Close buttons
        document.querySelectorAll('.pe-modal-close, [data-modal]').forEach(btn => {
          if (btn.dataset.modal) {
            btn.addEventListener('click', () => this._closeModal(btn.dataset.modal));
          }
        });
  
        // Overlay click to close
        document.querySelectorAll('.pe-modal-overlay').forEach(overlay => {
          overlay.addEventListener('click', e => {
            if (e.target === overlay) this._closeModal(overlay.id);
          });
        });
  
        // Link insert
        $('#pe-link-insert')?.addEventListener('click', () => this._doInsertLink());
  
        // Image insert
        $('#pe-image-insert')?.addEventListener('click', () => {
          const activePanel = $('.pe-tab-panel.active', $('#pe-image-modal'));
          if (activePanel?.dataset.panel === 'upload' && this.imageFile) {
            const alt = $('#pe-image-alt')?.value || '';
            const align = $('#pe-image-align')?.value || 'center';
            const file = this.imageFile;
            this._uploadImageFile(file)
              .then(src => this._doInsertImage(src, alt, align))
              .catch(() => this._showToast('Image upload failed. Please try again.'));
          } else {
            const url = $('#pe-image-url')?.value.trim();
            if (url) {
              const alt = $('#pe-image-alt')?.value || '';
              const align = $('#pe-image-align')?.value || 'center';
              this._doInsertImage(url, alt, align);
            }
          }
          this._closeModal('pe-image-modal');
        });
  
        // File input
        $('#pe-file-input')?.addEventListener('change', e => {
          const f = e.target.files?.[0];
          if (!f) return;
          this.imageFile = f;
          const reader = new FileReader();
          reader.onload = ev => {
            const preview = $('#pe-img-preview');
            const img = $('#pe-img-preview-img');
            if (preview && img) { img.src = ev.target.result; preview.style.display = 'block'; }
          };
          reader.readAsDataURL(f);
        });
  
        // Drop zone
        const dz = $('#pe-drop-zone');
        if (dz) {
          dz.addEventListener('dragover', e => { e.preventDefault(); dz.classList.add('dragover'); });
          dz.addEventListener('dragleave', () => dz.classList.remove('dragover'));
          dz.addEventListener('drop', e => {
            e.preventDefault();
            dz.classList.remove('dragover');
            const f = e.dataTransfer.files?.[0];
            if (f && f.type.startsWith('image/')) {
              this.imageFile = f;
              const reader = new FileReader();
              reader.onload = ev => {
                const preview = $('#pe-img-preview');
                const img = $('#pe-img-preview-img');
                if (preview && img) { img.src = ev.target.result; preview.style.display = 'block'; }
              };
              reader.readAsDataURL(f);
            }
          });
          dz.addEventListener('click', () => $('#pe-file-input')?.click());
        }
  
        // Video insert
        $('#pe-video-insert')?.addEventListener('click', () => {
          const url = $('#pe-video-url')?.value.trim();
          if (!url) return;
          const w = $('#pe-video-width')?.value || 560;
          const h = $('#pe-video-height')?.value || 315;
          const ctrl = $('#pe-video-controls')?.checked;
          this._doInsertVideo(url, w, h, ctrl);
          this._closeModal('pe-video-modal');
        });
  
        // Table insert
        $('#pe-table-insert')?.addEventListener('click', () => this._doInsertTable());
  
        // Source apply
        $('#pe-source-apply')?.addEventListener('click', () => this._applySource());
  
        // Tab switching in modals
        document.querySelectorAll('.pe-tab').forEach(tab => {
          tab.addEventListener('click', () => {
            const modal = tab.closest('.pe-modal');
            if (!modal) return;
            modal.querySelectorAll('.pe-tab').forEach(t => t.classList.remove('active'));
            modal.querySelectorAll('.pe-tab-panel').forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            modal.querySelector(`[data-panel="${tab.dataset.tab}"]`)?.classList.add('active');
          });
        });
  
        // Esc to close
        document.addEventListener('keydown', e => {
          if (e.key === 'Escape') {
            document.querySelectorAll('.pe-modal-overlay').forEach(m => { m.style.display = 'none'; });
            $('#pe-color-popup')?.style && ($('#pe-color-popup').style.display = 'none');
            $('#pe-context-menu')?.style && ($('#pe-context-menu').style.display = 'none');
          }
        });
      }
  
      _openModal(id) {
        const m = document.getElementById(id);
        if (m) { m.style.display = 'flex'; }
      }
  
      _closeModal(id) {
        const m = document.getElementById(id);
        if (m) { m.style.display = 'none'; }
      }
  
      /* ══════════════════════════════════════
         SYNC & UTILS
         ══════════════════════════════════════ */
      _cleanHTMLForSave() {
        const clone = this.content.cloneNode(true);

        clone.querySelectorAll('.pe-col-resizer, .pe-row-resizer, .pe-resize-handle').forEach(node => node.remove());
        clone.querySelectorAll('.selected, .pe-table-selected, .pe-cell-selected').forEach(node => {
          node.classList.remove('selected', 'pe-table-selected', 'pe-cell-selected');
        });

        return clone.innerHTML;
      }

      _syncTextarea() {
        if (this.textarea) this.textarea.value = this._cleanHTMLForSave();
      }
  
      _showToast(msg, duration = 2500) {
        const existing = $('.pe-toast');
        if (existing) existing.remove();
        const toast = el('div', { class: 'pe-toast', html: msg, style: `position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#1e1e2e;color:#fff;padding:10px 20px;border-radius:8px;font-size:13px;font-family:${getComputedStyle(document.documentElement).getPropertyValue('--pe-font')};z-index:99999;box-shadow:0 4px 16px rgba(0,0,0,.3);animation:pe-fade-in .15s ease` });
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), duration);
      }
  
      /* Public API */
      getHTML() { return this.content.innerHTML; }
      setHTML(html) { this.content.innerHTML = html; this._syncTextarea(); this._saveHistory(); }
      getText() { return this.content.innerText; }
      focus() { this.content.focus(); }
      destroy() {
        this.textarea.style.display = '';
        this.wrapper.remove();
      }
    }
  
    /* ══════════════════════════════════════
       PUBLIC INIT FUNCTION
       ══════════════════════════════════════ */
    global.initEditor = function (selector, options = {}) {
      const targets = typeof selector === 'string'
        ? document.querySelectorAll(selector)
        : [selector];
      const instances = [];
      targets.forEach(el => {
        if (el.tagName === 'TEXTAREA' && !el._peInstance) {
          const inst = new ProEditor(el, options);
          el._peInstance = inst;
          instances.push(inst);
        }
      });

      if (!global._peFormSyncBound) {
        global._peFormSyncBound = true;
        document.addEventListener('submit', event => {
          const form = event.target;
          if (!(form instanceof HTMLFormElement)) return;
          form.querySelectorAll('textarea').forEach(el => {
            if (el._peInstance) {
              el._peInstance._syncTextarea();
            }
          });
        }, true);
      }

      return instances.length === 1 ? instances[0] : instances;
    };
  
    // Also expose the class for advanced use
    global.ProEditor = ProEditor;
  
  })(window);