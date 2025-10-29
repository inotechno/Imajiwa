<div>
    <input type="file" id="board-upload" class="d-none" wire:model="upload"
        @change="$dispatch('file-selected', { type: $el.dataset.type })">

    <div x-data="boardApp(@js($cards), @js($connectors), '{{ $projectId }}')" x-init="init()">
        <div class="d-flex gap-2 mb-3">
            <button class="btn btn-primary btn-sm" @click="addCard('text')">📝 Text</button>
            <button class="btn btn-warning btn-sm" @click="addCard('note')">🗒️ Note</button>
            <button class="btn btn-info btn-sm" @click="uploadImage()">🖼️ Image</button>
            <button class="btn btn-secondary btn-sm" @click="uploadFile()">📎 File</button>
            <button class="btn btn-outline-info btn-sm" @click="setTool('connect')">🔗 Connect</button>
        </div>

        <div class="position-relative bg-dark rounded board-canvas" style="height:80vh; overflow:auto;">
            <template x-for="card in cards" :key="card.id">
                <div class="position-absolute board-card shadow rounded p-2" :id="'card-' + card.id"
                    :data-type="card.type" @click="focusCard(card.id, $event)" :class="{
                        'selected': selectedCards.includes(card.id),
                        'bg-white': card.type === 'text' || card.type === 'file',
                        'bg-warning text-dark': card.type === 'note'
                     }" :style="`
                        left:${card.x}px;
                        top:${card.y}px;
                        width:${card.w}px;
                        height:${card.h}px;
                        z-index:${card.z_index};
                        transition: box-shadow 0.25s ease, transform 0.2s ease;
                     `">

                    <template x-if="card.type === 'text'">
                        <div contenteditable="true" x-text="card.content" @input="updateContent(card, $event)"></div>
                    </template>

                    <template x-if="card.type === 'note'">
                        <div contenteditable="true" class="p-2 rounded" x-text="card.content"
                            @input="updateContent(card, $event)"></div>
                    </template>

                    <template x-if="card.type === 'image'">
                        <img :src="card.content" class="img-fluid rounded" style="max-height:100%; object-fit:cover;">
                    </template>

                    <template x-if="card.type === 'file'">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-paperclip"></i>
                            <a :href="card.content" target="_blank" class="text-primary">Open File</a>
                        </div>
                    </template>
                </div>
            </template>
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
                cards,
                connectors,
                selectedCards: [],
                clipboard: [],
                gridSize: 20,
                guides: { v: null, h: null },
                currentTool: 'select',
                connectingFrom: null,
                lines: [], // {fromId,toId,line}

                init() {
                    this.clientId = Math.random().toString(36).substring(2, 9);
                     LeaderLine.positionByWindowScroll = false;
                    this.createGuideElements();
                    this.enableDrag();
                    this.listenRealtime();
                    this.bindHotkeys();

                    // gambar semua konektor awal
                    if (Array.isArray(this.connectors)) {
                        this.connectors.forEach(c => this.drawLine(c.from_card_id, c.to_card_id));
                    }

                    // reposisi garis saat resize/scroll canvas
                    window.addEventListener('resize', () => this.lines.forEach(l => l.line.position()));
                    document.querySelector('.board-canvas')
                        ?.addEventListener('scroll', () => this.lines.forEach(l => l.line.position()));
                },

                smoothMove(cardId, newX, newY) {
                    const el = document.getElementById(`card-${cardId}`);
                    if (!el) return;

                    const currentLeft = parseFloat(el.style.left) || el.offsetLeft;
                    const currentTop  = parseFloat(el.style.top)  || el.offsetTop;

                    anime({
                        targets: el,
                        left: [currentLeft, newX],
                        top:  [currentTop,  newY],
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
                                const curTop  = parseFloat(target.style.top)  || target.offsetTop;

                                const newLeft = curLeft + e.dx;
                                const newTop  = curTop  + e.dy;

                                target.style.left = `${newLeft}px`;
                                target.style.top  = `${newTop}px`;

                                self.updateLinePositions(id);
                                self.showAlignmentGuideByAbs(id, newLeft, newTop);
                            },
                            end(e) {
                                const el = e.target;
                                const id = el.id.replace('card-', '');
                                const newX = parseFloat(el.style.left) || el.offsetLeft;
                                const newY = parseFloat(el.style.top)  || el.offsetTop;

                                const snapX = Math.round(newX / self.gridSize) * self.gridSize;
                                const snapY = Math.round(newY / self.gridSize) * self.gridSize;

                                const card = self.cards.find(c => c.id == id);
                                if (card) { card.x = snapX; card.y = snapY; }

                                Livewire.dispatch('updateCardPosition', { id, x: snapX, y: snapY });

                                el.style.left = snapX + 'px';
                                el.style.top  = snapY + 'px';

                                self.updateLinePositions(id);
                                self.hideAlignmentGuide();
                            }
                        }
                    });

                    interact('.board-card').resizable({
                        edges: { left: false, right: true, bottom: true, top: false },
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
                                Livewire.dispatch('updateCardSize', { id, w, h });
                                // reposisi garis (walau tidak wajib, agar anchor lebih tepat)
                                this.updateLinePositions(id);
                            }
                        },
                        modifiers: [
                            interact.modifiers.restrictSize({
                                min: { width: 120, height: 80 }
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
                    this.guides = { v, h };
                },

                showAlignmentGuideByAbs(id, absLeft, absTop) {
                    const current = this.cards.find(c => c.id == id);
                    if (!current) return;
                    let vShow = false, hShow = false;

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
                            if (!this.cards.find(c => c.id === e.card.id)) {
                                this.cards.push(e.card);
                                this.animateCard(e.card.id);
                            }
                        })
                        .listen('CardUpdated', (e) => {
                            const card = this.cards.find(c => c.id === e.card.id);
                            if (card) Object.assign(card, e.card);
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

                            // hapus kartu
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
                        if (!this.cards.find(c => c.id === card.id)) {
                            this.cards.push(card);
                            this.animateCard(card.id);
                        }
                    });

                    Livewire.on('connectorCreatedLocal', e => {
                        const connector = e[0];
                        // simpan di state lokal juga supaya konsisten
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

                // =========================
                // HOTKEYS
                // =========================
                bindHotkeys() {
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
                },

                duplicateSelectedCards() {
                    if (!this.selectedCards.length || this.isDuplicating) return;
                    this.isDuplicating = true;

                    this.selectedCards.forEach(async (id) => {
                        const orig = this.cards.find(c => c.id == id);
                        if (!orig) return;

                        const copy = { ...orig, id: null, x: orig.x + 40, y: orig.y + 40 };
                        const response = await Livewire.dispatch('createCardFromData', { data: copy, clientId: this.clientId });

                        if (response?.serverMemo?.data) {
                            const newCard = response.serverMemo.data;
                            this.cards.push(newCard);
                            this.animateCard(newCard.id);
                        }
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
                            Livewire.dispatch('createConnector', { from, to });
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

                    Livewire.dispatch('bringToFront', { id, type });
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
                        Livewire.dispatch('deleteCard', { id });
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
                    this.clipboard = this.cards
                        .filter(c => this.selectedCards.includes(c.id))
                        .map(c => ({ ...c }));
                },

                pasteCards() {
                    if (!this.clipboard.length) return;
                    this.clipboard.forEach(orig => {
                        const copy = { ...orig };
                        delete copy.id;
                        copy.x += 30; copy.y += 30;
                        Livewire.dispatch('createCardFromData', { data: copy, clientId: this.clientId });
                    });
                },

                updateContent(card, e) {
                    card.content = e.target.innerText;
                    Livewire.dispatch('updateCardContent', { id: card.id, content: card.content });
                },

                addCard(type = 'text') {
                    Livewire.dispatch('createCardOfType', { type });
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
                    const toEl   = document.getElementById(`card-${toId}`);

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

                    this.lines.push({ fromId, toId, line });
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
        .board-card {
            position: absolute;
            cursor: grab;
            transition: box-shadow 0.25s ease, transform 0.2s ease;
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
        }
    </style>
</div>