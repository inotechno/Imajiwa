<div wire:ignore>
    <div 
        id="tldraw-root" 
        style="height: 80vh; width: 100%; position: relative;"
        data-props="{{ json_encode([
            'projectId' => $projectId,
            'initialSnapshot' => $initialState,
            'componentId' => $this->getId(),
            'userId' => auth()->id(),
            'userName' => auth()->user()?->name ?? 'Guest',
        ]) }}"
    ></div>
</div>
