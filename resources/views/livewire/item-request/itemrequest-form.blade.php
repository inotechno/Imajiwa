<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Item Request', 'url' => route('item-request.index')], ['name' => $type == 'create' ? 'Create' : 'Edit Item Request ']]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title mb-0">
                            {{ $type == 'create' ? 'Create Item Request' : (isset($inventory) ? 'Edit Item Request ' . $inventory->name : 'Edit Item Request') }}
                        </h4>
                        <a href="{{ route('item-request.index') }}" class="btn btn-primary">
                            Kembali
                        </a>
                    </div>
                    <form wire:submit.prevent="save" class="needs-validation" wire:ignore.self>
                        <input type="hidden" wire:model="request_id">
                        {{-- ini untuk di tambahkan kedalam tabel request --}}
                        <div class="row mb-4">
                            <label for="name" class="col-form-label col-lg-2">Name Item Request</label>
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
                        {{-- ini untuk di tambahkan kedalam tabel inventory  --}}
                        <div class="table-responsive">
                            <table class="table project-list-table table-nowrap align-middle table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Purchase Date</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $index => $item)
                                        <tr>
                                            <td>
                                                <input type="text" wire:model="items.{{ $index }}.name"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <select wire:model="items.{{ $index }}.category_inventory_id"
                                                    class="form-control">
                                                    <option value="">Select Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" wire:model="items.{{ $index }}.qty"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" wire:model="items.{{ $index }}.price"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <input type="date"
                                                    wire:model="items.{{ $index }}.purchase_date"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <textarea wire:model="items.{{ $index }}.description" class="form-control"></textarea>
                                            </td>
                                            <td>
                                                <button type="button" wire:click="removeItem({{ $index }})"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="bx bxs-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <button type="button" wire:click="addItem" class="btn btn-primary btn-sm"><i
                                class="bx bx-plus-medical"></i></button>
                        <button type="submit" class="btn btn-success btn-sm">Submit</button>
                        @error('items')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
