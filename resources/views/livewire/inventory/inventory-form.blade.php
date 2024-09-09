<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Inventory', 'url' => route('inventory.index')], ['name' => $type == 'create' ? 'Create' : 'Edit Inventory ']]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">
                        {{ $type == 'create' ? 'Create Inventory' : 'Edit Inventory ' . $inventory->name }}
                    </h4>
                    <form wire:submit.prevent="save" class="needs-validation" wire:ignore.self>
                        <div class="row mb-4" wire:ignore>
                            <label for="status" class="col-form-label col-lg-2">Select Category</label>
                            <div class="col-lg-10">
                                <select class="form-control @error('category_inventory_id') is-invalid @enderror" id="category_inventory_id"
                                    wire:model="category_inventory_id" data-placeholder="Select Category">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="name" class="col-form-label col-lg-2">Name</label>
                            <div class="col-lg-10">
                                <input id="name" name="name" wire:model="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter Name...">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="serial_number" class="col-form-label col-lg-2">Serial Number</label>
                            <div class="col-lg-10">
                                <input id="serial_number" name="serial_number" wire:model="serial_number" type="text"
                                    class="form-control @error('serial_number') is-invalid @enderror"
                                    placeholder="Enter Serial Number...">

                                @error('serial_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="qty" class="col-form-label col-lg-2">Qty</label>
                            <div class="col-lg-10">
                                <input id="qty" name="qty" wire:model="qty" type="number"
                                    class="form-control @error('qty') is-invalid @enderror"
                                    placeholder="Enter Qty...">

                                @error('qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="model" class="col-form-label col-lg-2">Model</label>
                            <div class="col-lg-10">
                                <input id="model" name="model" wire:model="model" type="text"
                                    class="form-control @error('model') is-invalid @enderror"
                                    placeholder="Enter Model...">

                                @error('model')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="projectdesc" class="col-form-label col-lg-2">Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description" id="projectdesc"
                                    rows="3" placeholder="Enter Description..."></textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary">Create Inventory</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
