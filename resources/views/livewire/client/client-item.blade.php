<tr>
    <td>
        {{ $client->name }}
    </td>
    <td>
        {{ $client->email }}
    </td>
    <td>
        {{ $client->phone }}
    </td>
    <td>
        {{ $client->address }}
    </td>
    <td>
        {{ $client->contact_person }}
    </td>
    <td>
        @can('update:client')
            <a href="{{ route('client.edit', ['id' => $client->id]) }}"
                class="btn btn-primary btn-sm waves-effect waves-light"><i class="bx bx-pencil me-1"></i> Edit</a>
        @endcan
        @can('delete:client')
            <li class="list-inline-item">
                <button type="button" wire:click="deleteConfirm()" class="btn btn-danger btn-sm waves-effect waves-light">
                    <i class="mdi mdi-delete me-1"></i> Delete
                </button>
            </li>
        @endcan
    </td>
</tr>
