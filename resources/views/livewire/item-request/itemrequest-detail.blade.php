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
                            @php
                                $no = 1;
                                $grandTotal = 0;
                            @endphp
                            @forelse ($items as $item)
                                @php
                                    $itemTotal = $item['qty'] * $item['price'];
                                    $grandTotal += $itemTotal;
                                @endphp
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

                    <div class="mt-4">
                        <div class="row text-center">

                            <!-- Director -->
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Director: {{ $directorName }}</h5>
                                        @if ($isDirector && !$items[0]['director_approved_at'])
                                            <button class="btn btn-primary"
                                                wire:click="approveDirector({{ $items[0]['id'] }})">
                                                Approve as Director
                                            </button>
                                        @elseif ($items[0]['director_approved_at'])
                                            <span class="text-success">Approved</span>
                                        @else
                                            <span class="text-danger">Not Approved</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Commissioner -->
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Board Of Director: {{ $commissionerName }}</h5>
                                        @if ($isCommissioner && !$items[0]['commissioner_approved_at'])
                                            <button class="btn btn-primary"
                                                wire:click="approveCommissioner({{ $items[0]['id'] }})">
                                                Approve as Commissioner
                                            </button>
                                        @elseif ($items[0]['commissioner_approved_at'])
                                            <span class="text-success">Approved</span>
                                        @else
                                            <span class="text-danger">Not Approved</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
