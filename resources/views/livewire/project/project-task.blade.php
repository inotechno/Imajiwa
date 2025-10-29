<div>
    {{-- CREATE --}}
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">Tambah Task</div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" class="form-control" wire:model.defer="title">
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" rows="3" wire:model.defer="description"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mulai</label>
                        <input type="datetime-local" class="form-control" wire:model.defer="start_date">
                        @error('start_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Selesai</label>
                        <input type="datetime-local" class="form-control" wire:model.defer="end_date">
                        @error('end_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <button class="btn btn-primary">Simpan & ke Google Calendar</button>
            </form>

            @if (session()->has('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger mt-3">{{ session('error') }}</div>
            @endif
        </div>
    </div>

    {{-- LIST + EDIT + DELETE --}}
    <div class="card">
        <div class="card-header bg-light">Semua Task Project</div>
        <div class="card-body">
            @if ($tasks->count())
                <ul class="list-group">
                    @foreach ($tasks as $t)
                        <li class="list-group-item">
                            @if ($editingId === $t->id)
                                {{-- EDIT FORM --}}
                                <form wire:submit.prevent="update" class="mb-2">
                                    <div class="mb-2">
                                        <label class="form-label">Judul</label>
                                        <input type="text" class="form-control" wire:model.defer="edit_title">
                                        @error('edit_title')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea class="form-control" rows="2" wire:model.defer="edit_description"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Mulai</label>
                                            <input type="datetime-local" class="form-control"
                                                wire:model.defer="edit_start_date">
                                            @error('edit_start_date')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">Selesai</label>
                                            <input type="datetime-local" class="form-control"
                                                wire:model.defer="edit_end_date">
                                            @error('edit_end_date')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 mt-2">
                                        <button class="btn btn-success btn-sm">Simpan Perubahan</button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm"
                                            wire:click="cancelEdit">Batal</button>
                                    </div>
                                </form>
                            @else
                                {{-- READ --}}
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>{{ $t->title }}</strong>
                                        @if ($t->google_event_id)
                                            <span class="badge bg-success ms-2">Sync</span>
                                        @else
                                            <span class="badge bg-secondary ms-2">Lokal</span>
                                        @endif
                                        <br>
                                        <small>{{ $t->start_date }} — {{ $t->end_date }}</small><br>
                                        @if ($t->description)
                                            <span class="text-muted">{{ $t->description }}</span>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-primary"
                                            wire:click="startEdit({{ $t->id }})">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="confirmDelete({{ $t->id }})">Hapus</button>
                                    </div>
                                </div>
                            @endif

                            {{-- KONFIRMASI HAPUS --}}
                            @if ($deletingId === $t->id)
                                <div class="alert alert-warning mt-3 mb-0">
                                    Hapus task ini? @if ($t->google_event_id)
                                        (event Google juga akan dihapus)
                                    @endif
                                    <div class="mt-2 d-flex gap-2">
                                        <button class="btn btn-danger btn-sm" wire:click="delete">Ya, hapus</button>
                                        <button class="btn btn-outline-secondary btn-sm"
                                            wire:click="cancelDelete">Batal</button>
                                    </div>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted m-0">Belum ada task.</p>
            @endif
        </div>
    </div>
</div>
