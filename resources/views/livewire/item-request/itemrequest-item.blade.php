<tr>
    <td>
        {{ $request->name }}
    </td>
    <td>
        {{ $request->status }}
    </td>
    <td>
        @can('update:item-request')
            <a href="{{ route('item-request.edit', ['id' => $request->id]) }}"
                class="btn btn-primary btn-sm waves-effect waves-light"><i class="bx bx-pencil me-1"></i> Edit</a>
        @endcan
        @can('delete:item-request')
            <li class="list-inline-item">
                <button type="button" wire:click="deleteConfirm()" class="btn btn-danger btn-sm waves-effect waves-light">
                    <i class="mdi mdi-delete me-1"></i> Delete
                </button>
            </li>
        @endcan
    </td>
</tr>
