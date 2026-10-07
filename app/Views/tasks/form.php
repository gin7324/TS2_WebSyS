<?= $this->include('tasks/_header') ?>

<main class="page-shell reveal form-shell">
    <p class="eyebrow">Task management</p>
    <h1><?= esc($heading) ?></h1>
    <?php if ($errors): ?>
        <div class="notice notice-error" role="alert">
            <p>Please correct the following:</p>
            <ul>
                <?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form class="task-form" action="<?= esc($formAction) ?>" method="post">
        <?= csrf_field() ?>
        <label for="title">Title <span aria-hidden="true">*</span></label>
        <input class="control" id="title" name="title" type="text" maxlength="255" value="<?= esc($task['title'] ?? '') ?>" required>
        <label for="task_date">Task date <span aria-hidden="true">*</span></label>
        <input class="control" id="task_date" name="task_date" type="date" value="<?= esc($task['task_date'] ?? '') ?>" required>
        <div class="form-actions">
            <button class="button-link" type="submit">Save task</button>
            <a href="/tasks">Cancel</a>
        </div>
    </form>
</main>

<?= $this->include('tasks/_footer') ?>