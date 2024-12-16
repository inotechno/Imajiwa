<div>
    <div class="row">
        @foreach ($statuses as $status)
            @livewire('status-inventory.status-inventory-item', ['status' => $status], key($status->id))
        @endforeach
    </div>
</div>
