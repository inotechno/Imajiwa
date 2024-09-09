<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Other', 'url' => '/'], ['name' => 'Announcement', 'url' => route('announcement.index')], ['name' => $type == 'create' ? 'Create' : 'Edit Announcement ']]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">
                        {{ $type == 'create' ? 'Create Announcement' : 'Edit Announcement ' . $announcement->title }}
                    </h4>
                    <form wire:submit.prevent="save" class="needs-validation" wire:ignore.self>
                        <div class="row mb-4">
                            <label for="title" class="col-form-label col-lg-2">Title</label>
                            <div class="col-lg-10">
                                <input id="title" name="title" wire:model="title" type="text"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Enter Title...">

                                @error('title')
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
                                <button type="submit" class="btn btn-primary">Create Announcement</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
