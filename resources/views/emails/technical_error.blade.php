<!-- resources/views/emails/technical_error.blade.php -->

<h1>5xx Error Occurred</h1>
<p>An error with a 5xx status code has occurred on the server.</p>

<p><strong>Error Details:</strong></p>
<ul>
    <li><strong>Message:</strong> {{ $exception->getMessage() }}</li>
    <li><strong>File:</strong> {{ $exception->getFile() }}</li>
    <li><strong>Line:</strong> {{ $exception->getLine() }}</li>
    <li><strong>Trace:</strong></li>
    <pre>{{ $exception->getTraceAsString() }}</pre>
</ul>

<p>Please look into this issue as soon as possible.</p>
