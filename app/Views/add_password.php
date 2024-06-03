<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Add Password</h2>
        <?php if (isset($validation)) : ?>
            <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
        <?php endif; ?>
        <form action="/add_password" method="post">
            <div class="form-group">
                <label for="website">Website/Application</label>
                <input type="text" class="form-control" id="website" name="website" value="<?= set_value('website') ?>">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= set_value('username') ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Add Password</button>
        </form>
        <a href="/dashboard">Back to Dashboard</a>
    </div>
</body>

</html>