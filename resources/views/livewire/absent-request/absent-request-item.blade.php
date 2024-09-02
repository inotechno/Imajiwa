<tr class="align-middle">
    <td>
        @if ($user->avatar_url)
            <a href="javascript: void(0);" class="d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top"
                title="{{ $user->name }}">
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="rounded-circle avatar-sm">
            </a>
        @else
            <div class="avatar-sm">
                <span class="avatar-title rounded-circle bg-success text-white font-size-16">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
            </div>
        @endif
    </td>
    <td>
        <h5 class="text-truncate font-size-14">
            <a href="javascript: void(0);" class="text-dark">{{ $user->name }}</a>
        </h5>
        <p class="text-muted mb-0">{{ $user->email }}</p>
    </td>
    <td>
        <span>{{ $absent_request->start_date->format('d M, Y') }} - {{ $absent_request->end_date->format('d M, Y') }}</span>
    </td>
    <td>
        <p>{{$director->name}}</p>
        <p>{{$absent_request->director_approved_at}}</p>
    </td>
    <td>
        <p>{{$supervisor->name}}</p>
        <p>{{$absent_request->supervisor_approved_at}}</p>
    </td>
    <td>
        <span>{{ $absent_request->created_at->format('d M, Y h:i A') }}</span>
    </td>
    <td>
        <div class="d-flex flex-row gap-2">
            @can('view:absent-request')
                <a href="{{ route('absent-request.detail', ['id' => $absent_request->id]) }}" class="btn btn-sm btn-primary"><i
                        class="mdi mdi-eye me-1"></i> View</a>
            @endcan

            @can('update:absent-request')
                <a href="{{ route('absent-request.edit', ['id' => $absent_request->id]) }}" class="btn btn-sm btn-primary"><i
                        class="mdi mdi-pencil me-1"></i> Edit</a>
            @endcan

            @can('delete:absent-request')
                <button class="btn btn-sm btn-danger" wire:click="deleteConfirm({{ $absent_request->id }})"><i
                        class="mdi mdi-delete me-1"></i> Delete</button>
            @endcan
        </div>
    </td>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inisialisasi tooltip Bootstrap
                var tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');

                tooltipElements.forEach(function(element) {
                    var tooltip = new bootstrap.Tooltip(element, {
                        html: true,
                        title: function() {
                            return element.getAttribute('data-recipients');
                        }
                    });
                });
            });
        </script>
    @endpush
</tr>
