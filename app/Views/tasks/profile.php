<?= $this->include('tasks/_header') ?>

<main class="page-shell reveal">
    <p class="eyebrow">Personal details</p>
    <h1>Profile.</h1>
    <section class="profile-panel">
        <?php if ($user): ?>
            <dl class="profile-list">
                <dt>Username</dt><dd><?= esc($user['username']) ?></dd>
                <dt>Full name</dt><dd><?= esc($user['full_name']) ?></dd>
                <dt>Email</dt><dd><?= esc($user['email']) ?></dd>
                <dt>Member since</dt><dd><?= esc($user['created_at']) ?></dd>
            </dl>
        <?php else: ?>
            <p>No user profile was found.</p>
        <?php endif; ?>
    </section>
</main>

<?= $this->include('tasks/_footer') ?>