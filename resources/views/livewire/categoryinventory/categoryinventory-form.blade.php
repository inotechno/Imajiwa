<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Category Inventory', 'url' => route('category.index')], ['name' => $type == 'create' ? 'Create' : 'Edit Category Inventory ']]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">
                        {{ $type == 'create' ? 'Create Category Inventory' : 'Edit Category Inventory ' . $category->title }}
                    </h4>
                    <form wire:submit.prevent="save" class="needs-validation" wire:ignore.self>
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
                                <button type="submit" class="btn btn-primary">Create Category</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
