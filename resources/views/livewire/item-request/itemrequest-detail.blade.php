<div>
    @livewire('component.page.breadcrumb', ['breadcrumbs' => [['name' => 'Application', 'url' => '/'], ['name' => 'Item Request', 'url' => route('item-request.index')], ['name' => $name]]], key('breadcrumb'))

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Model</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Purchase Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; $grandTotal = 0; ?>
                            @forelse ($items as $item)
                                <?php
                                    $itemTotal = $item['qty'] * $item['price'];
                                    $grandTotal += $itemTotal;
                                ?>
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['description'] }}</td>
                                    <td>{{ $item['model'] }}</td>
                                    <td>{{ $item['qty'] }}</td>
                                    <td>{{ number_format($item['price'], 2) }}</td>
                                    <td>{{ number_format($itemTotal, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item['purchase_date'])->format('Y-m-d') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No items found</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-right"><strong>Grand Total</strong></td>
                                <td>{{ number_format($grandTotal, 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                    <a href="javascript:void(0)" class="btn btn-soft-info btn-sm"
                    wire:click="approveConfirm()">
                    <i class="mdi mdi-check"></i> Approve as Director
                </a>

                <a href="javascript:void(0)" class="btn btn-soft-info btn-sm"
                wire:click="approveConfirm()">
                <i class="mdi mdi-check"></i> Approve as Supervisor
            </a>
                    

                </div>
            </div>
        </div>
    </div>
</div>
