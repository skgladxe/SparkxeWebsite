{{-- ProEditor global modals – include once per page --}}
<div id="pe-link-modal" class="pe-modal-overlay" style="display: none">
    <div class="pe-modal">
        <div class="pe-modal-header">
            <span>Insert / Edit Link</span>
            <button type="button" class="pe-modal-close" data-modal="pe-link-modal">✕</button>
        </div>
        <div class="pe-modal-body">
            <label>URL</label>
            <input type="url" id="pe-link-url" placeholder="https://example.com">
            <label>Display Text</label>
            <input type="text" id="pe-link-text" placeholder="Link text">
            <label class="pe-checkbox-label">
                <input type="checkbox" id="pe-link-blank"> Open in new tab
            </label>
        </div>
        <div class="pe-modal-footer">
            <button type="button" class="pe-btn-secondary" data-modal="pe-link-modal">Cancel</button>
            <button type="button" class="pe-btn-primary" id="pe-link-insert">Insert Link</button>
        </div>
    </div>
</div>

<div id="pe-image-modal" class="pe-modal-overlay" style="display: none">
    <div class="pe-modal pe-modal-wide">
        <div class="pe-modal-header">
            <span>Insert Image</span>
            <button type="button" class="pe-modal-close" data-modal="pe-image-modal">✕</button>
        </div>
        <div class="pe-modal-body">
            <div class="pe-tabs">
                <button type="button" class="pe-tab active" data-tab="upload">Upload</button>
                <button type="button" class="pe-tab" data-tab="url">URL</button>
            </div>
            <div class="pe-tab-panel active" data-panel="upload">
                <div id="pe-drop-zone" class="pe-drop-zone">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="17 8 12 3 7 8" />
                        <line x1="12" y1="3" x2="12" y2="15" />
                    </svg>
                    <p>Drag &amp; drop or <label for="pe-file-input" class="pe-link">browse files</label></p>
                    <input type="file" id="pe-file-input" accept="image/*" style="display: none">
                </div>
                <div id="pe-img-preview" style="display: none; text-align: center; margin-top: 10px">
                    <img id="pe-img-preview-img" style="max-width: 100%; max-height: 180px; border-radius: 4px" alt="">
                </div>
            </div>
            <div class="pe-tab-panel" data-panel="url">
                <label>Image URL</label>
                <input type="url" id="pe-image-url" placeholder="https://example.com/image.jpg">
            </div>
            <div class="pe-form-row">
                <div>
                    <label>Alt Text</label>
                    <input type="text" id="pe-image-alt" placeholder="Describe the image">
                </div>
                <div>
                    <label>Alignment</label>
                    <select id="pe-image-align">
                        <option value="">None</option>
                        <option value="left">Left</option>
                        <option value="center">Center</option>
                        <option value="right">Right</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="pe-modal-footer">
            <button type="button" class="pe-btn-secondary" data-modal="pe-image-modal">Cancel</button>
            <button type="button" class="pe-btn-primary" id="pe-image-insert">Insert Image</button>
        </div>
    </div>
</div>

<div id="pe-video-modal" class="pe-modal-overlay" style="display: none">
    <div class="pe-modal">
        <div class="pe-modal-header">
            <span>Embed Video</span>
            <button type="button" class="pe-modal-close" data-modal="pe-video-modal">✕</button>
        </div>
        <div class="pe-modal-body">
            <label>Video URL (YouTube, Vimeo, or MP4)</label>
            <input type="url" id="pe-video-url" placeholder="https://www.youtube.com/watch?v=...">
            <div class="pe-form-row">
                <div>
                    <label>Width</label>
                    <input type="text" id="pe-video-width" value="560">
                </div>
                <div>
                    <label>Height</label>
                    <input type="text" id="pe-video-height" value="315">
                </div>
            </div>
            <label class="pe-checkbox-label">
                <input type="checkbox" id="pe-video-controls" checked> Show Controls
            </label>
        </div>
        <div class="pe-modal-footer">
            <button type="button" class="pe-btn-secondary" data-modal="pe-video-modal">Cancel</button>
            <button type="button" class="pe-btn-primary" id="pe-video-insert">Embed Video</button>
        </div>
    </div>
</div>

<div id="pe-table-modal" class="pe-modal-overlay" style="display: none">
    <div class="pe-modal">
        <div class="pe-modal-header">
            <span>Insert Table</span>
            <button type="button" class="pe-modal-close" data-modal="pe-table-modal">✕</button>
        </div>
        <div class="pe-modal-body">
            <p style="color: var(--pe-muted); font-size: 13px; margin-bottom: 12px">Hover over the grid to select table size</p>
            <div id="pe-table-grid-container">
                <div id="pe-table-grid"></div>
                <div id="pe-table-grid-label">0 × 0</div>
            </div>
            <div class="pe-form-row" style="margin-top: 14px">
                <div>
                    <label>Rows</label>
                    <input type="number" id="pe-table-rows" value="3" min="1" max="50">
                </div>
                <div>
                    <label>Columns</label>
                    <input type="number" id="pe-table-cols" value="3" min="1" max="20">
                </div>
            </div>
            <label class="pe-checkbox-label">
                <input type="checkbox" id="pe-table-header" checked> Include header row
            </label>
        </div>
        <div class="pe-modal-footer">
            <button type="button" class="pe-btn-secondary" data-modal="pe-table-modal">Cancel</button>
            <button type="button" class="pe-btn-primary" id="pe-table-insert">Insert Table</button>
        </div>
    </div>
</div>

<div id="pe-emoji-modal" class="pe-modal-overlay" style="display: none">
    <div class="pe-modal pe-modal-emoji">
        <div class="pe-modal-header">
            <span>Emoji Picker</span>
            <button type="button" class="pe-modal-close" data-modal="pe-emoji-modal">✕</button>
        </div>
        <div class="pe-modal-body">
            <input type="text" id="pe-emoji-search" placeholder="Search emoji…" style="margin-bottom: 10px">
            <div id="pe-emoji-categories"></div>
            <div id="pe-emoji-grid"></div>
        </div>
    </div>
</div>

<div id="pe-source-modal" class="pe-modal-overlay" style="display: none">
    <div class="pe-modal pe-modal-source">
        <div class="pe-modal-header">
            <span>HTML Source Code</span>
            <button type="button" class="pe-modal-close" data-modal="pe-source-modal">✕</button>
        </div>
        <div class="pe-modal-body">
            <textarea id="pe-source-textarea"></textarea>
        </div>
        <div class="pe-modal-footer">
            <button type="button" class="pe-btn-secondary" data-modal="pe-source-modal">Cancel</button>
            <button type="button" class="pe-btn-primary" id="pe-source-apply">Apply Changes</button>
        </div>
    </div>
</div>

<div id="pe-color-popup" class="pe-color-popup" style="display: none">
    <div class="pe-color-swatches" id="pe-color-swatches"></div>
    <div class="pe-color-custom">
        <label>Custom</label>
        <input type="color" id="pe-color-custom-input">
        <button type="button" class="pe-btn-primary pe-btn-sm" id="pe-color-apply">Apply</button>
    </div>
</div>

<div id="pe-context-menu" class="pe-context-menu" style="display: none"></div>
