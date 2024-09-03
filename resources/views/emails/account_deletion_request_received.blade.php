<!DOCTYPE html>
<html>
<head>
    <title>Account Removal Request Approved</title>
</head>
<body style="font-family: Arial, sans-serif;">
<div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border-radius: 5px;">
    <h2 style="color: #333;">Account Removal Scheduled</h2>
    <p style="color: #555;">
        We have received your request to delete your {{$web->name}} account. Your account will be removed after 30 days in accordance
        to our Privacy policy.
        If you do not want this to take place, click the button below to cancel the request.
    </p>
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $proceedUrl }}" style="padding: 10px 20px; background-color: #2AAA8A; color: #fff; text-decoration: none; border-radius: 5px;">Cancel Account Removal</a>
    </div>
    <p style="color: #777;">If you did not make this request, please ignore and the process will not proceed.</p>
</div>
</body>
</html>
