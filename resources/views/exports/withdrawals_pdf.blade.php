<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Withdrawals PDF</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid black; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h3>User Withdrawals Report</h3>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>User ID</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Reference</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($withdrawals as $withdrawal)
        <tr>
            <td>{{ $withdrawal->id }}</td>
            <td>{{ $withdrawal->user_id }}</td>
            <td>{{ $withdrawal->amount }}</td>
            <td>{{ $withdrawal->status }}</td>
            <td>{{ $withdrawal->reference }}</td>
            <td>{{ $withdrawal->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
