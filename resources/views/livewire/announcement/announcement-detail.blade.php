<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Other', 'url' => '/'], ['name' => 'Announcement', 'url' => route('announcement.index')], ['name' => $title]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ $title }}</h4>
                    <div class="row mb-4">
                        <label for="projectname" class="col-form-label col-lg-2">title</label>
                        <div class="col-lg-10">
                            <input id="title" name="title" type="text"
                                class="form-control" readonly
                                value="{{ $title }}">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="projectdesc" class="col-form-label col-lg-2">Description</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" id="projectdesc" rows="3"
                                readonly>{{ $description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
