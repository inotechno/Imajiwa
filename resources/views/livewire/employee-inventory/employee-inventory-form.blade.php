<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Employee Inventory', 'url' => route('employee-inventory.index')], ['name' => $type == 'create' ? 'Create' : 'Edit Employee Inventory ']]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">
                        {{ $type == 'create' ? 'Create Employee Inventory' : 'Edit Employee Inventory ' }}
                    </h4>
                    <form wire:submit.prevent="save" class="needs-validation" novalidate>
                        <div class="row mb-4">
                            <label for="employee_id" class="col-form-label col-lg-2">Employee</label>
                            <div class="col-lg-10">
                                <select id="employee_id"
                                    class="form-control select2 w-full @error('employee_id') is-invalid @enderror"
                                    wire:model="employee_id" id="employee_id">
                                    <option value="">Select Employee</option>
                                    @foreach ($employee as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="inventory_id" class="col-form-label col-lg-2">Inventory</label>
                            <div class="col-lg-10">
                                <select id="inventory_id"
                                    class="form-select select2 w-full @error('inventory_id') is-invalid @enderror"
                                    wire:model="inventory_id" id="inventory_id">
                                    <option value="">Select Inventory</option>
                                    @foreach ($inventory as $inv)
                                        <option value="{{ $inv->id }}">{{ $inv->name }}</option>
                                    @endforeach
                                </select>
                                @error('inventory_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="status_id" class="col-form-label col-lg-2">Status</label>
                            <div class="col-lg-10">
                                <select id="status_id"
                                    class="form-select select2 w-full @error('status_id') is-invalid @enderror"
                                    wire:model="status_id" id="status_id">
                                    <option value="">Select Status</option>
                                    @foreach ($status as $stat)
                                        <option value="{{ $stat->id }}">{{ $stat->name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="assigned_at" class="col-form-label col-lg-2">Assigned Date</label>
                            <div class="col-lg-10">
                                <input type="date" wire:model="assigned_at"
                                    class="form-control @error('assigned_at') is-invalid @enderror" id="assigned_at">
                                @error('assigned_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="returned_at" class="col-form-label col-lg-2">Returned Date</label>
                            <div class="col-lg-10">
                                <input type="date" wire:model="returned_at"
                                    class="form-control @error('returned_at') is-invalid @enderror" id="returned_at">
                                @error('returned_at')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="notes" class="col-form-label col-lg-2">Notes</label>
                            <div class="col-lg-10">
                                <textarea wire:model="notes" id="notes" rows="4" class="form-control @error('notes') is-invalid @enderror"
                                    placeholder="Add any notes here..."></textarea>
                                @error('notes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-lg-10">
                                <button type="submit" class="btn btn-primary">
                                    {{ $type == 'create' ? 'Create Employee Inventory' : 'Update Employee Inventory' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('styles')
        <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush

    @push('js')
        <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
        <script>
            document.addEventListener('livewire:load', function() {
                // Inisialisasi Select2
                function initSelect2(selector, eventName) {
                    $(selector).select2({
                        width: '100%'
                    }).on('change', function() {
                        Livewire.emit(eventName, $(this).val());
                    });
                }

                initSelect2('#employee_id', 'changeEmployee');
                initSelect2('#inventory_id', 'changeInventory');
                initSelect2('#status_id', 'changeStatus');

                // Re-inisialisasi Select2 setelah Livewire melakukan render ulang
                Livewire.hook('message.processed', () => {
                    $('#employee_id').select2();
                    $('#inventory_id').select2();
                    $('#status_id').select2();
                });
            });
        </script>
    @endpush
</div>
