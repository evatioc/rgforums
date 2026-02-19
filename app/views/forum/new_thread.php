<h1>New Thread in <?= e($category['name']) ?></h1>

<form class="panel form" method="post" action="/c/<?= e($category['slug']) ?>/new">
  <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>" />

  <label>
    <span>Title</span>
    <input name="title" maxlength="140" required />
  </label>

  <label>
    <span>Body</span>
    <textarea name="body" rows="8" required></textarea>
  </label>

  <button class="btn primary" type="submit">Create</button>
</form>
