<div class="row">
    <div class="col-lg-12">
        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Model</th>
                            <th scope="col">Serial Number</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Barcode</th>
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inventories as $inventory)
                            @livewire('inventory.inventory-item', ['inventory' => $inventory], key($inventory->id))
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
