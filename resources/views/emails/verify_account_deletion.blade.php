<!DOCTYPE html>
<html>
<head>
    <title>Verify Account Deletion Request</title>
</head>
<body style="font-family: Arial, sans-serif;">
<div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border-radius: 5px;">
    <h2 style="color: #333;">Account Deletion Request</h2>
    <p style="color: #555;">
        We have received your request to delete your {{$web->name}} account. Please confirm if you would like to proceed with this action.
        Once your account is deleted, all your data will be permanently removed from our systems.
    </p>
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $proceedUrl }}" style="padding: 10px 20px; background-color: #e74c3c; color: #fff; text-decoration: none; border-radius: 5px;">Proceed with Deletion</a>
    </div>
    <p style="color: #777;">If you did not make this request, please ignore and the process will not proceed.</p>
</div>
</body>
</html>
