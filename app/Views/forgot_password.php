<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <?php if (isset($validation)) : ?>
            <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
        <?php endif; ?>
        <?php if (isset($message)) : ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form action="/forgot_password" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email') ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>