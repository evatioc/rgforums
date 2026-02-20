<div class="forum-grid">
  <!-- Main Forum List -->
  <div class="main-col">
    <div class="cat-group">
      <div class="cat-header">
        <div class="cat-title">General Forums</div>
      </div>
      
      <div class="cat-list">
        <?php foreach ($categories as $c): ?>
          <div class="forum-row">
            <div class="forum-icon">
              <!-- Icon placeholder -->
              <div class="icon-circle">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
              </div>
            </div>
            
            <div class="forum-info">
              <a href="/c/<?= e($c['slug']) ?>" class="forum-name"><?= e($c['name']) ?></a>
              <div class="forum-desc"><?= e($c['description'] ?? '') ?></div>
            </div>
            
            <div class="forum-stats">
              <div class="stat-item">
                <span class="stat-val"><?= number_format($c['thread_count']) ?></span>
                <span class="stat-label">Threads</span>
              </div>
              <div class="stat-item">
                <span class="stat-val"><?= number_format($c['post_count']) ?></span>
                <span class="stat-label">Posts</span>
              </div>
            </div>
            
            <div class="forum-last">
              <?php if (!empty($c['last_post'])): ?>
                <a href="/t/<?= e($c['last_post']['thread_id']) ?>" class="last-title"><?= e($c['last_post']['title']) ?></a>
                <div class="last-meta">
                  by <?= e($c['last_post']['username']) ?>
                  <span class="time" title="<?= e($c['last_post']['created_at']) ?>">
                    <!-- Simple date format -->
                    <?= date('M j, Y', strtotime($c['last_post']['created_at'])) ?>
                  </span>
                </div>
              <?php else: ?>
                <span class="muted">No posts yet</span>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="widget">
      <h3>Latest Updates</h3>
      <div class="widget-content">
        <?php foreach ($sidebar_threads as $st): ?>
          <div class="widget-row">
            <div class="widget-icon">
               <span class="dot"></span>
            </div>
            <div class="widget-info">
              <a href="/t/<?= e($st['id']) ?>" class="widget-link"><?= e($st['title']) ?></a>
              <div class="widget-meta">
                <?= e($st['username']) ?> • <?= date('M j', strtotime($st['updated_at'])) ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- User Widget (if logged in) -->
    <?php if (Auth::check()): ?>
      <div class="widget">
        <h3>My Profile</h3>
        <div class="widget-content" style="text-align:center; padding: 10px;">
           <div class="avatar-lg" style="margin: 0 auto 10px; width: 64px; height: 64px; border-radius: 50%; background: var(--border);"></div>
           <strong><?= e(Auth::user()['username']) ?></strong>
           <div class="muted">Member</div>
        </div>
      </div>
    <?php else: ?>
      <div class="widget">
        <h3>Join Us</h3>
        <div class="widget-content">
           <p class="muted" style="margin-bottom: 12px; font-size: 13px;">Login or Sign up to participate in the community.</p>
           <div style="display:grid; gap:8px;">
             <a href="/login" class="btn btn-secondary full">Login</a>
             <a href="/register" class="btn btn-primary full">Register</a>
           </div>
        </div>
      </div>
    <?php endif; ?>
    
  </aside>
</div>
