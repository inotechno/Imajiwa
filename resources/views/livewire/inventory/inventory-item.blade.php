<tr>
    <td>
        {{ $inventory->name }}
    </td>
    {{-- <td>
        {{ $inventory->model }}
    </td>
    <td>
        {{ $inventory->serial_number }}
    </td> --}}
    <td>
        {{ $inventory->qty }}
    </td>
    <td>
        {{-- @if (!empty($inventory->qr_code_path))
            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($inventory->qr_code_path , 'C128', 2, 50) }}"
                alt="Barcode {{ $inventory->qr_code_path }}">
            <p>CODE - {{ $inventory->qr_code_path }}</p>
        @else --}}
        @if (!empty($inventory->qr_code_path))
            <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG(url('/inv/' . $inventory->qr_code_path), 'QRCODE') }}"
                alt="Barcode {{ $inventory->qr_code_path }}">
            <p>CODE - {{ $inventory->qr_code_path }}</p>
        @else
            <span>No QR Code</span>
        @endif
    </td>
    <td>
        @if ($inventory->image_path)
            @php
                $images = json_decode($inventory->image_path);
            @endphp

            @if (is_array($images))
                @foreach ($images as $image)
                    <img src="{{ asset('storage/' . $image) }}" alt="Image" width="100" height="100">
                @endforeach
            @else
                <img src="{{ asset('storage/default-image.png') }}" alt="Default Image" width="100" height="100">
            @endif
        @else
            <img src="{{ asset('storage/default-image.png') }}" alt="Default Image" width="100" height="100">
        @endif
    </td>
    <td>
        @can('update:inventory')
            <a href="{{ route('inventory.edit', ['id' => $inventory->id]) }}"
                class="btn btn-primary btn-sm waves-effect waves-light"><i class="bx bx-pencil me-1"></i> Edit</a>
        @endcan
        <a href="{{ route('inventory.detail', ['id' => $inventory->id]) }}"
            class="btn btn-primary btn-sm waves-effect waves-light"><i class="bx bx-pencil me-1"></i> Detail</a>
        @can('delete:inventory')
            <li class="list-inline-item">
                <button type="button" wire:click="deleteConfirm()" class="btn btn-danger btn-sm waves-effect waves-light">
                    <i class="mdi mdi-delete me-1"></i> Delete
                </button>
            </li>
        @endcan
    </td>
</tr>
