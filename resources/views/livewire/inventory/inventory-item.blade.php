<tr>
    <td>
        {{ $inventory->name }}
    </td>
    <td>
        {{ $inventory->model }}
    </td>
    <td>
        {{ $inventory->serial_number }}
    </td>
    <td>
        {{ $inventory->qty }}
    </td>
    <td>
        {{-- @if (!empty($inventory->qr_code_path))
            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($inventory->qr_code_path, 'UPCA', 2, 50) }}"
                alt="Barcode {{ $inventory->qr_code_path }}">
            <p>CODE - {{ $inventory->qr_code_path }}</p>
        @else --}}
        @if (!empty($inventory->qr_code_path))
            <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($inventory->qr_code_path, 'QRCODE') }}"
                alt="Barcode {{ $inventory->qr_code_path }}">
            <p>CODE - {{ $inventory->qr_code_path }}</p>
        @else
            <span>No QR Code</span>
        @endif
    </td>
    <td>{{ $inventory->description }}</td>
    <td>
        @can('update:inventory')
            <a href="{{ route('inventory.edit', ['id' => $inventory->id]) }}"
                class="btn btn-primary btn-sm waves-effect waves-light"><i class="bx bx-pencil me-1"></i> Edit</a>
        @endcan
        @can('delete:inventory')
            <li class="list-inline-item">
                <button type="button" wire:click="deleteConfirm()" class="btn btn-danger btn-sm waves-effect waves-light">
                    <i class="mdi mdi-delete me-1"></i> Delete
                </button>
            </li>
        @endcan
    </td>
</tr>
