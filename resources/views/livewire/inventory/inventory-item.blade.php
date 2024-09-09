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
