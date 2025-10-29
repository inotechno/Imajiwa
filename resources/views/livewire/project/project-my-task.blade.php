<div>
    <div class="card">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <strong>Task Saya di Project Ini</strong>
            <small class="text-muted">Menampilkan: yang saya buat & yang di-assign ke saya</small>
        </div>

        <div class="card-body">
            @if ($tasks->count())
                <ul class="list-group">
                    @php
                        $meUserId = auth()->id();
                        $myEmployeeId = optional(auth()->user()->employee)->id;
                    @endphp

                    @foreach ($tasks as $t)
                        @php
                            $isMine = $t->created_by === $meUserId;
                            $isAssigned = $myEmployeeId ? $t->employees->contains('id', $myEmployeeId) : false;
                        @endphp

                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div>
                                <div class="mb-1">
                                    <strong>{{ $t->title }}</strong>

                                    {{-- badge sinkron calendar --}}
                                    @if ($t->google_event_id)
                                        <span class="badge bg-success ms-2">Synced</span>
                                    @else
                                        <span class="badge bg-secondary ms-2">Local</span>
                                    @endif>

                                    {{-- badge kepemilikan/assigned --}}
                                    @if ($isMine)
                                        <span class="badge bg-info ms-2">Created by me</span>
                                    @endif
                                    @if ($isAssigned)
                                        <span class="badge bg-primary ms-2">Assigned to me</span>
                                    @endif
                                </div>

                                <small class="text-muted d-block">
                                    {{ \Carbon\Carbon::parse($t->start_date)->format('d M Y H:i') }}
                                    —
                                    {{ \Carbon\Carbon::parse($t->end_date)->format('d M Y H:i') }}
                                </small>

                                @if ($t->description)
                                    <div class="text-muted mt-1">{{ $t->description }}</div>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted mb-0">Belum ada task milik/assigned untuk Anda di project ini.</p>
            @endif
        </div>
    </div>
</div>
