<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Password copied to clipboard');
            }, function(err) {
                alert('Failed to copy: ' + err);
            });
        }
    </script>
</head>

<body>
    <div class="container">
        <h2>Dashboard</h2>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Password Manager</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/add_password">Add Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/generate_password">Generate Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Website/Application</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($passwords as $password) : ?>
                    <tr>
                        <td><?= $password['id'] ?></td>
                        <td><?= $password['website'] ?></td>
                        <td><?= $password['username'] ?></td>
                        <td><button onclick="copyToClipboard('<?= decrypt($password['password_encrypted'], session()->get('master_key')) ?>')">Copy</button></td>
                        <td>
                            <a href="/edit_password/<?= $password['id'] ?>" class="btn btn-primary">Edit</a>
                            <a href="/delete_password/<?= $password['id'] ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>