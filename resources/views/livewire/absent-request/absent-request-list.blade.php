<div>
    <div class="table-responsive">
        <table class="table project-list-table table-nowrap align-middle table-borderless">
            <thead>
                <tr>
                    <th scope="col" style="width: 100px">#</th>
                    <th scope="col">NAME</th>
                    <th scope="col">DATE</th>
                    <th scope="col">NOTES</th>
                    <th scope="col">APPROVED DIRECTOR</th>
                    <th scope="col">APPROVED SUPERVISOR</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absent_requests as $absent_request)
                    @livewire('daily-report.daily-report-item', ['absent_request' => $absent_request], key($absent_request->id))
                @endforeach
            </tbody>
        </table>
    </div>
</div>
