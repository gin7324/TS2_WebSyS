<?= $this->include('tasks/_header') ?>

<main class="page-shell reveal">
    <p class="eyebrow">Task archive</p>
    <h1>Every task.</h1>
    <p class="intro">Search the full list or filter it by status.</p>
    <?= $this->include('tasks/_messages') ?>

    <?php if (session()->get('user_id')): ?>
        <p><a class="button-link" href="/tasks/new">+ New task</a></p>
    <?php endif; ?>

    <div class="toolbar">
        <input class="control search-control" type="search" placeholder="Search tasks" aria-label="Search tasks" data-task-search>
        <select class="control" aria-label="Filter by status" data-task-filter>
            <option value="all">All statuses</option>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
        </select>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Created</th>
                    <?php if (session()->get('user_id')): ?><th>Actions</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr data-task-row data-title="<?= esc(strtolower($task['title'])) ?>" data-status="<?= esc($task['status']) ?>">
                        <td><?= esc($task['title']) ?></td>
                        <td><span class="status-pill"><?= esc($task['status']) ?></span></td>
                        <td><?= esc($task['task_date']) ?></td>
                        <td><?= esc($task['created_at']) ?></td>
                        <?php if (session()->get('user_id')): ?>
                            <td class="row-actions">
                                <a href="/tasks/<?= esc($task['id']) ?>/edit">Edit</a>
                                <form action="/tasks/<?= esc($task['id']) ?>/archive" method="post" onsubmit="return confirm('Archive this task?')">
                                    <?= csrf_field() ?>
                                    <button class="text-button" type="submit">Delete</button>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($tasks)): ?>
                    <tr><td colspan="5">No active tasks yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?= $this->include('tasks/_footer') ?>