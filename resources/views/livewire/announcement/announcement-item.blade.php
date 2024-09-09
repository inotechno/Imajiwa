<tr>
    <td>
        {{ $announcement->title }}
    </td>
    <td>{{ $announcement->description }}</td>
    <td>
        @can('update:announcement')
            <a href="{{ route('announcement.edit', ['id' => $announcement->id]) }}"
                class="btn btn-primary btn-sm waves-effect waves-light"><i class="bx bx-pencil me-1"></i> Edit</a>
        @endcan
        @can('delete:announcement')
            <li class="list-inline-item">
                <button type="button" wire:click="deleteConfirm()" class="btn btn-danger btn-sm waves-effect waves-light">
                    <i class="mdi mdi-delete me-1"></i> Delete
                </button>
            </li>
        @endcan
        <a href="{{ route('announcement.detail', ['id' => $announcement->id]) }}"
            class="btn btn-primary btn-sm waves-effect waves-light"><i class="mdi mdi-eye me-1"></i> Detail</a>
    </td>
</tr>
