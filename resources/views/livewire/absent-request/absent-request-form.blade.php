<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Absent Request', 'url' => route('absent-request.index')], ['name' => $mode == 'Create' ? 'Create' : 'Edit Absent Request ']]], key('breadcrumb'))


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ $mode == 'Create' ? 'Create Absent Request' : 'Edit Absent Request' }}
                    </h4>

                    <form action="" wire:submit.prevent="save" wire:ignore class="needs-validation"
                        id="absent-request-form">
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

                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                                    wire:target="save">Save</button>
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
                    todayHighlight: true, // Sorot tanggal hari ini
                    autoclose: true // Tutup datepicker setelah tanggal dipilih
                }).on('changeDate', function(e) {
                    @this.set('start_date', e.format(0, "yyyy-mm-dd")); // Update property Livewire
                });

                $('#end-datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    todayHighlight: true,
                    autoclose: true
                }).on('changeDate', function(e) {
                    @this.set('end_date', e.format(0, "yyyy-mm-dd"));
                })
            });
        </script>
    @endpush
</div>
