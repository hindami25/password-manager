<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Edit Password</h2>
        <?php if (isset($validation)) : ?>
            <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
        <?php endif; ?>
        <form action="/edit_password/<?= $password['id'] ?>" method="post">
            <div class="form-group">
                <label for="website">Website/Application</label>
                <input type="text" class="form-control" id="website" name="website" value="<?= set_value('website', $password['website']) ?>">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= set_value('username', $password['username']) ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="<?= set_value('password', decrypt($password['password_encrypted'], session()->get('master_key'))) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
        <a href="/dashboard">Back to Dashboard</a>
    </div>
</body>

</html>