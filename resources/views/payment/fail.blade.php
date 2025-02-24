<!-- resources/views/payment/fail.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffebee;
            color: #c62828;
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
        <i class="fas fa-times-circle icon"></i>
        <h1>Payment Failed!</h1>
        <p>Sorry, your payment could not be processed. Please try again.</p>
        <a href="{{ url('/') }}" style="text-decoration: none; color: white; background-color: #c62828; padding: 10px 20px; border-radius: 5px;">Try Again</a>
    </div>
</body>
</html>
