<tr>
    <td>
        {{ $category->name }}
    </td>
    <td>
        {{ $category->description }}
    </td>
    <td>
        @can('update:category-project')
            <a href="{{ route('category-project.edit', ['id' => $category->id]) }}"
                class="btn btn-primary btn-sm waves-effect waves-light"><i class="bx bx-pencil me-1"></i> Edit</a>
        @endcan
        @can('delete:category-project')
            <li class="list-inline-item">
                <button type="button" wire:click="deleteConfirm()" class="btn btn-danger btn-sm waves-effect waves-light">
                    <i class="mdi mdi-delete me-1"></i> Delete
                </button>
            </li>
        @endcan
    </td>
</tr>
