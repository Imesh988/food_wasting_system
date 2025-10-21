<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send SMS | Food Wasting System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-sm mx-auto" style="max-width: 500px;">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Send SMS via Text.lk</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('sms.send') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="phone" class="form-label">Recipient Phone (94XXXXXXXXX)</label>
                    <input type="text" name="phone" id="phone" class="form-control" required placeholder="9477xxxxxxx">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea name="message" id="message" rows="3" class="form-control" required>
                        {{ $message ?? 'Test message form food wasting syetm ' }}
                    </textarea>
                </div>
                <button type="submit" class="btn btn-success w-100">Send SMS</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
