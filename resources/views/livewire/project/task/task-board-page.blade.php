<div>
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">{{ $task->title }}</h4>
                <small class="text-muted">Task Board</small>
            </div>
            <div>
                <a href="{{ route('project.task.detail', ['project_id' => $project->id, 'id' => $task->id]) }}" 
                   class="btn btn-secondary">
                    <i class="mdi mdi-arrow-left me-1"></i> Back to Overview
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card" style="height: 85vh;">
                <div class="card-body p-0 h-100">
                    <div wire:ignore class="h-100">
                        <div 
                            id="tldraw-root" 
                            style="height: 100%; width: 100%; position: relative;"
                            data-props="{{ json_encode([
                                'projectId' => $roomId,
                                'initialSnapshot' => $initialState,
                                'componentId' => $this->getId(),
                                'userId' => auth()->id(),
                                'userName' => auth()->user()?->name ?? 'Guest',
                            ]) }}"
                        ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    console.log('[TaskBoardPage] Blade rendered for task {{ $task->id }}, room: {{ $roomId }}');
    
    // Check if element exists
    const root = document.getElementById('tldraw-root');
    console.log('[TaskBoardPage] #tldraw-root exists?', !!root);

    // Observer to detect if it gets removed
    if (root) {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.removedNodes.length) {
                    mutation.removedNodes.forEach(node => {
                        if (node.id === 'tldraw-root' || node.contains && node.contains(root)) {
                            console.error('[TaskBoardPage] ❌ #tldraw-root was REMOVED from DOM!', mutation);
                        }
                    });
                }
            });
        });
        observer.observe(document.body, { childList: true, subtree: true });
    }

    Livewire.hook('morph.updating', ({ component, el, toEl, skip, cleanup }) => {
        if (el.id === 'tldraw-root' || el.contains(document.getElementById('tldraw-root'))) {
            console.warn('[TaskBoardPage] Livewire is trying to update/remove #tldraw-root!');
        }
    });
</script>
@endscript
