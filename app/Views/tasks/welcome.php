<?= $this->include('tasks/_header') ?>

<main class="page-shell reveal">
    <p class="eyebrow">Daily focus</p>
    <h1>Tasks for today.</h1>
    <p class="intro">A clear view of what needs your attention right now.</p>
    <p class="date-label"><?= esc(date('F j, Y')) ?></p>
    <?= $this->include('tasks/_messages') ?>

    <?php if (empty($tasks)): ?>
        <p class="empty-state">No tasks scheduled for today.</p>
    <?php else: ?>
        <section class="task-grid" aria-label="Today's tasks">
            <?php foreach ($tasks as $task): ?>
                <article class="task-card <?= $task['status'] === 'completed' ? 'is-complete' : '' ?>" data-task-id="<?= esc($task['id']) ?>" data-status="<?= esc($task['status']) ?>">
                    <div>
                        <p class="task-meta"><?= esc($task['task_date']) ?></p>
                        <h2 class="task-title"><?= esc($task['title']) ?></h2>
                    </div>
                    <?php if (session()->get('user_id')): ?>
                        <button class="task-status" type="button" aria-pressed="<?= $task['status'] === 'completed' ? 'true' : 'false' ?>">
                            <?= $task['status'] === 'completed' ? 'Completed' : 'Mark complete' ?>
                        </button>
                    <?php else: ?>
                        <span class="status-pill"><?= esc($task['status']) ?></span>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
</main>

<?= $this->include('tasks/_footer') ?>