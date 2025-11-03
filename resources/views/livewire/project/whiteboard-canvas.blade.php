<div>
    <div class="p-3">
        <h5>{{ $project->name }}</h5>
        <p class="text-muted">Board: {{ $board->name }}</p>

        <div id="whiteboard" data-canvas='@json($canvasData)'
            style="width:100%;height:80vh;border-radius:10px;background:#fff;">
        </div>
    </div>

    @vite(['resources/js/whiteboard.jsx'])



</div>
