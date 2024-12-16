<div class="row">
    <div class="col-lg-12">
        <div class="">
            <div class="table-responsive">
                <table class="table project-list-table table-nowrap align-middle table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Employee</th>
                            <th scope="col">Inventory</th>
                            <th scope="col">Status</th>
                            <th scope="col">Assigned Date</th>
                            <th scope="col">Return Date</th>
                            <th scope="col">Note</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employeeInventories as $employeeInventory)
                            @livewire('employee-inventory.employee-inventory-item', ['employeeInventory' => $employeeInventory], key($employeeInventory->id))
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
