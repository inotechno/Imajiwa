<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Leave Request', 'url' => route('leave-request.index')], ['name' => $mode == 'Create' ? 'Create' : 'Edit Leave Request ']]], key('breadcrumb'))


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ $mode == 'Create' ? 'Create Leave Request' : 'Edit Leave Request' }}
                    </h4>

                    <form action="" wire:submit.prevent="save" wire:ignore class="needs-validation"
                        id="leave-request-form">
                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label for="notes" class="mb-3">Note</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" wire:model="notes"
                                        rows="3"></textarea>

                                    @error('notes')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="d-flex gap-2 mt-5">
                                    <div class="mb-3">
                                        <label for="type_leave" class="mb-3">Leave Period to be Taken</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" wire:model="leave_period" readonly>
                                            <span class="input-group-text bg-primary" id="option-date">Hari</span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="type_leave" class="mb-3">Already Taken</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" wire:model="leave_taken" readonly>
                                            <span class="input-group-text bg-primary" id="option-date">Hari</span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="type_leave" class="mb-3">Remaining</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control"  wire:model="leave_remaining" readonly>
                                            <span class="input-group-text bg-primary" id="option-date">Hari</span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="row">

                                    <div class="col-sm-6">
                                        <label class="mb-3">Start Date</label>
                                        <div id="start-datepicker" data-provide="datepicker-inline"
                                            class="bootstrap-datepicker-inline"></div>
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="mb-3">End Date</label>
                                        <div id="end-datepicker" data-provide="datepicker-inline"
                                            class="bootstrap-datepicker-inline"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                                wire:target="save">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="{{ asset('libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
            type="text/css">
    @endpush

    @push('js')
        <script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script>
            document.addEventListener('livewire:init', function() {
                $('#start-datepicker').datepicker({
                    format: 'yyyy-mm-dd', // Atur format tanggal sesuai kebutuhan
                    // todayHighlight: true, // Sorot tanggal hari ini
                    autoclose: true // Tutup datepicker setelah tanggal dipilih
                }).on('changeDate', function(e) {
                    Livewire.dispatch('change-date', {param: 'start_date', date: e.format(0, "yyyy-mm-dd")});
                });

                $('#end-datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    // todayHighlight: true,
                    autoclose: true
                }).on('changeDate', function(e) {
                    Livewire.dispatch('change-date', {param: 'end_date', date: e.format(0, "yyyy-mm-dd")});
                })

                Livewire.on('change-default', () => {
                    $('#start-datepicker').datepicker('update', @json($start_date));
                    $('#end-datepicker').datepicker('update', @json($end_date));
                })
            });
        </script>
    @endpush
</div>
