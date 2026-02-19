<h1>Admin</h1>

<div class="grid2">
  <div class="panel"><div class="k">Users</div><div class="v"><?= (int)$users ?></div></div>
  <div class="panel"><div class="k">Threads</div><div class="v"><?= (int)$threads ?></div></div>
  <div class="panel"><div class="k">Posts</div><div class="v"><?= (int)$posts ?></div></div>
</div>

<div class="panel">
  <a class="btn" href="/admin/categories">Manage Categories</a>
  <a class="btn" href="/admin/users">Manage Users</a>
</div>
