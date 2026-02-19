<h1>Categories</h1>

<form class="panel form" method="post" action="/admin/categories">
  <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>" />
  <label><span>Name</span><input name="name" required /></label>
  <label><span>Slug</span><input name="slug" placeholder="lowercase-dashes" required /></label>
  <label><span>Description</span><input name="description" /></label>
  <label><span>Sort Order</span><input name="sort_order" type="number" value="0" /></label>
  <button class="btn primary" type="submit">Add Category</button>
</form>

<div class="panel">
  <div class="list">
    <?php foreach ($categories as $c): ?>
      <div class="item">
        <div>
          <div class="title"><?= e($c['name']) ?></div>
          <div class="muted">/c/<?= e($c['slug']) ?> • sort <?= (int)$c['sort_order'] ?></div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
