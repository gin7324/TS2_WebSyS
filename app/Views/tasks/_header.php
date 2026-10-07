<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Tasks for Today') ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php $active = $active ?? ''; ?>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="/">Today / Tasks</a>
            <button class="menu-toggle" type="button" aria-expanded="false" aria-label="Toggle navigation">+</button>
            <nav class="site-nav" aria-label="Main navigation">
                <a class="<?= $active === 'today' ? 'active' : '' ?>" href="/">Today</a>
                <a class="<?= $active === 'tasks' ? 'active' : '' ?>" href="/tasks">All Tasks</a>
                <a class="<?= $active === 'profile' ? 'active' : '' ?>" href="/profile">Profile</a>
                <a class="<?= $active === 'about' ? 'active' : '' ?>" href="/about">About</a>
                <?php if (session()->get('user_id')): ?>
                    <form class="nav-logout" action="/logout" method="post">
                        <?= csrf_field() ?>
                        <button type="submit">Log out</button>
                    </form>
                <?php else: ?>
                    <a class="<?= $active === 'login' ? 'active' : '' ?>" href="/login">Log in</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>