<div>
    <!-- tempat tldraw -->
    <div id="tldraw-root" style="width:100%; height:80vh; border:1px solid #e5e7eb;"></div>

    <!-- hidden Livewire file input untuk upload (jika perlu) -->
    <input id="board-upload" type="file" class="d-none" />
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/tldraw@1.29.2/dist/tldraw.css">
    @endpush

    @push('js')
        <script src="https://unpkg.com/tldraw@1.29.2/dist/tldraw.js"></script>



        <script>
            document.addEventListener('DOMContentLoaded', () => {

                const container = document.getElementById('tldraw-root');

                const initialState = @json($initialState ?: null);
                const employeeId = {{ auth()->id() ?? 'null' }};
                const boardId = {{ $boardId }};

                // ============================
                // CREATE TLDraw v2 Editor
                // ============================
                const editor = new Tldraw.TLEditor({
                    element: container,
                });

                // Load snapshot from DB
                if (initialState) {
                    editor.store.loadSnapshot(initialState);
                }

                // Debounce save
                const debounce = (fn, delay) => {
                    let t;
                    return (...args) => {
                        clearTimeout(t);
                        t = setTimeout(() => fn(...args), delay);
                    };
                };

                const saveToServer = debounce(() => {
                    const snapshot = editor.store.getSnapshot();

                    Livewire.emit("saveBoardState", {
                        state: snapshot,
                        actorId: employeeId,
                    });
                }, 1000);

                // Listen for any change
                editor.store.onAfterChange(() => {
                    saveToServer();
                });

                // Listen broadcasting Echo
                Echo.private(`board.${boardId}`)
                    .listen("BoardStateUpdated", (e) => {
                        if (e.actorId == employeeId) return;

                        if (e.state) {
                            editor.store.loadSnapshot(e.state);
                        }
                    });
            });
        </script>
    @endpush
</div>
