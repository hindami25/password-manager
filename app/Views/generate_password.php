<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Generated password copied to clipboard');
            }, function(err) {
                alert('Failed to copy: ' + err);
            });
        }
    </script>
</head>

<body>
    <div class="container">
        <h2>Generate Password</h2>
        <div class="alert alert-info">
            Generated Password: <strong><?= $generatedPassword ?></strong>
            <button onclick="copyToClipboard('<?= $generatedPassword ?>')" class="btn btn-secondary">Copy</button>
        </div>

        <a href="/dashboard">Back to Dashboard</a>
    </div>
</body>

</html>