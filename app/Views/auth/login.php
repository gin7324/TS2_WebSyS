<?= view('tasks/_header', ['title' => $title, 'active' => 'login']) ?>

<main class="page-shell reveal form-shell">
    <p class="eyebrow">Task management</p>
    <h1>Log in.</h1>
    <?= view('tasks/_messages') ?>
    <form class="task-form" action="/login" method="post">
        <?= csrf_field() ?>
        <label for="username">Username</label>
        <input class="control" id="username" name="username" type="text" autocomplete="username" required>
        <label for="password">Password</label>
        <input class="control" id="password" name="password" type="password" autocomplete="current-password" required>
        <div class="form-actions">
            <button class="button-link" type="submit">Log in</button>
        </div>
    </form>
</main>

<?= $this->include('tasks/_footer') ?>