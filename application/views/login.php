<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>

<body>
  <div class="container">
    <?= form_open() ?>
    <input type="text" name="username" placeholder="username">
    <input type="password" name="password" placeholder="password">
    <?= form_submit('submit', 'login') ?>
    <?= form_close() ?>
  </div>
</body>

</html>