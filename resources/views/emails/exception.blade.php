<!DOCTYPE html>
<html>
<head>
    <title>Application Error</title>
</head>
<body>
    <h1>An error occurred in your Arrivals App application!</h1>
    <p>{{ $exception->getMessage() }} on {{ $exception->getFile() }} at line {{ $exception->getLine() }}</p>
    <p>Stack Trace:</p>
    <pre>{{ $exception->getTraceAsString() }}</pre>
    <p>Please investigate this issue.</p>
</body>
</html>