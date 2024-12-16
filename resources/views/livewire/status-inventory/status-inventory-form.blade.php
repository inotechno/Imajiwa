<div>
    <form wire:submit.prevent="save" class="needs-validation form-horizontal" wire:ignore.self>
        <div class="row">
            <div class="col-md">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror"
                    wire:model="name" placeholder="Status Name">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md">
                <label for="color" class="form-label">Color</label>
                <input type="color" id="color"
                    class="form-control form-control-color @error('color') is-invalid @enderror" wire:model="color"
                    value="#000000" title="Choose a color">
                @error('color')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-sm btn-primary mt-3">Submit</button>
        <button type="button" class="btn btn-sm btn-danger mt-3" wire:click="resetFormFields()">Clear</button>
    </form>

    @push('js')
        <script>
            document.addEventListener('livewire:init', function() {
                Livewire.on('refreshForm', () => {
                    // Custom JavaScript jika diperlukan untuk reset form atau update UI
                    console.log('Form refreshed!');
                });
            });
        </script>
    @endpush
</div>
