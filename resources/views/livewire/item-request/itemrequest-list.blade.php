<div class="row">
    <div class="col-lg-12">
        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $request)
                            @livewire('item-request.itemrequest-item', ['request' => $request], key($request->id))
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
