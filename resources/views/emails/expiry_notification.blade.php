<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Food Expiry Notification</title>
</head>
<body style="font-family: Arial, sans-serif; color:#333;">
    <h2>🍽 Food Expiry Alert</h2>
    <p>The following food items have expired or are expiring today ({{ now()->toDateString() }}):</p>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse:collapse; width:100%;">
        <thead>
            <tr style="background-color:#f3f4f6;">
                <th>Food Name</th>
                <th>Expiry Date</th>
                <th>Quantity</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($foodItems as $food)
                <tr>
                    <td>{{ $food->name }}</td>
                    <td>{{ $food->expiry_date }}</td>
                    <td>{{ $food->quantity }}</td>
                    <td>{{ $food->notes ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top:20px;">Please take necessary action regarding these items.</p>
    <p>— Your Food Waste Management System</p>
</body>
</html>
