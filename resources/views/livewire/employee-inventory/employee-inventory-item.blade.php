<tr>
    <td>
        {{ $employeeInventory->employee->user->name }}
    </td>
    <td>
        {{ $employeeInventory->inventory->name }}
    </td>
    <td>
        {{ $employeeInventory->statusInventory->name }}
    </td>
    <td>
        {{ $employeeInventory->assigned_at }}
    </td>
    <td>
        {{ $employeeInventory->returned_at }}
    </td>
    <td>
        {{ $employeeInventory->notes }}
    </td>
    <td>
        @can('update:employee-inventory')
            <a href="{{ route('employee-inventory.edit', ['id' => $employeeInventory->id]) }}"
                class="btn btn-primary btn-sm waves-effect waves-light"><i class="bx bx-pencil me-1"></i> Edit</a>
        @endcan
        {{-- <a href="{{ route('employee-inventory.detail', ['id' => $employeeInventory->id]) }}"
            class="btn btn-primary btn-sm waves-effect waves-light"><i class="bx bx-pencil me-1"></i> Detail</a> --}}
        @can('delete:employee-inventory')
            <li class="list-inline-item">
                <button type="button" wire:click="deleteConfirm()" class="btn btn-danger btn-sm waves-effect waves-light">
                    <i class="mdi mdi-delete me-1"></i> Delete
                </button>
            </li>
        @endcan
    </td>
</tr>
