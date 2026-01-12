<div>
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
</div>

@script
<script>
    console.log('[BLADE] ProjectBoard blade rendered');
    
    // Check if element exists immediately
    const root = document.getElementById('tldraw-root');
    console.log('[BLADE] #tldraw-root exists?', !!root);

    // Observer to detect if it gets removed
    if (root) {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.removedNodes.length) {
                    mutation.removedNodes.forEach(node => {
                        if (node.id === 'tldraw-root' || node.contains && node.contains(root)) {
                            console.error('[BLADE] ❌ #tldraw-root was REMOVED from DOM!', mutation);
                        }
                    });
                }
            });
        });
        observer.observe(document.body, { childList: true, subtree: true });
    }

    Livewire.hook('morph.updating', ({ component, el, toEl, skip, cleanup }) => {
        console.log('[LIVEWIRE] morph.updating', component.name);
        if (el.id === 'tldraw-root' || el.contains(document.getElementById('tldraw-root'))) {
            console.warn('[LIVEWIRE] Livewire is trying to update/remove #tldraw-root!');
        }
    });
</script>
@endscript
