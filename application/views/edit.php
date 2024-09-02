<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Form</title>
</head>

<body>
  <div class="container">
    <!-- <form action="<?= site_url('blog/update') ?>" method="post"> -->
    <?= form_open_multipart('blog/update') ?>
    <?= form_hidden('id', $blog['id']) ?>
    <div class="title">
      <label for="title">title</label>
      <!-- <input type="text" id="title" name="title" value="<?= $blog['title']; ?>"> -->
      <?= form_input('title', $blog['title']) ?>
    </div>
    <div class="slug">
      <label for="slug">slug</label>
      <!-- <input type="text" id="slug" name="slug" value="<?= $blog['slug']; ?>"> -->
      <?= form_input('slug', $blog['slug']) ?>
    </div>
    <div class="body" style="display: flex; align-items: start;">
      <label for="body">body</label>
      <?= form_textarea('body', $blog['body']) ?>
    </div>
    <div class="author">
      <label for="author">author</label>
      <!-- <input type="text" id="author" name="author" value="<?= $blog['author']; ?>"> -->
      <?= form_input('author', $blog['author']) ?>
    </div>
    <div class="cover">
      <label for="cover">cover</label>
      <?= form_upload('cover') ?>
      <!-- <input type="text" id="cover" name="cover"> -->
    </div>
    <button class="submit-button" type="submit">update</button>
    </form>
  </div>
</body>

</html>