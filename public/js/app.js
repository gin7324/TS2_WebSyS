document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.querySelector('.menu-toggle');
    const navigation = document.querySelector('.site-nav');

    if (menuToggle && navigation) {
        menuToggle.addEventListener('click', () => {
            const isOpen = navigation.classList.toggle('is-open');
            menuToggle.setAttribute('aria-expanded', String(isOpen));
        });
    }

    document.querySelectorAll('.task-status').forEach((button) => {
        button.addEventListener('click', async () => {
            const card = button.closest('.task-card');
            const nextStatus = card.dataset.status === 'completed' ? 'pending' : 'completed';
            button.disabled = true;

            try {
                const response = await fetch(`/tasks/${card.dataset.taskId}/status`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ status: nextStatus }),
                });
                if (!response.ok) throw new Error('The task status could not be saved.');

                card.dataset.status = nextStatus;
                card.classList.toggle('is-complete', nextStatus === 'completed');
                button.textContent = nextStatus === 'completed' ? 'Completed' : 'Mark complete';
                button.setAttribute('aria-pressed', String(nextStatus === 'completed'));
            } catch (error) {
                window.alert(error.message);
            } finally {
                button.disabled = false;
            }
        });
    });

    const search = document.querySelector('[data-task-search]');
    const filter = document.querySelector('[data-task-filter]');
    const rows = document.querySelectorAll('[data-task-row]');
    const updateTaskList = () => {
        const term = search ? search.value.toLowerCase() : '';
        const status = filter ? filter.value : 'all';
        rows.forEach((row) => {
            row.hidden = !row.dataset.title.includes(term) || (status !== 'all' && row.dataset.status !== status);
        });
    };
    search?.addEventListener('input', updateTaskList);
    filter?.addEventListener('change', updateTaskList);
});