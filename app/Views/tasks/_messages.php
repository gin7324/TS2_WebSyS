    <?php if ($message = session()->getFlashdata('success')): ?>
        <p class="notice notice-success" role="status"><?= esc($message) ?></p>
    <?php endif; ?>
    <?php if ($message = session()->getFlashdata('error')): ?>
        <p class="notice notice-error" role="alert"><?= esc($message) ?></p>
    <?php endif; ?>