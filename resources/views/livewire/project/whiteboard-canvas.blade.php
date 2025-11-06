<div>
    @vite('resources/js/whiteboard.jsx')

    <div id="whiteboard-container" wire:ignore x-data x-init="$nextTick(() => {
        const props = {
            boardId: {{ $board->id }},
            initialSnapshot: @js($snapshot),
            saveSnapshotUrl: @this.__instance.id, // ✅ ID unik Livewire
        };
        console.log('🧩 Livewire ID:', @this.__instance.id);
        document.getElementById('whiteboard-container').dataset.props = JSON.stringify(props);
    })"></div>
</div>
