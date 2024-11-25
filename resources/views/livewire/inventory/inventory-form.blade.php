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
                                <select class="form-control @error('category_inventory_id') is-invalid @enderror"
                                    id="category_inventory_id" wire:model="category_inventory_id"
                                    data-placeholder="Select Category">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                @error('category_inventory_id')
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
                                <div>
                                    @foreach ($serial_numbers as $index => $serial)
                                        <div class="input-group mb-2">
                                            <input id="serial_number_{{ $index }}"
                                                name="serial_numbers[{{ $index }}]"
                                                wire:model="serial_numbers.{{ $index }}" type="text"
                                                class="form-control @error('serial_numbers.' . $index) is-invalid @enderror"
                                                placeholder="Enter Serial Number...">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-danger"
                                                    wire:click="removeSerialNumber({{ $index }})">Remove</button>
                                            </div>
                                        </div>
                                        @error('serial_numbers.' . $index)
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-secondary" wire:click="addSerialNumber">Add Serial
                                    Number</button>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="qty" class="col-form-label col-lg-2">Qty</label>
                            <div class="col-lg-10">
                                <input id="qty" name="qty" wire:model="qty" type="number"
                                    class="form-control @error('qty') is-invalid @enderror" placeholder="Enter Qty...">

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
                        <div class="row mb-4">
                            <label for="images" class="col-form-label col-lg-2">Upload Images</label>
                            <div class="col-lg-10">
                                <input type="file" wire:model="images" multiple
                                    class="form-control @error('images.*') is-invalid @enderror">
                                @error('images.*')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="preview" class="col-form-label col-lg-2">Image Preview</label>
                            <div class="col-lg-10">
                                <div class="d-flex flex-wrap">
                                    @foreach ($images as $index => $image)
                                        <div class="me-3 mb-3">
                                            <img src="{{ $image->temporaryUrl() }}" alt="Image Preview"
                                                class="img-thumbnail" width="100">
                                            <button type="button" class="btn btn-danger btn-sm mt-1 m-2"
                                                wire:click="removeImage({{ $index }})"><i
                                                    class="fa fa-trash"></i></button>
                                        </div>
                                    @endforeach

                                    @foreach ($existingImages ?? [] as $index => $existingImage)
                                        <div class="me-3 mb-3">
                                            <img src="{{ Storage::url($existingImage) }}" alt="Existing Image"
                                                class="img-thumbnail" width="100">
                                            <button type="button" class="btn btn-danger btn-sm mt-1 m-2"
                                                wire:click="removeExistingImage({{ $index }})"><i
                                                    class="fa fa-trash"></i></button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit"class="btn btn-primary">
                                    {{ $type == 'create' ? 'Create Inventory' : 'Update Inventory' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
