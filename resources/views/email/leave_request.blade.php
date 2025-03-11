<!DOCTYPE html>
<html>

<head>
    <title>New Leave Request</title>
</head>

<body>
    <p>Dear {{ $emailData['recipient_role'] }},</p>

    <p>A new leave request has been submitted by <strong>{{ $emailData['employee_name'] }}</strong>.</p>

    @php
        use Carbon\Carbon;
        $startDate = Carbon::parse($emailData['start_date'])->translatedFormat('d F Y');
        $endDate = Carbon::parse($emailData['end_date'])->translatedFormat('d F Y');
    @endphp

    <p><strong>Start Date:</strong> {{ $startDate }}</p>
    <p><strong>End Date:</strong> {{ $endDate }}</p>
    <p><strong>Notes:</strong> {{ $emailData['notes'] }}</p>

    <p>Click the link below to review the leave request:</p>
    <p>
        <a href="{{ $emailData['leave_request_link'] }}" style="color: blue; text-decoration: underline;">
            Click here to view leave requests
        </a>
    </p>

    <p>Thank you.</p>
</body>

</html>
