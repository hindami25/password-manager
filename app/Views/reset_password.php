<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Reset Password</h2>
        <?php if (isset($validation)) : ?>
            <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
        <?php endif; ?>
        <?php if (isset($message)) : ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form action="/reset_password/<?= $resetToken ?>" method="post">
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
        <a href="/login">Login</a>
    </div>
</body>

</html>