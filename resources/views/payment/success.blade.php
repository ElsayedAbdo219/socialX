<!-- resources/views/payment/success.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e8f5e9;
            color: #2e7d32;
            text-align: center;
            padding: 50px;
        }
        .icon {
            font-size: 100px;
        }
    </style>
</head>
<body>
    <div>
        <i class="fas fa-check-circle icon"></i>
        <h1>Payment Successful!</h1>
        <p>Your payment has been processed successfully.</p>
        <a href="{{ url('/') }}" style="text-decoration: none; color: white; background-color: #2e7d32; padding: 10px 20px; border-radius: 5px;">Go to Home</a>
    </div>
</body>
</html>
