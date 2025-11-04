<div>
    @vite('resources/js/whiteboard.jsx')

    <div id="whiteboard-container" wire:ignore data-props='@json(['boardId' => $board->id, 'initialSnapshot' => $snapshot, 'saveSnapshotUrl' => $this->getId()])'></div>
</div>
