<div class="container-fluid p-4">
    <div class="row">
        <div class="col-lg-12">
            <!-- Inventory Details Section -->
            <div class="card mt-3">
                <div class="card-body">
                    <h4 class="card-title text-center">Detail Inventaris</h4>

                    @if ($inventory)
                        <!-- Inventory Information -->
                        <!-- Inventory Information -->
                        <div class="row mb-4 mt-4">
                            <!-- Image -->
                            @php
                                $images = json_decode($inventory->image_path); // Decode image path if it's JSON
                            @endphp

                            @if ($images && is_array($images))
                                @foreach ($images as $image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="Image of {{ $inventory->name }}"
                                         class="img-fluid rounded" style="max-height: 300px; object-fit: contain;">
                                @endforeach
                            @else
                                <p class="text-center text-light">No image available</p>
                            @endif
                        </div>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Code:</strong> {{ $inventory->qr_code_path }}</li>
                            <li class="list-group-item"><strong>status:</strong> {{ $inventory->status }}</li>
                            <li class="list-group-item"><strong>Name:</strong> {{ $inventory->name }}</li>
                            <li class="list-group-item"><strong>Description:</strong> {{ $inventory->description }}</li>
                            <li class="list-group-item"><strong>Serial Number:</strong> {{ $inventory->serial_number }}
                            </li>
                            <li class="list-group-item"><strong>Model:</strong> {{ $inventory->model }}</li>
                            <li class="list-group-item"><strong>Price:</strong>
                                ${{ number_format($inventory->price, 2) }}</li>
                            <li class="list-group-item"><strong>Quantity:</strong> {{ $inventory->qty }}</li>
                            <li class="list-group-item"><strong>Purchase Date:</strong>
                                {{ \Carbon\Carbon::parse($inventory->purchase_date)->format('d M Y') }}</li>
                        </ul>

                       
                    @else
                        <div class="alert alert-danger">
                            Inventaris tidak ditemukan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
