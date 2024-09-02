<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Input Data</title>
</head>

<body>
  <div class="container">
    <!-- <form method="post"> -->
    <?= form_open_multipart('blog/store') ?>
    <div class="title">
      <label for="title">title</label>
      <?= form_input('title', null) ?>
      <!-- <input type="text" id="title" name="title"> -->
    </div>
    <div class="slug">
      <label for="slug">slug</label>
      <?= form_input('slug') ?>
      <!-- <input type="text" id="slug" name="slug"> -->
    </div>
    <div class="body">
      <label for="body">body</label>
      <?= form_input('body') ?>
      <!-- <textarea id="body" name="body"></textarea> -->
    </div>
    <div class="author">
      <label for="author">author</label>
      <?= form_input('author') ?>
      <!-- <input type="text" id="author" name="author"> -->
    </div>
    <div class="cover">
      <label for="cover">cover</label>
      <?= form_upload('cover') ?>
      <!-- <input type="text" id="cover" name="cover"> -->
    </div>
    <button class="submit-button" type="submit">create</button>
    <?= form_close() ?>
    <!-- </form> -->
  </div>
</body>

</html>