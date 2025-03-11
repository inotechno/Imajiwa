<!DOCTYPE html>
<html>
<head>
    <title>New Absent Request</title>
</head>
<body>
    <p>Dear Supervisor,</p>
    
    <p>A new absent request has been submitted by <strong>{{ $emailData['employee_name'] }}</strong>.</p>

    <p><strong>Start Date:</strong> {{ $emailData['start_date'] }}</p>
    <p><strong>End Date:</strong> {{ $emailData['end_date'] }}</p>
    <p><strong>Notes:</strong> {{ $emailData['notes'] }}</p>

    <p>Click the link below to review the absent request:</p>
    <p><a href="{{ $emailData['absent_request_link'] }}">{{ $emailData['absent_request_link'] }}</a></p>

    <p>Thank you.</p>
</body>
</html>
