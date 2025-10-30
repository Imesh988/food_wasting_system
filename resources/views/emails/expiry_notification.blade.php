<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Food Expiry Notification</title>
</head>
<body style="font-family: Arial, sans-serif; color:#333; background-color:#f9fafb; padding:20px;">
    <div style="max-width:600px; margin:0 auto; background-color:#ffffff; padding:20px; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
        <h2 style="font-size:24px; font-weight:bold; color:#dc2626; margin-bottom:16px; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">🍽 Food Expiry Alert</h2>
        <p style="margin-bottom:16px;">
            The following food items have expired or are expiring today (<strong>{{ \Carbon\Carbon::now()->toDateString() }}</strong>):
        </p>

        @if(!empty($todayExpiredFoods) && $todayExpiredFoods->isNotEmpty())
        <div style="overflow-x:auto; margin-bottom:20px;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background-color:#f3f4f6;">
                        <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Food Name</th>
                        <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Expiry Date</th>
                        <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Quantity</th>
                        <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($todayExpiredFoods as $food)
                    <tr style="border-bottom:1px solid #eee;">
                        <td style="padding:8px;">{{ $food->name }}</td>
                        <td style="padding:8px;">{{ $food->expiry_date }}</td>
                        <td style="padding:8px;">{{ $food->quantity }}</td>
                        <td style="padding:8px;">{{ $food->notes ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

         <p style="margin-bottom:16px;">
          📅 Expiring in Next 3 Days       
         </p>

        @if(!empty($next3DaysFoods) && $next3DaysFoods->isNotEmpty())
        <div style="overflow-x:auto; margin-bottom:20px;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background-color:#f3f4f6;">
                        <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Food Name</th>
                        <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Expiry Date</th>
                        <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Quantity</th>
                        <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($next3DaysFoods as $food)
                    <tr style="border-bottom:1px solid #eee;">
                        <td style="padding:8px;">{{ $food->name }}</td>
                        <td style="padding:8px;">{{ $food->expiry_date }}</td>
                        <td style="padding:8px;">{{ $food->quantity }}</td>
                        <td style="padding:8px;">{{ $food->notes ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <p style="margin-top:20px;">Please take necessary action regarding these items.</p>
        <p style="margin-top:8px; color:#6b7280;">— Your Food Waste Management System</p>
    </div>
</body>
</html>
