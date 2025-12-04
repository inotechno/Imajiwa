<div>
    <input type="file" id="board-upload" class="d-none" wire:model="upload"
        @change="$dispatch('file-selected', { type: $el.dataset.type })">

    <div x-data="boardApp(@js($cards), @js($connectors), '{{ $projectId }}')" x-init="init()">
        <div class="d-flex gap-2 mb-3">
            <button
                :class="{ 'btn-primary': currentTool==='select', 'btn-outline-primary': currentTool!=='select', 'active': currentTool==='select' }"
                class="btn btn-sm" @click="setTool('select')">🖱️ Select</button>
            <button
                :class="{ 'btn-warning': currentTool==='note', 'btn-outline-warning': currentTool!=='note', 'active': currentTool==='note' }"
                class="btn btn-sm" @click="addCard('note')">🗒️ Note</button>
            <button
                :class="{ 'btn-info': currentTool==='image', 'btn-outline-info': currentTool!=='image', 'active': currentTool==='image' }"
                class="btn btn-sm" @click="uploadImage()">🖼️ Image</button>
            <button
                :class="{ 'btn-secondary': currentTool==='file', 'btn-outline-secondary': currentTool!=='file', 'active': currentTool==='file' }"
                class="btn btn-sm" @click="uploadFile()">📎 File</button>
            <button
                :class="{ 'btn-outline-info': currentTool!=='connect', 'btn-info': currentTool==='connect', 'active': currentTool==='connect' }"
                class="btn btn-sm" @click="setTool('connect')">🔗 Connect</button>
        </div>

        <div class="position-relative rounded board-canvas" style="height:80vh; overflow:auto;">
            <div class="board-inner position-relative" style="width:4000px; height:3000px;">
                <template x-for="card in cards" :key="card.id">
                    <div class="position-absolute board-card shadow rounded p-2" :id="'card-' + card.id"
                        :data-type="card.type" @click="focusCard(card.id, $event)"
                        :class="{
                            'selected': selectedCards.includes(card.id),
                            'bg-white': card.type === 'text' || card.type === 'file',
                            'bg-warning text-dark': card.type === 'note'
                        }"
                        :style="`
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        left:${card.x}px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        top:${card.y}px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        width:${card.w}px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        height:${card.h}px;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        z-index:${card.z_index};
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        transition: box-shadow 0.25s ease, transform 0.2s ease;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     `">

                        <template x-if="card.type === 'text'">
                            <div contenteditable="true" x-text="card.content" @input="updateContent(card, $event)">
                            </div>
                        </template>

                        <template x-if="card.type === 'note'">
                            <div contenteditable="true" class="p-2 rounded" x-text="card.content"
                                @input="updateContent(card, $event)"></div>
                        </template>

                        <template x-if="card.type === 'image'">
                            <img :src="card.content" class="img-fluid rounded"
                                style="max-height:100%; object-fit:cover;">
                        </template>

                        <template x-if="card.type === 'file'">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-paperclip"></i>
                                <a :href="card.content" target="_blank" class="text-primary">Open File</a>
                            </div>
                        </template>

                        <template x-if="card.type === 'youtube'">
                            <div class="board-yt-thumb" @click="card.opened = !card.opened" style="cursor:pointer">
                                <template x-if="!card.opened">
                                    <img :src="'https://img.youtube.com/vi/' + extractYoutubeId(card.content) + '/0.jpg'"
                                        style="max-width:100%;border-radius:5px" />
                                </template>
                                <template x-if="card.opened">
                                    <iframe :src="'https://www.youtube.com/embed/' + extractYoutubeId(card.content)"
                                        frameborder="0" allowfullscreen style="width:100%;height:180px"></iframe>
                                </template>
                                <div class="yt-url" x-text="card.content"
                                    style="font-size: 12px; color: #888;word-break:break-all"></div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
            <div class="zoom-control">
                <button class="btn btn-sm btn-outline-light me-1" @click="zoomOut()">-</button>
                <span class="zoom-label" x-text="Math.round(scale * 100) + '%'"></span>
                <button class="btn btn-sm btn-outline-light ms-1" @click="zoomIn()">+</button>
                <button class="btn btn-sm btn-outline-secondary ms-2" @click="resetZoom()">Reset</button>
            </div>

        </div>
    </div>

    {{-- Libs --}}
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hotkeys-js@3.9.4/dist/hotkeys.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leader-line@1.0.7/leader-line.min.js"></script>

    <script>
        function boardApp(cards, connectors, projectId) {
            return {
                scale: 1,
                originX: 0,
                originY: 0,
                innerEl: null,

                cards,
                connectors,
                selectedCards: [],
                clipboard: [],
                gridSize: 20,
                guides: {
                    v: null,
                    h: null
                },
                currentTool: 'select',
                connectingFrom: null,
                lines: [], // {fromId,toId,line}
                isResizingLocal: false,
                hotkeysBound: false,
                pasteBound: false,

                selectionBox: null,
                isSelecting: false,
                selectionStart: {
                    x: 0,
                    y: 0
                },


                history: [],
                historyIndex: -1,
                isRecordingHistory: true,

                init() {
                    this.clientId = Math.random().toString(36).substring(2, 9);
                    LeaderLine.positionByWindowScroll = false;
                    this.createGuideElements();
                    this.enableDrag();
                    this.listenRealtime();
                    this.setupZoomAndPan();
                    this.enableSelectionBox();
                    if (!this.hotkeysBound) {
                        this.bindHotkeys();
                        this.hotkeysBound = true;
                    }

                    // === Embed Link ala Millanote pada paste ===
                    const boardEl = document.querySelector('.board-canvas');
                    if (boardEl && !this.pasteBound) {
                        const pasteHandler = (e) => {
                            let pasted = (e.clipboardData || window.clipboardData).getData('text');
                            // Jika tidak ada teks, abaikan (biar ctrl+v internal berjalan)
                            if (!pasted) return;
                            let type = 'text';
                            let content = pasted;
                            let matched = false;
                            if (/^https?:\/\/(www.)?youtube.com|youtu.be\//.test(pasted)) {
                                type = 'youtube';
                                content = pasted;
                                matched = true;
                            } else if (/\.(jpg|jpeg|png|gif|svg)$/i.test(pasted)) {
                                type = 'image';
                                matched = true;
                            } else if (/^https?:\/\//.test(pasted)) {
                                type = 'link';
                                matched = true;
                            }
                            if (matched) {
                                // HANYA handle paste text link di sini; cegah bubbling/duplikasi
                                try {
                                    e.stopImmediatePropagation();
                                } catch (_) {}
                                e.stopPropagation();
                                e.preventDefault();
                                const centerX = Math.round((boardEl.scrollLeft + boardEl.clientWidth / 2) / this
                                    .gridSize) * this.gridSize;
                                const centerY = Math.round((boardEl.scrollTop + boardEl.clientHeight / 2) / this
                                    .gridSize) * this.gridSize;
                                const cardData = {
                                    type,
                                    content,
                                    x: centerX,
                                    y: centerY
                                };
                                Livewire.dispatch('createCardFromData', {
                                    data: cardData,
                                    clientId: this.clientId
                                });
                            }
                        };
                        boardEl.addEventListener('paste', pasteHandler, true); // capture to intercept lebih awal
                        this.pasteBound = true;
                    }

                    // gambar semua konektor awal
                    if (Array.isArray(this.connectors)) {
                        this.connectors.forEach(c => this.drawLine(c.from_card_id, c.to_card_id));
                    }

                    // reposisi garis saat resize/scroll canvas
                    window.addEventListener('resize', () => this.lines.forEach(l => l.line.position()));
                    document.querySelector('.board-canvas')
                        ?.addEventListener('scroll', () => this.lines.forEach(l => l.line.position()));

                    this.innerEl = document.querySelector('.board-inner');
                },


                pushHistory(action) {
                    if (!this.isRecordingHistory) return;
                    this.history = this.history.slice(0, this.historyIndex + 1);
                    this.history.push(action);
                    this.historyIndex++;
                },

                undo() {
                    if (this.historyIndex < 0) return;
                    const action = this.history[this.historyIndex];
                    this.isRecordingHistory = false;
                    this.applyActionReverse(action);
                    this.isRecordingHistory = true;
                    this.historyIndex--;
                },

                redo() {
                    if (this.historyIndex >= this.history.length - 1) return;
                    this.historyIndex++;
                    const action = this.history[this.historyIndex];
                    this.isRecordingHistory = false;
                    this.applyAction(action);
                    this.isRecordingHistory = true;
                },

                applyAction(action) {
                    const card = this.cards.find(c => c.id === action.id);
                    if (!card) return;
                    Object.assign(card, action.newState);
                    this.updateCardUI(card);
                },

                applyActionReverse(action) {
                    const card = this.cards.find(c => c.id === action.id);
                    if (!card) return;
                    Object.assign(card, action.oldState);
                    this.updateCardUI(card);
                },

                updateCardUI(card) {
                    const el = document.getElementById(`card-${card.id}`);
                    if (el) {
                        el.style.left = `${card.x}px`;
                        el.style.top = `${card.y}px`;
                        el.style.width = `${card.w}px`;
                        el.style.height = `${card.h}px`;
                    }
                },


                enableSelectionBox() {
                    const canvas = document.querySelector('.board-canvas');
                    const inner = document.querySelector('.board-inner');

                    canvas.addEventListener('mousedown', (e) => {
                        if (e.target.closest('.board-card')) return; // abaikan klik card
                        if (e.button !== 0) return; // hanya klik kiri
                        this.isSelecting = true;
                        const rect = canvas.getBoundingClientRect();
                        this.selectionStart = {
                            x: e.clientX - rect.left + canvas.scrollLeft,
                            y: e.clientY - rect.top + canvas.scrollTop
                        };
                        if (!this.selectionBox) {
                            this.selectionBox = document.createElement('div');
                            this.selectionBox.className = 'selection-box';
                            inner.appendChild(this.selectionBox);
                        }
                        Object.assign(this.selectionBox.style, {
                            left: this.selectionStart.x + 'px',
                            top: this.selectionStart.y + 'px',
                            width: '0px',
                            height: '0px',
                            display: 'block'
                        });
                    });

                    canvas.addEventListener('mousemove', (e) => {
                        if (!this.isSelecting) return;
                        const rect = canvas.getBoundingClientRect();
                        const x = e.clientX - rect.left + canvas.scrollLeft;
                        const y = e.clientY - rect.top + canvas.scrollTop;
                        const w = x - this.selectionStart.x;
                        const h = y - this.selectionStart.y;

                        Object.assign(this.selectionBox.style, {
                            left: (w > 0 ? this.selectionStart.x : x) + 'px',
                            top: (h > 0 ? this.selectionStart.y : y) + 'px',
                            width: Math.abs(w) + 'px',
                            height: Math.abs(h) + 'px'
                        });

                        const boxRect = this.selectionBox.getBoundingClientRect();
                        this.selectedCards = [];
                        this.cards.forEach(c => {
                            const el = document.getElementById(`card-${c.id}`);
                            if (!el) return;
                            const cardRect = el.getBoundingClientRect();
                            if (cardRect.right > boxRect.left && cardRect.left < boxRect.right && cardRect
                                .bottom > boxRect.top && cardRect.top < boxRect.bottom) {
                                this.selectedCards.push(c.id);
                            }
                        });
                    });

                    window.addEventListener('mouseup', () => {
                        if (this.isSelecting) {
                            this.isSelecting = false;
                            if (this.selectionBox) this.selectionBox.style.display = 'none';
                        }
                    });
                },

                // === Zoom & Pan ===
                setupZoomAndPan() {
                    const canvas = document.querySelector('.board-canvas');
                    const inner = document.querySelector('.board-inner');
                    if (!canvas || !inner) return;

                    let isPanning = false;
                    let startX = 0,
                        startY = 0;

                    // Zoom dengan Ctrl + Scroll
                    canvas.addEventListener('wheel', (e) => {
                        if (!e.ctrlKey) return;
                        e.preventDefault();
                        const delta = e.deltaY > 0 ? 0.9 : 1.1;
                        this.scale = Math.min(Math.max(this.scale * delta, 0.4), 2);
                        this.applyZoom();
                    });

                    // Pan dengan Alt + Drag
                    canvas.addEventListener('mousedown', (e) => {
                        if (!e.altKey) return;
                        isPanning = true;
                        startX = e.clientX - this.originX;
                        startY = e.clientY - this.originY;
                        canvas.classList.add('dragging');
                    });

                    canvas.addEventListener('mousemove', (e) => {
                        if (!isPanning) return;
                        this.originX = e.clientX - startX;
                        this.originY = e.clientY - startY;
                        this.applyZoom();
                    });

                    window.addEventListener('mouseup', () => {
                        isPanning = false;
                        canvas.classList.remove('dragging');
                    });
                },

                zoomIn() {
                    this.scale = Math.min(this.scale * 1.1, 2);
                    this.applyZoom();
                },
                zoomOut() {
                    this.scale = Math.max(this.scale * 0.9, 0.3);
                    this.applyZoom();
                },
                resetZoom() {
                    this.scale = 1;
                    this.originX = 0;
                    this.originY = 0;
                    this.applyZoom();
                },
                applyZoom() {
                    if (!this.innerEl) return;
                    this.innerEl.style.transition = 'transform 0.15s ease-out';
                    this.innerEl.style.transform =
                        `translate(${this.originX}px, ${this.originY}px) scale(${this.scale})`;
                    this.innerEl.style.transformOrigin = '0 0';
                    requestAnimationFrame(() => this.lines.forEach(l => l.line.position()));
                },




                smoothMove(cardId, newX, newY) {
                    const el = document.getElementById(`card-${cardId}`);
                    if (!el) return;

                    const currentLeft = parseFloat(el.style.left) || el.offsetLeft;
                    const currentTop = parseFloat(el.style.top) || el.offsetTop;

                    anime({
                        targets: el,
                        left: [currentLeft, newX],
                        top: [currentTop, newY],
                        duration: 300,
                        easing: 'easeOutCubic',
                        update: () => this.updateLinePositions(cardId),
                        complete: () => this.updateLinePositions(cardId)
                    });
                },

                setTool(tool) {
                    this.currentTool = tool;
                    this.connectingFrom = null;
                },

                // =========================
                // DRAG & RESIZE (tanpa transform)
                // =========================
                enableDrag() {
                    const self = this;

                    interact('.board-card').draggable({
                        inertia: true,
                        listeners: {
                            move(e) {
                                const target = e.target;
                                const id = parseInt(target.id.replace('card-', ''));

                                const curLeft = parseFloat(target.style.left) || target.offsetLeft;
                                const curTop = parseFloat(target.style.top) || target.offsetTop;

                                const newLeft = curLeft + e.dx;
                                const newTop = curTop + e.dy;

                                target.style.left = `${newLeft}px`;
                                target.style.top = `${newTop}px`;

                                self.updateLinePositions(id);
                                self.showAlignmentGuideByAbs(id, newLeft, newTop);
                            },
                            end(e) {
                                const el = e.target;
                                const id = el.id.replace('card-', '');
                                const newX = parseFloat(el.style.left) || el.offsetLeft;
                                const newY = parseFloat(el.style.top) || el.offsetTop;

                                const snapX = Math.round(newX / self.gridSize) * self.gridSize;
                                const snapY = Math.round(newY / self.gridSize) * self.gridSize;

                                const card = self.cards.find(c => c.id == id);
                                if (card) {
                                    card.x = snapX;
                                    card.y = snapY;
                                }

                                Livewire.dispatch('updateCardPosition', {
                                    id,
                                    x: snapX,
                                    y: snapY
                                });

                                el.style.left = snapX + 'px';
                                el.style.top = snapY + 'px';

                                self.updateLinePositions(id);
                                self.hideAlignmentGuide();
                            }
                        }
                    });

                    interact('.board-card').resizable({
                        edges: {
                            left: false,
                            right: true,
                            bottom: true,
                            top: false
                        },
                        inertia: true,
                        listeners: {
                            move(e) {
                                const target = e.target;
                                target.style.width = e.rect.width + 'px';
                                target.style.height = e.rect.height + 'px';
                            },
                            end(e) {
                                const el = e.target;
                                const id = el.id.replace('card-', '');
                                const w = parseFloat(el.style.width);
                                const h = parseFloat(el.style.height);
                                // update local model agar sync juga di tab yang resize
                                let card = self.cards.find(c => c.id == id);
                                if (card) {
                                    card.w = w;
                                    card.h = h;
                                }
                                Livewire.dispatch('updateCardSize', {
                                    id,
                                    w,
                                    h
                                });
                                self.updateLinePositions(id);
                                setTimeout(() => {
                                    self.isResizingLocal = false
                                }, 150);
                            }
                        },
                        modifiers: [
                            interact.modifiers.restrictSize({
                                min: {
                                    width: 120,
                                    height: 80
                                }
                            })
                        ]
                    });
                },

                uploadImage() {
                    const input = document.getElementById('board-upload');
                    input.accept = 'image/*';
                    input.dataset.type = 'image';
                    input.click();
                },

                uploadFile() {
                    const input = document.getElementById('board-upload');
                    input.accept = '*/*';
                    input.dataset.type = 'file';
                    input.click();
                },

                // =========================
                // ALIGNMENT GUIDES
                // =========================
                createGuideElements() {
                    const container = document.querySelector('.board-canvas');
                    if (!container) return;
                    const v = document.createElement('div');
                    const h = document.createElement('div');
                    v.classList.add('guide-line', 'vertical');
                    h.classList.add('guide-line', 'horizontal');
                    v.style.display = h.style.display = 'none';
                    container.appendChild(v);
                    container.appendChild(h);
                    this.guides = {
                        v,
                        h
                    };
                },

                showAlignmentGuideByAbs(id, absLeft, absTop) {
                    const current = this.cards.find(c => c.id == id);
                    if (!current) return;
                    let vShow = false,
                        hShow = false;

                    this.cards.forEach(c => {
                        if (c.id === current.id) return;
                        if (Math.abs(c.x - absLeft) < 5) {
                            this.guides.v.style.left = c.x + 'px';
                            vShow = true;
                        }
                        if (Math.abs(c.y - absTop) < 5) {
                            this.guides.h.style.top = c.y + 'px';
                            hShow = true;
                        }
                    });

                    this.guides.v.style.display = vShow ? 'block' : 'none';
                    this.guides.h.style.display = hShow ? 'block' : 'none';
                },

                hideAlignmentGuide() {
                    if (!this.guides.v || !this.guides.h) return;
                    this.guides.v.style.display = 'none';
                    this.guides.h.style.display = 'none';
                },

                // =========================
                // REALTIME
                // =========================
                listenRealtime() {
                    Echo.channel(`board.${projectId}`)
                        .listen('CardCreated', (e) => {
                            // PATCH - cek jika id sudah ada, skip!
                            if (!this.cards.find(c => c.id === e.card.id)) {
                                this.cards.push(e.card);
                                this.animateCard(e.card.id);
                            }
                        })
                        .listen('CardUpdated', (e) => {
                            const card = this.cards.find(c => c.id === e.card.id);
                            if (card) {
                                Object.assign(card, e.card);
                                // --- resize animation sync
                                const el = document.getElementById(`card-${card.id}`);
                                if (el) {
                                    this.smoothResize(card.id, card.w, card.h);
                                }
                                this.updateLinePositions(card.id);
                            }
                        })
                        .listen('.CardMoved', (e) => {
                            const moved = this.cards.find(c => c.id === e.card.id);
                            if (!moved) return;
                            moved.x = e.card.x;
                            moved.y = e.card.y;
                            this.smoothMove(moved.id, moved.x, moved.y);
                            setTimeout(() => this.updateLinePositions(moved.id), 350);
                        })
                        .listen('.CardDeleted', (e) => {
                            // hapus garis yang terkait
                            this.lines = this.lines.filter(l => {
                                const hit = (l.fromId == e.id || l.toId == e.id);
                                if (hit) l.line.remove();
                                return !hit;
                            });
                            this.cards = this.cards.filter(c => c.id !== e.id);
                            const el = document.getElementById(`card-${e.id}`);
                            if (el) anime({
                                targets: el,
                                opacity: [1, 0],
                                duration: 300,
                                easing: 'easeOutQuad',
                                complete: () => el.remove()
                            });
                        })
                        .listen('.ConnectorCreated', (e) => {
                            if (!e.connector) return;
                            const exists = this.connectors.find(c =>
                                c.from_card_id === e.connector.from_card_id &&
                                c.to_card_id === e.connector.to_card_id
                            );
                            if (!exists) {
                                this.connectors.push(e.connector);
                                this.drawLine(e.connector.from_card_id, e.connector.to_card_id);
                            }
                        });

                    Livewire.on('cardDeletedLocal', (event) => {
                        const id = Array.isArray(event) ? event[0] : event;
                        // lokal: hapus garis yang terkait
                        this.lines = this.lines.filter(l => {
                            const hit = (l.fromId == id || l.toId == id);
                            if (hit) l.line.remove();
                            return !hit;
                        });
                        this.cards = this.cards.filter(c => c.id !== id);
                    });
                    Livewire.on('cardCreatedLocal', (event) => {
                        const card = event[0];
                        // PATCH - cek jika id sudah ada, skip!
                        if (!this.cards.find(c => c.id === card.id)) {
                            this.cards.push(card);
                            this.animateCard(card.id);
                        }
                    });
                    Livewire.on('connectorCreatedLocal', e => {
                        const connector = e[0];
                        this.connectors.push({
                            id: connector.id ?? null,
                            from_card_id: connector.from_card_id,
                            to_card_id: connector.to_card_id,
                            color: connector.color ?? '#A0AEC0',
                            thickness: connector.thickness ?? 2,
                            style: connector.style ?? 'line',
                        });
                        this.drawLine(connector.from_card_id, connector.to_card_id);
                    });
                },
                // --- tambahkan fungsi berikut setelah smoothMove:
                smoothResize(cardId, newW, newH) {
                    // cegah animasi resize remote jika sedang resizing lokal
                    if (this.isResizingLocal) return;
                    const el = document.getElementById(`card-${cardId}`);
                    if (!el) return;
                    const currentW = parseFloat(el.style.width) || el.offsetWidth;
                    const currentH = parseFloat(el.style.height) || el.offsetHeight;
                    anime({
                        targets: el,
                        width: [currentW, newW],
                        height: [currentH, newH],
                        duration: 300,
                        easing: 'easeOutCubic',
                        update: () => this.updateLinePositions(cardId),
                        complete: () => this.updateLinePositions(cardId)
                    });
                },

                // =========================
                // HOTKEYS
                // =========================
                bindHotkeys() {
                    if (this.hotkeysBound) return; // guard rebinding
                    const self = this;

                    hotkeys('ctrl+d,command+d', e => {
                        e.preventDefault();
                        self.duplicateSelectedCards();
                    });
                    hotkeys('ctrl+a,command+a', e => {
                        e.preventDefault();
                        self.selectedCards = self.cards.map(c => c.id);
                    });
                    hotkeys('esc', () => self.selectedCards = []);
                    hotkeys('del,backspace', e => {
                        e.preventDefault();
                        self.deleteSelectedCards();
                    });
                    hotkeys('ctrl+c,command+c', e => {
                        e.preventDefault();
                        self.copySelectedCards();
                    });
                    hotkeys('ctrl+v,command+v', e => {
                        e.preventDefault();
                        self.pasteCards();
                    });
                    hotkeys('ctrl+=,command+=', e => {
                        e.preventDefault();
                        this.zoomIn();
                    });
                    hotkeys('ctrl+-,command+-', e => {
                        e.preventDefault();
                        this.zoomOut();
                    });
                    hotkeys('ctrl+0,command+0', e => {
                        e.preventDefault();
                        this.resetZoom();
                    });
                    hotkeys('shift+0', e => {
                        e.preventDefault();
                        const canvas = document.querySelector('.board-canvas');
                        const inner = this.innerEl;
                        if (!canvas || !inner) return;
                        const scaleX = canvas.clientWidth / inner.scrollWidth;
                        const scaleY = canvas.clientHeight / inner.scrollHeight;
                        this.scale = Math.min(scaleX, scaleY);
                        this.originX = 0;
                        this.originY = 0;
                        this.applyZoom();
                    });

                },

                duplicateSelectedCards() {
                    if (!this.selectedCards.length || this.isDuplicating) return;
                    this.isDuplicating = true;
                    let offsetGap = 40;
                    const defaultX = 120,
                        defaultY = 120;
                    let cardsToCopy = this.cards.filter(c => this.selectedCards.includes(c.id));
                    cardsToCopy.forEach(orig => {
                        const copy = {
                            ...orig
                        };
                        delete copy.id;
                        // PATCH: jangan fallback ke 'text':
                        if (orig.type) copy.type = orig.type;
                        if (!copy.content && orig.content) copy.content = orig.content;
                        const ox = Number(orig.x),
                            oy = Number(orig.y);
                        copy.x = (isNaN(ox) ? defaultX : ox) + offsetGap;
                        copy.y = (isNaN(oy) ? defaultY : oy) + offsetGap;
                        Livewire.dispatch('createCardFromData', {
                            data: copy,
                            clientId: this.clientId
                        });
                    });
                    setTimeout(() => (this.isDuplicating = false), 300);
                },

                toggleCardSelection(id, event) {
                    if (event?.ctrlKey || event?.metaKey) {
                        const idx = this.selectedCards.indexOf(id);
                        if (idx === -1) this.selectedCards.push(id);
                        else this.selectedCards.splice(idx, 1);
                    } else {
                        this.selectedCards = [id];
                    }
                },

                focusCard(id, event) {
                    const el = document.getElementById(`card-${id}`);
                    const type = el?.dataset?.type || "card";

                    if (this.currentTool === 'connect') {
                        if (!this.connectingFrom) {
                            this.connectingFrom = id;
                        } else {
                            const from = this.connectingFrom;
                            const to = id;
                            this.connectingFrom = null;
                            this.setTool('select');
                            Livewire.dispatch('createConnector', {
                                from,
                                to
                            });
                            this.drawLine(from, to);
                        }
                        return;
                    }

                    this.selectedCards = [id];

                    if (el) {
                        anime({
                            targets: el,
                            scale: [1.0, 1.05, 1.0],
                            duration: 250,
                            easing: 'easeOutQuad'
                        });
                    }

                    Livewire.dispatch('bringToFront', {
                        id,
                        type
                    });
                },

                deleteSelectedCards() {
                    if (!this.selectedCards.length) return;
                    const ids = [...this.selectedCards];

                    // hapus garis terkait secara lokal
                    ids.forEach(id => {
                        this.lines = this.lines.filter(l => {
                            const hit = (l.fromId == id || l.toId == id);
                            if (hit) l.line.remove();
                            return !hit;
                        });
                    });

                    this.cards = this.cards.filter(c => !ids.includes(c.id));
                    this.selectedCards = [];

                    ids.forEach(id => {
                        Livewire.dispatch('deleteCard', {
                            id
                        });
                        const el = document.getElementById(`card-${id}`);
                        if (el) anime({
                            targets: el,
                            opacity: [1, 0],
                            duration: 300,
                            easing: 'easeInQuad',
                            complete: () => el.remove()
                        });
                    });
                },

                copySelectedCards() {
                    // Log semua state di proses copy
                    console.log('cards (full):', this.cards);
                    console.log('selectedCards:', this.selectedCards);
                    this.clipboard = this.cards
                        .filter(c => this.selectedCards.includes(c.id))
                        .map(c => ({
                            ...c
                        }));
                    console.log('clipboard (after copy):', this.clipboard);
                    // Untuk kroscek setiap isi card di clipboard hasil copy
                    this.clipboard.forEach((c, idx) => console.log('copied clip', idx, 'type:', c.type, 'content:', c
                        .content));
                },

                pasteCards() {
                    if (!this.clipboard.length) return;
                    let offsetGap = 40;
                    const defaultX = 120,
                        defaultY = 120;
                    console.log('== PASTE DEBUG == clipboard length:', this.clipboard.length);
                    this.clipboard.forEach((orig, idx) => {
                        const copy = {
                            ...orig
                        };
                        delete copy.id;
                        if (orig.type) copy.type = orig.type;
                        if (!copy.content && orig.content) copy.content = orig.content;
                        const ox = Number(orig.x),
                            oy = Number(orig.y);
                        copy.x = (isNaN(ox) ? defaultX : ox) + offsetGap;
                        copy.y = (isNaN(oy) ? defaultY : oy) + offsetGap;
                        console.log('Paste dispatch', idx, ':', copy); // LOG DETAIL DISPATCH
                        Livewire.dispatch('createCardFromData', {
                            data: copy,
                            clientId: this.clientId
                        });
                    });
                },

                updateContent(card, e) {
                    card.content = e.target.innerText;
                    Livewire.dispatch('updateCardContent', {
                        id: card.id,
                        content: card.content
                    });
                },

                addCard(type = 'text') {
                    Livewire.dispatch('createCardOfType', {
                        type
                    });
                },

                animateCard(id) {
                    const el = document.getElementById(`card-${id}`);
                    if (el) {
                        anime({
                            targets: el,
                            scale: [0.8, 1],
                            opacity: [0, 1],
                            duration: 350,
                            easing: 'easeOutQuad'
                        });
                    }
                },

                drawLine(fromId, toId, attempt = 0) {
                    if (fromId === toId) return;
                    if (this.lines.some(l => l.fromId === fromId && l.toId === toId)) return;

                    const fromEl = document.getElementById(`card-${fromId}`);
                    const toEl = document.getElementById(`card-${toId}`);

                    if (!fromEl || !toEl) {
                        if (attempt < 10) setTimeout(() => this.drawLine(fromId, toId, attempt + 1), 200);
                        return;
                    }

                    const line = new LeaderLine(fromEl, toEl, {
                        color: '#A0AEC0',
                        size: 2,
                        path: 'straight',
                        startPlug: 'disc',
                        endPlug: 'arrow1',
                        // tidak perlu positionByTransform karena kita tidak pakai transform saat drag
                    });

                    this.lines.push({
                        fromId,
                        toId,
                        line
                    });
                },

                updateLinePositions(cardId) {
                    requestAnimationFrame(() => {
                        this.lines.forEach(l => {
                            if (l.fromId == cardId || l.toId == cardId) l.line.position();
                        });
                    });
                },
            }
        }
    </script>

    <style>
        .selection-box {
            position: absolute;
            border: 1px dashed rgba(0, 123, 255, 0.8);
            background: rgba(0, 123, 255, 0.2);
            pointer-events: none;
            z-index: 999;
        }

        .zoom-control {
            position: fixed !important;
            /* 🧩 biar tidak ikut scroll */
            bottom: 15px;
            right: 15px;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 13px;
            backdrop-filter: blur(4px);
        }

        .zoom-control button {
            color: #fff !important;
            border-color: rgba(255, 255, 255, 0.4) !important;
        }

        .zoom-control button:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .board-card {
            position: absolute;
            cursor: grab;
            transition: box-shadow 0.25s ease, transform 0.2s ease;
        }

        .board-inner {
            transform-origin: 0 0;
            transition: transform 0.2s ease-out;
        }

        .board-card.selected {
            box-shadow: 0 0 12px rgba(0, 123, 255, 0.85);
        }

        .board-card::after {
            content: '';
            position: absolute;
            right: 4px;
            bottom: 4px;
            width: 10px;
            height: 10px;
            border-right: 2px solid #007bff;
            border-bottom: 2px solid #007bff;
            opacity: 0.4;
        }

        .guide-line {
            position: absolute;
            background: rgba(0, 123, 255, 0.4);
            z-index: 9999;
            pointer-events: none;
        }

        .guide-line.vertical {
            width: 1px;
            height: 100%;
        }

        .guide-line.horizontal {
            height: 1px;
            width: 100%;
        }

        .board-card.note {
            background-color: #ffe680 !important;
            border: 1px solid #f0d94a;
        }

        .board-card img {
            max-width: 100%;
            border-radius: 10px;
        }

        .board-card[data-type="note"] {
            background: #fff9a3 !important;
            border: 1px solid #f1d94c;
            box-shadow: 2px 4px 8px rgba(0, 0, 0, 0.12);
            font-family: "Comic Sans MS", cursive, sans-serif;
            color: #333;
            padding: 12px;
            line-height: 1.3;
            font-size: 0.95rem;
            transform: rotate(-1.5deg);
        }

        .board-card[data-type="note"]::before {
            content: "";
            position: absolute;
            right: 0;
            top: 0;
            border-top: 20px solid #f8e36b;
            border-left: 20px solid transparent;
            width: 0;
            height: 0;
        }

        .board-card[data-type="note"]:hover {
            transform: rotate(0deg) scale(1.02);
            box-shadow: 4px 6px 12px rgba(0, 0, 0, 0.18);
        }

        .board-canvas {
            position: relative;
            overflow: auto;
            height: 80vh;
            border-radius: 0.75rem;
            background-color: #1d1f22 !important;

            /* Pola grid titik seperti Milanote */
            background-image: radial-gradient(circle, rgba(255, 255, 255, 0.08) 1px, transparent 1px);
            background-size: 28px 28px;
            background-position: center;
            transition: background-color 0.3s ease, background-size 0.3s ease;
        }


        /* Efek saat drag/zoom */
        .board-canvas.dragging {
            cursor: grabbing !important;
        }

        .board-canvas:not(.dragging) {
            cursor: grab;
        }
    </style>
</div>
