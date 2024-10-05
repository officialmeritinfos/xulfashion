<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Offline - {{config('app.name')}} Business</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .offline-container {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="offline-container">
    <img src="{{asset('home/image/xulfashion_business.png')}}" alt="App Icon" class="mb-3" style="width: 100px;">
    <h1>You are Offline</h1>
    <p class="lead">It looks like you're not connected to the internet. Please check your connection and try again.</p>
    <button class="btn btn-primary" onclick="window.location.reload();">Try Again</button>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
